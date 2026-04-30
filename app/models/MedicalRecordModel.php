<?php

class MedicalRecordModel {
    private $db;

    public function __construct() {
        $this->db = new Database();
    }

    /**
     * Insert a new medical record
     */
    public function addRecord(int $petId, int $vetId, string $treatmentDate, string $diagnosis, string $treatment, ?string $notes = null): bool {
        $stmt = $this->db->conn->prepare(
            "INSERT INTO medical_records (pet_id, vet_id, treatment_date, diagnosis, treatment, notes) VALUES (?, ?, ?, ?, ?, ?)"
        );
        $stmt->bind_param("iissss", $petId, $vetId, $treatmentDate, $diagnosis, $treatment, $notes);
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
}
