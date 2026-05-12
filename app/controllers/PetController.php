<?php

class PetController extends Controller {

    public function __construct() {
        // Ensure user is logged in to access pet management
        Auth::requireLogin();
    }

    /**
     * Show the form to add a new pet
     */
    public function addPet() {
        $data = [
            'errors'  => [],
            'success' => false,
            'old'     => []
        ];
        $this->view('pets/add', $data);
    }

    /**
     * Process the form submission to store a new pet
     */
    public function store() {
        $errors = [];
        $success = false;

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $name       = trim(htmlspecialchars($_POST['name'] ?? ''));
            $type       = trim(htmlspecialchars($_POST['type'] ?? ''));
            $breed      = trim(htmlspecialchars($_POST['breed'] ?? ''));
            $dob        = $_POST['dob'] ?? null;
            
            // Calculate age from DOB
            $age = 0;
            if (!empty($dob)) {
                $birthDate = new DateTime($dob);
                $today = new DateTime('today');
                $age = $birthDate->diff($today)->y;
            }
            $ownerName  = trim(htmlspecialchars($_POST['owner_name'] ?? ''));
            $ownerPhone = trim(htmlspecialchars($_POST['owner_phone'] ?? ''));

            // Vaccination data
            $vacStatus  = $_POST['vac_status'] ?? 'not_vaccinated';

            // Validation
            if (empty($name)) {
                $errors['name'] = 'Pet name is required.';
            }
            if (empty($type)) {
                $errors['type'] = 'Pet type is required.';
            }
            if (empty($breed)) {
                $errors['breed'] = 'Breed is required.';
            }
            if (empty($dob)) {
                $errors['dob'] = 'Date of birth is required.';
            }

            if (empty($errors)) {
                // Handle file upload
                $photoPath = null;
                if (!empty($_FILES['photo']['name']) && $_FILES['photo']['error'] === UPLOAD_ERR_OK) {
                    $uploadDir = __DIR__ . '/../../public/uploads/pets/';
                    if (!is_dir($uploadDir)) {
                        mkdir($uploadDir, 0777, true);
                    }
                    $fileExt = strtolower(pathinfo($_FILES['photo']['name'], PATHINFO_EXTENSION));
                    $allowedExts = ['jpg', 'jpeg', 'png', 'gif'];
                    
                    if (in_array($fileExt, $allowedExts)) {
                        $fileName = uniqid('pet_') . '.' . $fileExt;
                        $destination = $uploadDir . $fileName;
                        
                        if (move_uploaded_file($_FILES['photo']['tmp_name'], $destination)) {
                            $photoPath = 'uploads/pets/' . $fileName;
                        } else {
                            $errors['photo'] = 'Failed to upload photo.';
                        }
                    } else {
                        $errors['photo'] = 'Invalid file type. Only JPG, PNG, and GIF are allowed.';
                    }
                }

                if (empty($errors)) {
                    $petModel = $this->model('PetModel');
                    $vacModel = $this->model('VaccinationModel');
                    
                    $ownerId = null;
                    if (Auth::role() === 'owner') {
                        $ownerId = $_SESSION['user_id'];
                    }
                    
                    $petId = $petModel->addPet($ownerId, $name, $type, $breed, $age, $photoPath, $ownerName, $ownerPhone, $dob, $vacStatus);
                    
                    if ($petId) {
                        // Handle "Already Vaccinated" history
                        if ($vacStatus === 'already_vaccinated' || $vacStatus === 'partially_vaccinated') {
                            if (!empty($_POST['history_vac_name'])) {
                                $vacModel->addImportedHistory([
                                    'pet_id' => $petId,
                                    'vaccine_name' => $_POST['history_vac_name'],
                                    'date_given' => $_POST['history_vac_date'] ?? date('Y-m-d'),
                                    'next_due_date' => $_POST['history_vac_next'] ?? null,
                                    'notes' => 'Imported during registration',
                                    'uploaded_document' => null // Document upload logic can be added here
                                ]);
                            }
                        }

                        $success = true;
                        if ($vacStatus === 'not_vaccinated') {
                            $_SESSION['flash_success'] = '🐾 Pet added successfully! 💉 A full vaccination schedule has been generated for ' . htmlspecialchars($name) . '. Please check the Vaccination section to book appointments.';
                        } else {
                            $_SESSION['flash_success'] = '🐾 Pet added successfully!';
                        }
                        header('Location: ?url=pet/listPets');
                        exit;
                    } else {
                        $errors['general'] = 'Failed to add pet. Please try again.';
                    }
                }
            }
        }

        $data = [
            'errors'  => $errors,
            'success' => $success,
            'old'     => $_POST ?? []
        ];

