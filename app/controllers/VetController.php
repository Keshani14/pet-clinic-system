<?php

class VetController extends Controller {

    public function __construct() {
        // Only vets can access this controller
        Auth::requireRole('vet');
    }

    public function dashboard() {
        $appointmentModel = $this->model('AppointmentModel');
        // Show all patients with status 'ready', regardless of scheduled date
        $waitingList = $appointmentModel->searchAppointments(null, 'ready', null);
        
        $allAppts = $appointmentModel->getAllAppointments();
        
        $stats = [
            'waiting' => count($waitingList),
            'completed_today' => 0
        ];

        $todayDate = date('Y-m-d');
        foreach ($allAppts as $appt) {
            if ($appt['status'] === 'completed' && !empty($appt['completed_at']) && date('Y-m-d', strtotime($appt['completed_at'])) === $todayDate) {
                $stats['completed_today']++;
            }
        }

        $data = [
            'name'  => Auth::name(),
            'stats' => $stats,
            'waiting_list' => $waitingList
        ];
        $this->view('vet/dashboard', $data);
    }

    /**
     * Start consultation for a pet.
     */
    public function consult($id) {
        $appointmentModel = $this->model('AppointmentModel');
        $nurseNoteModel = $this->model('NurseNoteModel');
        
        $appointment = $appointmentModel->getAppointmentById((int)$id);
        $nurseNote = $nurseNoteModel->getNoteByAppointment((int)$id);

        if (!$appointment) {
            header('Location: ?url=vet/dashboard');
            exit;
        }

        // Set status to in-consultation and log it
        $appointmentModel->updateStatus((int)$id, 'in-consultation', $_SESSION['user_id']);

        $this->view('vet/consult', [
            'appointment' => $appointment,
            'nurseNote' => $nurseNote
        ]);
    }

    /**
     * Complete consultation and save diagnosis.
     */
    public function complete($id) {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $appointmentModel = $this->model('AppointmentModel');
            
            // Log completion status
            $appointmentModel->updateStatus((int)$id, 'completed', $_SESSION['user_id']);
            
            // Update consultation details
            $success = $appointmentModel->updateConsultation((int)$id, [
                'diagnosis' => $_POST['diagnosis'] ?? '',
                'prescription' => $_POST['prescription'] ?? ''
            ]);

            if ($success) {
                // Also add to Medical Records for permanent storage
                $appt = $appointmentModel->getAppointmentById((int)$id);
                if ($appt && !empty($appt['pet_id'])) {
                    $mrModel = $this->model('MedicalRecordModel');
                    $nurseNoteModel = $this->model('NurseNoteModel');
                    $nurseNote = $nurseNoteModel->getNoteByAppointment((int)$id);
                    
                    $vitalsStr = $nurseNote ? "W: {$nurseNote['weight']}kg, T: {$nurseNote['temperature']}C" : "No vitals";

                    // Record Vaccination if applicable
                    if (($_POST['appointment_type'] ?? '') === 'vaccination') {
                        $vacModel = $this->model('VaccinationModel');
                        $vacModel->recordVaccination([
                            'appointment_id' => $id,
                            'pet_id' => $appt['pet_id'],
                            'vaccine_name' => $_POST['vaccine_name'] ?? 'General Vaccine',
                            'date_given' => $_POST['date_given'] ?? date('Y-m-d'),
                            'next_due_date' => $_POST['next_due_date'] ?? null,
                            'notes' => $_POST['diagnosis'] ?? '',
                            'batch_number' => $_POST['batch_number'] ?? '',
                            'vet_id' => $_SESSION['user_id']
                        ]);
                    }

                    $mrModel->addRecord(
                        $appt['pet_id'],
                        $_SESSION['user_id'],
                        date('Y-m-d'),
                        ($_POST['appointment_type'] === 'vaccination' ? 'Vaccination: ' . $_POST['vaccine_name'] : ($_POST['diagnosis'] ?? 'No diagnosis')),
                        ($_POST['appointment_type'] === 'vaccination' ? 'Vaccination' : 'Consultation'),
                        $_POST['prescription'] ?? '',
                        'Vitals: ' . $vitalsStr . '. Symptoms: ' . ($nurseNote['symptoms'] ?? 'None')
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
