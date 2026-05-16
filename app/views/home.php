<?php
$pageTitle       = 'Furry Friends — Connect. Care. Cure.';
$pageDescription = 'Providing the highest standard of veterinary care with compassion and expertise.';
$bodyClass       = 'page-home';
require_once __DIR__ . '/layouts/header.php';
?>


<div class="top-bar">
    <div class="container top-bar-content">
        <div class="contact-info">
            <span class="icon">📞</span> +94 112 345 678 | <span class="icon">📧</span> info@petclinic.lk
        </div>
        <div class="emergency-info">
            <span class="top-bar-emergency">🚑 24/7 Emergency: +94 777 999 000</span>
        </div>
    </div>
</div>

<nav class="home-nav">
    <div class="container nav-content">
        <a href="index.php" class="nav-logo">
            <span>🐾</span> Furry Friends
        </a>
        <ul class="nav-links-list">
            <li><a href="index.php" class="active">Home</a></li>
            <li><a href="?url=home/about">About</a></li>
            <li><a href="?url=home/team">Team</a></li>
            <li><a href="?url=home/services">Services</a></li>
            <li><a href="?url=home/contact">Contact</a></li>
        </ul>
        <div class="nav-auth">
            <a href="?url=appointment/create" class="nav-emergency-btn" style="background: #db2777 !important; margin-right: 15px;">Book Appointment</a>
            <?php if (Auth::isLoggedIn()): ?>
                <a href="<?php echo Auth::ROLE_DASHBOARDS[Auth::role()] ?? '?url=home/index'; ?>" class="btn-cta-primary">Dashboard</a>
            <?php else: ?>
                <a href="?url=user/login" class="btn-login-text">Login</a>
                <a href="?url=user/signup" class="btn-cta-primary">Join Us</a>
            <?php endif; ?>
        </div>
    </div>
</nav>

<section class="hero-section">
    <div class="hero-carousel">
        <div class="carousel-slide active" style="background-color: #fdf2f8; background-image: url('https://images.unsplash.com/photo-1543466835-00a7907e9de1?q=80&w=1920&auto=format&fit=crop&v=5');"></div>
        <div class="carousel-slide" style="background-color: #fdf2f8; background-image: url('https://images.unsplash.com/photo-1514888286974-6c03e2ca1dba?q=80&w=1920&auto=format&fit=crop&v=5');"></div>
        <div class="carousel-slide" style="background-color: #fdf2f8; background-image: url('https://images.unsplash.com/photo-1517849845537-4d257902454a?q=80&w=1920&auto=format&fit=crop&v=5');"></div>
    </div>
    <div class="hero-overlay"></div>
    <div class="container hero-container">
        <div class="hero-paw-decor">
            <span class="paw paw-1">🐾</span>
            <span class="paw paw-2">🐾</span>
            <span class="paw paw-3">🐾</span>
        </div>
        <h1 class="hero-main-title">Modern Pet Care</h1>
        <p class="hero-subtitle" style="font-size: 1.5rem; font-weight: 700; margin-top: 15px; text-shadow: 1px 1px 10px rgba(0,0,0,0.5);">Providing world-class veterinary services with love and compassion.</p>
        <div class="hero-actions" style="margin-top: 40px;">
            <a href="?url=appointment/create" class="btn-cta-primary" style="background: #db2777 !important; color: white !important; font-size: 1.2rem !important; padding: 15px 40px !important; border-radius: 99px !important; border: none !important; box-shadow: 0 10px 25px rgba(219, 39, 119, 0.4) !important;">Book Your Pet’s Appointment Now</a>
        </div>
    </div>
</section>

