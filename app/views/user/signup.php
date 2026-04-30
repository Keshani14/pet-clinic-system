<?php
// ── Page meta ─────────────────────────────────────────────────
$pageTitle       = 'Sign Up — Pet Clinic';
$pageDescription = "Create your Pet Clinic account — book appointments and manage your pet's health records with ease.";
require_once __DIR__ . '/../../views/layouts/header.php';
?>

<main class="card" role="main">

    <!-- ── Card Header ─────────────────────────────────────── -->
    <div class="card-header">
        <span class="paw-icon" aria-hidden="true">🐾</span>
        <h1>Create Your Account</h1>
        <p>Join Pet Clinic and keep your furry friends healthy!</p>
    </div>

    <!-- ── Card Body ───────────────────────────────────────── -->
    <div class="card-body">

        <!-- General error banner -->
        <?php if (!empty($errors['general'])): ?>
            <div class="alert alert-danger" role="alert" id="general-error-alert">
                <span aria-hidden="true">⚠️</span>
                <?php echo htmlspecialchars($errors['general']); ?>
            </div>
        <?php endif; ?>

        <!-- ── Signup Form ──────────────────────────────────── -->
        <form id="signup-form" method="POST"
              action="?url=user/signup"
              novalidate
              aria-label="Registration form">

            <!-- Name row -->
            <div class="form-row">

                <!-- First Name -->
                <div class="form-group">
                    <label for="first_name">
                        First Name <span class="required" aria-label="required">*</span>
                    </label>
                    <div class="input-wrap">
                        <span class="icon" aria-hidden="true">👤</span>
                        <input type="text" id="first_name" name="first_name"
                               placeholder="Jane"
                               value="<?php echo htmlspecialchars($old['first_name'] ?? ''); ?>"
                               class="<?php echo !empty($errors['first_name']) ? 'is-invalid' : ''; ?>"
                               aria-required="true" autocomplete="given-name">
                    </div>
                    <?php if (!empty($errors['first_name'])): ?>
                        <span class="field-error" role="alert">
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
                        <input type="text" id="last_name" name="last_name"
                               placeholder="Doe"
                               value="<?php echo htmlspecialchars($old['last_name'] ?? ''); ?>"
                               class="<?php echo !empty($errors['last_name']) ? 'is-invalid' : ''; ?>"
                               aria-required="true" autocomplete="family-name">
                    </div>
                    <?php if (!empty($errors['last_name'])): ?>
                        <span class="field-error" role="alert">
                            <span aria-hidden="true">⚠</span>
                            <?php echo htmlspecialchars($errors['last_name']); ?>
                        </span>
                    <?php endif; ?>
                </div>

            </div><!-- /form-row -->

            <!-- Email -->
            <div class="form-group">
                <label for="email">
                    Email Address <span class="required" aria-label="required">*</span>
                </label>
                <div class="input-wrap">
                    <span class="icon" aria-hidden="true">✉️</span>
                    <input type="email" id="email" name="email"
                           placeholder="jane@example.com"
                           value="<?php echo htmlspecialchars($old['email'] ?? ''); ?>"
                           class="<?php echo !empty($errors['email']) ? 'is-invalid' : ''; ?>"
                           aria-required="true" autocomplete="email">
                </div>
                <?php if (!empty($errors['email'])): ?>
                    <span class="field-error" role="alert">
                        <span aria-hidden="true">⚠</span>
                        <?php echo htmlspecialchars($errors['email']); ?>
                    </span>
                <?php endif; ?>
            </div>

            <!-- Role Selection -->
            <div class="form-group">
                <label for="role">
                    Register As <span class="required" aria-label="required">*</span>
                </label>
                <div class="input-wrap">
                    <span class="icon" aria-hidden="true">🏷️</span>
                    <select id="role" name="role" class="<?php echo !empty($errors['role']) ? 'is-invalid' : ''; ?>" aria-required="true">
                        <option value="owner" <?php echo (isset($old['role']) && $old['role'] === 'owner') ? 'selected' : ''; ?>>Pet Owner (Instant Approval)</option>
                        <option value="vet" <?php echo (isset($old['role']) && $old['role'] === 'vet') ? 'selected' : ''; ?>>Veterinarian (Requires Approval)</option>
                        <option value="nurse" <?php echo (isset($old['role']) && $old['role'] === 'nurse') ? 'selected' : ''; ?>>Nurse (Requires Approval)</option>
                    </select>
                </div>
                <?php if (!empty($errors['role'])): ?>
                    <span class="field-error" role="alert">
                        <span aria-hidden="true">⚠</span>
                        <?php echo htmlspecialchars($errors['role']); ?>
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
                    <input type="password" id="password" name="password"
                           placeholder="Min. 8 characters"
                           class="<?php echo !empty($errors['password']) ? 'is-invalid' : ''; ?>"
                           aria-required="true" autocomplete="new-password">
                    <button type="button" class="toggle-pwd"
                            id="toggle-pwd-btn"
                            aria-label="Toggle password visibility"
                            data-target="password">👁</button>
                </div>
                <?php if (!empty($errors['password'])): ?>
                    <span class="field-error" role="alert">
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
                    <input type="password" id="confirm_password" name="confirm_password"
                           placeholder="Repeat your password"
                           class="<?php echo !empty($errors['confirm_password']) ? 'is-invalid' : ''; ?>"
                           aria-required="true" autocomplete="new-password">
                    <button type="button" class="toggle-pwd"
                            id="toggle-confirm-btn"
                            aria-label="Toggle confirm password visibility"
                            data-target="confirm_password">👁</button>
                </div>
                <?php if (!empty($errors['confirm_password'])): ?>
                    <span class="field-error" role="alert">
                        <span aria-hidden="true">⚠</span>
                        <?php echo htmlspecialchars($errors['confirm_password']); ?>
                    </span>
                <?php endif; ?>
            </div>

            <!-- Submit -->
            <button type="submit" id="signup-submit-btn" class="btn-primary">
                Create Account 🐾
            </button>

        </form>

        <!-- Login link -->
        <p class="divider-text">
            Already have an account?
            <a href="?url=user/login" id="login-link">Log in here</a>
        </p>

    </div><!-- /card-body -->
