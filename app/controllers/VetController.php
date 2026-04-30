<?php

class VetController extends Controller {

    public function __construct() {
        // Only vets can access this controller
        Auth::requireRole('vet');
    }

    public function dashboard() {
        $data = [
            'name' => Auth::name()
        ];
        $this->view('vet/dashboard', $data);
    }
}
