<?php
// ── Page meta — picked up by layouts/header.php ──────────────
$pageTitle       = 'Welcome — Pet Clinic';
$pageDescription = 'Pet Clinic — caring for your furry family with love and expertise.';
$bodyClass       = 'page-home';
require_once __DIR__ . '/layouts/header.php';
?>

<div class="hero-icon" aria-hidden="true">🐾</div>
<h1 class="hero-title">Welcome to <span>Pet Clinic</span></h1>
<p class="hero-subtitle">
    Caring for your furry family with love, expertise, and a warm smile — every single day.
</p>

<div class="cta-wrap">
    <?php if (Auth::isLoggedIn()): ?>
        <a href="<?php echo Auth::ROLE_DASHBOARDS[Auth::role()] ?? '?url=home/index'; ?>" class="btn-cta-primary">Go to Dashboard</a>
        <a href="?url=user/logout" class="btn-cta-secondary">Log Out</a>
    <?php else: ?>
        <a href="?url=user/signup" class="btn-cta-primary" id="signup-cta-btn">Create Account</a>
        <a href="?url=user/login"  class="btn-cta-secondary" id="login-cta-btn">Log In</a>
    <?php endif; ?>
</div>

<?php require_once __DIR__ . '/layouts/footer.php'; ?>