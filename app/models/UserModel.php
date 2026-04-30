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
        string $password,
        string $role = 'owner'         // default to pet owner for self-registration
    ): bool {
        $hashedPassword = password_hash($password, PASSWORD_BCRYPT);

        $stmt = $this->db->conn->prepare(
            "INSERT INTO users (first_name, last_name, email, phone, password, role, created_at)
             VALUES (?, ?, ?, ?, ?, ?, NOW())"
        );
        $stmt->bind_param(
            "ssssss",
            $firstName,
            $lastName,
            $email,
            $phone,
            $hashedPassword,
            $role
        );
        $success = $stmt->execute();
        $stmt->close();
        return $success;
    }

    /**
     * Find a user row by email address.
     * Returns the full row as an associative array, or null if not found.
     * Used by the login flow to verify credentials.
     *
     * @param  string     $email
     * @return array|null
     */
    public function getUserByEmail(string $email): ?array {
        $stmt = $this->db->conn->prepare(
            "SELECT id, first_name, last_name, email, phone, password, role
             FROM users WHERE email = ? LIMIT 1"
        );
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();
        $user   = $result->fetch_assoc() ?: null;
        $stmt->close();
        return $user;
    }
}
