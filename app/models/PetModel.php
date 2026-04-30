<?php

class PetModel {
    private $db;

    public function __construct() {
        $this->db = new Database();
    }

    /**
     * Add a new pet to the database
     */
    public function addPet(?int $ownerId, string $name, string $type, string $breed, int $age, ?string $photo = null, ?string $ownerName = null, ?string $ownerPhone = null): bool {
        $stmt = $this->db->conn->prepare(
            "INSERT INTO pets (owner_id, name, type, breed, age, photo, owner_name, owner_phone) VALUES (?, ?, ?, ?, ?, ?, ?, ?)"
        );
        $stmt->bind_param("isssisss", $ownerId, $name, $type, $breed, $age, $photo, $ownerName, $ownerPhone);
        $success = $stmt->execute();
        $stmt->close();
        
        return $success;
    }

    /**
     * Fetch all pets (with owner details)
     */
    public function getAllPets(): array {
        $query = "
            SELECT p.id, p.name, p.type, p.breed, p.age, p.photo, p.owner_name, p.owner_phone,
                   u.first_name AS owner_first_name, u.last_name AS owner_last_name, u.phone AS owner_phone_user
            FROM pets p
            LEFT JOIN users u ON p.owner_id = u.id
            ORDER BY p.created_at DESC
        ";
        
        $result = $this->db->conn->query($query);
        $pets = [];
        
        if ($result && $result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
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
            "SELECT id, name, type, breed, age, photo, owner_name, owner_phone FROM pets WHERE owner_id = ? ORDER BY created_at DESC"
        );
        $stmt->bind_param("i", $ownerId);
        $stmt->execute();
        $result = $stmt->get_result();
        
        $pets = [];
        if ($result && $result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
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
        return $pet ?: null;
    }

    /**
     * Update an existing pet
     */
    public function updatePet(int $id, string $name, string $type, string $breed, int $age, ?string $photo = null, ?string $ownerName = null, ?string $ownerPhone = null): bool {
        // If a new photo is provided, update it. Otherwise, keep the existing one.
        if ($photo !== null) {
            $stmt = $this->db->conn->prepare("UPDATE pets SET name=?, type=?, breed=?, age=?, photo=?, owner_name=?, owner_phone=? WHERE id=?");
            $stmt->bind_param("sssisssi", $name, $type, $breed, $age, $photo, $ownerName, $ownerPhone, $id);
        } else {
            $stmt = $this->db->conn->prepare("UPDATE pets SET name=?, type=?, breed=?, age=?, owner_name=?, owner_phone=? WHERE id=?");
            $stmt->bind_param("sssissi", $name, $type, $breed, $age, $ownerName, $ownerPhone, $id);
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
