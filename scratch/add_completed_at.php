<?php
require_once 'core/database.php';
$db = new Database();
$query = "ALTER TABLE appointments ADD COLUMN completed_at TIMESTAMP NULL DEFAULT NULL";
if ($db->conn->query($query)) {
    echo "Column 'completed_at' added successfully.\n";
} else {
    echo "Error adding column: " . $db->conn->error . "\n";
}
