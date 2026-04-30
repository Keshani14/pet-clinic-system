<?php

class AdminController extends Controller {

    public function __construct() {
        // Only admins can access this controller
        Auth::requireRole('admin');
    }

    public function dashboard() {
        $data = [
            'name' => Auth::name()
        ];
        $this->view('admin/dashboard', $data);
    }
}
