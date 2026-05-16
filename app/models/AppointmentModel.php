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
        $type = $data['appointment_type'] ?? 'general';
        $stmt = $this->db->conn->prepare(
            "INSERT INTO appointments (pet_id, pet_name, owner_id, appointment_date, reason, status, appointment_type) 
             VALUES (?, ?, ?, ?, ?, 'pending', ?)"
        );
        $stmt->bind_param(
            "isisss",
            $data['pet_id'],
            $data['pet_name'],
            $data['owner_id'],
            $data['appointment_date'],
            $data['reason'],
            $type
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
     * Update appointment status with logging and validation.
     */
    public function updateStatus(int $id, string $status, ?int $updatedBy = null): bool {
        // Fetch current status for logging
        $currentAppt = $this->getAppointmentById($id);
        $oldStatus = $currentAppt['status'] ?? null;

        // Simple validation: Cannot update from cancelled or completed unless by admin
        if ($oldStatus === 'cancelled' || $oldStatus === 'completed') {
            if (Auth::role() !== 'admin') {
                return false;
            }
        }
        
        $stmt = $this->db->conn->prepare("UPDATE appointments SET status = ? WHERE id = ?");
        $stmt->bind_param("si", $status, $id);
        $success = $stmt->execute();
        $stmt->close();

        if ($success && $updatedBy) {
            // Log the change
            $stmtLog = $this->db->conn->prepare(
                "INSERT INTO status_logs (appointment_id, old_status, new_status, updated_by) VALUES (?, ?, ?, ?)"
            );
            $stmtLog->bind_param("issi", $id, $oldStatus, $status, $updatedBy);
            $stmtLog->execute();
            $stmtLog->close();
            
            // Handle specific timestamps
            if ($status === 'checked-in') {
                $this->db->conn->query("UPDATE appointments SET checked_in_at = NOW(), nurse_id = $updatedBy WHERE id = $id");
            } elseif ($status === 'ready') {
                $this->db->conn->query("UPDATE appointments SET ready_at = NOW() WHERE id = $id");
            } elseif ($status === 'in-consultation') {
                $this->db->conn->query("UPDATE appointments SET consultation_started_at = NOW() WHERE id = $id");
            } elseif ($status === 'completed') {
                $this->db->conn->query("UPDATE appointments SET completed_at = NOW() WHERE id = $id");
            }
        }
        
        return $success;
    }

    /**
     * Search and Filter appointments (for Nurse Dashboard).
     */
    public function searchAppointments(?string $query = null, ?string $status = null, ?string $date = null): array {
        $sql = "SELECT a.*, p.name as pet_name_orig, p.type as pet_type, p.age as pet_age, p.dob as pet_dob,
                       u.first_name as owner_first, u.last_name as owner_last,
                       nn.weight, nn.temperature, nn.symptoms, nn.notes as nurse_notes
                FROM appointments a
                LEFT JOIN pets p ON a.pet_id = p.id
                JOIN users u ON a.owner_id = u.id
                LEFT JOIN nurse_notes nn ON a.id = nn.appointment_id
                WHERE 1=1";
        
        $params = [];
        $types = "";

        if ($query) {
            $sql .= " AND (p.name LIKE ? OR u.first_name LIKE ? OR u.last_name LIKE ?)";
            $q = "%$query%";
            array_push($params, $q, $q, $q);
            $types .= "sss";
        }

        if ($status && $status !== 'all') {
            $sql .= " AND a.status = ?";
            array_push($params, $status);
            $types .= "s";
        }

        if ($date) {
            $sql .= " AND DATE(a.appointment_date) = ?";
            array_push($params, $date);
            $types .= "s";
        }

        $sql .= " ORDER BY a.appointment_date ASC";

        $stmt = $this->db->conn->prepare($sql);
        if (!empty($params)) {
            $stmt->bind_param($types, ...$params);
        }
        
        $stmt->execute();
        $result = $stmt->get_result();
        $appts = [];
        while ($row = $result->fetch_assoc()) {
            $row['pet_name_display'] = $row['pet_name_orig'] ?? $row['pet_name'];
            $row['display_type'] = $row['pet_type'] ?? 'Unknown';
            $row['owner_name'] = $row['owner_first'] . ' ' . $row['owner_last'];
            $appts[] = $row;
        }
        $stmt->close();
        return $appts;
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
                    u.first_name as owner_first, u.last_name as owner_last,
                    nn.weight, nn.temperature, nn.symptoms, nn.notes as nurse_notes
             FROM appointments a
             LEFT JOIN pets p ON a.pet_id = p.id
             JOIN users u ON a.owner_id = u.id
             LEFT JOIN nurse_notes nn ON a.id = nn.appointment_id
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
