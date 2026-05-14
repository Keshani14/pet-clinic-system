<?php
$pageTitle       = 'Meet Our Expert Team — Pet Clinic';
$pageDescription = 'Our specialists are here to provide the best care for your furry friends.';
$bodyClass       = 'page-team';
require_once __DIR__ . '/layouts/header.php';
?>

<style>
/* ── Perfected Team Page Styles ── */
body.page-team {
    background: linear-gradient(135deg, #fff5f8 0%, #ffe4ef 100%);
}

.team-hero {
    padding: 100px 0 60px;
    text-align: center;
    position: relative;
}
.team-hero h1 { 
    font-size: 4rem; 
    font-weight: 900; 
    color: #1e293b; 
    margin-bottom: 15px; 
    letter-spacing: -2px;
    background: linear-gradient(135deg, #db2777, #be185d);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
}
.team-hero p { font-size: 1.2rem; color: #64748b; max-width: 600px; margin: 0 auto; line-height: 1.6; }

/* Paw Decorations */
.paw-decor {
    position: absolute;
    font-size: 4rem;
    opacity: 0.05;
    pointer-events: none;
    z-index: 0;
}

.team-container {
    max-width: 1200px;
    margin: 0 auto;
    padding: 40px 20px 100px;
}

.team-grid {
    display: grid;
    grid-template-columns: repeat(4, 1fr);
    gap: 25px;
    margin-top: -100px;
}

@media (max-width: 1200px) {
    .team-grid { grid-template-columns: repeat(2, 1fr); margin-top: -60px; }
}

@media (max-width: 768px) {
    .team-grid { grid-template-columns: 1fr; margin-top: -40px; }
}

.team-card {
    background: rgba(255, 255, 255, 0.7);
    backdrop-filter: blur(10px);
    border-radius: 30px;
    overflow: hidden;
    border: 1px solid rgba(255, 255, 255, 0.5);
    box-shadow: 0 10px 30px rgba(219, 39, 119, 0.05);
    transition: all 0.5s cubic-bezier(0.165, 0.84, 0.44, 1);
    position: relative;
}

.team-card::after {
    content: '';
    position: absolute;
    inset: 0;
    border-radius: 30px;
    padding: 2px;
    background: linear-gradient(135deg, #db2777, transparent);
    -webkit-mask: linear-gradient(#fff 0 0) content-box, linear-gradient(#fff 0 0);
    mask: linear-gradient(#fff 0 0) content-box, linear-gradient(#fff 0 0);
    -webkit-mask-composite: xor;
    mask-composite: exclude;
    opacity: 0;
    transition: opacity 0.5s ease;
}

.team-card:hover {
    transform: translateY(-15px) scale(1.02);
    box-shadow: 0 30px 60px rgba(219, 39, 119, 0.15);
    background: #fff;
}
.team-card:hover::after { opacity: 1; }

.member-image {
    height: 300px;
    position: relative;
}
.member-image img {
    width: 100%;
    height: 100%;
    object-fit: cover;
}
.member-image::after {
    content: '';
    position: absolute;
    bottom: 0; left: 0; right: 0;
    height: 60px;
    background: linear-gradient(to top, rgba(255,255,255,1), transparent);
}

.member-content {
    padding: 0 30px 40px;
    text-align: center;
}
.member-role {
    font-size: 0.8rem;
    font-weight: 800;
    color: #db2777;
    text-transform: uppercase;
    letter-spacing: 2px;
    margin-bottom: 8px;
    display: block;
}
.member-name {
    font-size: 1.6rem;
    font-weight: 900;
    color: #1e293b;
    margin-bottom: 12px;
}
.member-bio {
    font-size: 0.95rem;
    color: #64748b;
    line-height: 1.7;
    margin-bottom: 25px;
}

.member-socials {
    display: flex;
    justify-content: center;
    gap: 15px;
}
.social-btn {
    width: 45px; height: 45px;
    border-radius: 15px;
    background: #fef2f7;
    color: #db2777;
    display: flex; align-items: center; justify-content: center;
    text-decoration: none;
    transition: all 0.3s ease;
    font-size: 1.2rem;
}
.social-btn:hover {
    background: #db2777;
    color: #fff;
    transform: rotate(10deg) translateY(-5px);
}

/* Stats Section */
.stats-strip {
    background: #fff;
    padding: 30px 0;
    margin-bottom: 60px;
    box-shadow: 0 5px 20px rgba(0,0,0,0.02);
}
.stats-flex {
    display: flex;
    justify-content: space-around;
    align-items: center;
    flex-wrap: wrap;
    gap: 20px;
}
.stat-item { text-align: center; }
.stat-item h3 { font-size: 2rem; font-weight: 900; color: #db2777; margin-bottom: 0; }
.stat-item p { font-size: 0.9rem; color: #94a3b8; font-weight: 700; text-transform: uppercase; }

@media (max-width: 768px) {
    .team-hero h1 { font-size: 2.8rem; }
    .stats-flex { flex-direction: column; gap: 30px; }
}
</style>

<nav class="home-nav">
    <div class="container nav-content">
        <a href="index.php" class="nav-logo">
            <span>🐾</span> Pet Clinic
        </a>
        <ul class="nav-links-list">
            <li><a href="index.php">Home</a></li>
            <li><a href="?url=home/about">About</a></li>
            <li><a href="?url=home/team" class="active">Team</a></li>
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

<section class="team-hero">
    <span class="paw-decor" style="top: 10%; left: 10%;">🐾</span>
    <span class="paw-decor" style="top: 40%; right: 5%; transform: rotate(20deg);">🐾</span>
    <span class="paw-decor" style="bottom: 10%; left: 20%; transform: rotate(-15deg);">🐾</span>
    
    <div class="container">
        <h1>Our Super Team</h1>
        <p>The highly skilled hands and compassionate hearts behind your pet's health and happiness.</p>
    </div>
</section>

<div class="stats-strip">
    <div class="container stats-flex">
        <div class="stat-item"><h3>15+</h3><p>Years Experience</p></div>
        <div class="stat-item"><h3>2500+</h3><p>Happy Pets</p></div>
        <div class="stat-item"><h3>12</h3><p>Specialists</p></div>
        <div class="stat-item"><h3>24/7</h3><p>Emergency Care</p></div>
    </div>
</div>

<section class="team-container">
    <div class="team-grid">
        
        <!-- Dr. Sarah Miller -->
        <div class="team-card">
            <div class="member-image">
                <img src="https://images.unsplash.com/photo-1612349317150-e413f6a5b16d?auto=format&fit=crop&w=800&q=80" alt="Dr. Sarah Miller">
            </div>
            <div class="member-content">
                <span class="member-role">Lead Veterinary Surgeon</span>
                <h2 class="member-name">Dr. Sarah Miller</h2>
                <p class="member-bio">Expert in advanced surgical techniques with a focus on orthopedic health and speedy recoveries.</p>
                <div class="member-socials">
                    <a href="#" class="social-btn">📘</a>
                    <a href="#" class="social-btn">📸</a>
                </div>
            </div>
        </div>

        <!-- Dr. James Wilson -->
        <div class="team-card">
            <div class="member-image">
                <img src="https://images.unsplash.com/photo-1537368910025-700350fe46c7?auto=format&fit=crop&w=800&q=80" alt="Dr. James Wilson">
            </div>
            <div class="member-content">
                <span class="member-role">Senior Medical Specialist</span>
                <h2 class="member-name">Dr. James Wilson</h2>
                <p class="member-bio">Leading our internal medicine department with a focus on cardiology and senior pet wellness care.</p>
                <div class="member-socials">
                    <a href="#" class="social-btn">📘</a>
                    <a href="#" class="social-btn">💼</a>
                </div>
            </div>
        </div>

        <!-- Emily Chen -->
        <div class="team-card">
            <div class="member-image">
                <img src="https://images.unsplash.com/photo-1551190822-a9333d879b1f?auto=format&fit=crop&w=800&q=80" alt="Emily Chen">
            </div>
            <div class="member-content">
                <span class="member-role">Head of Nursing</span>
                <h2 class="member-name">Emily Chen</h2>
                <p class="member-bio">Dedicated to providing a calm and loving environment for every patient during their clinical stay.</p>
                <div class="member-socials">
                    <a href="#" class="social-btn">📸</a>
                    <a href="#" class="social-btn">💬</a>
                </div>
            </div>
        </div>

        <!-- Alex Thompson -->
        <div class="team-card">
            <div class="member-image">
                <img src="https://images.unsplash.com/photo-1583337130417-3346a1be7dee?auto=format&fit=crop&w=800&q=80" alt="Alex Thompson">
            </div>
            <div class="member-content">
                <span class="member-role">Certified Master Groomer</span>
                <h2 class="member-name">Alex Thompson</h2>
                <p class="member-bio">Combining styling expertise with animal psychology to ensure a stress-free grooming experience.</p>
                <div class="member-socials">
                    <a href="#" class="social-btn">📸</a>
                    <a href="#" class="social-btn">💬</a>
                </div>
            </div>
        </div>

    </div>
</section>

<?php require_once __DIR__ . '/layouts/footer.php'; ?>
