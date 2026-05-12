<?php
$pageTitle       = 'Pet Clinic — Connect. Care. Cure.';
$pageDescription = 'Providing the highest standard of veterinary care with compassion and expertise.';
$bodyClass       = 'page-home';
require_once __DIR__ . '/layouts/header.php';
?>

<!-- Top Bar -->
<div class="top-bar">
    <div class="container top-bar-content">
        <div class="contact-info">
            <span class="icon">📞</span> 11 2 700 899
        </div>
        <div class="emergency-info">
            <span class="icon red">✚</span> 776 890 666
        </div>
    </div>
</div>

<!-- Main Navigation -->
<nav class="home-nav">
    <div class="container nav-content">
        <a href="index.php" class="nav-logo">
            <span>🐾</span> Pet Clinic
        </a>
        <ul class="nav-links-list">
            <li><a href="index.php">Home</a></li>
            <li><a href="?url=home/about">About</a></li>
            <li><a href="#">Team</a></li>
            <li><a href="#">Services</a></li>
            <li><a href="#">Contact</a></li>
        </ul>
        <div class="nav-auth">
            <?php if (Auth::isLoggedIn()): ?>
                <a href="<?php echo Auth::ROLE_DASHBOARDS[Auth::role()] ?? '?url=home/index'; ?>" class="btn-cta-primary">Dashboard</a>
            <?php else: ?>
                <a href="?url=user/login" class="btn-login-text">Login</a>
                <a href="?url=user/signup" class="btn-cta-primary">Join Us</a>
            <?php endif; ?>
        </div>
    </div>
</nav>

<!-- Hero Section -->
<section class="hero-section" style="background-image: url('images/pet_clinic_hero_blue.png');">
    <div class="hero-overlay"></div>
    <div class="container hero-container">
        <div class="hero-paw-decor">
            <span class="paw paw-1">🐾</span>
            <span class="paw paw-2">🐾</span>
            <span class="paw paw-3">🐾</span>
        </div>
        <h1 class="hero-main-title">CONNECT. CARE. CURE.</h1>
        
    </div>
</section>

<!-- Content Sections -->
<section class="intro-section">
    <div class="container text-center">
        <h2 class="section-title">Welcome to <span>Our Pet Family</span></h2>
        <p class="intro-text">
            We are dedicated to providing the highest level of veterinary medicine along with friendly, compassionate service. 
            We believe in treating every patient as if they were our own pet, and giving them the same loving attention and care.
        </p>
    </div>
</section>

<footer class="home-footer">
    <div class="container">
        <div class="footer-content">
            <div class="footer-brand">
                <span class="footer-logo">🐾</span>
                <h4>Pet Clinic</h4>
            </div>
            <p>&copy; <?php echo date('Y'); ?> Pet Clinic Management System. Delivering Excellence in Pet Care.</p>
        </div>
    </div>
</footer>

<!-- Back to Top -->
<a href="#" class="back-to-top" id="backToTop">
    <span>↑</span>
</a>

<?php require_once __DIR__ . '/layouts/footer.php'; ?>