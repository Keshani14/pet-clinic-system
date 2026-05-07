<?php
require_once 'core/database.php';
$db = new Database();
$query = "UPDATE appointments SET completed_at = appointment_date WHERE status = 'completed' AND completed_at IS NULL";
if ($db->conn->query($query)) {
    echo "Backfilled 'completed_at' for existing appointments.\n";
} else {
    echo "Error backfilling: " . $db->conn->error . "\n";
}
