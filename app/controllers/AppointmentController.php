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
        $bookedSlots = $appointmentModel->getBookedSlots();

        $this->view('appointments/create', [
            'errors' => [],
            'bookedSlots' => $bookedSlots
        ]);
    }

    /**
     * Store a new appointment in the database.
     */
    public function store() {
        $errors = [];
        
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $petName = trim($_POST['pet_name'] ?? '');
            $date = $_POST['appointment_date'] ?? '';
            $reason = trim($_POST['reason'] ?? '');

            if (empty($petName)) $errors['pet_name'] = "Please enter your pet's name.";
            if (empty($date)) {
                $errors['appointment_date'] = "Please select a date and time.";
            } else {
                $appointmentModel = $this->model('AppointmentModel');
                if ($appointmentModel->isSlotTaken($date)) {
                    $errors['appointment_date'] = "Sorry, this time slot is already booked. Please choose another time.";
                }
            }
            if (empty($reason)) $errors['reason'] = "Please provide a reason for the appointment.";

            if (empty($errors)) {
                $appointmentModel = $this->model('AppointmentModel');
                $success = $appointmentModel->createAppointment([
                    'pet_id' => null, // Storing as name only as requested
                    'pet_name' => $petName,
                    'owner_id' => $_SESSION['user_id'],
                    'appointment_date' => $date,
                    'reason' => $reason
                ]);

                if ($success) {
                    $_SESSION['flash_success'] = "🎉 Appointment booked successfully for your " . htmlspecialchars($petName) . "!";
                    header('Location: ?url=appointment/myAppointments');
                    exit;
                } else {
                    $errors['general'] = "Failed to book appointment. Please try again.";
                }
            }
        }
        
        $this->view('appointments/create', [
            'errors' => $errors,
            'old' => $_POST
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
}
