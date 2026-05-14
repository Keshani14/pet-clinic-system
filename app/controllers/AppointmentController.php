<?php

/**
 * AppointmentController — manages pet owner appointment bookings.
 */
class AppointmentController extends Controller {

    public function __construct() {
        Auth::requireRole('owner');
    }

    /**
     * Show the appointment booking form.
     */
    public function create() {
        $appointmentModel = $this->model('AppointmentModel');
        $petModel = $this->model('PetModel');
        
        $bookedSlots = $appointmentModel->getBookedSlots();
        $myPets = $petModel->getPetsByOwner($_SESSION['user_id']);

        $preselectedPetId = $_GET['pet_id'] ?? '';
        $preselectedReason = isset($_GET['vaccine']) ? 'Vaccination for: ' . $_GET['vaccine'] : '';

        $this->view('appointments/create', [
            'errors' => [],
            'bookedSlots' => $bookedSlots,
            'myPets' => $myPets,
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
        
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $petId = $_POST['pet_id'] ?? '';
            $date = $_POST['appointment_date'] ?? '';
            $reason = trim($_POST['reason'] ?? '');

            if (empty($petId)) $errors['pet_id'] = "Please select your pet.";
            if (empty($date)) {
                $errors['appointment_date'] = "Please select a date and time.";
            } else {
                $appointmentModel = $this->model('AppointmentModel');
                
                // 1. Check if it's in the past
                $selectedTime = strtotime($date);
                if ($selectedTime < time()) {
                    $errors['appointment_date'] = "You cannot book an appointment in the past. Please select a future date and time.";
                }
                // 2. Check if within working hours
                elseif (!$this->isWithinWorkingHours($date)) {
                    $errors['appointment_date'] = "The clinic is closed at this time. Please select a time within our working hours: Mon-Fri (8 AM - 6 PM) or Sat (9 AM - 4 PM).";
                }
                // 3. Check if slot is taken
                elseif ($appointmentModel->isSlotTaken($date)) {
                    $errors['appointment_date'] = "Sorry, this time slot is already booked. Please choose another time.";
                }
            }
            if (empty($reason)) $errors['reason'] = "Please provide a reason for the appointment.";

            if (empty($errors)) {
                $appointmentModel = $this->model('AppointmentModel');
                $petModel = $this->model('PetModel');
                $pet = $petModel->getPetById($petId);
                $petName = $pet['name'] ?? 'Pet';

                $success = $appointmentModel->createAppointment([
                    'pet_id' => $petId,
                    'pet_name' => $petName,
                    'owner_id' => $_SESSION['user_id'],
                    'appointment_date' => $date,
                    'reason' => $reason,
                    'appointment_type' => $_POST['appointment_type'] ?? 'general'
                ]);

                if ($success) {
                    $_SESSION['flash_success'] = "🎉 Appointment booked successfully for " . htmlspecialchars($petName) . "!";
                    header('Location: ?url=appointment/myAppointments');
                    exit;
                } else {
                    $errors['general'] = "Failed to book appointment. Please try again.";
                }
            }
        }
        
        $petModel = $this->model('PetModel');
        $myPets = $petModel->getPetsByOwner($_SESSION['user_id']);
        $appointmentModel = $this->model('AppointmentModel');
        $bookedSlots = $appointmentModel->getBookedSlots();

        $this->view('appointments/create', [
            'errors' => $errors,
            'old' => $_POST,
            'myPets' => $myPets,
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
