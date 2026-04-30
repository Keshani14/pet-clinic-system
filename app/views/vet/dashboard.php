<?php
$pageTitle = 'Vet Dashboard — Pet Clinic';
require_once __DIR__ . '/../../views/layouts/header.php';
?>

<div class="card" style="max-width: 800px; width: 100%;">
    <div class="card-header" style="background: linear-gradient(135deg, #0ea5e9, #38bdf8);">
        <span class="paw-icon" aria-hidden="true">🩺</span>
        <h1>Vet Dashboard</h1>
        <p>Welcome back, Dr. <?php echo htmlspecialchars($name ?? 'Vet'); ?>!</p>
    </div>
    <div class="card-body" style="text-align: center;">
        <p>View upcoming appointments and patient medical histories.</p>
        <div class="divider-line"></div>
        <a href="?url=user/logout" class="btn-secondary">Log Out</a>
    </div>
</div>

<?php require_once __DIR__ . '/../../views/layouts/footer.php'; ?>
