<?php
require_once 'core/database.php';
$db = new Database();
$res = $db->conn->query("DESCRIBE pets");
while($row = $res->fetch_assoc()) {
    echo $row['Field'] . " (" . $row['Type'] . ")\n";
}