</main>

<script>
(function () {
    'use strict';

    /* Password visibility toggles */
    document.querySelectorAll('.toggle-pwd').forEach(function (btn) {
        btn.addEventListener('click', function () {
            var input    = document.getElementById(btn.getAttribute('data-target'));
            if (!input) return;
            var hidden   = input.type === 'password';
            input.type   = hidden ? 'text' : 'password';
            btn.textContent = hidden ? '🙈' : '👁';
        });
    });

    /* Password strength meter */
    var pwdInput     = document.getElementById('password');
    var strengthWrap = document.getElementById('strength-wrap');
    var fill         = document.getElementById('strength-fill');
    var lbl          = document.getElementById('strength-label');

    var levels = [
        { label: 'Very Weak',   color: '#f87171', width: '15%'  },
        { label: 'Weak',        color: '#fb923c', width: '35%'  },
        { label: 'Fair',        color: '#facc15', width: '55%'  },
        { label: 'Strong',      color: '#34d399', width: '78%'  },
        { label: 'Very Strong', color: '#10b981', width: '100%' },
    ];

    function scorePassword(pw) {
        var s = 0;
        if (pw.length >= 8)             s++;
        if (pw.length >= 12)            s++;
        if (/[A-Z]/.test(pw))           s++;
        if (/[0-9]/.test(pw))           s++;
        if (/[^A-Za-z0-9]/.test(pw))   s++;
        return Math.min(s, 4);
    }

    if (pwdInput) {
        pwdInput.addEventListener('input', function () {
            var pw = pwdInput.value;
            if (!pw.length) { strengthWrap.style.display = 'none'; return; }
            strengthWrap.style.display = 'block';
            var lvl = levels[scorePassword(pw)];
            fill.style.width      = lvl.width;
            fill.style.background = lvl.color;
            lbl.textContent       = 'Strength: ' + lvl.label;
            lbl.style.color       = lvl.color;
        });
    }

    /* Client-side form validation */
    var form = document.getElementById('signup-form');
    if (form) {
        form.addEventListener('submit', function (e) {
            var valid = true;

            function markInvalid(id, msg) {
                var el = document.getElementById(id);
                if (!el) return;
                el.classList.add('is-invalid');
                var next = el.parentElement.nextElementSibling;
                if (!next || !next.classList.contains('field-error')) {
                    var span = document.createElement('span');
                    span.className = 'field-error';
                    span.setAttribute('role', 'alert');
                    span.innerHTML = '<span aria-hidden="true">⚠</span> ' + msg;
                    el.parentElement.insertAdjacentElement('afterend', span);
                }
                valid = false;
            }

            document.querySelectorAll('input').forEach(function (i) { i.classList.remove('is-invalid'); });

            var fn = document.getElementById('first_name');
            if (fn && !fn.value.trim()) markInvalid('first_name', 'First name is required.');

            var ln = document.getElementById('last_name');
            if (ln && !ln.value.trim()) markInvalid('last_name', 'Last name is required.');

            var em = document.getElementById('email');
            if (em) {
                if (!em.value.trim())                                      markInvalid('email', 'Email is required.');
                else if (!/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(em.value))    markInvalid('email', 'Enter a valid email.');
            }

            var pw  = document.getElementById('password');
            var cpw = document.getElementById('confirm_password');
            if (pw && pw.value.length < 8)           markInvalid('password', 'Password must be at least 8 characters.');
            if (pw && cpw && pw.value !== cpw.value) markInvalid('confirm_password', 'Passwords do not match.');

            if (!valid) e.preventDefault();
        });
    }
})();
</script>

<?php require_once __DIR__ . '/../../views/layouts/footer.php'; ?>
