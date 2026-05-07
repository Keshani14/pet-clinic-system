<?php
require_once __DIR__ . '/../core/database.php';

$db = new Database();

$queries = [
    // 1. Update appointments table to support different types
    "ALTER TABLE appointments ADD COLUMN IF NOT EXISTS appointment_type ENUM('general', 'vaccination') DEFAULT 'general'",

    // 2. Create vaccination_schedule table
    "CREATE TABLE IF NOT EXISTS vaccination_schedule (
        id INT AUTO_INCREMENT PRIMARY KEY,
        pet_id INT NOT NULL,
        vaccine_name VARCHAR(100) NOT NULL,
        due_date DATE NOT NULL,
        status ENUM('Upcoming', 'Completed', 'Overdue') DEFAULT 'Upcoming',
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
        FOREIGN KEY (pet_id) REFERENCES pets(id) ON DELETE CASCADE
    )",

    // 3. Create vaccinations table (history of administered shots)
    "CREATE TABLE IF NOT EXISTS vaccinations (
        id INT AUTO_INCREMENT PRIMARY KEY,
        appointment_id INT DEFAULT NULL,
        pet_id INT NOT NULL,
        vaccine_name VARCHAR(100) NOT NULL,
        date_given DATE NOT NULL,
        next_due_date DATE DEFAULT NULL,
        notes TEXT DEFAULT NULL,
        batch_number VARCHAR(50) DEFAULT NULL,
        vet_id INT NOT NULL,
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
        FOREIGN KEY (pet_id) REFERENCES pets(id) ON DELETE CASCADE,
        FOREIGN KEY (appointment_id) REFERENCES appointments(id) ON DELETE SET NULL
    )",

    // 4. Update existing appointments to 'general' if null
    "UPDATE appointments SET appointment_type = 'general' WHERE appointment_type IS NULL"
];

echo "--- Starting Vaccination System Migration ---\n";
foreach ($queries as $query) {
    if ($db->conn->query($query)) {
        echo "✅ Success: " . substr($query, 0, 50) . "...\n";
    } else {
        echo "❌ Error: " . $db->conn->error . "\n";
    }
}
echo "--- Migration Complete ---\n";
