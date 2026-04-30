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

        $status = ($role === 'owner') ? 'approved' : 'pending';
        
        $stmt = $this->db->conn->prepare(
            "INSERT INTO users (first_name, last_name, email, phone, password, role, status, created_at)
             VALUES (?, ?, ?, ?, ?, ?, ?, NOW())"
        );
        $stmt->bind_param(
            "sssssss",
            $firstName,
            $lastName,
            $email,
            $phone,
            $hashedPassword,
            $role,
            $status
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
            "SELECT id, first_name, last_name, email, phone, password, role, status
             FROM users WHERE email = ? LIMIT 1"
        );
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();
        $user   = $result->fetch_assoc() ?: null;
        $stmt->close();
        return $user;
    }

    /**
     * Fetch all users with 'pending' status.
     * @return array
     */
    public function getPendingUsers(): array {
        $query = "SELECT id, first_name, last_name, email, role, status FROM users WHERE status = 'pending' ORDER BY created_at DESC";
        $result = $this->db->conn->query($query);
        $users = [];
        if ($result) {
            while ($row = $result->fetch_assoc()) {
                $users[] = $row;
            }
        }
        return $users;
    }

    /**
     * Update the status of a user.
     * @param int $id
     * @param string $status
     * @return bool
     */
    public function updateStatus(int $id, string $status): bool {
        if (!in_array($status, ['approved', 'rejected'])) return false;
        
        $stmt = $this->db->conn->prepare("UPDATE users SET status = ? WHERE id = ?");
        $stmt->bind_param("si", $status, $id);
        $success = $stmt->execute();
        $stmt->close();
        return $success;
    }

    /**
     * Fetch all users with role 'vet' or 'nurse'.
     * @return array
     */
    public function getStaffUsers(): array {
        $query = "SELECT id, first_name, last_name, email, role, status FROM users WHERE role IN ('vet', 'nurse') ORDER BY created_at DESC";
        $result = $this->db->conn->query($query);
        $users = [];
        if ($result) {
            while ($row = $result->fetch_assoc()) {
                $users[] = $row;
            }
        }
        return $users;
    }
}
