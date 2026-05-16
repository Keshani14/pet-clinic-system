<?php
$pageTitle = 'Access Restricted — Furry Friends';
require_once __DIR__ . '/../../views/layouts/header.php';
?>

<div style="background: linear-gradient(135deg, #fff1f2 0%, #f1f5f9 100%); min-height: 100vh; display: flex; align-items: center; justify-content: center; padding: 40px;">
    <div class="card" style="max-width: 550px; width: 100%; text-align: center; background: rgba(255, 255, 255, 0.7); backdrop-filter: blur(25px); border: 1px solid rgba(255, 255, 255, 0.8); border-radius: 40px; padding: 60px 40px; box-shadow: 0 25px 50px rgba(219, 39, 119, 0.08);">
        
        <!-- 🛡️ Clinical Security Icon -->
        <div style="width: 120px; height: 120px; background: #fff1f2; border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto 35px; font-size: 3.5rem; border: 4px solid white; box-shadow: 0 15px 30px rgba(219, 39, 119, 0.1);">
            🚫
        </div>

        <h1 style="font-size: 2.2rem; font-weight: 900; color: #1e293b; letter-spacing: -1.5px; margin-bottom: 15px;">Access Restricted</h1>
        
        <div style="height: 4px; width: 60px; background: #db2777; border-radius: 2px; margin: 0 auto 25px;"></div>

        <p style="font-size: 1.1rem; color: #64748b; font-weight: 600; line-height: 1.6; margin-bottom: 40px;">
            The clinical protocols for this section are restricted to specific staff roles. Please return to your designated command center or contact administration if you believe this is an error.
        </p>

        <div style="display: flex; gap: 15px; justify-content: center;">
            <a href="?url=home/index" class="btn-pill" style="background: white; color: #64748b; border: 1.5px solid #e2e8f0; padding: 14px 30px; font-weight: 800; text-decoration: none;">Return Home</a>
            
            <?php if (Auth::isLoggedIn()): ?>
                <a href="<?php echo Auth::dashboardUrl(); ?>" class="btn-pill" style="background: #db2777; color: white; border: none; padding: 14px 30px; font-weight: 900; box-shadow: 0 10px 20px rgba(219, 39, 119, 0.2); text-decoration: none;">Go to Dashboard</a>
            <?php else: ?>
                <a href="?url=user/login" class="btn-pill" style="background: #db2777; color: white; border: none; padding: 14px 30px; font-weight: 900; box-shadow: 0 10px 20px rgba(219, 39, 119, 0.2); text-decoration: none;">Please Log In</a>
            <?php endif; ?>
        </div>

        <div style="margin-top: 50px; padding-top: 30px; border-top: 1px solid rgba(0,0,0,0.03); display: flex; align-items: center; justify-content: center; gap: 10px; color: #94a3b8; font-weight: 700; font-size: 0.85rem;">
            <span>🛡️</span> Security Protocols Active
        </div>
    </div>
</div>

<?php require_once __DIR__ . '/../../views/layouts/footer.php'; ?>
