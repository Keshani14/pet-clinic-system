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
            "INSERT INTO appointments (pet_id, pet_name, owner_id, appointment_date, reason, status) 
             VALUES (?, ?, ?, ?, ?, 'pending')"
        );
        $stmt->bind_param(
            "isiss",
            $data['pet_id'],
            $data['pet_name'],
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
            "SELECT a.*, p.name as registered_pet_name, p.type as pet_type 
             FROM appointments a
             LEFT JOIN pets p ON a.pet_id = p.id
             WHERE a.owner_id = ?
             ORDER BY a.appointment_date DESC"
        );
        $stmt->bind_param("i", $ownerId);
        $stmt->execute();
        $result = $stmt->get_result();
        $appointments = [];
        while ($row = $result->fetch_assoc()) {
            if (!empty($row['registered_pet_name'])) {
                $row['pet_name_display'] = $row['registered_pet_name'];
                $row['display_type'] = $row['pet_type'];
            } else {
                // Fallback for cases where pet_id might be null or pet was deleted
                $row['pet_name_display'] = $row['pet_name'];
                $row['display_type'] = 'Unknown';
            }
            $appointments[] = $row;
        }
        $stmt->close();
        return $appointments;
    }

    /**
     * Fetch all appointments with owner and pet details.
     */
    public function getAllAppointments(): array {
        $query = "
            SELECT a.*, p.name as registered_pet_name, p.type as pet_type,
                   u.first_name as owner_first, u.last_name as owner_last
            FROM appointments a
            LEFT JOIN pets p ON a.pet_id = p.id
            JOIN users u ON a.owner_id = u.id
            ORDER BY a.appointment_date ASC
        ";
        $result = $this->db->conn->query($query);
        $appointments = [];
        while ($row = $result->fetch_assoc()) {
            $row['pet_name_display'] = $row['registered_pet_name'] ?? $row['pet_name'];
            $row['owner_name'] = $row['owner_first'] . ' ' . $row['owner_last'];
            $appointments[] = $row;
        }
        return $appointments;
    }

    /**
     * Fetch appointments scheduled for today.
     */
    public function getTodayAppointments(): array {
        $query = "
            SELECT a.*, p.name as registered_pet_name, p.type as pet_type,
                   u.first_name as owner_first, u.last_name as owner_last
            FROM appointments a
            LEFT JOIN pets p ON a.pet_id = p.id
            JOIN users u ON a.owner_id = u.id
            WHERE DATE(a.appointment_date) = CURDATE()
            ORDER BY a.appointment_date ASC
        ";
        $result = $this->db->conn->query($query);
        $appointments = [];
        while ($row = $result->fetch_assoc()) {
            $row['pet_name_display'] = $row['registered_pet_name'] ?? $row['pet_name'];
            $row['owner_name'] = $row['owner_first'] . ' ' . $row['owner_last'];
            $appointments[] = $row;
        }
        return $appointments;
    }

    /**
     * Update appointment status.
     */
    public function updateStatus(int $id, string $status): bool {
        $stmt = $this->db->conn->prepare("UPDATE appointments SET status = ? WHERE id = ?");
        $stmt->bind_param("si", $status, $id);
        $success = $stmt->execute();
        $stmt->close();
        return $success;
    }

    /**
     * Update vitals (Nurse step).
     */
    public function updateVitals(int $id, array $data): bool {
        $stmt = $this->db->conn->prepare(
            "UPDATE appointments SET weight = ?, temperature = ?, vitals_notes = ?, status = 'ready' WHERE id = ?"
        );
        $stmt->bind_param("sssi", $data['weight'], $data['temperature'], $data['vitals_notes'], $id);
        $success = $stmt->execute();
        $stmt->close();
        return $success;
    }

    /**
     * Update consultation details (Vet step).
     */
    public function updateConsultation(int $id, array $data): bool {
        $stmt = $this->db->conn->prepare(
            "UPDATE appointments SET diagnosis = ?, prescription = ?, status = 'completed' WHERE id = ?"
        );
        $stmt->bind_param("ssi", $data['diagnosis'], $data['prescription'], $id);
        $success = $stmt->execute();
        $stmt->close();
        return $success;
    }

    /**
     * Fetch a single appointment by ID.
     */
    public function getAppointmentById(int $id): ?array {
        $stmt = $this->db->conn->prepare(
            "SELECT a.*, p.name as pet_name_orig, p.type as pet_type, 
                    u.first_name as owner_first, u.last_name as owner_last
             FROM appointments a
             LEFT JOIN pets p ON a.pet_id = p.id
             JOIN users u ON a.owner_id = u.id
             WHERE a.id = ?"
        );
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();
        $row = $result->fetch_assoc();
        if ($row) {
            $row['pet_name_display'] = $row['pet_name_orig'] ?? $row['pet_name'];
            $row['display_type'] = $row['pet_type'] ?? 'Unknown';
            $row['owner_name'] = $row['owner_first'] . ' ' . $row['owner_last'];
        }
        $stmt->close();
        return $row;
    }

    /**
     * Check if a specific time slot is already booked.
     * We consider a slot "taken" if there's an appointment within 30 minutes.
     */
    public function isSlotTaken(string $dateTime): bool {
        $stmt = $this->db->conn->prepare(
            "SELECT id FROM appointments 
             WHERE ABS(TIMESTAMPDIFF(MINUTE, appointment_date, ?)) < 30
             AND status NOT IN ('cancelled', 'rejected')
             LIMIT 1"
        );
        $stmt->bind_param("s", $dateTime);
        $stmt->execute();
        $stmt->store_result();
        $taken = $stmt->num_rows > 0;
        $stmt->close();
        return $taken;
    }

    /**
     * Get all upcoming booked slots.
     */
    public function getBookedSlots(): array {
        $query = "SELECT appointment_date FROM appointments 
                  WHERE appointment_date >= NOW() 
                  AND status NOT IN ('cancelled', 'rejected')
                  ORDER BY appointment_date ASC";
        $result = $this->db->conn->query($query);
        $slots = [];
        while ($row = $result->fetch_assoc()) {
            $slots[] = $row['appointment_date'];
        }
        return $slots;
    }
}
