<?php

/**
 * AppointmentController — manages pet owner appointment bookings.
 */
class AppointmentController extends Controller {

    public function __construct() {
        Auth::requireRole('owner', 'nurse', 'admin');
    }

    /**
     * Show the appointment booking form.
     */
    public function create() {
        $appointmentModel = $this->model('AppointmentModel');
        $petModel = $this->model('PetModel');
        
        $bookedSlots = $appointmentModel->getBookedSlots();
        
        // If staff, get ALL pets. If owner, only THEIR pets.
        if (Auth::role() === 'owner') {
            $pets = $petModel->getPetsByOwner($_SESSION['user_id']);
        } else {
            $pets = $petModel->getAllPets();
        }

        $preselectedPetId = $_GET['pet_id'] ?? '';
        $preselectedReason = isset($_GET['vaccine']) ? 'Vaccination for: ' . $_GET['vaccine'] : '';

        $this->view('appointments/create', [
            'errors' => [],
            'bookedSlots' => $bookedSlots,
            'pets' => $pets,
            'old' => [
                'pet_id' => $preselectedPetId,
                'reason' => $preselectedReason,
                'appointment_date' => $_GET['date'] ?? ''
            ]
        ]);
    }

    /**
     * Store a new appointment in the database.
     */
    public function store() {
        $errors = [];
        $appointmentModel = $this->model('AppointmentModel');
        $petModel = $this->model('PetModel');

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $petId = $_POST['pet_id'] ?? '';
            $date = $_POST['appointment_date'] ?? '';
            $reason = trim($_POST['reason'] ?? '');

            if (empty($petId)) $errors['pet_id'] = "Please select a patient.";
            if (empty($date)) {
                $errors['appointment_date'] = "Please select a date and time.";
            } else {
                // 1. Check if it's in the past
                $selectedTime = strtotime($date);
                if ($selectedTime < time()) {
                    $errors['appointment_date'] = "You cannot book an appointment in the past.";
                }
                // 2. Check if within working hours
                elseif (!$this->isWithinWorkingHours($date)) {
                    $errors['appointment_date'] = "Selected time is outside working hours.";
                }
                // 3. Check if slot is taken
                elseif ($appointmentModel->isSlotTaken($date)) {
                    $errors['appointment_date'] = "This slot is already booked.";
                }
            }
            if (empty($reason)) $errors['reason'] = "Please provide a reason.";

            if (empty($errors)) {
                $pet = $petModel->getPetById($petId);
                $petName = $pet['name'] ?? 'Pet';
                
                // For staff, owner_id comes from the pet record. For owners, it's their own ID.
                $ownerId = (Auth::role() === 'owner') ? $_SESSION['user_id'] : $pet['owner_id'];

                $success = $appointmentModel->createAppointment([
                    'pet_id' => $petId,
                    'pet_name' => $petName,
                    'owner_id' => $ownerId,
                    'appointment_date' => $date,
                    'reason' => $reason,
                    'appointment_type' => $_POST['appointment_type'] ?? 'general'
                ]);

                if ($success) {
                    $_SESSION['flash_success'] = "🎉 Appointment booked successfully for " . htmlspecialchars($petName) . "!";
                    if (Auth::role() === 'owner') {
                        header('Location: ?url=appointment/myAppointments');
                    } else {
                        header('Location: ?url=nurse/dashboard');
                    }
                    exit;
                } else {
                    $errors['general'] = "Failed to book appointment.";
                }
            }
        }
        
        $bookedSlots = $appointmentModel->getBookedSlots();
        if (Auth::role() === 'owner') {
            $pets = $petModel->getPetsByOwner($_SESSION['user_id']);
        } else {
            $pets = $petModel->getAllPets();
        }

        $this->view('appointments/create', [
            'errors' => $errors,
            'old' => $_POST,
            'pets' => $pets,
            'bookedSlots' => $bookedSlots
        ]);
    }

    /**
     * List appointments for the logged-in owner.
     */
    public function myAppointments() {
        $appointmentModel = $this->model('AppointmentModel');
        $appointments = $appointmentModel->getAppointmentsByOwner($_SESSION['user_id']);

        $this->view('appointments/index', [
            'appointments' => $appointments
        ]);
    }

    /**
     * API Endpoint: Get statuses for a list of IDs (for real-time updates).
     */
    public function getStatuses() {
        header('Content-Type: application/json');
        $idsStr = $_GET['ids'] ?? '';
        if (empty($idsStr)) {
            echo json_encode(['status' => 'error', 'message' => 'No IDs provided']);
            exit;
        }

        $ids = explode(',', $idsStr);
        $appointmentModel = $this->model('AppointmentModel');
        $statuses = [];

        foreach ($ids as $id) {
            $appt = $appointmentModel->getAppointmentById((int)$id);
            if ($appt) {
                $statuses[$id] = $appt['status'];
            }
        }

        echo json_encode(['status' => 'success', 'statuses' => $statuses]);
        exit;
    }
    /**
     * Helper to validate working hours.
     */
    private function isWithinWorkingHours($dateStr) {
        try {
            $dt = new DateTime($dateStr);
            $dayOfWeek = (int)$dt->format('w'); // 0 (Sun) to 6 (Sat)
            $time = $dt->format('H:i');

            // Sunday (0) - Closed
            if ($dayOfWeek === 0) return false;

            // Saturday (6) - 9:00 AM to 4:00 PM
            if ($dayOfWeek === 6) {
                return ($time >= '09:00' && $time <= '16:00');
            }

            // Weekdays (1-5) - 8:00 AM to 6:00 PM (last slot at 5:30)
            return ($time >= '08:00' && $time <= '17:30');
        } catch (Exception $e) {
            return false;
        }
    }
}
