<?php

class Database {
    public $conn;

    public function __construct() {
        $this->conn = new mysqli("localhost", "root", "", "pet_clinic");

        if ($this->conn->connect_error) {
            die("Database connection failed");
        }
    }
}