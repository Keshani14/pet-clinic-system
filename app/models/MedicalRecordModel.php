<?php

class MedicalRecordModel {
    private $db;

    public function __construct() {
        $this->db = new Database();
    }

    /**
     * Insert a new medical record
     */
    public function addRecord(int $petId, int $vetId, string $treatmentDate, string $diagnosis, string $treatment, ?string $medicines = null, ?string $notes = null): bool {
        $stmt = $this->db->conn->prepare(
            "INSERT INTO medical_records (pet_id, vet_id, treatment_date, diagnosis, treatment, medicines, notes) VALUES (?, ?, ?, ?, ?, ?, ?)"
        );
        $stmt->bind_param("iisssss", $petId, $vetId, $treatmentDate, $diagnosis, $treatment, $medicines, $notes);
        $success = $stmt->execute();
        $stmt->close();
        return $success;
    }

    /**
     * Fetch medical history for a specific pet
     */
    public function getRecordsByPetId(int $petId): array {
        $query = "
            SELECT mr.*, u.first_name as vet_first_name, u.last_name as vet_last_name
            FROM medical_records mr
            JOIN users u ON mr.vet_id = u.id
            WHERE mr.pet_id = ?
            ORDER BY mr.treatment_date DESC, mr.created_at DESC
        ";
        
        $stmt = $this->db->conn->prepare($query);
        $stmt->bind_param("i", $petId);
        $stmt->execute();
        $result = $stmt->get_result();
        
        $records = [];
        if ($result) {
            while ($row = $result->fetch_assoc()) {
                $records[] = $row;
            }
        }
        $stmt->close();
        return $records;
    }

    /**
     * Fetch all medical records for all pets (Summary View)
     */
    public function getAllRecords(): array {
        $query = "
            SELECT mr.*, p.name as pet_name, p.type as pet_type, p.photo as pet_photo, u.first_name as vet_first_name, u.last_name as vet_last_name
            FROM medical_records mr
            JOIN pets p ON mr.pet_id = p.id
            JOIN users u ON mr.vet_id = u.id
            ORDER BY mr.treatment_date DESC, mr.created_at DESC
        ";
        
        $result = $this->db->conn->query($query);
        
        $records = [];
        if ($result) {
            while ($row = $result->fetch_assoc()) {
                $records[] = $row;
            }
        }
        return $records;
    }
}
