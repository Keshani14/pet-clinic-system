<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Create your Pet Clinic account — book appointments and manage your pet's health records with ease.">
    <title>Sign Up — Pet Clinic</title>

    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;500;600;700;800&display=swap" rel="stylesheet">

    <style>
        /* ── Design Tokens ─────────────────────────────────────────── */
        :root {
            --pink-50 : #fff0f5;
            --pink-100: #ffe0ec;
            --pink-200: #ffb3cc;
            --pink-400: #f472a8;
            --pink-500: #e8438f;
            --pink-600: #d12e7a;
            --white   : #ffffff;
            --gray-100: #f9f9f9;
            --gray-400: #a0a0a0;
            --gray-600: #555555;
            --gray-800: #222222;
            --radius  : 14px;
            --shadow  : 0 8px 40px rgba(232,67,143,.15);
            --transition: .25s ease;
        }

        /* ── Reset & Base ──────────────────────────────────────────── */
        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

        body {
            font-family: 'Nunito', sans-serif;
            min-height: 100vh;
            background: linear-gradient(135deg, #fff0f5 0%, #ffe8f0 40%, #ffd6e7 100%);
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 40px 16px;
        }

        /* ── Card ──────────────────────────────────────────────────── */
        .card {
            background: var(--white);
            border-radius: var(--radius);
            box-shadow: var(--shadow);
            width: 100%;
            max-width: 520px;
            overflow: hidden;
            animation: slideUp .45s cubic-bezier(.22,.61,.36,1) both;
        }

        @keyframes slideUp {
            from { opacity: 0; transform: translateY(28px); }
            to   { opacity: 1; transform: translateY(0);    }
        }

        /* ── Card Header ───────────────────────────────────────────── */
        .card-header {
            background: linear-gradient(135deg, var(--pink-500), var(--pink-400));
            padding: 36px 40px 32px;
            text-align: center;
            position: relative;
        }

        .card-header .paw-icon {
            font-size: 2.6rem;
            display: block;
            margin-bottom: 10px;
            filter: drop-shadow(0 2px 6px rgba(0,0,0,.15));
        }

        .card-header h1 {
            color: var(--white);
            font-size: 1.65rem;
            font-weight: 800;
            letter-spacing: -.3px;
        }

        .card-header p {
            color: rgba(255,255,255,.85);
            font-size: .92rem;
            margin-top: 6px;
        }

        /* ── Card Body ─────────────────────────────────────────────── */
        .card-body { padding: 36px 40px 40px; }

        /* ── Alerts ────────────────────────────────────────────────── */
        .alert {
            border-radius: 10px;
            padding: 14px 18px;
            font-size: .9rem;
            font-weight: 600;
            margin-bottom: 22px;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .alert-success {
            background: #f0fff8;
            border: 1.5px solid #68d9a4;
            color: #1a7a4c;
        }

        .alert-danger {
            background: #fff2f5;
            border: 1.5px solid var(--pink-200);
            color: var(--pink-600);
        }

        /* ── Form Rows ─────────────────────────────────────────────── */
        .form-row {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 16px;
        }

        .form-group { margin-bottom: 18px; }

        label {
            display: block;
            font-size: .85rem;
            font-weight: 700;
            color: var(--gray-600);
            margin-bottom: 7px;
            letter-spacing: .2px;
        }

        label .required { color: var(--pink-500); margin-left: 2px; }

        /* ── Input Fields ──────────────────────────────────────────── */
        .input-wrap {
            position: relative;
            display: flex;
            align-items: center;
        }

        .input-wrap .icon {
            position: absolute;
            left: 14px;
            font-size: 1rem;
            color: var(--pink-400);
            pointer-events: none;
        }

        input[type="text"],
        input[type="email"],
        input[type="tel"],
        input[type="password"] {
            width: 100%;
            padding: 11px 14px 11px 40px;
            border: 1.8px solid var(--pink-100);
            border-radius: 10px;
            font-family: 'Nunito', sans-serif;
            font-size: .95rem;
            color: var(--gray-800);
            background: var(--pink-50);
            transition: border-color var(--transition), box-shadow var(--transition), background var(--transition);
            outline: none;
        }

        input:focus {
            border-color: var(--pink-400);
            background: var(--white);
            box-shadow: 0 0 0 3px rgba(244,114,168,.18);
        }

        input.is-invalid {
            border-color: #f87171;
            background: #fff5f5;
        }

        /* Password toggle button */
        .toggle-pwd {
            position: absolute;
            right: 12px;
            background: none;
            border: none;
            cursor: pointer;
            font-size: 1rem;
            color: var(--gray-400);
            padding: 4px;
            line-height: 1;
            transition: color var(--transition);
        }
        .toggle-pwd:hover { color: var(--pink-500); }

        /* ── Field Error ───────────────────────────────────────────── */
        .field-error {
            display: flex;
            align-items: center;
            gap: 5px;
            color: #e53e3e;
            font-size: .78rem;
            font-weight: 600;
            margin-top: 6px;
        }

        /* ── Password Strength Bar ─────────────────────────────────── */
        .strength-bar-wrap {
            margin-top: 8px;
            display: none;    /* shown by JS when typing starts */
        }

        .strength-bar-track {
            height: 5px;
            border-radius: 99px;
            background: var(--pink-100);
            overflow: hidden;
        }

        .strength-bar-fill {
            height: 100%;
            border-radius: 99px;
            width: 0%;
            transition: width .35s ease, background .35s ease;
        }

        .strength-label {
            font-size: .75rem;
            font-weight: 700;
            margin-top: 4px;
            color: var(--gray-400);
        }

        /* ── Submit Button ─────────────────────────────────────────── */
        .btn-signup {
            width: 100%;
            padding: 13px;
            background: linear-gradient(135deg, var(--pink-500), var(--pink-400));
            color: var(--white);
            border: none;
            border-radius: 10px;
            font-family: 'Nunito', sans-serif;
            font-size: 1rem;
            font-weight: 800;
            letter-spacing: .3px;
            cursor: pointer;
            margin-top: 8px;
            transition: transform var(--transition), box-shadow var(--transition), opacity var(--transition);
            box-shadow: 0 4px 18px rgba(232,67,143,.35);
        }

        .btn-signup:hover  { transform: translateY(-2px); box-shadow: 0 8px 24px rgba(232,67,143,.4); }
        .btn-signup:active { transform: translateY(0);    opacity: .9; }

        /* ── Divider & Login link ──────────────────────────────────── */
        .divider {
            text-align: center;
            color: var(--gray-400);
            font-size: .84rem;
            margin: 22px 0 0;
        }

        .divider a {
            color: var(--pink-500);
            font-weight: 700;
            text-decoration: none;
        }
        .divider a:hover { text-decoration: underline; }

        /* ── Success State Card ────────────────────────────────────── */
        .success-card {
            text-align: center;
            padding: 48px 40px;
        }

        .success-card .tick {
            font-size: 3.5rem;
            display: block;
            margin-bottom: 16px;
            animation: popIn .5s cubic-bezier(.18,.89,.32,1.28) both;
        }

        @keyframes popIn {
            from { transform: scale(0); opacity: 0; }
            to   { transform: scale(1); opacity: 1; }
        }

        .success-card h2 {
            font-size: 1.45rem;
            font-weight: 800;
            color: var(--gray-800);
            margin-bottom: 10px;
        }

        .success-card p { color: var(--gray-600); font-size: .95rem; }

        .btn-login {
            display: inline-block;
            margin-top: 24px;
            padding: 12px 32px;
            background: linear-gradient(135deg, var(--pink-500), var(--pink-400));
            color: var(--white);
            border-radius: 10px;
            font-weight: 800;
            text-decoration: none;
            font-size: .95rem;
            box-shadow: 0 4px 18px rgba(232,67,143,.35);
            transition: transform var(--transition), box-shadow var(--transition);
        }
        .btn-login:hover { transform: translateY(-2px); box-shadow: 0 8px 24px rgba(232,67,143,.4); }

        /* ── Responsive ────────────────────────────────────────────── */
        @media (max-width: 480px) {
            .card-header, .card-body { padding-left: 22px; padding-right: 22px; }
            .form-row { grid-template-columns: 1fr; gap: 0; }
        }
    </style>
</head>
<body>

<main class="card" role="main">

    <!-- ── Card Header ─────────────────────────────────────────── -->
    <div class="card-header">
        <span class="paw-icon" aria-hidden="true">🐾</span>
        <h1>Create Your Account</h1>
        <p>Join Pet Clinic and keep your furry friends healthy!</p>
    </div>

    <!-- ── Card Body ───────────────────────────────────────────── -->
    <div class="card-body">

        <?php if (!empty($success)): ?>
        <!-- ── Success State ──────────────────────────────────── -->
        <div class="success-card" id="success-state">
            <span class="tick" aria-hidden="true">✅</span>
            <h2>You're all set!</h2>
            <p>Your account has been created successfully.<br>You can now log in and book your first appointment.</p>
            <a href="?url=user/login" class="btn-login" id="go-login-btn">Go to Login</a>
        </div>

        <?php else: ?>

        <!-- ── General Error Banner ───────────────────────────── -->
        <?php if (!empty($errors['general'])): ?>
            <div class="alert alert-danger" role="alert" id="general-error-alert">
                <span aria-hidden="true">⚠️</span>
                <?php echo htmlspecialchars($errors['general']); ?>
            </div>
        <?php endif; ?>

        <!-- ── Signup Form ────────────────────────────────────── -->
        <form id="signup-form" method="POST"
              action="?url=user/signup"
              novalidate
              aria-label="Registration form">

            <!-- Name Row -->
            <div class="form-row">
                <!-- First Name -->
                <div class="form-group">
                    <label for="first_name">
                        First Name <span class="required" aria-label="required">*</span>
                    </label>
                    <div class="input-wrap">
                        <span class="icon" aria-hidden="true">👤</span>
                        <input
                            type="text"
                            id="first_name"
                            name="first_name"
                            placeholder="Jane"
                            value="<?php echo htmlspecialchars($old['first_name'] ?? ''); ?>"
                            class="<?php echo !empty($errors['first_name']) ? 'is-invalid' : ''; ?>"
                            aria-required="true"
                            autocomplete="given-name"
                        >
                    </div>
                    <?php if (!empty($errors['first_name'])): ?>
                        <span class="field-error" id="first-name-error" role="alert">
                            <span aria-hidden="true">⚠</span>
                            <?php echo htmlspecialchars($errors['first_name']); ?>
                        </span>
                    <?php endif; ?>
                </div>

                <!-- Last Name -->
                <div class="form-group">
                    <label for="last_name">
                        Last Name <span class="required" aria-label="required">*</span>
                    </label>
                    <div class="input-wrap">
                        <span class="icon" aria-hidden="true">👤</span>
                        <input
                            type="text"
                            id="last_name"
                            name="last_name"
                            placeholder="Doe"
                            value="<?php echo htmlspecialchars($old['last_name'] ?? ''); ?>"
                            class="<?php echo !empty($errors['last_name']) ? 'is-invalid' : ''; ?>"
                            aria-required="true"
                            autocomplete="family-name"
                        >
                    </div>
                    <?php if (!empty($errors['last_name'])): ?>
                        <span class="field-error" id="last-name-error" role="alert">
                            <span aria-hidden="true">⚠</span>
                            <?php echo htmlspecialchars($errors['last_name']); ?>
                        </span>
                    <?php endif; ?>
                </div>
            </div>

            <!-- Email -->
            <div class="form-group">
                <label for="email">
                    Email Address <span class="required" aria-label="required">*</span>
                </label>
                <div class="input-wrap">
                    <span class="icon" aria-hidden="true">✉️</span>
                    <input
                        type="email"
                        id="email"
                        name="email"
                        placeholder="jane@example.com"
                        value="<?php echo htmlspecialchars($old['email'] ?? ''); ?>"
                        class="<?php echo !empty($errors['email']) ? 'is-invalid' : ''; ?>"
                        aria-required="true"
                        autocomplete="email"
                    >
                </div>
                <?php if (!empty($errors['email'])): ?>
                    <span class="field-error" id="email-error" role="alert">
                        <span aria-hidden="true">⚠</span>
                        <?php echo htmlspecialchars($errors['email']); ?>
                    </span>
                <?php endif; ?>
            </div>

            <!-- Phone -->
            <div class="form-group">
                <label for="phone">Phone Number <span style="color:var(--gray-400);font-weight:500;">(optional)</span></label>
                <div class="input-wrap">
                    <span class="icon" aria-hidden="true">📞</span>
                    <input
                        type="tel"
                        id="phone"
                        name="phone"
                        placeholder="+94 77 123 4567"
                        value="<?php echo htmlspecialchars($old['phone'] ?? ''); ?>"
                        class="<?php echo !empty($errors['phone']) ? 'is-invalid' : ''; ?>"
                        autocomplete="tel"
                    >
                </div>
                <?php if (!empty($errors['phone'])): ?>
                    <span class="field-error" id="phone-error" role="alert">
                        <span aria-hidden="true">⚠</span>
                        <?php echo htmlspecialchars($errors['phone']); ?>
                    </span>
                <?php endif; ?>
            </div>

            <!-- Password -->
            <div class="form-group">
                <label for="password">
                    Password <span class="required" aria-label="required">*</span>
                </label>
                <div class="input-wrap">
                    <span class="icon" aria-hidden="true">🔒</span>
                    <input
                        type="password"
                        id="password"
                        name="password"
                        placeholder="Min. 8 characters"
                        class="<?php echo !empty($errors['password']) ? 'is-invalid' : ''; ?>"
                        aria-required="true"
                        autocomplete="new-password"
                    >
                    <button type="button"
                            class="toggle-pwd"
                            id="toggle-pwd-btn"
                            aria-label="Toggle password visibility"
                            data-target="password">👁</button>
                </div>
                <?php if (!empty($errors['password'])): ?>
                    <span class="field-error" id="password-error" role="alert">
                        <span aria-hidden="true">⚠</span>
                        <?php echo htmlspecialchars($errors['password']); ?>
                    </span>
                <?php endif; ?>

                <!-- Strength meter -->
                <div class="strength-bar-wrap" id="strength-wrap" aria-live="polite">
                    <div class="strength-bar-track">
                        <div class="strength-bar-fill" id="strength-fill"></div>
                    </div>
                    <div class="strength-label" id="strength-label"></div>
                </div>
            </div>

            <!-- Confirm Password -->
            <div class="form-group">
                <label for="confirm_password">
                    Confirm Password <span class="required" aria-label="required">*</span>
                </label>
                <div class="input-wrap">
                    <span class="icon" aria-hidden="true">🔒</span>
                    <input
                        type="password"
                        id="confirm_password"
                        name="confirm_password"
                        placeholder="Repeat your password"
                        class="<?php echo !empty($errors['confirm_password']) ? 'is-invalid' : ''; ?>"
                        aria-required="true"
                        autocomplete="new-password"
                    >
                    <button type="button"
                            class="toggle-pwd"
                            id="toggle-confirm-btn"
                            aria-label="Toggle confirm password visibility"
                            data-target="confirm_password">👁</button>
                </div>
                <?php if (!empty($errors['confirm_password'])): ?>
                    <span class="field-error" id="confirm-password-error" role="alert">
                        <span aria-hidden="true">⚠</span>
                        <?php echo htmlspecialchars($errors['confirm_password']); ?>
                    </span>
                <?php endif; ?>
            </div>

            <!-- Submit -->
            <button type="submit" id="signup-submit-btn" class="btn-signup">
                Create Account 🐾
            </button>

        </form>

        <!-- Login link -->
        <p class="divider">
            Already have an account? <a href="?url=user/login" id="login-link">Log in here</a>
        </p>

        <?php endif; ?>
    </div><!-- /card-body -->
</main>

<!-- ── JavaScript: client-side enhancements ──────────────────────── -->
<script>
(function () {
    'use strict';

    /* ── Password visibility toggles ─────────────────────────── */
    document.querySelectorAll('.toggle-pwd').forEach(function(btn) {
        btn.addEventListener('click', function() {
            var targetId  = btn.getAttribute('data-target');
            var input     = document.getElementById(targetId);
            if (!input) return;
            var isHidden  = input.type === 'password';
            input.type    = isHidden ? 'text' : 'password';
            btn.textContent = isHidden ? '🙈' : '👁';
        });
    });

    /* ── Password strength meter ──────────────────────────────── */
    var pwdInput    = document.getElementById('password');
    var strengthWrap = document.getElementById('strength-wrap');
    var fill         = document.getElementById('strength-fill');
    var label        = document.getElementById('strength-label');

    var levels = [
        { label: 'Very Weak',  color: '#f87171', width: '15%' },
        { label: 'Weak',       color: '#fb923c', width: '35%' },
        { label: 'Fair',       color: '#facc15', width: '55%' },
        { label: 'Strong',     color: '#34d399', width: '78%' },
        { label: 'Very Strong',color: '#10b981', width: '100%' },
    ];

    function scorePassword(pw) {
        var score = 0;
        if (pw.length >= 8)  score++;
        if (pw.length >= 12) score++;
        if (/[A-Z]/.test(pw)) score++;
        if (/[0-9]/.test(pw)) score++;
        if (/[^A-Za-z0-9]/.test(pw)) score++;
        return Math.min(score, 4);
    }

    if (pwdInput) {
        pwdInput.addEventListener('input', function() {
            var pw = pwdInput.value;
            if (pw.length === 0) {
                strengthWrap.style.display = 'none';
                return;
            }
            strengthWrap.style.display = 'block';
            var idx    = scorePassword(pw);
            var lvl    = levels[idx];
            fill.style.width      = lvl.width;
            fill.style.background = lvl.color;
            label.textContent     = 'Strength: ' + lvl.label;
            label.style.color     = lvl.color;
        });
    }

    /* ── Client-side form validation ─────────────────────────── */
    var form = document.getElementById('signup-form');
    if (form) {
        form.addEventListener('submit', function(e) {
            var valid = true;

            /* Helper: show inline error */
            function markInvalid(inputId, msg) {
                var input = document.getElementById(inputId);
                if (!input) return;
                input.classList.add('is-invalid');
                // Only add client-side error if no server-side error already shown
                var existing = input.parentElement.nextElementSibling;
                if (!existing || !existing.classList.contains('field-error')) {
                    var span = document.createElement('span');
                    span.className = 'field-error';
                    span.setAttribute('role', 'alert');
                    span.innerHTML = '<span aria-hidden="true">⚠</span> ' + msg;
                    input.parentElement.insertAdjacentElement('afterend', span);
                }
                valid = false;
            }

            /* Clear previous client-side errors */
            document.querySelectorAll('input').forEach(function(i) {
                i.classList.remove('is-invalid');
            });
            document.querySelectorAll('.field-error[data-client]').forEach(function(el) {
                el.remove();
            });

            var fn = document.getElementById('first_name');
            if (fn && fn.value.trim() === '') markInvalid('first_name', 'First name is required.');

            var ln = document.getElementById('last_name');
            if (ln && ln.value.trim() === '') markInvalid('last_name', 'Last name is required.');

            var em = document.getElementById('email');
            if (em) {
                if (em.value.trim() === '') {
                    markInvalid('email', 'Email address is required.');
                } else if (!/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(em.value.trim())) {
                    markInvalid('email', 'Please enter a valid email address.');
                }
            }

            var pw  = document.getElementById('password');
            var cpw = document.getElementById('confirm_password');

            if (pw && pw.value.length < 8) {
                markInvalid('password', 'Password must be at least 8 characters.');
            }

            if (pw && cpw && pw.value !== cpw.value) {
                markInvalid('confirm_password', 'Passwords do not match.');
            }

            if (!valid) e.preventDefault();
        });
    }
})();
</script>

</body>
</html>
