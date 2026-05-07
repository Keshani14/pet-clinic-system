<?php

class NurseNoteModel {
    private $db;

    public function __construct() {
        $this->db = new Database();
    }

    /**
     * Save pre-consultation vitals and notes.
     */
    public function saveNote(array $data): bool {
        $stmt = $this->db->conn->prepare(
            "INSERT INTO nurse_notes (appointment_id, weight, temperature, symptoms, notes, created_by) 
             VALUES (?, ?, ?, ?, ?, ?)"
        );
        $stmt->bind_param("issssi", 
            $data['appointment_id'], 
            $data['weight'], 
            $data['temperature'], 
            $data['symptoms'], 
            $data['notes'], 
            $data['created_by']
        );
        $success = $stmt->execute();
        $stmt->close();
        return $success;
    }

    /**
     * Get nurse notes for an appointment.
     */
    public function getNoteByAppointment(int $appointmentId): ?array {
        $stmt = $this->db->conn->prepare(
            "SELECT nn.*, u.first_name, u.last_name 
             FROM nurse_notes nn
             JOIN users u ON nn.created_by = u.id
             WHERE nn.appointment_id = ?
             ORDER BY nn.created_at DESC LIMIT 1"
        );
        $stmt->bind_param("i", $appointmentId);
        $stmt->execute();
        $result = $stmt->get_result();
        $note = $result->fetch_assoc();
        $stmt->close();
        return $note;
    }
}
