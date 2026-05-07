<?php

/**
 * NurseController — handles dashboard and patient flow for nurses.
 */
class NurseController extends Controller {

    public function __construct() {
        Auth::requireRole('nurse');
    }

    /**
     * Show nurse dashboard with summary statistics and search/filter.
     */
    public function dashboard() {
        $appointmentModel = $this->model('AppointmentModel');
        
        $query  = $_GET['q'] ?? null;
        $status = $_GET['status'] ?? null;
        $date   = $_GET['date'] ?? null; // Removed default today

        $appointments = $appointmentModel->searchAppointments($query, $status, $date);
        $todayAppts = $appointmentModel->getTodayAppointments();

        // Calculate stats
        $stats = [
            'total_today' => count($todayAppts),
            'pending' => 0,
            'confirmed' => 0,
            'checked_in' => 0,
            'ready' => 0
        ];

        foreach ($todayAppts as $appt) {
            if ($appt['status'] === 'pending') $stats['pending']++;
            if ($appt['status'] === 'confirmed') $stats['confirmed']++;
            if ($appt['status'] === 'checked-in') $stats['checked_in']++;
            if ($appt['status'] === 'ready') $stats['ready']++;
        }

        $this->view('nurse/appointments', [
            'name' => Auth::name(),
            'stats' => $stats,
            'appointments' => $appointments,
            'filters' => [
                'q' => $query,
                'status' => $status,
                'date' => $date
            ]
        ]);
    }

    /**
     * Alias for dashboard - Patient Queue.
     */
    public function appointments() {
        $this->dashboard();
    }

    /**
     * Confirm a pending appointment.
     */
    public function confirm($id) {
        $appointmentModel = $this->model('AppointmentModel');
        if ($appointmentModel->updateStatus((int)$id, 'confirmed', $_SESSION['user_id'])) {
            $_SESSION['flash_success'] = '✅ Appointment confirmed.';
        }
        header('Location: ' . ($_SERVER['HTTP_REFERER'] ?? '?url=nurse/dashboard'));
        exit;
    }

    /**
     * Mark an appointment as 'checked-in'.
     */
    public function checkIn($id) {
        $appointmentModel = $this->model('AppointmentModel');
        if ($appointmentModel->updateStatus((int)$id, 'checked-in', $_SESSION['user_id'])) {
            $_SESSION['flash_success'] = '📍 Patient checked in. Please record vitals and symptoms.';
            header('Location: ?url=nurse/prepare/' . $id);
            exit;
        }
        header('Location: ?url=nurse/dashboard');
        exit;
    }

    /**
     * Show form to prepare patient (vitals).
     */
    public function prepare($id) {
        $appointmentModel = $this->model('AppointmentModel');
        $appointment = $appointmentModel->getAppointmentById((int)$id);

        if (!$appointment) {
            header('Location: ?url=nurse/dashboard');
            exit;
        }

        $this->view('nurse/prepare', [
            'appointment' => $appointment
        ]);
    }

    /**
     * Save vitals and mark as ready for vet.
     */
    public function saveVitals($id) {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $appointmentModel = $this->model('AppointmentModel');
            $nurseNoteModel = $this->model('NurseNoteModel');

            $data = [
                'appointment_id' => (int)$id,
                'weight' => $_POST['weight'] ?? '',
                'temperature' => $_POST['temperature'] ?? '',
                'symptoms' => $_POST['symptoms'] ?? '',
                'notes' => $_POST['notes'] ?? '',
                'created_by' => $_SESSION['user_id']
            ];

            if ($nurseNoteModel->saveNote($data)) {
                $appointmentModel->updateStatus((int)$id, 'ready', $_SESSION['user_id']);
                $_SESSION['flash_success'] = '🎯 Vitals saved. Patient is now in the Vet queue.';
            } else {
                $_SESSION['flash_error'] = '❌ Failed to save vitals.';
            }
        }
        header('Location: ?url=nurse/dashboard');
        exit;
    }
    
}
