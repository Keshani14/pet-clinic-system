<?php
require_once 'core/database.php';

$db = new Database();

$queries = [
    "ALTER TABLE appointments ADD COLUMN IF NOT EXISTS weight VARCHAR(20) DEFAULT NULL",
    "ALTER TABLE appointments ADD COLUMN IF NOT EXISTS temperature VARCHAR(20) DEFAULT NULL",
    "ALTER TABLE appointments ADD COLUMN IF NOT EXISTS vitals_notes TEXT DEFAULT NULL",
    "ALTER TABLE appointments ADD COLUMN IF NOT EXISTS diagnosis TEXT DEFAULT NULL",
    "ALTER TABLE appointments ADD COLUMN IF NOT EXISTS prescription TEXT DEFAULT NULL"
];

foreach ($queries as $query) {
    if ($db->conn->query($query)) {
        echo "Successfully executed: $query\n";
    } else {
        echo "Error executing $query: " . $db->conn->error . "\n";
    }
}
