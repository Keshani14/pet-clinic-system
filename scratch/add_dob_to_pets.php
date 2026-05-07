<?php
require_once 'core/database.php';
$db = new Database();
$query = "ALTER TABLE pets ADD COLUMN dob DATE NULL AFTER age";
if ($db->conn->query($query)) {
    echo "Column 'dob' added successfully.\n";
} else {
    echo "Error adding column: " . $db->conn->error . "\n";
}
