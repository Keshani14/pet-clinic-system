<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Pet Clinic — caring for your furry family with love and expertise.">
    <title>Welcome — Pet Clinic</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700;800;900&display=swap" rel="stylesheet">
    <style>
        :root {
            --pink-50 : #fff0f5;
            --pink-100: #ffe0ec;
            --pink-400: #f472a8;
            --pink-500: #e8438f;
            --white   : #ffffff;
            --gray-600: #555555;
            --gray-800: #222222;
        }

        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

        body {
            font-family: 'Nunito', sans-serif;
            min-height: 100vh;
            background: linear-gradient(135deg, #fff0f5 0%, #ffe8f0 40%, #ffd6e7 100%);
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            padding: 40px 16px;
            text-align: center;
        }

        .hero-icon {
            font-size: 4rem;
            margin-bottom: 18px;
            animation: bounce .8s cubic-bezier(.36,.07,.19,.97) both;
        }

        @keyframes bounce {
            0%,100% { transform: translateY(0);   }
            40%      { transform: translateY(-18px); }
            60%      { transform: translateY(-10px); }
        }

        h1 {
            font-size: 2.4rem;
            font-weight: 900;
            color: var(--gray-800);
            letter-spacing: -.5px;
            margin-bottom: 12px;
        }

        h1 span { color: var(--pink-500); }

        p.subtitle {
            color: var(--gray-600);
            font-size: 1.05rem;
            max-width: 400px;
            margin-bottom: 36px;
            line-height: 1.65;
        }

        .cta-wrap { display: flex; gap: 16px; flex-wrap: wrap; justify-content: center; }

        .btn {
            padding: 13px 32px;
            border-radius: 12px;
            font-family: 'Nunito', sans-serif;
            font-size: 1rem;
            font-weight: 800;
            text-decoration: none;
            transition: transform .22s ease, box-shadow .22s ease;
            cursor: pointer;
            border: none;
        }

        .btn-primary {
            background: linear-gradient(135deg, var(--pink-500), var(--pink-400));
            color: var(--white);
            box-shadow: 0 4px 18px rgba(232,67,143,.35);
        }

        .btn-secondary {
            background: var(--white);
            color: var(--pink-500);
            border: 2px solid var(--pink-100);
        }

        .btn:hover { transform: translateY(-3px); box-shadow: 0 8px 24px rgba(232,67,143,.3); }
    </style>
</head>
<body>
    <div class="hero-icon" aria-hidden="true">🐾</div>
    <h1>Welcome to <span>Pet Clinic</span></h1>
    <p class="subtitle">
        Caring for your furry family with love, expertise, and a warm smile — every single day.
    </p>
    <div class="cta-wrap">
        <a href="?url=user/signup" class="btn btn-primary" id="signup-cta-btn">Create Account</a>
        <a href="?url=user/login"  class="btn btn-secondary" id="login-cta-btn">Log In</a>
    </div>
</body>
</html>