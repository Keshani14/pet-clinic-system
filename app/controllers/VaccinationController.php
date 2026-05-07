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
        // Fetch vaccine guide from templates
        $db = new Database();
        $res = $db->conn->query("SELECT pet_type, vaccine_name, description FROM vaccine_templates WHERE is_active = 1");
        $templates = $res->fetch_all(MYSQLI_ASSOC);
        
        $vaccineGuide = [];
        foreach ($templates as $t) {
            $guideType = $t['pet_type'];
            if (!isset($vaccineGuide[$guideType])) {
                $vaccineGuide[$guideType] = ['core' => [], 'non_core' => []];
            }
            $vaccineGuide[$guideType]['core'][] = [
                'name' => $t['vaccine_name'],
                'desc' => $t['description'],
                'frequency' => 'Based on template'
            ];
        }
        
        if (empty($vaccineGuide)) {
            $vaccineGuide = ['Other' => ['core' => [], 'non_core' => []]];
        }

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
