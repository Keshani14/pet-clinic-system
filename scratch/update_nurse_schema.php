<?php
require_once 'core/database.php';

$db = new Database();

$queries = [
    // 1. Add new columns to appointments table
    "ALTER TABLE appointments MODIFY COLUMN status ENUM('pending','confirmed','checked-in','ready','in-consultation','completed','cancelled','approved') DEFAULT 'pending'",
    "ALTER TABLE appointments ADD COLUMN IF NOT EXISTS nurse_id INT DEFAULT NULL",
    "ALTER TABLE appointments ADD COLUMN IF NOT EXISTS checked_in_at DATETIME DEFAULT NULL",
    "ALTER TABLE appointments ADD COLUMN IF NOT EXISTS ready_at DATETIME DEFAULT NULL",
    "ALTER TABLE appointments ADD COLUMN IF NOT EXISTS consultation_started_at DATETIME DEFAULT NULL",
    // Fix existing blank statuses caused by the enum restriction
    "UPDATE appointments SET status = 'pending' WHERE status = '' OR status IS NULL",
    
    // 2. Create nurse_notes table
    "CREATE TABLE IF NOT EXISTS nurse_notes (
        id INT AUTO_INCREMENT PRIMARY KEY,
        appointment_id INT NOT NULL,
        weight VARCHAR(20) DEFAULT NULL,
        temperature VARCHAR(20) DEFAULT NULL,
        symptoms TEXT DEFAULT NULL,
        notes TEXT DEFAULT NULL,
        created_by INT NOT NULL,
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
        FOREIGN KEY (appointment_id) REFERENCES appointments(id) ON DELETE CASCADE
    )",
    
    // 3. Create status_logs table
    "CREATE TABLE IF NOT EXISTS status_logs (
        id INT AUTO_INCREMENT PRIMARY KEY,
        appointment_id INT NOT NULL,
        old_status VARCHAR(50) DEFAULT NULL,
        new_status VARCHAR(50) NOT NULL,
        updated_by INT NOT NULL,
        updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
        FOREIGN KEY (appointment_id) REFERENCES appointments(id) ON DELETE CASCADE
    )"
];

foreach ($queries as $query) {
    if ($db->conn->query($query)) {
        echo "Successfully executed: $query\n";
    } else {
        echo "Error executing $query: " . $db->conn->error . "\n";
    }
}
