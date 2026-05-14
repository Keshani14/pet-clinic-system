<?php

/**
 * VaccinationModel — handles vaccination schedules and clinical records.
 */
class VaccinationModel {
    private $db;

    public function __construct() {
        $this->db = new Database();
    }

    /**
     * Get upcoming or overdue vaccinations for a pet.
     */
    public function getSchedulesByPet(int $petId): array {
        $stmt = $this->db->conn->prepare(
            "SELECT * FROM vaccination_schedule 
             WHERE pet_id = ? 
             ORDER BY due_date ASC"
        );
        $stmt->bind_param("i", $petId);
        $stmt->execute();
        $result = $stmt->get_result();
        $schedules = [];
        $today = date('Y-m-d');
        
        while ($row = $result->fetch_assoc()) {
            // Auto-detect overdue
            if ($row['status'] === 'Upcoming' && $row['due_date'] < $today) {
                $row['status'] = 'Overdue';
                $this->updateScheduleStatus($row['id'], 'Overdue');
            }
            $schedules[] = $row;
        }
        $stmt->close();
        return $schedules;
    }

    /**
     * Update schedule status.
     */
    public function updateScheduleStatus(int $id, string $status): bool {
        $stmt = $this->db->conn->prepare("UPDATE vaccination_schedule SET status = ? WHERE id = ?");
        $stmt->bind_param("si", $status, $id);
        $success = $stmt->execute();
        $stmt->close();
        return $success;
    }

    /**
     * Record a vaccination administration.
     */
    public function recordVaccination(array $data): bool {
        $stmt = $this->db->conn->prepare(
            "INSERT INTO vaccinations (appointment_id, pet_id, vaccine_name, date_given, next_due_date, notes, batch_number, vet_id) 
             VALUES (?, ?, ?, ?, ?, ?, ?, ?)"
        );
        $stmt->bind_param(
            "iisssssi",
            $data['appointment_id'],
            $data['pet_id'],
            $data['vaccine_name'],
            $data['date_given'],
            $data['next_due_date'],
            $data['notes'],
            $data['batch_number'],
            $data['vet_id']
        );
        $success = $stmt->execute();
        $stmt->close();

        if ($success) {
            // Mark the schedule as completed if it exists
            $this->markAsCompleted($data['pet_id'], $data['vaccine_name']);
            
            // Create next schedule if next_due_date is provided
            if (!empty($data['next_due_date'])) {
                $this->addSchedule([
                    'pet_id' => $data['pet_id'],
                    'vaccine_name' => $data['vaccine_name'],
                    'due_date' => $data['next_due_date'],
                    'status' => 'Upcoming'
                ]);
            }
        }
        return $success;
    }

    /**
     * Mark a specific vaccine as completed in the schedule.
     */
    private function markAsCompleted(int $petId, string $vaccineName): void {
        $stmt = $this->db->conn->prepare(
            "UPDATE vaccination_schedule SET status = 'Completed' 
             WHERE pet_id = ? AND vaccine_name = ? AND status != 'Completed'
             ORDER BY due_date ASC LIMIT 1"
        );
        $stmt->bind_param("is", $petId, $vaccineName);
        $stmt->execute();
        $stmt->close();
    }

    /**
     * Add a manual schedule entry.
     */
    public function addSchedule(array $data): bool {
        $stmt = $this->db->conn->prepare(
            "INSERT INTO vaccination_schedule (pet_id, vaccine_name, due_date, status) VALUES (?, ?, ?, ?)"
        );
        $stmt->bind_param("isss", $data['pet_id'], $data['vaccine_name'], $data['due_date'], $data['status']);
        $success = $stmt->execute();
        $stmt->close();
        return $success;
    }

    /**
     * Get vaccination history for a pet.
     */
    public function getHistory(int $petId): array {
        $stmt = $this->db->conn->prepare(
            "SELECT v.*, u.first_name as vet_first, u.last_name as vet_last
             FROM vaccinations v
             JOIN users u ON v.vet_id = u.id
             WHERE v.pet_id = ?
             ORDER BY v.date_given DESC"
        );
        $stmt->bind_param("i", $petId);
        $stmt->execute();
        $result = $stmt->get_result();
        $history = [];
        while ($row = $result->fetch_assoc()) {
            $row['vet_name'] = $row['vet_first'] . ' ' . $row['vet_last'];
            $history[] = $row;
        }
        $stmt->close();
        return $history;
    }

