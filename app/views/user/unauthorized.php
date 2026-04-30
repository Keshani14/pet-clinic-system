<?php
$pageTitle = 'Unauthorized — Pet Clinic';
require_once __DIR__ . '/../../views/layouts/header.php';
?>

<main class="card text-center" role="main">
    <div class="card-body">
        <span class="icon-lg">🚫</span>
        <h1 class="text-gray-800 mb-10">Access Denied</h1>
        <p class="text-gray-600 mb-30">
            You do not have permission to view this page.
        </p>
        <a href="?url=home/index" class="btn-primary btn-auto">Return Home</a>
    </div>
</main>

<?php require_once __DIR__ . '/../../views/layouts/footer.php'; ?>
