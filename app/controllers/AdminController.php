<?php

/**
 * AdminController — manages administrative tasks like user approvals.
 */
class AdminController extends Controller {

    public function __construct() {
        Auth::requireRole('admin');
    }

    /**
     * Show admin dashboard overview
     */
    public function dashboard() {
        $userModel = $this->model('UserModel');
        $petModel = $this->model('PetModel');
        
        $stats = [
            'pending_count' => count($userModel->getPendingUsers()),
            'total_pets'    => count($petModel->getAllPets())
        ];
        
        $this->view('admin/dashboard', [
            'stats' => $stats
        ]);
    }

    /**
     * Show list of pending join requests
     */
    public function requests() {
        $userModel = $this->model('UserModel');
        $staffUsers = $userModel->getStaffUsers();
        
        $this->view('admin/requests', [
            'staffUsers' => $staffUsers
        ]);
    }

    /**
     * Approve a user account
     */
    public function approve($id) {
        if (!$id) {
            header('Location: ?url=admin/requests');
            exit;
        }

        $userModel = $this->model('UserModel');
        if ($userModel->updateStatus((int)$id, 'approved')) {
            $_SESSION['flash_success'] = '✅ User account has been approved.';
        } else {
            $_SESSION['flash_error'] = '❌ Failed to approve user.';
        }

        header('Location: ?url=admin/requests');
        exit;
    }

    /**
     * Reject a user account
     */
    public function reject($id) {
        if (!$id) {
            header('Location: ?url=admin/requests');
            exit;
        }

        $userModel = $this->model('UserModel');
        if ($userModel->updateStatus((int)$id, 'rejected')) {
            $_SESSION['flash_success'] = '⚠️ User account has been rejected.';
        } else {
            $_SESSION['flash_error'] = '❌ Failed to reject user.';
        }

        header('Location: ?url=admin/requests');
        exit;
    }
}
