<?php

class PetModel {
    private $db;

    public function __construct() {
        $this->db = new Database();
    }

    /**
     * Add a new pet to the database
     */
    public function addPet(?int $ownerId, string $name, string $type, string $breed, int $age, ?string $photo = null, ?string $ownerName = null, ?string $ownerPhone = null, ?string $dob = null, string $vacStatus = 'not_vaccinated'): ?int {
        $stmt = $this->db->conn->prepare(
            "INSERT INTO pets (owner_id, name, type, breed, age, dob, photo, owner_name, owner_phone) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)"
        );
        $stmt->bind_param("isssissss", $ownerId, $name, $type, $breed, $age, $dob, $photo, $ownerName, $ownerPhone);
        $stmt->execute();
        $petId = $stmt->insert_id;
        $success = $stmt->affected_rows > 0;
        $stmt->close();

        if ($success) {
            require_once 'VaccinationModel.php';
            $vaccinationModel = new VaccinationModel();
            
            // If DOB is not provided, estimate it from age
            if (empty($dob)) {
                $dob = date('Y-m-d', strtotime("-{$age} years"));
            }
            
            // Only generate full schedule if the owner explicitly says "Not Vaccinated"
            if ($vacStatus === 'not_vaccinated') {
                $vaccinationModel->generateInitialSchedule($petId, $type, $dob);
            }
            
            return $petId;
        }
        
        return null;
    }

    /**
     * Fetch all pets (with owner details)
     */
    public function getAllPets(): array {
        $query = "
            SELECT p.id, p.name, p.type, p.breed, p.age, p.dob, p.photo, p.owner_name, p.owner_phone,
                   u.first_name AS owner_first_name, u.last_name AS owner_last_name, u.phone AS owner_phone_user
            FROM pets p
            LEFT JOIN users u ON p.owner_id = u.id
            ORDER BY p.created_at DESC
        ";
        
        $result = $this->db->conn->query($query);
        $pets = [];
        
        if ($result && $result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $row['age'] = $this->calculateAgeFromDob($row['dob'], $row['age']);
                $pets[] = $row;
            }
        }
        
        return $pets;
    }

    /**
     * Get total count of pets in the system
     */
    public function getTotalPetsCount(): int {
        $result = $this->db->conn->query("SELECT COUNT(*) as total FROM pets");
        if ($result && $row = $result->fetch_assoc()) {
            return (int) $row['total'];
        }
        return 0;
    }

    /**
     * Fetch pets belonging to a specific owner
     */
    public function getPetsByOwner(int $ownerId): array {
        $stmt = $this->db->conn->prepare(
            "SELECT id, name, type, breed, age, dob, photo, owner_name, owner_phone FROM pets WHERE owner_id = ? ORDER BY created_at DESC"
        );
        $stmt->bind_param("i", $ownerId);
        $stmt->execute();
        $result = $stmt->get_result();
        
        $pets = [];
        if ($result && $result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $row['age'] = $this->calculateAgeFromDob($row['dob'], $row['age']);
                $pets[] = $row;
            }
        }
        $stmt->close();
        
        return $pets;
    }

    /**
     * Get a single pet by its ID
     */
    public function getPetById(int $id): ?array {
        $stmt = $this->db->conn->prepare("SELECT * FROM pets WHERE id = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();
        $pet = $result->fetch_assoc();
        $stmt->close();
        
        if ($pet) {
            $pet['age'] = $this->calculateAgeFromDob($pet['dob'], $pet['age']);
        }
        
        return $pet ?: null;
    }

    /**
     * Helper to calculate human-friendly age string from DOB
     */
    private function calculateAgeFromDob(?string $dob, $fallbackAge): string {
        if (empty($dob)) {
            return $fallbackAge . ' yrs';
        }
        
        try {
            $birthDate = new DateTime($dob);
            $today = new DateTime('today');
            $diff = $birthDate->diff($today);
            
            $y = $diff->y;
            $m = $diff->m;
            $d = $diff->d;

            if ($y > 0) {
                if ($m > 0) {
                    return $y . ($y == 1 ? ' yr, ' : ' yrs, ') . $m . ($m == 1 ? ' month' : ' months');
                }
                return $y . ($y == 1 ? ' yr' : ' yrs');
            }
            
            if ($m > 0) {
                return $m . ($m == 1 ? ' month' : ' months');
            }
            
            if ($d > 0) {
                return $d . ($d == 1 ? ' day' : ' days');
            }
            
            return 'Newborn';
        } catch (Exception $e) {
            return $fallbackAge . ' yrs';
        }
    }

    /**
     * Update an existing pet
     */
    public function updatePet(int $id, string $name, string $type, string $breed, int $age, ?string $photo = null, ?string $ownerName = null, ?string $ownerPhone = null, ?string $dob = null): bool {
        // If a new photo is provided, update it. Otherwise, keep the existing one.
        if ($photo !== null) {
            $stmt = $this->db->conn->prepare("UPDATE pets SET name=?, type=?, breed=?, age=?, dob=?, photo=?, owner_name=?, owner_phone=? WHERE id=?");
            $stmt->bind_param("sssissssi", $name, $type, $breed, $age, $dob, $photo, $ownerName, $ownerPhone, $id);
        } else {
            $stmt = $this->db->conn->prepare("UPDATE pets SET name=?, type=?, breed=?, age=?, dob=?, owner_name=?, owner_phone=? WHERE id=?");
            $stmt->bind_param("ssissssi", $name, $type, $breed, $age, $dob, $ownerName, $ownerPhone, $id);
        }
        $success = $stmt->execute();
        $stmt->close();
        return $success;
    }

    /**
     * Delete a pet
     */
    public function deletePet(int $id): bool {
        $stmt = $this->db->conn->prepare("DELETE FROM pets WHERE id = ?");
        $stmt->bind_param("i", $id);
        $success = $stmt->execute();
        $stmt->close();
        return $success;
    }
}
