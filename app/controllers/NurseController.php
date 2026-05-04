<?php

/**
 * NurseController — handles dashboard and patient flow for nurses.
 */
class NurseController extends Controller {

    public function __construct() {
        Auth::requireRole('nurse');
    }

    /**
     * Show nurse dashboard with summary statistics.
     */
    public function dashboard() {
        $appointmentModel = $this->model('AppointmentModel');
        $todayAppts = $appointmentModel->getTodayAppointments();

        // Calculate stats
        $stats = [
            'total_today' => count($todayAppts),
            'pending' => 0,
            'ready' => 0
        ];

        foreach ($todayAppts as $appt) {
            if ($appt['status'] === 'pending') $stats['pending']++;
            if ($appt['status'] === 'ready') $stats['ready']++;
        }

        $this->view('nurse/dashboard', [
            'name' => Auth::name(),
            'stats' => $stats,
            'recent' => array_slice($todayAppts, 0, 5)
        ]);
    }

    /**
     * List all appointments for the nurse to manage.
     */
    public function appointments() {
        $appointmentModel = $this->model('AppointmentModel');
        $appointments = $appointmentModel->getAllAppointments();

        $this->view('nurse/appointments', [
            'appointments' => $appointments
        ]);
    }

    /**
     * Confirm a pending appointment.
     */
    public function confirm($id) {
        if (!$id) {
            header('Location: ?url=nurse/appointments');
            exit;
        }
        $appointmentModel = $this->model('AppointmentModel');
        if ($appointmentModel->updateStatus((int)$id, 'confirmed')) {
            $_SESSION['flash_success'] = '✅ Appointment confirmed.';
        }
        header('Location: ' . ($_SERVER['HTTP_REFERER'] ?? '?url=nurse/appointments'));
        exit;
    }

    /**
     * Mark an appointment as 'checked-in'.
     */
    public function checkIn($id) {
        if (!$id) {
            header('Location: ?url=nurse/appointments');
            exit;
        }

        $appointmentModel = $this->model('AppointmentModel');
        if ($appointmentModel->updateStatus((int)$id, 'checked-in')) {
            $_SESSION['flash_success'] = '✅ Patient checked in successfully.';
        } else {
            $_SESSION['flash_error'] = '❌ Failed to update status.';
        }

        header('Location: ' . ($_SERVER['HTTP_REFERER'] ?? '?url=nurse/appointments'));
        exit;
    }

    /**
     * Show form to prepare patient (vitals).
     */
    public function prepare($id) {
        $appointmentModel = $this->model('AppointmentModel');
        $appointment = $appointmentModel->getAppointmentById((int)$id);

        if (!$appointment) {
            header('Location: ?url=nurse/appointments');
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
            $success = $appointmentModel->updateVitals((int)$id, [
                'weight' => $_POST['weight'] ?? '',
                'temperature' => $_POST['temperature'] ?? '',
                'vitals_notes' => $_POST['vitals_notes'] ?? ''
            ]);

            if ($success) {
                $_SESSION['flash_success'] = '🎯 Vitals saved. Patient is now in the Vet queue.';
                header('Location: ?url=nurse/appointments');
                exit;
            }
        }
        header('Location: ?url=nurse/appointments');
        exit;
    }


}
