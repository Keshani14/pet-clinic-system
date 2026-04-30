<?php

/**
 * AppointmentModel — handles database operations for pet appointments.
 */
class AppointmentModel {

    private $db;

    public function __construct() {
        $this->db = new Database();
    }

    /**
     * Create a new appointment record.
     */
    public function createAppointment(array $data): bool {
        $stmt = $this->db->conn->prepare(
            "INSERT INTO appointments (pet_id, owner_id, appointment_date, reason, status) 
             VALUES (?, ?, ?, ?, 'pending')"
        );
        $stmt->bind_param(
            "iiss",
            $data['pet_id'],
            $data['owner_id'],
            $data['appointment_date'],
            $data['reason']
        );
        $success = $stmt->execute();
        $stmt->close();
        return $success;
    }

    /**
     * Fetch all appointments for a specific owner.
     */
    public function getAppointmentsByOwner(int $ownerId): array {
        $stmt = $this->db->conn->prepare(
            "SELECT a.*, p.name as pet_name 
             FROM appointments a
             JOIN pets p ON a.pet_id = p.id
             WHERE a.owner_id = ?
             ORDER BY a.appointment_date DESC"
        );
        $stmt->bind_param("i", $ownerId);
        $stmt->execute();
        $result = $stmt->get_result();
        $appointments = [];
        while ($row = $result->fetch_assoc()) {
            $appointments[] = $row;
        }
        $stmt->close();
        return $appointments;
    }
}
