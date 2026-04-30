<?php

class NurseController extends Controller {

    public function __construct() {
        // Only nurses can access this controller
        Auth::requireRole('nurse');
    }

    public function dashboard() {
        $data = [
            'name' => Auth::name()
        ];
        $this->view('nurse/dashboard', $data);
    }
}