        // If there are errors, show the add form again
        $this->view('pets/add', $data);
    }

    /**
     * List pets
     */
    public function listPets() {
        $petModel = $this->model('PetModel');
        
        // If the user is an owner, only show their pets. Otherwise, show all.
        if (Auth::role() === 'owner') {
            $pets = $petModel->getPetsByOwner($_SESSION['user_id']);
        } else {
            $pets = $petModel->getAllPets();
        }

        $data = [
            'pets' => $pets
        ];

        $this->view('pets/list', $data);
    }

    public function edit() {
        if (!isset($_GET['id'])) {
            header('Location: ?url=pet/listPets');
            exit;
        }
        $id = (int)$_GET['id'];
        $petModel = $this->model('PetModel');
        $pet = $petModel->getPetById($id);

        if (!$pet) {
            header('Location: ?url=pet/listPets');
            exit;
        }

        // Access check: only admins/vets/nurses, or the owner of the pet.
        if (Auth::role() === 'owner' && $pet['owner_id'] != $_SESSION['user_id']) {
            header('Location: ?url=user/unauthorized');
            exit;
        }

        $this->view('pets/edit', ['pet' => $pet]);
    }

    /**
     * View a pet profile (Read-only view)
     */
    public function profile($id = null) {
        if (!$id) {
            header('Location: ?url=pet/listPets');
            exit;
        }

        $petModel = $this->model('PetModel');
        $pet = $petModel->getPetById((int)$id);

        if (!$pet) {
            header('Location: ?url=pet/listPets');
            exit;
        }

        // Fetch medical history for this pet
        $medicalModel = $this->model('MedicalRecordModel');
        $history = $medicalModel->getHistoryByPet((int)$id);

        // Fetch vaccination history (full)
        $vaccinationModel = $this->model('VaccinationModel');
        $vaccinations = $vaccinationModel->getFullHistory((int)$id);
        $schedules = $vaccinationModel->getSchedulesByPet((int)$id);

        $this->view('pets/view', [
            'pet' => $pet,
            'history' => $history,
            'vaccinations' => $vaccinations,
            'schedules' => $schedules
        ]);
    }

    public function update() {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST' || !isset($_POST['id'])) {
            header('Location: ?url=pet/listPets');
            exit;
        }

        $id         = (int)$_POST['id'];
        $name       = trim(htmlspecialchars($_POST['name'] ?? ''));
        $type       = trim(htmlspecialchars($_POST['type'] ?? ''));
        $breed      = trim(htmlspecialchars($_POST['breed'] ?? ''));
        $dob        = $_POST['dob'] ?? null;

        // Calculate age from DOB
        $age = 0;
        if (!empty($dob)) {
            $birthDate = new DateTime($dob);
            $today = new DateTime('today');
            $age = $birthDate->diff($today)->y;
        }
        $ownerName  = trim(htmlspecialchars($_POST['owner_name'] ?? ''));
        $ownerPhone = trim(htmlspecialchars($_POST['owner_phone'] ?? ''));

        $petModel = $this->model('PetModel');
        $pet = $petModel->getPetById($id);

        if (!$pet) {
            header('Location: ?url=pet/listPets');
            exit;
        }

        // Access check
        if (Auth::role() === 'owner' && $pet['owner_id'] != $_SESSION['user_id']) {
            header('Location: ?url=user/unauthorized');
            exit;
        }

        // Handle file upload
        $photoPath = null;
        if (!empty($_FILES['photo']['name']) && $_FILES['photo']['error'] === UPLOAD_ERR_OK) {
            $uploadDir = __DIR__ . '/../../public/uploads/pets/';
            if (!is_dir($uploadDir)) {
                mkdir($uploadDir, 0777, true);
            }
            $fileExt = strtolower(pathinfo($_FILES['photo']['name'], PATHINFO_EXTENSION));
            $allowedExts = ['jpg', 'jpeg', 'png', 'gif'];
            
            if (in_array($fileExt, $allowedExts)) {
                $fileName = uniqid('pet_') . '.' . $fileExt;
                $destination = $uploadDir . $fileName;
                if (move_uploaded_file($_FILES['photo']['tmp_name'], $destination)) {
                    $photoPath = 'uploads/pets/' . $fileName;
                }
            }
        }

        $petModel->updatePet($id, $name, $type, $breed, $age, $photoPath, $ownerName, $ownerPhone, $dob);
        $_SESSION['flash_success'] = '🐾 Pet updated successfully!';
        header('Location: ?url=pet/listPets');
        exit;
    }

    public function delete() {
        if (!isset($_GET['id'])) {
            header('Location: ?url=pet/listPets');
            exit;
        }

        $id = (int)$_GET['id'];
        $petModel = $this->model('PetModel');
        $pet = $petModel->getPetById($id);

        if ($pet) {
            // Access check
            if (Auth::role() === 'owner' && $pet['owner_id'] != $_SESSION['user_id']) {
                header('Location: ?url=user/unauthorized');
                exit;
            }
            $petModel->deletePet($id);
            $_SESSION['flash_success'] = '🗑️ Pet deleted successfully!';
        }

        header('Location: ?url=pet/listPets');
        exit;
    }
}
