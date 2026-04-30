<?php

/**
 * AdminController — manages administrative tasks like user approvals.
 */
class AdminController extends Controller {

    public function __construct() {
        Auth::requireRole('admin');
    }

    /**
     * Show admin dashboard
     */
    public function dashboard() {
        $userModel = $this->model('UserModel');
        $pendingUsers = $userModel->getPendingUsers();
        
        $this->view('admin/dashboard', [
            'pendingUsers' => $pendingUsers
        ]);
    }

    /**
     * Approve a user account
     */
    public function approve($id) {
        if (!$id) {
            header('Location: ?url=admin/dashboard');
            exit;
        }

        $userModel = $this->model('UserModel');
        if ($userModel->updateStatus((int)$id, 'approved')) {
            $_SESSION['flash_success'] = '✅ User account has been approved.';
        } else {
            $_SESSION['flash_error'] = '❌ Failed to approve user.';
        }

        header('Location: ?url=admin/dashboard');
        exit;
    }

    /**
     * Reject a user account
     */
    public function reject($id) {
        if (!$id) {
            header('Location: ?url=admin/dashboard');
            exit;
        }

        $userModel = $this->model('UserModel');
        if ($userModel->updateStatus((int)$id, 'rejected')) {
            $_SESSION['flash_success'] = '⚠️ User account has been rejected.';
        } else {
            $_SESSION['flash_error'] = '❌ Failed to reject user.';
        }

        header('Location: ?url=admin/dashboard');
        exit;
    }
}
