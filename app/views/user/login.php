<?php
// ── Page meta ─────────────────────────────────────────────────
$pageTitle       = 'Log In — Pet Clinic';
$pageDescription = 'Log in to your Pet Clinic account to manage appointments and your pet\'s health records.';
require_once __DIR__ . '/../../views/layouts/header.php';
?>

<main class="card card--sm" role="main">

    <!-- ── Card Header ─────────────────────────────────────── -->
    <div class="card-header">
        <span class="paw-icon paw-icon--wave" aria-hidden="true">🐾</span>
        <h1>Welcome Back!</h1>
        <p>Log in to manage your pet's health &amp; appointments.</p>
    </div>

    <!-- ── Card Body ───────────────────────────────────────── -->
    <div class="card-body">

        <div class="paw-dots" aria-hidden="true">· 🐾 ·</div>

        <!-- Flash success (set by signup redirect) -->
        <?php if (!empty($_SESSION['flash_success'])): ?>
            <div class="alert alert-success" role="status">
                <span aria-hidden="true">✅</span>
                <?php
                    echo htmlspecialchars($_SESSION['flash_success']);
                    unset($_SESSION['flash_success']);
                ?>
            </div>
        <?php endif; ?>

        <!-- Error banner -->
        <?php if (!empty($error)): ?>
            <div class="alert alert-danger" role="alert" id="login-error-alert">
                <span aria-hidden="true">⚠️</span>
                <?php echo htmlspecialchars($error); ?>
            </div>
        <?php endif; ?>

        <!-- ── Login Form ───────────────────────────────────── -->
        <form id="login-form" method="POST"
              action="?url=user/login"
              novalidate
              aria-label="Login form">

            <!-- Email -->
            <div class="form-group">
                <label for="email">Email Address</label>
                <div class="input-wrap">
                    <span class="icon" aria-hidden="true">✉️</span>
                    <input type="email" id="email" name="email"
                           placeholder="jane@example.com"
                           value="<?php echo $oldEmail ?? ''; ?>"
                           class="<?php echo !empty($error) ? 'is-invalid' : ''; ?>"
                           aria-required="true"
                           autocomplete="email"
                           autofocus>
                </div>
            </div>

            <!-- Password -->
            <div class="form-group">
                <label for="password">Password</label>
                <div class="input-wrap">
                    <span class="icon" aria-hidden="true">🔒</span>
                    <input type="password" id="password" name="password"
                           placeholder="Enter your password"
                           class="<?php echo !empty($error) ? 'is-invalid' : ''; ?>"
                           aria-required="true"
                           autocomplete="current-password">
                    <button type="button" class="toggle-pwd"
                            id="toggle-pwd-btn"
                            aria-label="Toggle password visibility"
                            data-target="password">👁</button>
                </div>
            </div>

            <!-- Remember me + Forgot password -->
            <div class="form-meta">
                <label class="remember-label" for="remember">
                    <input type="checkbox" id="remember" name="remember">
                    Remember me
                </label>
                <a href="#" class="forgot-link" id="forgot-link">Forgot password?</a>
            </div>

            <!-- Submit -->
            <button type="submit" id="login-submit-btn" class="btn-primary">
                Log In 🐾
            </button>

        </form>

        <!-- Divider -->
        <div class="divider-line" aria-hidden="true">or</div>

        <!-- Sign-up prompt -->
        <p class="auth-prompt">
            Don't have an account?
            <a href="?url=user/signup" id="goto-signup-link">Create one for free</a>
        </p>

    </div><!-- /card-body -->
</main>

<script>
(function () {
    'use strict';

    /* Password toggle */
    var toggleBtn = document.getElementById('toggle-pwd-btn');
    var pwdInput  = document.getElementById('password');
    if (toggleBtn && pwdInput) {
        toggleBtn.addEventListener('click', function () {
            var hidden     = pwdInput.type === 'password';
            pwdInput.type  = hidden ? 'text' : 'password';
            toggleBtn.textContent = hidden ? '🙈' : '👁';
        });
    }

    /* Client-side validation */
    var form = document.getElementById('login-form');
    if (form) {
        form.addEventListener('submit', function (e) {
            var emailVal = document.getElementById('email').value.trim();
            var pwdVal   = document.getElementById('password').value;
            var valid    = true;

            document.querySelectorAll('input').forEach(function (i) { i.classList.remove('is-invalid'); });

            if (!emailVal || !/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(emailVal)) {
                document.getElementById('email').classList.add('is-invalid');
                valid = false;
            }
            if (!pwdVal) {
                document.getElementById('password').classList.add('is-invalid');
                valid = false;
            }

            if (!valid) {
                e.preventDefault();
                var btn = document.getElementById('login-submit-btn');
                btn.style.animation = 'none';
                btn.offsetHeight;
                btn.style.animation = 'shake .35s ease';
            }
        });
    }

    /* Forgot password placeholder */
    var forgot = document.getElementById('forgot-link');
    if (forgot) {
        forgot.addEventListener('click', function (e) {
            e.preventDefault();
            alert('Password reset will be available soon. Please contact the clinic directly.');
        });
    }
})();
</script>

<?php require_once __DIR__ . '/../../views/layouts/footer.php'; ?>