<section class="intro-section">
    <div class="container">
        <div class="text-center mb-30">
            <h2 style="font-size: 2.5rem; color: #1e293b; font-weight: 900;">Why Choose Us?</h2>
        </div>
        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 60px; align-items: center; margin-top: 50px;">
            <div style="border-radius: 30px; overflow: hidden; box-shadow: 0 20px 40px rgba(0,0,0,0.1);">
                <img src="https://images.unsplash.com/photo-1450778869180-41d0601e046e?auto=format&fit=crop&w=800&q=80" alt="Happy Dog" style="width: 100%; height: 500px; object-fit: cover;">
            </div>
            <ul class="intro-bullets" style="margin-top: 0; grid-template-columns: 1fr;">
                <li class="bullet-item" style="text-align: left; display: flex; align-items: center; gap: 20px; padding: 25px;">
                    <span class="bullet-icon" style="margin-bottom: 0;">🔬</span>
                    <div>
                        <h3 style="margin-bottom: 5px;">State-of-the-Art</h3>
                        <p>Equipped with modern diagnostic and surgical facilities for precise care.</p>
                    </div>
                </li>
                <li class="bullet-item" style="text-align: left; display: flex; align-items: center; gap: 20px; padding: 25px;">
                    <span class="bullet-icon" style="margin-bottom: 0;">❤️</span>
                    <div>
                        <h3 style="margin-bottom: 5px;">Compassionate Team</h3>
                        <p>A group of dedicated specialists who treat every pet like family.</p>
                    </div>
                </li>
                <li class="bullet-item" style="text-align: left; display: flex; align-items: center; gap: 20px; padding: 25px;">
                    <span class="bullet-icon" style="margin-bottom: 0;">🦴</span>
                    <div>
                        <h3 style="margin-bottom: 5px;">Personalized Care</h3>
                        <p>Tailored treatment plans designed specifically for your pet's needs.</p>
                    </div>
                </li>
            </ul>
        </div>
    </div>
</section>

<section class="section-padding" style="background: #fdf2f8;">
    <div class="container">
        <div class="text-center mb-40">
            <h2 style="font-size: 2.5rem; color: #1e293b; font-weight: 900;">Meet Our Specialists</h2>
            <p style="color: #64748b; font-size: 1.1rem; max-width: 600px; margin: 10px auto 0;">World-class experts dedicated to your pet's wellbeing.</p>
        </div>
        <div style="display: grid; grid-template-columns: repeat(3, 1fr); gap: 30px;" class="intro-bullets">
            <div class="bullet-item" style="padding: 0; overflow: hidden; background: white;">
                <img src="https://images.unsplash.com/photo-1612349317150-e413f6a5b16d?auto=format&fit=crop&w=400&q=80" alt="Dr. Miller" style="width: 100%; height: 250px; object-fit: cover;">
                <div style="padding: 20px;">
                    <h3 style="margin-bottom: 5px;">Dr. Sarah Miller</h3>
                    <p style="color: #db2777; font-weight: 800; font-size: 0.85rem; text-transform: uppercase; margin-bottom: 10px;">Lead Surgeon</p>
                    <p style="font-size: 0.9rem;">Specializing in advanced orthopedic surgery and post-op care.</p>
                </div>
            </div>
            <div class="bullet-item" style="padding: 0; overflow: hidden; background: white;">
                <img src="https://images.unsplash.com/photo-1537368910025-700350fe46c7?auto=format&fit=crop&w=400&q=80" alt="Dr. Wilson" style="width: 100%; height: 250px; object-fit: cover;">
                <div style="padding: 20px;">
                    <h3 style="margin-bottom: 5px;">Dr. James Wilson</h3>
                    <p style="color: #db2777; font-weight: 800; font-size: 0.85rem; text-transform: uppercase; margin-bottom: 10px;">Senior Physician</p>
                    <p style="font-size: 0.9rem;">Expert in internal medicine and senior pet wellness programs.</p>
                </div>
            </div>
            <div class="bullet-item" style="padding: 0; overflow: hidden; background: white;">
                <img src="https://images.unsplash.com/photo-1551190822-a9333d879b1f?auto=format&fit=crop&w=400&q=80" alt="Emily Chen" style="width: 100%; height: 250px; object-fit: cover;">
                <div style="padding: 20px;">
                    <h3 style="margin-bottom: 5px;">Emily Chen</h3>
                    <p style="color: #db2777; font-weight: 800; font-size: 0.85rem; text-transform: uppercase; margin-bottom: 10px;">Head Nurse</p>
                    <p style="font-size: 0.9rem;">Passionate about providing a stress-free experience for every patient.</p>
                </div>
            </div>
        </div>
        <div class="text-center mt-40">
            <a href="?url=home/team" class="btn-cta-secondary" style="display: inline-block; padding: 12px 30px; border-radius: 99px;">View Full Team →</a>
        </div>
    </div>
</section>

<a href="#" class="back-to-top">↑</a>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Hero Carousel Logic
    const slides = document.querySelectorAll('.carousel-slide');
    let currentSlide = 0;

    function nextSlide() {
        slides[currentSlide].classList.remove('active');
        currentSlide = (currentSlide + 1) % slides.length;
        slides[currentSlide].classList.add('active');
    }

    setInterval(nextSlide, 5000); // Change slide every 5 seconds
});
</script>

<?php include 'layouts/footer.php'; ?>
