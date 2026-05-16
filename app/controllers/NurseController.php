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
        
        // Get stats for today
        $today = date('Y-m-d');
        $allToday = $appointmentModel->searchAppointments(null, null, $today);
        
        $stats = [
            'total_today' => count($allToday),
            'pending' => 0,
            'confirmed' => 0,
            'checked_in' => 0,
            'ready' => 0
        ];

        foreach ($allToday as $appt) {
            if ($appt['status'] === 'pending') $stats['pending']++;
            if ($appt['status'] === 'confirmed') $stats['confirmed']++;
            if ($appt['status'] === 'checked-in') $stats['checked_in']++;
            if ($appt['status'] === 'ready') $stats['ready']++;
        }

        // Get 5 most recent activity items for today
        $recent = array_slice($allToday, 0, 5);

        $this->view('nurse/dashboard', [
            'name' => Auth::name(),
            'stats' => $stats,
            'recent' => $recent
        ]);
    }

    /**
     * Patient Queue — detailed list with search and filters.
     */
    public function appointments() {
        $appointmentModel = $this->model('AppointmentModel');
        
        $query  = $_GET['q'] ?? null;
        $status = $_GET['status'] ?? null;
        
        $dateParam = $_GET['date'] ?? 'default';
        if ($dateParam === 'default') {
            $date = date('Y-m-d');
        } elseif ($dateParam === '') {
            $date = null;
        } else {
            $date = $dateParam;
        }

        $appointments = $appointmentModel->searchAppointments($query, $status, $date);

        // Calculate stats for the current view
        $stats = [
            'total_today' => count($appointments),
            'pending' => 0,
            'confirmed' => 0,
            'checked_in' => 0,
            'ready' => 0
        ];

        foreach ($appointments as $appt) {
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
     * API Endpoint: Get real-time stats for the dashboard notification bar.
     */
    public function getLiveStats() {
        header('Content-Type: application/json');
        
        $appointmentModel = $this->model('AppointmentModel');
        
        // Match the dashboard logic: if date is provided, use it, else use today
        $dateParam = $_GET['date'] ?? 'default';
        if ($dateParam === 'default') {
            $date = date('Y-m-d');
        } elseif ($dateParam === '') {
            $date = null;
        } else {
            $date = $dateParam;
        }
        
        $appointments = $appointmentModel->searchAppointments(null, null, $date);

        $stats = [
            'total_today' => count($appointments),
            'pending' => 0,
            'confirmed' => 0,
            'checked_in' => 0,
            'ready' => 0
        ];

        foreach ($appointments as $appt) {
            if ($appt['status'] === 'pending') $stats['pending']++;
            if ($appt['status'] === 'confirmed') $stats['confirmed']++;
            if ($appt['status'] === 'checked-in') $stats['checked_in']++;
            if ($appt['status'] === 'ready') $stats['ready']++;
        }

        echo json_encode(['status' => 'success', 'data' => $stats]);
        exit;
    }

    /**
     * Confirm a pending appointment.
     */
    public function confirm($id) {
        $appointmentModel = $this->model('AppointmentModel');
        if ($appointmentModel->updateStatus((int)$id, 'confirmed', $_SESSION['user_id'])) {
            $_SESSION['flash_success'] = '✅ Appointment confirmed.';
        }
        header('Location: ?url=nurse/dashboard');
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
     * Manually mark an appointment as 'ready' for the vet.
     */
    public function markReady($id) {
        $appointmentModel = $this->model('AppointmentModel');
        if ($appointmentModel->updateStatus((int)$id, 'ready', $_SESSION['user_id'])) {
            $_SESSION['flash_success'] = '🎯 Patient marked as Ready for Vet.';
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
