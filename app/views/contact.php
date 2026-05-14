<?php
$pageTitle       = 'Contact Us — PawCare Clinic';
$pageDescription = 'Get in touch with PawCare Clinic. Find our address, phone, working hours, and send us a message.';
$bodyClass       = 'page-contact';
require_once __DIR__ . '/layouts/header.php';
?>
<style>
/* ══════════════════════════════════════
   CONTACT PAGE STYLES
══════════════════════════════════════ */
body.page-contact {
    display: block !important;
    padding: 0 !important;
    background: #f8fafc !important;
    min-height: 100vh;
}

/* ── Topbar ── */
.contact-topbar { background:#ffffff; border-bottom:1px solid #e8e8e8; padding:12px 0; }
.contact-topbar-inner { max-width:1500px; margin:0 auto; padding:0 30px; display:flex; align-items:center; justify-content:space-between; }
.ct-phone { display:flex; align-items:center; gap:8px; font-weight:700; font-size:1rem; color:#1a1a1a; }
.ct-nav { display:flex; list-style:none; gap:35px; margin:0; padding:0; }
.ct-nav a { text-decoration:none; color:#444; font-weight:600; font-size:0.97rem; transition:color .2s; }
.ct-nav a.active, .ct-nav a:hover { color:#db2777; }
.ct-emergency { display:flex; align-items:center; gap:8px; background:#e53e3e; color:#fff; padding:9px 18px; border-radius:8px; font-weight:700; font-size:0.95rem; text-decoration:none; transition:background .2s; }
.ct-emergency:hover { background:#c53030; }

/* ── Hero Banner ── */
.contact-hero {
    background: linear-gradient(135deg, #831843 0%, #db2777 50%, #f472b6 100%);
    padding: 70px 0 80px;
    text-align: center;
    color: #fff;
    position: relative;
    overflow: hidden;
}
.contact-hero::before {
    content: '🐾';
    position: absolute; font-size: 14rem; opacity: 0.06;
    top: -30px; right: -40px; line-height: 1;
}
.contact-hero::after {
    content: '🐾';
    position: absolute; font-size: 10rem; opacity: 0.06;
    bottom: -20px; left: -20px; line-height: 1;
}
.contact-hero h1 { font-size:3.2rem; font-weight:900; margin-bottom:15px; letter-spacing:-1px; }
.contact-hero p { font-size:1.2rem; opacity:0.9; max-width:550px; margin:0 auto; line-height:1.6; }

/* ── Main Layout ── */
.contact-main { max-width:1500px; margin:0 auto; padding:70px 30px 100px; }
.contact-grid { display:grid; grid-template-columns:1fr 1.3fr; gap:50px; }

/* ── Info Cards ── */
.info-card {
    background:#fff; border-radius:20px; padding:35px;
    box-shadow:0 4px 25px rgba(0,0,0,0.07); margin-bottom:25px;
    border:1px solid #f0f0f0;
}
.info-card:last-child { margin-bottom:0; }
.info-card-title {
    font-size:1.15rem; font-weight:800; color:#0f172a;
    margin-bottom:25px; padding-bottom:15px;
    border-bottom:2px solid #fce7f3;
    display:flex; align-items:center; gap:10px;
}
.info-card-title span { color:#db2777; }
.info-row { display:flex; align-items:flex-start; gap:15px; margin-bottom:20px; }
.info-row:last-child { margin-bottom:0; }
.info-icon {
    width:42px; height:42px; background:#fdf2f8; border-radius:12px;
    display:flex; align-items:center; justify-content:center;
    font-size:1.2rem; flex-shrink:0;
}
.info-text strong { display:block; font-size:0.8rem; font-weight:800; color:#94a3b8; text-transform:uppercase; letter-spacing:1px; margin-bottom:3px; }
.info-text span { font-size:1rem; color:#334155; font-weight:600; line-height:1.5; }

/* ── Hours Table ── */
.hours-table { width:100%; border-collapse:collapse; }
.hours-table tr { border-bottom:1px solid #f1f5f9; }
.hours-table tr:last-child { border-bottom:none; }
.hours-table td { padding:11px 0; font-size:0.97rem; color:#334155; font-weight:600; }
.hours-table td:last-child { text-align:right; color:#64748b; font-weight:500; }
.hours-badge {
    display:inline-block; padding:3px 10px;
    background:#fef3c7; color:#d97706;
    border-radius:99px; font-size:0.8rem; font-weight:700;
}
.hours-badge.closed { background:#fee2e2; color:#e53e3e; }
.hours-badge.open { background:#dcfce7; color:#16a34a; }

/* ── Emergency Banner ── */
.emergency-banner {
    background: linear-gradient(135deg, #e53e3e, #c53030);
    border-radius:20px; padding:30px 35px;
    display:flex; align-items:center; gap:20px;
    box-shadow:0 10px 30px rgba(229,62,62,0.2);
    color:#fff; margin-bottom:25px;
}
.emergency-icon { font-size:2.5rem; flex-shrink:0; }
.emergency-text h3 { font-size:1.2rem; font-weight:900; margin-bottom:5px; }
.emergency-text p { opacity:0.9; font-size:0.97rem; margin-bottom:8px; }
.emergency-number {
    font-size:1.4rem; font-weight:900; display:flex; align-items:center; gap:8px;
}

/* ── Social ── */
.social-bar { display:flex; gap:12px; margin-top:5px; }
.social-btn {
    width:46px; height:46px; border-radius:12px; display:flex;
    align-items:center; justify-content:center; font-size:1.3rem;
    text-decoration:none; transition:transform .2s, box-shadow .2s;
}
.social-btn:hover { transform:translateY(-4px); box-shadow:0 8px 20px rgba(0,0,0,0.15); }
.social-facebook { background:#1877f2; }
.social-instagram { background:linear-gradient(135deg,#f09433,#e6683c,#dc2743,#cc2366,#bc1888); }
.social-whatsapp { background:#25d366; }

/* ── Contact Form ── */
.form-card {
    background:#fff; border-radius:20px; padding:45px;
    box-shadow:0 4px 25px rgba(0,0,0,0.07); border:1px solid #f0f0f0;
}
.form-card h2 { font-size:1.8rem; font-weight:900; color:#0f172a; margin-bottom:8px; }
.form-card .form-subtitle { color:#64748b; font-size:1rem; margin-bottom:30px; }
.form-row { display:grid; grid-template-columns:1fr 1fr; gap:18px; }
.form-group { margin-bottom:20px; }
.form-group label {
    display:block; font-size:0.85rem; font-weight:700;
    color:#374151; margin-bottom:7px; text-transform:uppercase; letter-spacing:0.5px;
}
.form-group input, .form-group select, .form-group textarea {
    width:100%; padding:14px 18px; border:2px solid #e5e7eb;
    border-radius:12px; font-size:1rem; color:#1f2937;
    font-family:inherit; transition:border-color .2s, box-shadow .2s;
    background:#fafafa; outline:none;
}
.form-group input:focus, .form-group select:focus, .form-group textarea:focus {
    border-color:#db2777; box-shadow:0 0 0 4px rgba(219,39,119,0.08);
    background:#fff;
}
.form-group textarea { resize:vertical; min-height:130px; }
.form-group input.error, .form-group textarea.error { border-color:#e53e3e; }
.field-error { color:#e53e3e; font-size:0.8rem; margin-top:5px; display:none; }
.btn-send {
    width:100%; padding:18px; background:linear-gradient(135deg,#db2777,#be185d);
    color:#fff; border:none; border-radius:14px; font-size:1.1rem; font-weight:800;
    cursor:pointer; transition:all .3s ease; font-family:inherit;
    box-shadow:0 8px 25px rgba(219,39,119,0.25);
    display:flex; align-items:center; justify-content:center; gap:10px;
}
.btn-send:hover { transform:translateY(-3px); box-shadow:0 12px 35px rgba(219,39,119,0.35); }
.btn-send:active { transform:translateY(0); }
.alert-success, .alert-error {
    padding:16px 20px; border-radius:12px; font-weight:700; font-size:0.97rem;
    margin-bottom:20px; display:none; align-items:center; gap:10px;
}
.alert-success { background:#dcfce7; color:#16a34a; border:1px solid #bbf7d0; }
.alert-error   { background:#fee2e2; color:#dc2626; border:1px solid #fecaca; }

/* ── Map Section ── */
.map-section { max-width:1500px; margin:0 auto; padding:0 30px 80px; }
.map-section h2 { font-size:1.8rem; font-weight:900; color:#0f172a; margin-bottom:5px; }
.map-section .map-sub { color:#64748b; margin-bottom:25px; font-size:0.97rem; }
.map-wrapper { border-radius:20px; overflow:hidden; box-shadow:0 10px 40px rgba(0,0,0,0.1); border:1px solid #e5e7eb; }
.map-wrapper iframe { width:100%; height:420px; border:0; display:block; }
.map-note { text-align:center; margin-top:12px; color:#94a3b8; font-size:0.85rem; font-style:italic; }

/* ── Quick Help ── */
.quick-help-section {
    background:linear-gradient(135deg, #fdf2f8 0%, #fff0f5 100%);
    border-top:1px solid #fce7f3;
    padding:60px 30px;
    text-align:center;
}
.quick-help-inner { max-width:700px; margin:0 auto; }
.quick-help-icon { font-size:3rem; margin-bottom:20px; }
.quick-help-section h2 { font-size:2rem; font-weight:900; color:#0f172a; margin-bottom:15px; }
.quick-help-section p { color:#475569; font-size:1.1rem; line-height:1.7; margin-bottom:30px; }
.btn-quick-help {
    display:inline-block; padding:16px 40px;
    background:#db2777; color:#fff; text-decoration:none;
    border-radius:14px; font-weight:800; font-size:1.05rem;
    box-shadow:0 8px 25px rgba(219,39,119,0.25); transition:all .3s;
}
.btn-quick-help:hover { transform:translateY(-3px); box-shadow:0 12px 35px rgba(219,39,119,0.35); }

@media(max-width:900px) {
    .contact-grid { grid-template-columns:1fr; }
    .form-row { grid-template-columns:1fr; }
    .contact-hero h1 { font-size:2.2rem; }
    .form-card { padding:30px 20px; }
    .contact-topbar-inner { flex-direction:column; gap:15px; }
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
            <li><a href="?url=home/services">Services</a></li>
            <li><a href="?url=home/contact" class="active">Contact</a></li>
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

<!-- ── Hero ── -->
<div class="contact-hero">
    <h1>Get In Touch</h1>
    <p>We're here for you and your pets — 24 hours a day, 7 days a week. Reach out anytime.</p>
</div>

<!-- ── Main Content ── -->
<div class="contact-main">
    <div class="contact-grid">

        <!-- LEFT COLUMN: Info Cards -->
        <div>
            <!-- Emergency Banner -->
            <div class="emergency-banner">
                <div class="emergency-icon">🚨</div>
                <div class="emergency-text">
                    <h3>24/7 Emergency Pet Support</h3>
                    <p>Life-threatening situation? Call us immediately.</p>
                    <div class="emergency-number">📞 +94 71 999 9999</div>
                </div>
            </div>

            <!-- Clinic Info -->
            <div class="info-card">
                <div class="info-card-title">🐾 <span>PawCare Clinic</span> — Contact Info</div>

                <div class="info-row">
                    <div class="info-icon">📍</div>
                    <div class="info-text">
                        <strong>Address</strong>
                        <span>No. 25, Galle Road, Colombo 03, Sri Lanka</span>
                    </div>
                </div>

                <div class="info-row">
                    <div class="info-icon">📞</div>
                    <div class="info-text">
                        <strong>Phone</strong>
                        <span>+94 77 123 4567</span>
                    </div>
                </div>

                <div class="info-row">
                    <div class="info-icon">📧</div>
                    <div class="info-text">
                        <strong>Email</strong>
                        <span>support@pawcareclinic.com</span>
                    </div>
                </div>

                <div class="info-row">
                    <div class="info-icon">🌐</div>
                    <div class="info-text">
                        <strong>Social Media</strong>
                        <div class="social-bar" style="margin-top:8px;">
                            <a href="#" class="social-btn social-facebook" title="Facebook">📘</a>
                            <a href="#" class="social-btn social-instagram" title="Instagram">📸</a>
                            <a href="#" class="social-btn social-whatsapp" title="WhatsApp">💬</a>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Working Hours -->
            <div class="info-card">
                <div class="info-card-title">🕒 <span>Working Hours</span></div>
                <table class="hours-table">
                    <tr>
                        <td>Monday – Friday</td>
                        <td><span class="hours-badge open">8:00 AM – 6:00 PM</span></td>
                    </tr>
                    <tr>
                        <td>Saturday</td>
                        <td><span class="hours-badge">9:00 AM – 4:00 PM</span></td>
                    </tr>
                    <tr>
                        <td>Sunday</td>
                        <td><span class="hours-badge closed">Emergency Only</span></td>
                    </tr>
                    <tr>
                        <td>Public Holidays</td>
                        <td><span class="hours-badge closed">Emergency Only</span></td>
                    </tr>
                </table>
            </div>
        </div>

        <!-- RIGHT COLUMN: Contact Form -->
        <div class="form-card">
            <h2>Send Us a Message</h2>
            <p class="form-subtitle">Fill in the form below and our team will get back to you within 24 hours.</p>

            <div class="alert-success" id="successAlert">✅ Your message has been sent! We'll get back to you soon.</div>
            <div class="alert-error" id="errorAlert">❌ Please fill in all required fields correctly.</div>

            <form id="contactForm" novalidate>
                <div class="form-row">
                    <div class="form-group">
                        <label for="ct_name">Full Name *</label>
                        <input type="text" id="ct_name" placeholder="e.g. Kasun Perera" autocomplete="name">
                        <div class="field-error" id="err_name">Please enter your name.</div>
                    </div>
                    <div class="form-group">
                        <label for="ct_email">Email Address *</label>
                        <input type="email" id="ct_email" placeholder="you@example.com" autocomplete="email">
                        <div class="field-error" id="err_email">Please enter a valid email.</div>
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-group">
                        <label for="ct_phone">Phone Number</label>
                        <input type="tel" id="ct_phone" placeholder="+94 77 000 0000" autocomplete="tel">
                    </div>
                    <div class="form-group">
                        <label for="ct_subject">Subject *</label>
                        <select id="ct_subject">
                            <option value="">— Select a subject —</option>
                            <option value="appointment">Appointment Booking</option>
                            <option value="vaccination">Vaccination Query</option>
                            <option value="emergency">Emergency Inquiry</option>
                            <option value="general">General Inquiry</option>
                            <option value="feedback">Feedback / Complaint</option>
                        </select>
                        <div class="field-error" id="err_subject">Please select a subject.</div>
                    </div>
                </div>

                <div class="form-group">
                    <label for="ct_message">Message *</label>
                    <textarea id="ct_message" placeholder="Tell us about your pet and how we can help you..."></textarea>
                    <div class="field-error" id="err_message">Please enter your message.</div>
                </div>

                <button type="submit" class="btn-send" id="sendBtn">
                    <span>📨</span> Send Message
                </button>
            </form>
        </div>

    </div>
</div>

<!-- ── Map Section ── -->
<div class="map-section">
    <h2>📍 Find Us</h2>
    <p class="map-sub">We're located on Galle Road, Colombo — easy to reach by bus, train, or cab.</p>
    <div class="map-wrapper">
        <iframe
            src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3960.7985553855455!2d79.8489!3d6.9105!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3ae259232d0b9b8b%3A0x1e9cb49f6e11db9a!2sGalle%20Road%2C%20Colombo%2003!5e0!3m2!1sen!2slk!4v1715600000000"
            allowfullscreen=""
            loading="lazy"
            referrerpolicy="no-referrer-when-downgrade">
        </iframe>
    </div>
    <p class="map-note">* Demo project location for academic purposes — University Capstone Project.</p>
</div>

<!-- ── Quick Help ── -->
<div class="quick-help-section">
    <div class="quick-help-inner">
        <div class="quick-help-icon">🐶</div>
        <h2>Need Help With Your Pet?</h2>
        <p>Need help booking appointments or managing vaccinations? Our dedicated team is ready to assist you and your beloved pets every step of the way.</p>
        <a href="?url=user/signup" class="btn-quick-help">Register for Free →</a>
    </div>
</div>

<a href="#" class="back-to-top">↑</a>

<script>
(function () {
    const form = document.getElementById('contactForm');

    form.addEventListener('submit', function (e) {
        e.preventDefault();
        clearErrors();

        const name    = document.getElementById('ct_name');
        const email   = document.getElementById('ct_email');
        const subject = document.getElementById('ct_subject');
        const message = document.getElementById('ct_message');

        let valid = true;
        const emailRx = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;

        if (!name.value.trim()) { showError('err_name', name); valid = false; }
        if (!email.value.trim() || !emailRx.test(email.value)) { showError('err_email', email); valid = false; }
        if (!subject.value) { showError('err_subject', subject); valid = false; }
        if (!message.value.trim()) { showError('err_message', message); valid = false; }

        if (!valid) {
            document.getElementById('errorAlert').style.display = 'flex';
            return;
        }

        // Simulate submission
        const btn = document.getElementById('sendBtn');
        btn.innerHTML = '<span>⏳</span> Sending…';
        btn.disabled = true;

        setTimeout(function () {
            form.reset();
            btn.innerHTML = '<span>📨</span> Send Message';
            btn.disabled = false;
            document.getElementById('successAlert').style.display = 'flex';
            setTimeout(() => document.getElementById('successAlert').style.display = 'none', 5000);
        }, 1500);
    });

    function showError(id, field) {
        document.getElementById(id).style.display = 'block';
        field.classList.add('error');
    }

    function clearErrors() {
        document.querySelectorAll('.field-error').forEach(el => el.style.display = 'none');
        document.querySelectorAll('.error').forEach(el => el.classList.remove('error'));
        document.getElementById('successAlert').style.display = 'none';
        document.getElementById('errorAlert').style.display = 'none';
    }
})();
</script>

<?php include 'layouts/footer.php'; ?>
