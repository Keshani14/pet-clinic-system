<?php
require_once 'core/database.php';
$db = new Database();
$res = $db->conn->query("DESCRIBE appointments");
while($row = $res->fetch_assoc()) {
    echo $row['Field'] . "\n";
}
