<?php
$pageTitle = 'Admin Dashboard — Pet Clinic';
$bodyClass = 'dashboard-layout';
require_once __DIR__ . '/../../views/layouts/header.php';
?>

<div class="dashboard-wrapper">
    <?php require_once __DIR__ . '/../../views/layouts/admin_sidebar.php'; ?>
    <main class="main-content">
        <div class="card card--xl">
            <div class="card-header">
                <span class="paw-icon" aria-hidden="true">👑</span>
                <h1>Admin Dashboard</h1>
                <p>Welcome back, <strong><?php echo Auth::name(); ?></strong>! Management overview.</p>
            </div>
            
            <div class="card-body">
                <div class="form-row">
                    <!-- Pending Requests Card -->
                    <div class="card stat-card--pending">
                        <div class="card-body text-center">
                            <span class="icon-lg">⏳</span>
                            <h3 class="text-gray-800">Join Requests</h3>
                            <p class="hero-title" style="margin: 10px 0; font-size: 2.5rem;">
                                <?php echo $stats['pending_count']; ?>
                            </p>
                            <a href="?url=admin/requests" class="btn-pill btn-sm">View Requests</a>
                        </div>
                    </div>

                    <!-- Total Pets Card -->
                    <div class="card stat-card--pets">
                        <div class="card-body text-center">
                            <span class="icon-lg">🐾</span>
                            <h3 class="text-gray-800">Registered Pets</h3>
                            <p class="hero-title" style="margin: 10px 0; font-size: 2.5rem; color: #16a34a;">
                                <?php echo $stats['total_pets']; ?>
                            </p>
                            <a href="?url=pet/listPets" class="btn-pill btn-sm btn-approve">Manage Pets</a>
                        </div>
                    </div>
                </div>

                <div class="divider-line"></div>
                
                <div class="text-center my-20">
                    <p class="text-gray-600">Quick Access: Manage clinic records and user access from the sidebar.</p>
                </div>
            </div>
        </div>
    </main>
</div>

<?php require_once __DIR__ . '/../../views/layouts/footer.php'; ?>
