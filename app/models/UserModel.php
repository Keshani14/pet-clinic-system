<?php

/**
 * UserModel — handles all database operations related to users.
 * Follows the MVC pattern; accessed via Controller::model().
 */
class UserModel {

    private $db;

    public function __construct() {
        // Instantiate the Database class to get the mysqli connection
        $this->db = new Database();
    }

    /**
     * Check whether an email address already exists in the users table.
     *
     * @param  string $email
     * @return bool   true if the email is taken, false otherwise
     */
    public function emailExists(string $email): bool {
        $stmt = $this->db->conn->prepare(
            "SELECT id FROM users WHERE email = ? LIMIT 1"
        );
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $stmt->store_result();
        $exists = $stmt->num_rows > 0;
        $stmt->close();
        return $exists;
    }

    /**
     * Insert a new user record into the database.
     * The password is hashed with bcrypt before storage.
     *
     * @param  string $firstName
     * @param  string $lastName
     * @param  string $email
     * @param  string $phone
     * @param  string $password  plain-text password
     * @return bool   true on success, false on failure
     */
    public function register(
        string $firstName,
        string $lastName,
        string $email,
        string $phone,
        string $password
    ): bool {
        $hashedPassword = password_hash($password, PASSWORD_BCRYPT);

        $stmt = $this->db->conn->prepare(
            "INSERT INTO users (first_name, last_name, email, phone, password, created_at)
             VALUES (?, ?, ?, ?, ?, NOW())"
        );
        $stmt->bind_param(
            "sssss",
            $firstName,
            $lastName,
            $email,
            $phone,
            $hashedPassword
        );
        $success = $stmt->execute();
        $stmt->close();
        return $success;
    }
}
