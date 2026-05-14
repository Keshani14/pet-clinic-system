<?php
$pageTitle       = ($service['name'] ?? 'Service') . ' — Pet Clinic';
$pageDescription = $service['summary'] ?? '';
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
/* ─── Nav ─── */
.services-topbar { background:#ffffff; border-bottom:1px solid #eee; padding:12px 0; }
.services-topbar-inner { max-width:1500px; margin:0 auto; padding:0 30px; display:flex; align-items:center; justify-content:space-between; }
.svc-phone { display:flex; align-items:center; gap:8px; font-weight:700; font-size:1.05rem; color:#1a1a1a; }
.svc-nav-links { display:flex; list-style:none; gap:40px; margin:0; padding:0; }
.svc-nav-links a { text-decoration:none; color:#333; font-weight:600; font-size:1rem; transition:color .2s; }
.svc-nav-links a.active, .svc-nav-links a:hover { color:#db2777; }
.svc-emergency { display:flex; align-items:center; gap:10px; background:#e53e3e; color:#fff; padding:10px 20px; border-radius:8px; font-weight:700; font-size:1rem; }

/* ─── Breadcrumb ─── */
.breadcrumb-bar { background:#ffffff; border-bottom:1px solid #eee; padding:14px 0; }
.breadcrumb-bar .container { max-width:1500px; margin:0 auto; padding:0 30px; }
.breadcrumb { display:flex; align-items:center; gap:8px; font-size:0.9rem; color:#888; }
.breadcrumb a { color:#db2777; text-decoration:none; font-weight:600; }
.breadcrumb a:hover { text-decoration:underline; }

/* ─── Hero ─── */
.svc-detail-hero {
    position: relative;
    height: 50vh;
    min-height: 400px;
    background-size: cover;
    background-position: center;
    display: flex;
    align-items: flex-end;
    padding-bottom: 60px;
    overflow: hidden;
}
.svc-detail-hero::after {
    content:'';
    position:absolute; inset:0;
    background: linear-gradient(to top, rgba(0,0,0,0.75) 0%, rgba(0,0,0,0.2) 60%, transparent 100%);
}
.svc-hero-text {
    position:relative; z-index:2;
    max-width:1500px; margin:0 auto; padding:0 30px; width:100%;
}
.svc-hero-badge {
    display:inline-block; padding:6px 16px;
    background:rgba(219,39,119,0.85); color:#fff;
    border-radius:99px; font-size:0.8rem; font-weight:800;
    letter-spacing:2px; text-transform:uppercase;
    margin-bottom:14px;
}
.svc-hero-text h1 {
    font-size:3.5rem; font-weight:900; color:#fff;
    text-shadow:0 3px 20px rgba(0,0,0,0.4); margin:0; line-height:1.1;
}

/* ─── Content Layout ─── */
.svc-detail-body { max-width:1500px; margin:0 auto; padding:70px 30px 100px; }
.svc-detail-layout { display:grid; grid-template-columns:1.4fr 1fr; gap:70px; align-items:start; }

.svc-detail-left h2 {
    font-size:2rem; font-weight:900; color:#0f172a; margin-bottom:20px;
}
.svc-detail-left h2 span { color:#db2777; }
.svc-detail-left p {
    font-size:1.15rem; line-height:1.9; color:#475569; margin-bottom:20px;
}
.svc-features-list { list-style:none; padding:0; margin:30px 0; }
.svc-features-list li {
    display:flex; align-items:flex-start; gap:14px;
    font-size:1.05rem; color:#334155; margin-bottom:16px; line-height:1.5;
}
.svc-features-list li .check {
    min-width:26px; height:26px; background:#db2777; border-radius:50%;
    display:flex; align-items:center; justify-content:center;
    color:#fff; font-size:0.8rem; margin-top:2px;
}

/* ─── CTA Card ─── */
.svc-cta-card {
    background:#ffffff; border-radius:24px;
    padding:50px 40px; text-align:center;
    box-shadow:0 20px 60px rgba(0,0,0,0.08);
    border:1px solid #fce7f3;
    position:sticky; top:30px;
}
.svc-cta-card .cta-icon { font-size:3.5rem; margin-bottom:20px; }
.svc-cta-card h3 { font-size:1.7rem; font-weight:900; color:#0f172a; margin-bottom:12px; }
.svc-cta-card p { color:#64748b; font-size:1rem; line-height:1.6; margin-bottom:35px; }
.btn-register-now {
    display:block; width:100%; padding:18px;
    background:linear-gradient(135deg, #db2777, #be185d);
    color:#ffffff; text-decoration:none;
    border-radius:14px; font-size:1.1rem; font-weight:800;
    box-shadow:0 10px 30px rgba(219,39,119,0.3);
    transition:all .3s ease; margin-bottom:15px;
}
.btn-register-now:hover {
    transform:translateY(-4px);
    box-shadow:0 15px 40px rgba(219,39,119,0.4);
}
.btn-login-alt {
    display:block; width:100%; padding:16px;
    background:#f8fafc; color:#db2777; text-decoration:none;
    border-radius:14px; font-size:1rem; font-weight:700;
    border:2px solid #fce7f3; transition:all .3s ease;
}
.btn-login-alt:hover { background:#fdf2f8; border-color:#db2777; }
.cta-note { font-size:0.85rem; color:#94a3b8; margin-top:20px; }

/* ─── Back Link ─── */
.back-services-link {
    display:inline-flex; align-items:center; gap:8px;
    color:#db2777; text-decoration:none;
    font-weight:700; font-size:1rem; margin-bottom:40px;
    transition:gap .2s;
}
.back-services-link:hover { gap:12px; }

@media(max-width:900px) {
    .svc-detail-layout { grid-template-columns:1fr; }
    .svc-hero-text h1 { font-size:2.5rem; }
}
</style>

<!-- Top Bar -->
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

<!-- Breadcrumb -->
<div class="breadcrumb-bar">
    <div class="container">
        <nav class="breadcrumb">
            <a href="index.php">Home</a> <span>›</span>
            <a href="?url=home/services">Services</a> <span>›</span>
            <span><?php echo htmlspecialchars($service['name']); ?></span>
        </nav>
    </div>
</div>

<!-- Hero -->
<section class="svc-detail-hero" style="background-image:url('<?php echo htmlspecialchars($service['image']); ?>');">
    <div class="svc-hero-text">
        <div class="svc-hero-badge">Our Services</div>
        <h1><?php echo htmlspecialchars($service['name']); ?></h1>
    </div>
</section>

<!-- Body -->
<div class="svc-detail-body">
    <div class="svc-detail-layout">
        <!-- Left: Description -->
        <div class="svc-detail-left">
            <a href="?url=home/services" class="back-services-link">← Back to All Services</a>
            <h2><?php echo $service['heading']; ?></h2>
            <?php foreach ($service['paragraphs'] as $para): ?>
                <p><?php echo $para; ?></p>
            <?php endforeach; ?>
            <ul class="svc-features-list">
                <?php foreach ($service['features'] as $feat): ?>
                <li>
                    <span class="check">✓</span>
                    <span><?php echo $feat; ?></span>
                </li>
                <?php endforeach; ?>
            </ul>
        </div>

        <!-- Right: CTA Card -->
        <div>
            <div class="svc-cta-card">
                <div class="cta-icon"><?php echo $service['icon']; ?></div>
                <h3>Ready to Get Started?</h3>
                <p>Register with Pet Clinic today and give your pet the world-class care they deserve.</p>
                <a href="?url=user/signup" class="btn-register-now">Register Now — It's Free</a>
                <a href="?url=user/login" class="btn-login-alt">Already a member? Login</a>
                <p class="cta-note">✨ No credit card required. Cancel anytime.</p>
            </div>
        </div>
    </div>
</div>

<a href="#" class="back-to-top">↑</a>
<?php include 'layouts/footer.php'; ?>
