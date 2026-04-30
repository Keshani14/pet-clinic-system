<?php

class OwnerController extends Controller {

    public function __construct() {
        // Only owners can access this controller
        Auth::requireRole('owner');
    }

    public function dashboard() {
        $data = [
            'name' => Auth::name()
        ];
        $this->view('owner/dashboard', $data);
    }
}
