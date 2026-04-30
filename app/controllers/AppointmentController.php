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
        $petModel = $this->model('PetModel');
        $pets = $petModel->getPetsByOwner($_SESSION['user_id']);

        $this->view('appointments/create', [
            'pets' => $pets,
            'errors' => []
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

            if (empty($petId)) $errors['pet_id'] = "Please select a pet.";
            if (empty($date)) $errors['appointment_date'] = "Please select a date and time.";
            if (empty($reason)) $errors['reason'] = "Please provide a reason for the appointment.";

            if (empty($errors)) {
                $appointmentModel = $this->model('AppointmentModel');
                $success = $appointmentModel->createAppointment([
                    'pet_id' => $petId,
                    'owner_id' => $_SESSION['user_id'],
                    'appointment_date' => $date,
                    'reason' => $reason
                ]);

                if ($success) {
                    $_SESSION['flash_success'] = "🎉 Appointment booked successfully! Waiting for clinic approval.";
                    header('Location: ?url=appointment/myAppointments');
                    exit;
                } else {
                    $errors['general'] = "Failed to book appointment. Please try again.";
                }
            }
        }

        $petModel = $this->model('PetModel');
        $pets = $petModel->getPetsByOwner($_SESSION['user_id']);
        
        $this->view('appointments/create', [
            'pets' => $pets,
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
