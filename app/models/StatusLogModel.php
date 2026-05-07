<?php

class StatusLogModel {
    private $db;

    public function __construct() {
        $this->db = new Database();
    }

    /**
     * Record a status change.
     */
    public function log(int $appointmentId, ?string $oldStatus, string $newStatus, int $updatedBy): bool {
        $stmt = $this->db->conn->prepare(
            "INSERT INTO status_logs (appointment_id, old_status, new_status, updated_by) VALUES (?, ?, ?, ?)"
        );
        $stmt->bind_param("issi", $appointmentId, $oldStatus, $newStatus, $updatedBy);
        $success = $stmt->execute();
        $stmt->close();
        return $success;
    }

    /**
     * Get status history for an appointment.
     */
    public function getLogsByAppointment(int $appointmentId): array {
        $stmt = $this->db->conn->prepare(
            "SELECT sl.*, u.first_name, u.last_name, u.role 
             FROM status_logs sl
             JOIN users u ON sl.updated_by = u.id
             WHERE sl.appointment_id = ?
             ORDER BY sl.updated_at ASC"
        );
        $stmt->bind_param("i", $appointmentId);
        $stmt->execute();
        $result = $stmt->get_result();
        $logs = [];
        while ($row = $result->fetch_assoc()) {
            $logs[] = $row;
        }
        $stmt->close();
        return $logs;
    }
}
