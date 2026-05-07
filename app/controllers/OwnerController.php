<?php

class OwnerController extends Controller {

    public function __construct() {
        // Only owners can access this controller
        Auth::requireRole('owner');
    }

    public function dashboard() {
        $appointmentModel = $this->model('AppointmentModel');
        $vaccinationModel = $this->model('VaccinationModel');
        
        $appointments = $appointmentModel->getAppointmentsByOwner($_SESSION['user_id']);
        $reminders = $vaccinationModel->getReminders($_SESSION['user_id']);

        $data = [
            'name' => Auth::name(),
            'appointments' => array_slice($appointments, 0, 3),
            'reminders' => $reminders
        ];
        $this->view('owner/dashboard', $data);
    }

    /**
     * Show comprehensive vaccination history and upcoming schedules for owner's pets.
     */
    public function vaccinations() {
        $petModel = $this->model('PetModel');
        $vaccinationModel = $this->model('VaccinationModel');
        
        $myPets = $petModel->getPetsByOwner($_SESSION['user_id']);
        $fullHistory = [];
        $allSchedules = [];

        foreach ($myPets as $pet) {
            $fullHistory[$pet['id']] = $vaccinationModel->getHistory($pet['id']);
            $allSchedules[$pet['id']] = $vaccinationModel->getSchedulesByPet($pet['id']);
        }

        $data = [
            'pets' => $myPets,
            'history' => $fullHistory,
            'schedules' => $allSchedules
        ];
        $this->view('owner/vaccinations', $data);
    }
}