    /**
     * Generate initial schedule based on pet type and DOB from templates.
     */
    public function generateInitialSchedule(int $petId, string $type, string $dob): void {
        $type = strtolower(trim($type));
        
        // Fetch templates for this pet type
        $stmt = $this->db->conn->prepare("SELECT * FROM vaccine_templates WHERE LOWER(pet_type) = ? AND is_active = 1");
        $stmt->bind_param("s", $type);
        $stmt->execute();
        $templates = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
        $stmt->close();

        // If no specific templates, try 'general'
        if (empty($templates)) {
            $stmt = $this->db->conn->prepare("SELECT * FROM vaccine_templates WHERE LOWER(pet_type) = 'general' AND is_active = 1");
            $stmt->execute();
            $templates = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
            $stmt->close();
        }

        $oneYearAgo = date('Y-m-d', strtotime('-1 year'));

        foreach ($templates as $t) {
            // Calculate due date: DOB + recommended_age_weeks
            $dueDate = date('Y-m-d', strtotime("+{$t['recommended_age_weeks']} weeks", strtotime($dob)));
            
            // Don't schedule if it was supposed to happen long ago (e.g., > 1 year ago)
            if ($dueDate < $oneYearAgo) {
                continue;
            }
            
            $this->addSchedule([
                'pet_id' => $petId,
                'vaccine_template_id' => $t['id'],
                'vaccine_name' => $t['vaccine_name'],
                'due_date' => $dueDate,
                'status' => 'Upcoming'
            ]);
        }
    }

    /**
     * Add a record to pet vaccination history (imported records).
     */
    public function addImportedHistory(array $data): bool {
        $stmt = $this->db->conn->prepare(
            "INSERT INTO pet_vaccination_history (pet_id, vaccine_name, date_given, next_due_date, notes, uploaded_document) 
             VALUES (?, ?, ?, ?, ?, ?)"
        );
        $stmt->bind_param(
            "isssss",
            $data['pet_id'],
            $data['vaccine_name'],
            $data['date_given'],
            $data['next_due_date'],
            $data['notes'],
            $data['uploaded_document']
        );
        $success = $stmt->execute();
        $stmt->close();
        
        if ($success && !empty($data['next_due_date'])) {
            // Mark similar upcoming schedules as completed
            $this->markAsCompleted($data['pet_id'], $data['vaccine_name']);
            
            // Add the next booster schedule
            $this->addSchedule([
                'pet_id' => $data['pet_id'],
                'vaccine_name' => $data['vaccine_name'],
                'due_date' => $data['next_due_date'],
                'status' => 'Upcoming'
            ]);
        }
        
        return $success;
    }

    /**
     * Get all history (clinical + imported).
     */
    public function getFullHistory(int $petId): array {
        $clinical = $this->getHistory($petId);
        
        $stmt = $this->db->conn->prepare("SELECT * FROM pet_vaccination_history WHERE pet_id = ? ORDER BY date_given DESC");
        $stmt->bind_param("i", $petId);
        $stmt->execute();
        $imported = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
        $stmt->close();
        
        foreach ($imported as &$imp) {
            $imp['source'] = 'Imported';
            $imp['vet_name'] = 'Owner Provided';
        }
        
        foreach ($clinical as &$clin) {
            $clin['source'] = 'Clinic';
        }
        
        $combined = array_merge($clinical, $imported);
        usort($combined, function($a, $b) {
            return strtotime($b['date_given']) - strtotime($a['date_given']);
        });
        
        return $combined;
    }

    /**
     * Get reminders for an owner's pets.
     */
    public function getReminders(int $ownerId): array {
        $stmt = $this->db->conn->prepare(
            "SELECT vs.*, p.name as pet_name 
             FROM vaccination_schedule vs
             JOIN pets p ON vs.pet_id = p.id
             WHERE p.owner_id = ? AND vs.status IN ('Upcoming', 'Overdue')
             AND vs.due_date <= DATE_ADD(CURDATE(), INTERVAL 30 DAY)
             ORDER BY vs.due_date ASC"
        );
        $stmt->bind_param("i", $ownerId);
        $stmt->execute();
        $result = $stmt->get_result();
        $reminders = [];
        while ($row = $result->fetch_assoc()) {
            $reminders[] = $row;
        }
        $stmt->close();
        return $reminders;
    }
}
