<?php
$pageTitle = 'Owner Dashboard — Pet Clinic';
$bodyClass = 'dashboard-layout';
require_once __DIR__ . '/../../views/layouts/header.php';
?>

<div class="dashboard-wrapper">
    <?php require_once __DIR__ . '/../../views/layouts/owner_sidebar.php'; ?>
    <main class="main-content">
        <div class="card card--xl">
            <div class="card-header">
                <span class="paw-icon" aria-hidden="true">🐶</span>
                <h1>Owner Dashboard</h1>
                <p>Welcome back, <strong><?php echo htmlspecialchars($name ?? 'Owner'); ?></strong>!</p>
            </div>
            
            <div class="card-body">
                <div class="form-row">
                    <!-- My Pets Card -->
                    <div class="card stat-card--pets">
                        <div class="card-body text-center">
                            <span class="icon-lg">🐾</span>
                            <h3 class="text-gray-800">My Pets</h3>
                            <p class="text-gray-600 mb-20">Manage your registered furry friends.</p>
                            <a href="?url=pet/listPets" class="btn-pill btn-sm btn-approve">Manage Pets</a>
                        </div>
                    </div>

                    <!-- Appointments Card -->
                    <div class="card" style="background: var(--pink-50); border: 2px solid var(--pink-100);">
                        <div class="card-body text-center">
                            <span class="icon-lg">🗓️</span>
                            <h3 class="text-gray-800">Appointments</h3>
                            <p class="text-gray-600 mb-20">Book or view your clinic visits.</p>
                            <a href="?url=appointment/create" class="btn-pill btn-sm">Book New +</a>
                        </div>
                    </div>
                </div>

                <div class="divider-line"></div>

                <div class="mt-30">
                    <h2 class="text-gray-800 mb-20">🗓️ Upcoming Appointments</h2>
                    
                    <?php if (empty($appointments)): ?>
                        <div class="empty-state" style="background: var(--gray-100); border-radius: var(--radius);">
                            <p>You have no appointments scheduled yet. <a href="?url=appointment/create">Schedule your first visit!</a></p>
                        </div>
                    <?php else: ?>
                        <div class="table-responsive">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>Pet</th>
                                        <th>Date & Time</th>
                                        <th>Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($appointments as $appt): ?>
                                        <tr>
                                            <td class="text-pink-bold"><?php echo htmlspecialchars($appt['pet_name']); ?></td>
                                            <td>
                                                <strong><?php echo date('M d', strtotime($appt['appointment_date'])); ?></strong> 
                                                <small class="text-gray-500"><?php echo date('h:i A', strtotime($appt['appointment_date'])); ?></small>
                                            </td>
                                            <td>
                                                <?php if ($appt['status'] === 'approved'): ?>
                                                    <span class="text-green-bold">Approved</span>
                                                <?php elseif ($appt['status'] === 'pending'): ?>
                                                    <span class="text-gray-600">Pending</span>
                                                <?php else: ?>
                                                    <span class="text-danger-bold"><?php echo ucfirst($appt['status']); ?></span>
                                                <?php endif; ?>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                        <div class="text-center mt-10">
                            <a href="?url=appointment/myAppointments" class="link-back" style="font-size: 0.9rem;">View All Appointments →</a>
                        </div>
                    <?php endif; ?>
                </div>

                <div class="divider-line"></div>
                
                <div class="text-center my-20">
                    <p class="text-gray-600">Need help? Contact our clinic at +94 11 234 5678.</p>
                </div>
            </div>
        </div>
    </main>
</div>

<?php require_once __DIR__ . '/../../views/layouts/footer.php'; ?>
