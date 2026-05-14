<?php
$pageTitle       = 'Pet Clinic — Connect. Care. Cure.';
$pageDescription = 'Providing the highest standard of veterinary care with compassion and expertise.';
$bodyClass       = 'page-home';
require_once __DIR__ . '/layouts/header.php';
?>

<body class="page-home">
<div class="top-bar">
    <div class="container top-bar-content">
        <div class="contact-info">
            <span class="icon">📞</span> +94 112 345 678 | <span class="icon">📧</span> info@petclinic.lk
        </div>
        <div class="emergency-info">
            <span class="icon red">🚑</span> 24/7 Emergency: +94 777 999 000
        </div>
    </div>
</div>

<nav class="home-nav">
    <div class="container nav-content">
        <a href="index.php" class="nav-logo">
            <span>🐾</span> Pet Clinic
        </a>
        <ul class="nav-links-list">
            <li><a href="index.php" class="active">Home</a></li>
            <li><a href="?url=home/about">About</a></li>
            <li><a href="?url=home/team">Team</a></li>
            <li><a href="?url=home/services">Services</a></li>
            <li><a href="?url=home/contact">Contact</a></li>
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

<section class="hero-section" style="background-image: url('images/pet_clinic_hero_blue.png');">
    <div class="hero-overlay"></div>
    <div class="container hero-container">
        <div class="hero-paw-decor">
            <span class="paw paw-1">🐾</span>
            <span class="paw paw-2">🐾</span>
            <span class="paw paw-3">🐾</span>
        </div>
        <h1 class="hero-main-title">Modern Pet Care</h1>
        <p class="hero-subtitle">Providing world-class veterinary services with love and compassion.</p>
        <div class="hero-actions">
            <a href="?url=user/signup" class="btn-cta-primary">Join Our Clinic Today</a>
        </div>
    </div>
</section>

<section class="intro-section">
    <div class="container">
        <div class="intro-text">
            Founded with a vision to redefine veterinary excellence, we combine state-of-the-art medical technology with a heart for animals. Our team of specialists is dedicated to providing personalized care tailored to the unique needs of your furry family members.
        </div>
    </div>
</section>

<a href="#" class="back-to-top">↑</a>

<?php include 'layouts/footer.php'; ?>