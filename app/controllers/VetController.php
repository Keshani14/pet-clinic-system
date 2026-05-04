<?php

class VetController extends Controller {

    public function __construct() {
        // Only vets can access this controller
        Auth::requireRole('vet');
    }

    public function dashboard() {
        $appointmentModel = $this->model('AppointmentModel');
        $allAppts = $appointmentModel->getAllAppointments();
        
        $stats = [
            'waiting' => 0,
            'completed_today' => 0
        ];

        $todayDate = date('Y-m-d');
        foreach ($allAppts as $appt) {
            if ($appt['status'] === 'ready') $stats['waiting']++;
            if ($appt['status'] === 'completed' && date('Y-m-d', strtotime($appt['appointment_date'])) === $todayDate) {
                $stats['completed_today']++;
            }
        }

        $data = [
            'name'  => Auth::name(),
            'stats' => $stats,
            'waiting_list' => array_filter($allAppts, function($a) { return $a['status'] === 'ready'; })
        ];
        $this->view('vet/dashboard', $data);
    }

    /**
     * Start consultation for a pet.
     */
    public function consult($id) {
        $appointmentModel = $this->model('AppointmentModel');
        $appointment = $appointmentModel->getAppointmentById((int)$id);

        if (!$appointment) {
            header('Location: ?url=vet/dashboard');
            exit;
        }

        // Set status to in-consultation
        $appointmentModel->updateStatus((int)$id, 'in-consultation');

        $this->view('vet/consult', [
            'appointment' => $appointment
        ]);
    }

    /**
     * Complete consultation and save diagnosis.
     */
    public function complete($id) {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $appointmentModel = $this->model('AppointmentModel');
            $success = $appointmentModel->updateConsultation((int)$id, [
                'diagnosis' => $_POST['diagnosis'] ?? '',
                'prescription' => $_POST['prescription'] ?? ''
            ]);

            if ($success) {
                // Also add to Medical Records for permanent storage
                $appt = $appointmentModel->getAppointmentById((int)$id);
                if ($appt && !empty($appt['pet_id'])) {
                    $mrModel = $this->model('MedicalRecordModel');
                    $mrModel->addRecord(
                        $appt['pet_id'],
                        $_SESSION['user_id'],
                        date('Y-m-d'),
                        $_POST['diagnosis'] ?? 'No diagnosis',
                        'Consultation',
                        $_POST['prescription'] ?? '',
                        'Vitals: W=' . ($appt['weight'] ?? '-') . ', T=' . ($appt['temperature'] ?? '-')
                    );
                }

                $_SESSION['flash_success'] = '🎉 Consultation completed and record saved.';
                header('Location: ?url=vet/dashboard');
                exit;
            }
        }
        header('Location: ?url=vet/dashboard');
        exit;
    }

    /**
     * List all appointments for the vet.
     */
    public function appointments() {
        $appointmentModel = $this->model('AppointmentModel');
        $appointments = $appointmentModel->getAllAppointments();

        $this->view('vet/appointments', [
            'appointments' => $appointments
        ]);
    }
}
