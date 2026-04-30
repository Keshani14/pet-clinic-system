<?php
$pageTitle = 'Unauthorized — Pet Clinic';
require_once __DIR__ . '/../../views/layouts/header.php';
?>

<main class="card" role="main" style="text-align: center;">
    <div class="card-body">
        <span style="font-size: 4rem; display: block; margin-bottom: 20px;">🚫</span>
        <h1 style="color: var(--gray-800); margin-bottom: 10px;">Access Denied</h1>
        <p style="color: var(--gray-600); margin-bottom: 30px;">
            You do not have permission to view this page.
        </p>
        <a href="?url=home/index" class="btn-primary" style="display: inline-block; width: auto; padding: 12px 30px;">Return Home</a>
    </div>
</main>

<?php require_once __DIR__ . '/../../views/layouts/footer.php'; ?>
