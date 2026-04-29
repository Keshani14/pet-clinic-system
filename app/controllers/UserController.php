<?php

/**
 * UserController — manages user registration (signup) flow.
 * Routes: ?url=user/signup  (GET → show form | POST → process form)
 */
class UserController extends Controller {

    public function signup() {
        // Load the UserModel for database operations
        $userModel = $this->model('UserModel');

        $errors  = [];
        $success = false;

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {

            // ── Sanitise inputs ──────────────────────────────────────────
            $firstName       = trim(htmlspecialchars($_POST['first_name']   ?? ''));
            $lastName        = trim(htmlspecialchars($_POST['last_name']    ?? ''));
            $email           = trim(htmlspecialchars($_POST['email']        ?? ''));
            $phone           = trim(htmlspecialchars($_POST['phone']        ?? ''));
            $password        = $_POST['password']         ?? '';
            $confirmPassword = $_POST['confirm_password'] ?? '';

            // ── Validation ───────────────────────────────────────────────
            if (empty($firstName)) {
                $errors['first_name'] = 'First name is required.';
            }

            if (empty($lastName)) {
                $errors['last_name'] = 'Last name is required.';
            }

            if (empty($email)) {
                $errors['email'] = 'Email address is required.';
            } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $errors['email'] = 'Please enter a valid email address.';
            } elseif ($userModel->emailExists($email)) {
                $errors['email'] = 'This email is already registered.';
            }

            if (!empty($phone) && !preg_match('/^[0-9\+\-\s]{7,15}$/', $phone)) {
                $errors['phone'] = 'Please enter a valid phone number.';
            }

            if (strlen($password) < 8) {
                $errors['password'] = 'Password must be at least 8 characters.';
            }

            if ($password !== $confirmPassword) {
                $errors['confirm_password'] = 'Passwords do not match.';
            }

            // ── Register if no errors ────────────────────────────────────
            if (empty($errors)) {
                $registered = $userModel->register(
                    $firstName,
                    $lastName,
                    $email,
                    $phone,
                    $password
                );

                if ($registered) {
                    $success = true;
                } else {
                    $errors['general'] = 'Registration failed. Please try again.';
                }
            }
        }

        // Pass data to the view
        $data = [
            'errors'  => $errors,
            'success' => $success,
            'old'     => $_POST ?? [],  // re-populate form fields on error
        ];

        $this->view('user/signup', $data);
    }
}
