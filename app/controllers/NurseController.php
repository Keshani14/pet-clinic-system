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
     * Mark an appointment as 'ready' for the vet.
     */
    public function markReady($id) {
        if (!$id) {
            header('Location: ?url=nurse/appointments');
            exit;
        }

        $appointmentModel = $this->model('AppointmentModel');
        if ($appointmentModel->updateStatus((int)$id, 'ready')) {
            $_SESSION['flash_success'] = '🎯 Patient marked as READY for the Vet.';
        } else {
            $_SESSION['flash_error'] = '❌ Failed to update status.';
        }

        header('Location: ' . ($_SERVER['HTTP_REFERER'] ?? '?url=nurse/appointments'));
        exit;
    }
}
