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

        $this->view('appointments/create', [
            'errors' => [],
            'bookedSlots' => $bookedSlots,
            'myPets' => $myPets,
            'old' => ['pet_id' => $preselectedPetId]
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
                if ($appointmentModel->isSlotTaken($date)) {
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
                    'reason' => $reason
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
}
