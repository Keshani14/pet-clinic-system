<?php

/**
 * UserController — manages user registration and authentication.
 * Routes:
 *   ?url=user/signup  (GET → show form | POST → process form)
 *   ?url=user/login   (GET → show form | POST → process login)
 *   ?url=user/logout  (GET → destroy session & redirect home)
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
            $role            = trim(htmlspecialchars($_POST['role']         ?? 'owner'));
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

            if (!in_array($role, ['owner', 'vet', 'nurse'])) {
                $errors['role'] = 'Invalid role selected.';
            }

            // ── Register if no errors ────────────────────────────────────
            if (empty($errors)) {
                $registered = $userModel->register(
                    $firstName,
                    $lastName,
                    $email,
                    $phone,
                    $password,
                    $role
                );

                if ($registered) {
                    // Store a flash message and redirect to login
                    if ($role === 'owner') {
                        $_SESSION['flash_success'] = '🎉 Account created! Please log in to continue.';
                    } else {
                        $_SESSION['flash_success'] = '📝 Registration submitted! Your account is waiting for admin approval.';
                    }
                    header('Location: ?url=user/login');
                    exit;
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

    // ----------------------------------------------------------------
    //  LOGIN
    // ----------------------------------------------------------------

    public function login() {
        // If the user is already logged in, send them to the dashboard
        if (Auth::isLoggedIn()) {
            Auth::redirectToDashboard();
        }

        $userModel = $this->model('UserModel');
        $error     = '';

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {

            // ── Sanitise inputs ──────────────────────────────────────
            $email    = trim($_POST['email']    ?? '');
            $password = $_POST['password']      ?? '';

            // ── Basic presence check ─────────────────────────────────
            if (empty($email) || empty($password)) {
                $error = 'Please enter both your email and password.';
            } else {
                // ── Look up the user ─────────────────────────────────
                $user = $userModel->getUserByEmail($email);

                if ($user && password_verify($password, $user['password'])) {
                    // ── Check Approval Status ────────────────────────
                    if ($user['status'] === 'approved') {
                        // ── Credentials valid & approved → write session
                        Auth::setSession($user);
                        Auth::redirectToDashboard();
                    } elseif ($user['status'] === 'pending') {
                        $error = 'Your account is waiting for admin approval.';
                    } else {
                        $error = 'Your account registration has been rejected.';
                    }
                } else {
                    // ── Bad credentials – intentionally vague message ─
                    $error = 'Incorrect email or password. Please try again.';
                }
            }
        }

        $data = [
            'error'    => $error,
            'oldEmail' => htmlspecialchars($_POST['email'] ?? ''),
        ];

        $this->view('user/login', $data);
    }

    // ----------------------------------------------------------------
    //  UNAUTHORIZED
    // ----------------------------------------------------------------

    public function unauthorized() {
        $this->view('user/unauthorized');
    }

    // ----------------------------------------------------------------
    //  LOGOUT
    // ----------------------------------------------------------------

    public function logout() {
        // Destroy all session data and redirect to the login page
        Auth::destroySession();
        header('Location: ?url=user/login');
        exit;
    }
}
