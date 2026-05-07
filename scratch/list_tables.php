<?php
require_once 'core/database.php';
$db = new Database();
$res = $db->conn->query("SHOW TABLES");
while($row = $res->fetch_row()) {
    echo $row[0] . "\n";
}
