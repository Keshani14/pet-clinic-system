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
            // ── CSRF Check ──────────────────────────────────────────
            if (!Auth::verifyCsrfToken($_POST['csrf_token'] ?? '')) {
                die("CSRF token validation failed.");
            }

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

            // ── CSRF Check ──────────────────────────────────────────
            if (!Auth::verifyCsrfToken($_POST['csrf_token'] ?? '')) {
                die("CSRF token validation failed.");
            }

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
                        
                        // Log successful login
                        error_log("[AUTH] Login success: $email at " . date('Y-m-d H:i:s'));
                        
                        Auth::redirectToDashboard();
                    } elseif ($user['status'] === 'pending') {
                        $error = '⏳ Your account is waiting for admin approval.';
                    } elseif ($user['status'] === 'rejected') {
                        $error = '❌ Your account registration has been rejected.';
                    } else {
                        $error = '⚠️ Your account is currently inactive.';
                    }
                } else {
                    // ── Bad credentials ──
                    $error = '🚫 Incorrect email or password. Please try again.';
                    
                    // Log failed attempt
                    error_log("[AUTH] Login failed: $email at " . date('Y-m-d H:i:s'));
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
    //  PROFILE
    // ----------------------------------------------------------------

    public function profile() {
        Auth::requireLogin(); // Ensure the user is logged in
        
        $userModel = $this->model('UserModel');
        $userData = $userModel->getUserById((int)$_SESSION['user_id']);
        
        if (!$userData) {
            die("User not found.");
        }

        // Handle legacy 'name' column splitting if first_name is empty
        if (empty($userData['first_name']) && !empty($userData['name'])) {
            $parts = explode(' ', $userData['name'], 2);
            $userData['first_name'] = $parts[0];
            $userData['last_name'] = $parts[1] ?? '';
        }

        $this->view('user/profile', [
            'user' => $userData
        ]);
    }

    public function updateProfile() {
        Auth::requireLogin();

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $userModel = $this->model('UserModel');
            $id = (int)$_SESSION['user_id'];

            $data = [
                'first_name' => trim(htmlspecialchars($_POST['first_name'] ?? '')),
                'last_name' => trim(htmlspecialchars($_POST['last_name'] ?? '')),
                'email' => trim(htmlspecialchars($_POST['email'] ?? '')),
                'phone' => trim(htmlspecialchars($_POST['phone'] ?? ''))
            ];

            if ($userModel->updateProfile($id, $data)) {
                $_SESSION['flash_success'] = '✨ Profile updated successfully!';
                // Update session name if it changed
                $_SESSION['user_name'] = $data['first_name'] . ' ' . $data['last_name'];
            } else {
                $_SESSION['flash_error'] = '❌ Failed to update profile.';
            }
        }
        header('Location: ?url=user/profile');
        exit;
    }

    public function uploadPhoto() {
        Auth::requireLogin();

        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['profile_photo'])) {
            $file = $_FILES['profile_photo'];
            $id = (int)$_SESSION['user_id'];

            // ── Validation ──────────────────────────────────────────
            $allowedTypes = ['image/jpeg', 'image/png', 'image/webp'];
            $maxSize = 2 * 1024 * 1024; // 2MB

            if (!in_array($file['type'], $allowedTypes)) {
                $_SESSION['flash_error'] = '❌ Invalid file type. Please upload a JPG, PNG, or WebP image.';
            } elseif ($file['size'] > $maxSize) {
                $_SESSION['flash_error'] = '❌ File too large. Maximum size is 2MB.';
            } elseif ($file['error'] !== UPLOAD_ERR_OK) {
                $_SESSION['flash_error'] = '❌ Upload failed. Please try again.';
            } else {
                // ── Process Upload ───────────────────────────────────
                $ext = pathinfo($file['name'], PATHINFO_EXTENSION);
                $fileName = 'profile_' . $id . '_' . time() . '.' . $ext;
                $uploadPath = 'uploads/profile_photos/' . $fileName;

                if (move_uploaded_file($file['tmp_name'], 'c:/xampp/htdocs/pet_clinic/public/' . $uploadPath)) {
                    $userModel = $this->model('UserModel');
                    if ($userModel->updateProfilePhoto($id, $uploadPath)) {
                        $_SESSION['flash_success'] = '✨ Professional photo updated!';
                        $_SESSION['user_photo'] = $uploadPath; // Refresh session
                    } else {
                        $_SESSION['flash_error'] = '❌ Database update failed.';
                    }
                } else {
                    $_SESSION['flash_error'] = '❌ Failed to move uploaded file.';
                }
            }
        }
        header('Location: ?url=user/profile');
        exit;
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
