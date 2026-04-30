<?php

class OwnerController extends Controller {

    public function __construct() {
        // Only owners can access this controller
        Auth::requireRole('owner');
    }

    public function dashboard() {
        $appointmentModel = $this->model('AppointmentModel');
        $appointments = $appointmentModel->getAppointmentsByOwner($_SESSION['user_id']);

        $data = [
            'name' => Auth::name(),
            'appointments' => array_slice($appointments, 0, 3) // show latest 3
        ];
        $this->view('owner/dashboard', $data);
    }
}
