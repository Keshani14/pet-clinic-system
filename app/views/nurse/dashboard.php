<?php
$pageTitle = 'Nurse Dashboard — Pet Clinic';
require_once __DIR__ . '/../../views/layouts/header.php';
?>

<div class="card" style="max-width: 800px; width: 100%;">
    <div class="card-header" style="background: linear-gradient(135deg, #10b981, #34d399);">
        <span class="paw-icon" aria-hidden="true">💉</span>
        <h1>Nurse Dashboard</h1>
        <p>Welcome back, <?php echo htmlspecialchars($name ?? 'Nurse'); ?>!</p>
    </div>
    <div class="card-body" style="text-align: center;">
        <p>Manage daily tasks, check-ins, and assist veterinarians.</p>
        <div class="divider-line"></div>
        <a href="?url=user/logout" class="btn-secondary">Log Out</a>
    </div>
</div>

<?php require_once __DIR__ . '/../../views/layouts/footer.php'; ?>
