<?php
$pageTitle = 'Clinic Schedule — Pet Clinic';
$bodyClass = 'dashboard-layout';
require_once __DIR__ . '/../../views/layouts/header.php';
?>

<div class="dashboard-wrapper">
    <?php require_once __DIR__ . '/../../views/layouts/vet_sidebar.php'; ?>
    <main class="main-content">
        <div class="card card--xl">
            <div class="card-header">
                <span class="paw-icon" aria-hidden="true">🗓️</span>
                <h1>Clinic Schedule</h1>
                <p>View all appointments and patient statuses across the clinic.</p>
            </div>
            
            <div class="card-body">
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
                                            <?php if ($appt['status'] === 'pending'): ?>
                                                <span class="text-gray-500">⏳ Pending</span>
                                            <?php elseif ($appt['status'] === 'confirmed'): ?>
                                                <span class="text-blue-bold">🗓️ Confirmed</span>
                                            <?php elseif ($appt['status'] === 'checked-in'): ?>
                                                <span class="badge badge-nurse">📍 Checked-in</span>
                                            <?php elseif ($appt['status'] === 'ready'): ?>
                                                <span class="badge badge-vet">🚀 Ready for Vet</span>
                                            <?php elseif ($appt['status'] === 'in-consultation'): ?>
                                                <span class="text-pink-bold">🩺 In Consultation</span>
                                            <?php elseif ($appt['status'] === 'completed'): ?>
                                                <span class="text-green-bold">✅ Completed</span>
                                            <?php else: ?>
                                                <span class="text-gray-600"><?php echo ucfirst($appt['status']); ?></span>
                                            <?php endif; ?>
                                        </td>
                                        <td class="text-right">
                                            <div style="display: flex; gap: 8px; justify-content: flex-end;">
                                                <?php if ($appt['status'] === 'ready'): ?>
                                                    <a href="?url=vet/consult/<?php echo $appt['id']; ?>" class="btn-pill btn-sm btn-approve">Consult</a>
                                                <?php endif; ?>
                                                
                                                <?php if (!empty($appt['pet_id'])): ?>
                                                    <a href="?url=medical/viewHistory&pet_id=<?php echo $appt['pet_id']; ?>" class="btn-pill btn-sm btn-dark">History</a>
                                                <?php endif; ?>
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
                    <a href="?url=vet/dashboard" class="link-back">← Back to Dashboard</a>
                </div>
            </div>
        </div>
    </main>
</div>

<?php require_once __DIR__ . '/../../views/layouts/footer.php'; ?>
