<?php
$pageTitle = 'My Appointments — Pet Clinic';
$bodyClass = 'dashboard-layout';
require_once __DIR__ . '/../../views/layouts/header.php';
?>

<div class="dashboard-wrapper">
    <?php 
    if (file_exists(__DIR__ . '/../../views/layouts/owner_sidebar.php')) {
        require_once __DIR__ . '/../../views/layouts/owner_sidebar.php';
    }
    ?>
    <main class="main-content">
        <div class="card card--xl">
            <div class="card-header">
                <span class="paw-icon" aria-hidden="true">🗓️</span>
                <h1>My Appointments</h1>
                <p>Track your scheduled visits and their status.</p>
            </div>
            
            <div class="card-body">
                <?php if (isset($_SESSION['flash_success'])): ?>
                    <div class="alert alert-success">
                        <?php echo $_SESSION['flash_success']; unset($_SESSION['flash_success']); ?>
                    </div>
                <?php endif; ?>

                <div class="mb-20 text-right">
                    <a href="?url=appointment/create" class="btn-pill">Book New Appointment +</a>
                </div>

                <?php if (empty($appointments)): ?>
                    <div class="empty-state">
                        <span class="icon-lg">📅</span>
                        <p>You have no appointments scheduled. <a href="?url=appointment/create">Book one today!</a></p>
                    </div>
                <?php else: ?>
                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>Animal Type</th>
                                    <th>Date & Time</th>
                                    <th>Reason</th>
                                    <th>Status</th>
                                    <th class="text-right">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($appointments as $appt): ?>
                                    <tr>
                                        <td class="text-pink-bold"><?php echo htmlspecialchars($appt['pet_name_display']); ?></td>
                                        <td>
                                            <strong><?php echo date('M d, Y', strtotime($appt['appointment_date'])); ?></strong><br>
                                            <small class="text-gray-500"><?php echo date('h:i A', strtotime($appt['appointment_date'])); ?></small>
                                        </td>
                                        <td>
                                            <div class="text-gray-600" style="max-width: 300px; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;" title="<?php echo htmlspecialchars($appt['reason']); ?>">
                                                <?php echo htmlspecialchars($appt['reason']); ?>
                                            </div>
                                        </td>
                                        <td>
                                            <?php if ($appt['status'] === 'approved'): ?>
                                                <span class="text-green-bold">✅ Approved</span>
                                            <?php elseif ($appt['status'] === 'cancelled'): ?>
                                                <span class="text-danger-bold">❌ Cancelled</span>
                                            <?php elseif ($appt['status'] === 'completed'): ?>
                                                <span class="badge badge-vet">🏁 Completed</span>
                                            <?php else: ?>
                                                <span class="text-gray-600">⏳ Pending</span>
                                            <?php endif; ?>
                                        </td>
                                        <td class="text-right">
                                            <!-- Optional: Add cancel action if pending -->
                                            <?php if ($appt['status'] === 'pending'): ?>
                                                <button class="btn-pill btn-sm btn-danger" style="padding: 6px 12px;" disabled>Cancel</button>
                                            <?php endif; ?>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                <?php endif; ?>

                <div class="divider-line"></div>
                <div class="text-center">
                    <a href="?url=owner/dashboard" class="link-back">← Back to Dashboard</a>
                </div>
            </div>
        </div>
    </main>
</div>

<?php require_once __DIR__ . '/../../views/layouts/footer.php'; ?>
