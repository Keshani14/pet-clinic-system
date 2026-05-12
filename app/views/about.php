<?php
$pageTitle       = 'About Us — Pet Clinic';
$pageDescription = 'Learn more about our dedicated team and our mission to provide the best care for your pets.';
$bodyClass       = 'page-about';
require_once __DIR__ . '/layouts/header.php';
?>

<nav class="home-nav">
    <div class="container nav-content">
        <a href="index.php" class="nav-logo">
            <span>🐾</span> Pet Clinic
        </a>
        <ul class="nav-links-list">
            <li><a href="index.php">Home</a></li>
            <li><a href="?url=home/about" class="active">About</a></li>
            <li><a href="#">Team</a></li>
            <li><a href="#">Services</a></li>
            <li><a href="#">Blog</a></li>
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

<section class="about-hero-section" style="background-image: url('images/pet_clinic_hero_blue.png');">
    <div class="hero-overlay"></div>
    <div class="container hero-container">
        <h1 class="hero-main-title">About Our Clinic</h1>
        <p class="about-tagline">Compassionate care for every furry family member.</p>
    </div>
</section>

<section class="about-content-section">
    <div class="container">
        <div class="about-grid">
            <div class="about-text-content">
                <h2 class="section-title">Our <span>Story</span></h2>
                <p class="about-p">
                    Founded in 2010, Pet Clinic has been a cornerstone of the local community, dedicated to the health and well-being of animals. What started as a small family-run practice has grown into a state-of-the-art facility, equipped with the latest medical technology and a team of highly specialized veterinarians.
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
    <div class="container text-center">
        <h2 class="section-title">Our <span>Mission</span></h2>
        <div class="mission-box">
            <p>"To provide world-class veterinary care through innovation, empathy, and a deep-rooted love for animals. We strive to enhance the bond between humans and their pets by ensuring a long, healthy, and happy life for every animal we treat."</p>
        </div>
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

<a href="#" class="back-to-top" id="backToTop">
    <span>↑</span>
</a>

<?php require_once __DIR__ . '/layouts/footer.php'; ?>
