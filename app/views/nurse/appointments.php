<?php
$pageTitle = 'Patient Queue — Pet Clinic';
$bodyClass = 'dashboard-layout';
require_once __DIR__ . '/../../views/layouts/header.php';
?>

<div class="dashboard-wrapper">
    <?php require_once __DIR__ . '/../../views/layouts/nurse_sidebar.php'; ?>
    <main class="main-content">
        <div class="card card--xl">
            <div class="card-header">
                <span class="paw-icon" aria-hidden="true">📋</span>
                <h1>Patient Queue</h1>
                <p>Manage all scheduled appointments and patient check-ins.</p>
            </div>
            
            <div class="card-body">
                <?php if (isset($_SESSION['flash_success'])): ?>
                    <div class="alert alert-success">
                        <?php echo $_SESSION['flash_success']; unset($_SESSION['flash_success']); ?>
                    </div>
                <?php endif; ?>

                <?php if (empty($appointments)): ?>
                    <div class="empty-state">
                        <span class="icon-lg">📅</span>
                        <p>No appointments found in the system.</p>
                    </div>
                <?php else: ?>
                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>Pet & Owner</th>
                                    <th>Date & Time</th>
                                    <th>Status</th>
                                    <th class="text-right">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($appointments as $appt): ?>
                                    <tr>
                                        <td>
                                            <strong class="text-pink-bold" style="font-size: 1.1rem;"><?php echo htmlspecialchars($appt['pet_name_display']); ?></strong><br>
                                            <span class="text-gray-600">Owner: <?php echo htmlspecialchars($appt['owner_name']); ?></span>
                                        </td>
                                        <td>
                                            <strong><?php echo date('M d, Y', strtotime($appt['appointment_date'])); ?></strong><br>
                                            <small class="text-gray-500"><?php echo date('h:i A', strtotime($appt['appointment_date'])); ?></small>
                                        </td>
                                        <td>
                                            <?php if ($appt['status'] === 'checked-in'): ?>
                                                <span class="badge badge-nurse">Checked-in</span>
                                            <?php elseif ($appt['status'] === 'ready'): ?>
                                                <span class="badge badge-vet">Ready</span>
                                            <?php elseif ($appt['status'] === 'completed'): ?>
                                                <span class="text-green-bold">✅ Completed</span>
                                            <?php elseif ($appt['status'] === 'cancelled'): ?>
                                                <span class="text-danger-bold">❌ Cancelled</span>
                                            <?php else: ?>
                                                <span class="text-gray-600"><?php echo ucfirst($appt['status']); ?></span>
                                            <?php endif; ?>
                                        </td>
                                        <td class="text-right">
                                            <div style="display: flex; gap: 5px; justify-content: flex-end;">
                                                <?php if ($appt['status'] === 'pending'): ?>
                                                    <a href="?url=nurse/checkIn/<?php echo $appt['id']; ?>" class="btn-pill btn-sm">Check-in</a>
                                                <?php endif; ?>
                                                
                                                <?php if ($appt['status'] === 'checked-in'): ?>
                                                    <a href="?url=nurse/markReady/<?php echo $appt['id']; ?>" class="btn-pill btn-sm btn-approve">Mark Ready</a>
                                                <?php endif; ?>
                                                
                                                <a href="?url=pet/profile/<?php echo $appt['pet_id']; ?>" class="btn-secondary btn-sm" style="padding: 6px 12px;">Profile</a>
                                            </div>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                <?php endif; ?>

                <div class="divider-line"></div>
                <div class="text-center">
                    <a href="?url=nurse/dashboard" class="link-back">← Back to Dashboard</a>
                </div>
            </div>
        </div>
    </main>
</div>

<?php require_once __DIR__ . '/../../views/layouts/footer.php'; ?>
