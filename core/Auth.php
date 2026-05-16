<?php

/**
 * Auth — static helper for authentication and role-based access control.
 * All controllers call these methods to guard their actions.
 */
class Auth {

    /** All valid roles in the system */
    const ROLES = ['admin', 'vet', 'nurse', 'owner'];

    /** Role → dashboard URL map */
    const ROLE_DASHBOARDS = [
        'admin' => '?url=admin/dashboard',
        'vet'   => '?url=vet/dashboard',
        'nurse' => '?url=nurse/dashboard',
        'owner' => '?url=owner/dashboard',
    ];

    /* ── Authentication ─────────────────────────────────────── */

    /** Return true if a user is logged in (session exists). */
    public static function isLoggedIn(): bool {
        return !empty($_SESSION['user_id']);
    }

    /**
     * Redirect to login if no active session.
     * Call at the top of any protected action.
     */
    public static function requireLogin(): void {
        if (!self::isLoggedIn()) {
            header('Location: ?url=user/login');
            exit;
        }
    }

    /* ── Role checks ────────────────────────────────────────── */

    /** Return true if the logged-in user has any of the given roles. */
    public static function hasRole(string ...$roles): bool {
        return in_array($_SESSION['user_role'] ?? '', $roles, true);
    }

    /**
     * Require login AND one of the given roles.
     * Redirects to /user/unauthorized if the role does not match.
     */
    public static function requireRole(string ...$roles): void {
        self::requireLogin();
        if (!self::hasRole(...$roles)) {
            header('Location: ?url=user/unauthorized');
            exit;
        }
    }

    /* ── Session helpers ────────────────────────────────────── */

    /** Write user data into the session after a successful login. */
    public static function setSession(array $user): void {
        // Regenerate session ID to prevent session fixation
        if (!headers_sent()) {
            session_regenerate_id(true);
        }
        
        $_SESSION['user_id']    = $user['id'];
        $_SESSION['user_name']  = trim(($user['first_name'] ?? '') . ' ' . ($user['last_name'] ?? ($user['name'] ?? '')));
        $_SESSION['user_email'] = $user['email'];
        $_SESSION['user_role']  = $user['role'];
        $_SESSION['user_photo'] = $user['profile_photo'] ?? null;
        $_SESSION['last_login'] = time();
    }

    /** Destroy the session (logout). */
    public static function destroySession(): void {
        session_unset();
        session_destroy();
    }

    /** Redirect the logged-in user to their role-specific dashboard. */
    public static function redirectToDashboard(): void {
        $role = $_SESSION['user_role'] ?? '';
        $url  = self::ROLE_DASHBOARDS[$role] ?? '?url=home/index';
        header('Location: ' . $url);
        exit;
    }

    /** Convenience: get current user's role from session. */
    public static function role(): string {
        return $_SESSION['user_role'] ?? '';
    }

    /** Convenience: get current user's display name from session. */
    public static function name(): string {
        return $_SESSION['user_name'] ?? 'User';
    }

    /** Convenience: get current user's photo from session. */
    public static function photo(): ?string {
        return $_SESSION['user_photo'] ?? null;
    }

    /* ── CSRF Protection ────────────────────────────────────── */

    /** Generate and store a CSRF token in session. */
    public static function generateCsrfToken(): string {
        if (empty($_SESSION['csrf_token'])) {
            $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
        }
        return $_SESSION['csrf_token'];
    }

    /** Verify a given CSRF token matches the session one. */
    public static function verifyCsrfToken(string $token): bool {
        if (empty($_SESSION['csrf_token']) || empty($token)) {
            return false;
        }
        return hash_equals($_SESSION['csrf_token'], $token);
    }
}
