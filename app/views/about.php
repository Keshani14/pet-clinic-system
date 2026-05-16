<?php
$pageTitle       = 'About Us — Furry Friends';
$pageDescription = 'Learn more about our dedicated team and our mission to provide the best care for your pets.';
$bodyClass       = 'page-about';
require_once __DIR__ . '/layouts/header.php';
?>
<body class="page-about">
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
            <span>🐾</span> Furry Friends
        </a>
        <ul class="nav-links-list">
            <li><a href="index.php">Home</a></li>
            <li><a href="?url=home/about" class="active">About</a></li>
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

<section class="about-hero-split">
    <div class="container hero-split-container">
        <div class="hero-split-text">
            <h1 class="hero-split-title">About Our <span>Clinic</span></h1>
            <p class="hero-split-tagline">Compassionate care for every furry family member. We are dedicated to providing the highest quality medical care for your beloved pets.</p>
        </div>
        <div class="hero-split-image-container">
            <img src="images/hero_banner.png" alt="Our Clinic">
        </div>
    </div>
</section>

<section class="about-content-section">
    <div class="container">
        <div class="about-grid">
            <div class="about-text-content">
                <h2 class="section-title">Our <span>Story</span></h2>
                <p class="about-p">
                    Founded in 2010, Furry Friends has been a cornerstone of the local community, dedicated to the health and well-being of animals. What started as a small family-run practice has grown into a state-of-the-art facility, equipped with the latest medical technology and a team of highly specialized veterinarians.
                </p>
                <p class="about-p">
                    We understand that your pets are more than just animals—they are members of your family. That's why we take a holistic and compassionate approach to every case, ensuring that both you and your furry friends feel comfortable and informed at every step of the way.
                </p>
            </div>
            <div class="about-stats">
                <div class="stat-card">
                    <h3>15+</h3>
                    <p>Years of Excellence</p>
                </div>
                <div class="stat-card">
                    <h3>10k+</h3>
                    <p>Happy Pets</p>
                </div>
                <div class="stat-card">
                    <h3>24/7</h3>
                    <p>Emergency Support</p>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="mission-section">
    <div class="container">
        <h2 class="section-title text-center">Our <span>Mission</span></h2>
        <div class="mission-box">
            <p>"To provide world-class veterinary care through innovation, empathy, and a deep-rooted love for animals. We strive to enhance the bond between humans and their pets by ensuring a long, healthy, and happy life for every animal we treat."</p>
        </div>
    </div>
</section>

<a href="#" class="back-to-top" id="backToTop">
    <span>↑</span>
</a>

<?php require_once __DIR__ . '/layouts/footer.php'; ?>
