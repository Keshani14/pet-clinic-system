<?php
$pageTitle       = 'Our Services — Pet Clinic';
$pageDescription = 'Discover the comprehensive veterinary services we offer.';
$bodyClass       = 'page-services';
require_once __DIR__ . '/layouts/header.php';
?>
<style>
body.page-services {
    display: block !important;
    padding: 0 !important;
    background: #f0f0f0 !important;
    min-height: 100vh;
}

/* ─── Services Nav ─── */
.services-topbar {
    background: #ffffff;
    border-bottom: 1px solid #eee;
    padding: 12px 0;
}
.services-topbar-inner {
    max-width: 1500px;
    margin: 0 auto;
    padding: 0 30px;
    display: flex;
    align-items: center;
    justify-content: space-between;
}
.svc-phone {
    display: flex;
    align-items: center;
    gap: 8px;
    font-weight: 700;
    font-size: 1.05rem;
    color: #1a1a1a;
}
.svc-phone svg { color: #db2777; }
.svc-nav-links {
    display: flex;
    list-style: none;
    gap: 40px;
    margin: 0;
    padding: 0;
}
.svc-nav-links a {
    text-decoration: none;
    color: #333;
    font-weight: 600;
    font-size: 1rem;
    transition: color 0.2s;
}
.svc-nav-links a.active { color: #db2777; }
.svc-nav-links a:hover { color: #db2777; }
.svc-emergency {
    display: flex;
    align-items: center;
    gap: 10px;
    background: #e53e3e;
    color: #fff;
    padding: 10px 20px;
    border-radius: 8px;
    font-weight: 700;
    font-size: 1rem;
}

/* ─── Header ─── */
.services-page-header {
    text-align: center;
    padding: 60px 20px 40px;
    background: #f0f0f0;
}
.services-page-header .label {
    font-size: 1.3rem;
    color: #db2777;
    font-weight: 700;
    display: block;
    margin-bottom: 8px;
}
.services-page-header h1 {
    font-size: 2.8rem;
    font-weight: 900;
    color: #1a1a1a;
    font-family: 'Georgia', serif;
    font-style: italic;
    margin: 0;
}

/* ─── Services Grid ─── */
.services-cards-section {
    max-width: 1400px;
    margin: 0 auto;
    padding: 0 30px 80px;
}
.services-cards-grid {
    display: grid;
    grid-template-columns: repeat(4, 1fr);
    gap: 24px;
}
.svc-card {
    background: #ffffff;
    border-radius: 12px;
    overflow: hidden;
    box-shadow: 0 2px 10px rgba(0,0,0,0.07);
    transition: transform 0.2s, box-shadow 0.2s;
}
.svc-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 10px 25px rgba(0,0,0,0.12);
}
.svc-card-img {
    width: 100%;
    height: 180px;
    object-fit: cover;
    display: block;
}
.svc-card-body {
    padding: 20px 15px;
    text-align: center;
    min-height: 80px;
    display: flex;
    align-items: center;
    justify-content: center;
}
.svc-card-body h3 {
    font-size: 1rem;
    font-weight: 600;
    color: #2d2d2d;
    line-height: 1.4;
    margin: 0;
}
.svc-card a {
    text-decoration: none;
    color: inherit;
    display: block;
}
.svc-card:hover .svc-card-body h3 {
    color: #db2777;
    transition: color 0.2s;
}

@media (max-width: 900px) {
    .services-cards-grid { grid-template-columns: repeat(2, 1fr); }
}
@media (max-width: 500px) {
    .services-cards-grid { grid-template-columns: 1fr; }
    .services-page-header h1 { font-size: 2rem; }
}
</style>

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
            <li><a href="index.php">Home</a></li>
            <li><a href="?url=home/about">About</a></li>
            <li><a href="#">Team</a></li>
            <li><a href="?url=home/services" class="active">Services</a></li>
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

<!-- Page Header -->
<div class="services-page-header">
    <span class="label">Services</span>
    <h1>What We Offer</h1>
</div>

<!-- Services Cards -->
<section class="services-cards-section">
    <div class="services-cards-grid">

        <div class="svc-card">
            <a href="?url=home/serviceDetail&service=pain-control">
                <img class="svc-card-img" src="https://images.unsplash.com/photo-1587300003388-59208cc962cb?auto=format&fit=crop&w=600&q=80" alt="Pain Control">
                <div class="svc-card-body"><h3>Comprehensive <span>Pain</span> Control</h3></div>
            </a>
        </div>

        <div class="svc-card">
            <a href="?url=home/serviceDetail&service=anesthesia">
                <img class="svc-card-img" src="https://images.unsplash.com/photo-1612349317150-e413f6a5b16d?auto=format&fit=crop&w=600&q=80" alt="Anesthesia">
                <div class="svc-card-body"><h3>Advanced Anesthesia</h3></div>
            </a>
        </div>

        <div class="svc-card">
            <a href="?url=home/serviceDetail&service=surgery">
                <img class="svc-card-img" src="https://images.unsplash.com/photo-1596492784531-6e6eb5ea9993?auto=format&fit=crop&w=600&q=80" alt="Surgery">
                <div class="svc-card-body"><h3>Companion <span>Animal</span> Surgery</h3></div>
            </a>
        </div>

        <div class="svc-card">
            <a href="?url=home/serviceDetail&service=medical-services">
                <img class="svc-card-img" src="https://images.unsplash.com/photo-1548767797-d8c844163c4c?auto=format&fit=crop&w=600&q=80" alt="Medical Services">
                <div class="svc-card-body"><h3>Companion <span>Animal</span> Medical Services</h3></div>
            </a>
        </div>

        <div class="svc-card">
            <a href="?url=home/serviceDetail&service=dental">
                <img class="svc-card-img" src="https://images.unsplash.com/photo-1559839914-17aae19cec71?auto=format&fit=crop&w=600&q=80" alt="Dental">
                <div class="svc-card-body"><h3>Dental Services</h3></div>
            </a>
        </div>

        <div class="svc-card">
            <a href="?url=home/serviceDetail&service=grooming">
                <img class="svc-card-img" src="https://images.unsplash.com/photo-1553531889-e6cf4d692b1b?auto=format&fit=crop&w=600&q=80" alt="Grooming">
                <div class="svc-card-body"><h3>Professional Grooming</h3></div>
            </a>
        </div>

        <div class="svc-card">
            <a href="?url=home/serviceDetail&service=laboratory">
                <img class="svc-card-img" src="https://images.unsplash.com/photo-1576671081837-49000212a370?auto=format&fit=crop&w=600&q=80" alt="Laboratory">
                <div class="svc-card-body"><h3>Laboratory Services</h3></div>
            </a>
        </div>

        <div class="svc-card">
            <a href="?url=home/serviceDetail&service=emergency">
                <img class="svc-card-img" src="https://images.unsplash.com/photo-1551190822-a9333d879b1f?auto=format&fit=crop&w=600&q=80" alt="Emergency">
                <div class="svc-card-body"><h3>24 Hour Emergency Service</h3></div>
            </a>
        </div>

        <div class="svc-card">
            <a href="?url=home/serviceDetail&service=vaccination">
                <img class="svc-card-img" src="https://images.unsplash.com/photo-1585421514284-efb74c2b69ba?auto=format&fit=crop&w=600&q=80" alt="Vaccination">
                <div class="svc-card-body"><h3>Vaccination Management</h3></div>
            </a>
        </div>

        <div class="svc-card">
            <a href="?url=home/serviceDetail&service=appointments">
                <img class="svc-card-img" src="https://images.unsplash.com/photo-1600880292203-757bb62b4baf?auto=format&fit=crop&w=600&q=80" alt="Appointments">
                <div class="svc-card-body"><h3>Online Appointment Booking</h3></div>
            </a>
        </div>

        <div class="svc-card">
            <a href="?url=home/serviceDetail&service=records">
                <img class="svc-card-img" src="https://images.unsplash.com/photo-1587300003388-59208cc962cb?auto=format&fit=crop&w=600&q=80" alt="Pet Records">
                <div class="svc-card-body"><h3>Digital Pet Health Records</h3></div>
            </a>
        </div>

        <div class="svc-card">
            <a href="?url=home/serviceDetail&service=nutrition">
                <img class="svc-card-img" src="https://images.unsplash.com/photo-1516734212186-a967f81ad0d7?auto=format&fit=crop&w=600&q=80" alt="Nutritional Advice">
                <div class="svc-card-body"><h3>Nutritional Counselling</h3></div>
            </a>
        </div>

    </div>
</section>

<a href="#" class="back-to-top">↑</a>

<?php include 'layouts/footer.php'; ?>
