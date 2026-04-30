<?php

class MedicalController extends Controller {
    
    /**
     * Show summary of all medical records
     */
    public function index() {
        Auth::requireLogin();
        Auth::requireRole('vet', 'admin');

        $mrModel = $this->model('MedicalRecordModel');
        $records = $mrModel->getAllRecords();

        $this->view('medical/index', ['records' => $records]);
    }

    /**
     * Show form to add a new medical record
     */
    public function addRecord() {
        Auth::requireLogin();
        Auth::requireRole('vet', 'admin');

        if (!isset($_GET['pet_id'])) {
            header('Location: ?url=pet/listPets');
            exit;
        }

        $petId = (int)$_GET['pet_id'];
        $petModel = $this->model('PetModel');
        $pet = $petModel->getPetById($petId);

        if (!$pet) {
            header('Location: ?url=pet/listPets');
            exit;
        }

        $this->view('medical/add', ['pet' => $pet]);
    }

    /**
     * Store the new medical record
     */
    public function store() {
        Auth::requireLogin();
        Auth::requireRole('vet', 'admin');

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $petId         = (int)$_POST['pet_id'];
            $treatmentDate = trim($_POST['treatment_date'] ?? date('Y-m-d'));
            $diagnosis     = trim(htmlspecialchars($_POST['diagnosis'] ?? ''));
            $treatment     = trim(htmlspecialchars($_POST['treatment'] ?? ''));
            $medicines     = trim(htmlspecialchars($_POST['medicines'] ?? ''));
            $notes         = trim(htmlspecialchars($_POST['notes'] ?? ''));
            $vetId         = $_SESSION['user_id'];

            $errors = [];
            if (empty($treatmentDate)) $errors['treatment_date'] = "Treatment date is required.";
            if (empty($diagnosis)) $errors['diagnosis'] = "Diagnosis is required.";
            if (empty($treatment)) $errors['treatment'] = "Treatment is required.";

            if (empty($errors)) {
                $mrModel = $this->model('MedicalRecordModel');
                $success = $mrModel->addRecord($petId, $vetId, $treatmentDate, $diagnosis, $treatment, $medicines, $notes);

                if ($success) {
                    $_SESSION['flash_success'] = "✅ Medical record added successfully!";
                    header("Location: ?url=medical/viewHistory&pet_id=$petId");
                    exit;
                } else {
                    $errors['general'] = "Failed to save the record. Please try again.";
                }
            }

            // If errors, go back to add view
            $petModel = $this->model('PetModel');
            $pet = $petModel->getPetById($petId);
            $this->view('medical/add', [
                'pet' => $pet,
                'errors' => $errors,
                'old' => $_POST
            ]);
        }
    }

    /**
     * View full medical history of a pet
     */
    public function viewHistory() {
        Auth::requireLogin();
        // Owners can view history of THEIR pets. Vets/Admins can view ALL.
        
        if (!isset($_GET['pet_id'])) {
            header('Location: ?url=pet/listPets');
            exit;
        }

        $petId = (int)$_GET['pet_id'];
        $petModel = $this->model('PetModel');
        $pet = $petModel->getPetById($petId);

        if (!$pet) {
            header('Location: ?url=pet/listPets');
            exit;
        }

        // Access check for owners
        if (Auth::role() === 'owner' && $pet['owner_id'] != $_SESSION['user_id']) {
            header('Location: ?url=user/unauthorized');
            exit;
        }

        $mrModel = $this->model('MedicalRecordModel');
        $history = $mrModel->getRecordsByPetId($petId);

        $this->view('medical/history', [
            'pet' => $pet,
            'history' => $history
        ]);
    }
}
