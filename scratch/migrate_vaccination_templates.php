<?php
require_once 'core/database.php';
$db = new Database();

// 1. Create vaccine_templates table
$q1 = "CREATE TABLE IF NOT EXISTS vaccine_templates (
    id INT AUTO_INCREMENT PRIMARY KEY,
    pet_type VARCHAR(50) NOT NULL,
    vaccine_name VARCHAR(100) NOT NULL,
    recommended_age_weeks INT NOT NULL,
    booster_interval_months INT DEFAULT 0,
    description TEXT,
    is_active TINYINT DEFAULT 1,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
)";
$db->conn->query($q1);

// 2. Create pet_vaccination_history table
$q2 = "CREATE TABLE IF NOT EXISTS pet_vaccination_history (
    id INT AUTO_INCREMENT PRIMARY KEY,
    pet_id INT NOT NULL,
    vaccine_name VARCHAR(100) NOT NULL,
    date_given DATE NOT NULL,
    next_due_date DATE,
    notes TEXT,
    uploaded_document VARCHAR(255),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (pet_id) REFERENCES pets(id) ON DELETE CASCADE
)";
$db->conn->query($q2);

// 3. Update vaccination_schedule table
$q3 = "ALTER TABLE vaccination_schedule ADD COLUMN IF NOT EXISTS vaccine_template_id INT NULL AFTER pet_id";
$db->conn->query($q3);

// 4. Seed default templates
$templates = [
    // Dogs
    ['dog', 'Rabies', 12, 12, 'Protects against Rabies virus.'],
    ['dog', 'DHPPi / 5-in-1', 6, 12, 'Distemper, Hepatitis, Parvovirus, Parainfluenza.'],
    ['dog', 'Parvo Booster', 9, 0, 'Follow-up parvovirus booster.'],
    ['dog', 'Distemper Booster', 9, 0, 'Follow-up distemper booster.'],
    
    // Cats
    ['cat', 'Rabies', 12, 12, 'Protects against Rabies virus.'],
    ['cat', 'FVRCP', 8, 12, 'Feline Viral Rhinotracheitis, Calicivirus, Panleukopenia.'],
    ['cat', 'Feline Leukemia', 12, 12, 'Protects against FeLV.']
];

foreach ($templates as $t) {
    // Check if exists
    $check = $db->conn->prepare("SELECT id FROM vaccine_templates WHERE pet_type = ? AND vaccine_name = ?");
    $check->bind_param("ss", $t[0], $t[1]);
    $check->execute();
    if ($check->get_result()->num_rows === 0) {
        $stmt = $db->conn->prepare("INSERT INTO vaccine_templates (pet_type, vaccine_name, recommended_age_weeks, booster_interval_months, description) VALUES (?, ?, ?, ?, ?)");
        $stmt->bind_param("ssiis", $t[0], $t[1], $t[2], $t[3], $t[4]);
        $stmt->execute();
        $stmt->close();
    }
    $check->close();
}

echo "Database updated and templates seeded successfully.\n";
