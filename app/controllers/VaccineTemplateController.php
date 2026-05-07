<?php

class VaccineTemplateController extends Controller {

    public function __construct() {
        Auth::requireRole('admin');
    }

    public function index() {
        $db = new Database();
        $res = $db->conn->query("SELECT * FROM vaccine_templates ORDER BY pet_type, recommended_age_weeks");
        $templates = $res->fetch_all(MYSQLI_ASSOC);
        
        $this->view('admin/vaccine_templates', ['templates' => $templates]);
    }

    public function store() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $type = $_POST['pet_type'];
            $name = $_POST['vaccine_name'];
            $age = (int)$_POST['recommended_age_weeks'];
            $booster = (int)$_POST['booster_interval_months'];
            $desc = $_POST['description'];

            $db = new Database();
            $stmt = $db->conn->prepare("INSERT INTO vaccine_templates (pet_type, vaccine_name, recommended_age_weeks, booster_interval_months, description) VALUES (?, ?, ?, ?, ?)");
            $stmt->bind_param("ssiis", $type, $name, $age, $booster, $desc);
            $stmt->execute();
            $stmt->close();
            
            $_SESSION['flash_success'] = "Vaccine template added successfully.";
        }
        header('Location: ?url=vaccinetemplate/index');
        exit;
    }

    public function delete($id) {
        $db = new Database();
        $stmt = $db->conn->prepare("DELETE FROM vaccine_templates WHERE id = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $stmt->close();
        
        $_SESSION['flash_success'] = "Template removed.";
        header('Location: ?url=vaccinetemplate/index');
        exit;
    }
}
