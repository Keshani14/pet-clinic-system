<?php
$pageTitle = 'Nurse Dashboard — Pet Clinic';
require_once __DIR__ . '/../../views/layouts/header.php';
?>

<div class="card card--lg">
    <div class="card-header bg-green">
        <span class="paw-icon" aria-hidden="true">💉</span>
        <h1>Nurse Dashboard</h1>
        <p>Welcome back, <?php echo htmlspecialchars($name ?? 'Nurse'); ?>!</p>
    </div>
    <div class="card-body text-center">
        <p>Manage daily tasks, check-ins, and assist veterinarians.</p>
        <div class="my-20">
            <a href="?url=pet/listPets" class="btn-pill">View Patient Records</a>
        </div>
        <div class="divider-line"></div>
        <a href="?url=user/logout" class="btn-secondary">Log Out</a>
    </div>
</div>

<?php require_once __DIR__ . '/../../views/layouts/footer.php'; ?>
