<?php

class VetController extends Controller {

    public function __construct() {
        // Only vets can access this controller
        Auth::requireRole('vet');
    }

    public function dashboard() {
        $petModel = $this->model('PetModel');
        $totalPets = $petModel->getTotalPetsCount();
        // We'll also fetch a small subset of recently added pets for the activity feed
        $recentPets = array_slice($petModel->getAllPets(), 0, 5);

        $data = [
            'name'       => Auth::name(),
            'totalPets'  => $totalPets,
            'recentPets' => $recentPets
        ];
        $this->view('vet/dashboard', $data);
    }
}
