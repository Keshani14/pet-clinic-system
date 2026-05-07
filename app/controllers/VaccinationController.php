<?php

class VaccinationController extends Controller {

    public function __construct() {
        Auth::requireRole('owner');
    }

    /**
     * Show the required vaccinations for the owner's pets.
     */
    public function index() {
        $petModel = $this->model('PetModel');
        $myPets = $petModel->getPetsByOwner($_SESSION['user_id']);

        // Vaccination schedule data (Core and Non-Core)
        $vaccineGuide = [
            'Dog' => [
                'core' => [
                    ['name' => 'Rabies', 'desc' => 'Mandatory. Prevents fatal viral disease.', 'frequency' => 'Every 1-3 years'],
                    ['name' => 'DHPP', 'desc' => 'Distemper, Hepatitis, Parainfluenza, Parvovirus.', 'frequency' => 'Every 3 years'],
                ],
                'non_core' => [
                    ['name' => 'Bordetella', 'desc' => 'Prevents Kennel Cough. Recommended for social dogs.', 'frequency' => 'Annually'],
                    ['name' => 'Leptospirosis', 'desc' => 'Prevents bacterial disease from wildlife/water.', 'frequency' => 'Annually'],
                ]
            ],
            'Cat' => [
                'core' => [
                    ['name' => 'Rabies', 'desc' => 'Mandatory. Prevents fatal viral disease.', 'frequency' => 'Every 1-3 years'],
                    ['name' => 'FVRCP', 'desc' => 'Rhinotracheitis, Calicivirus, Panleukopenia.', 'frequency' => 'Every 3 years'],
                ],
                'non_core' => [
                    ['name' => 'FeLV', 'desc' => 'Feline Leukemia. Recommended for outdoor cats.', 'frequency' => 'Annually'],
                ]
            ],
            'Other' => [
                'core' => [
                    ['name' => 'General Checkup', 'desc' => 'Basic health screening and parasite control.', 'frequency' => 'Bi-annually'],
                ],
                'non_core' => []
            ]
        ];

        $this->view('vaccinations/index', [
            'myPets' => $myPets,
            'vaccineGuide' => $vaccineGuide,
            'typeMapper' => function($rawType) use ($vaccineGuide) {
                $type = trim(strtolower($rawType));
                if (in_array($type, ['cat', 'feline', 'persian', 'siamese', 'kitten'])) return 'Cat';
                if (in_array($type, ['dog', 'canine', 'puppy', 'hound', 'retriever'])) return 'Dog';
                return 'Other';
            }
        ]);
    }
}
