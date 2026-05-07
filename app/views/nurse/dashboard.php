<?php
$pageTitle = 'Nurse Dashboard — Pet Clinic';
$bodyClass = 'dashboard-layout';
require_once __DIR__ . '/../../views/layouts/header.php';
?>

<div class="dashboard-wrapper">
    <?php require_once __DIR__ . '/../../views/layouts/nurse_sidebar.php'; ?>
    <main class="main-content">
        <div class="card card--xl">
            <div class="card-header">
                <span class="paw-icon" aria-hidden="true">🏥</span>
                <h1>Nurse Dashboard</h1>
                <p>Welcome back, <strong><?php echo htmlspecialchars($name); ?></strong>! Daily operations overview.</p>
            </div>
            
            <div class="card-body">
                <div class="form-row">
                    <!-- Today Total -->
                    <div class="card" style="background: var(--pink-50); border: 2px solid var(--pink-100);">
                        <div class="card-body text-center">
                            <span class="icon-lg">📅</span>
                            <h3 class="text-gray-800">Today's Visits</h3>
                            <p class="hero-title" style="margin: 10px 0; font-size: 2.5rem; color: var(--pink-500);">
                                <?php echo $stats['total_today']; ?>
                            </p>
                        </div>
                    </div>

                    <!-- Pending -->
                    <div class="card" style="background: #fffbeb; border: 2px solid #fef3c7;">
                        <div class="card-body text-center">
                            <span class="icon-lg">⏳</span>
                            <h3 class="text-gray-800">Awaiting Check-in</h3>
                            <p class="hero-title" style="margin: 10px 0; font-size: 2.5rem; color: #d97706;">
                                <?php echo $stats['pending']; ?>
                            </p>
                        </div>
                    </div>

                    <!-- Ready -->
                    <div class="card" style="background: #f0fdf4; border: 2px solid #dcfce7;">
                        <div class="card-body text-center">
                            <span class="icon-lg">✅</span>
                            <h3 class="text-gray-800">Ready for Vet</h3>
                            <p class="hero-title" style="margin: 10px 0; font-size: 2.5rem; color: #16a34a;">
                                <?php echo $stats['ready']; ?>
                            </p>
                        </div>
                    </div>
                </div>

                <div class="divider-line"></div>

                <div class="mt-30">
                    <h2 class="text-gray-800 mb-20">📋 Recent Activity (Today)</h2>
                    <?php if (empty($recent)): ?>
                        <div class="empty-state">
                            <p>No appointments recorded for today yet.</p>
                        </div>
                    <?php else: ?>
                        <div class="table-responsive">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>Pet</th>
                                        <th>Time</th>
                                        <th>Status</th>
                                        <th class="text-right">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($recent as $appt): ?>
                                        <tr>
                                            <td>
                                                <strong class="text-pink-bold"><?php echo htmlspecialchars($appt['pet_name_display']); ?></strong><br>
                                                <small class="text-gray-500">Owner: <?php echo htmlspecialchars($appt['owner_name']); ?></small>
                                            </td>
                                            <td><?php echo date('h:i A', strtotime($appt['appointment_date'])); ?></td>
                                            <td>
                                                <?php if ($appt['status'] === 'checked-in'): ?>
                                                    <span class="badge badge-nurse">Checked-in</span>
                                                <?php elseif ($appt['status'] === 'ready'): ?>
                                                    <span class="badge badge-vet">Ready</span>
                                                <?php else: ?>
                                                    <span class="text-gray-600"><?php echo ucfirst($appt['status']); ?></span>
                                                <?php endif; ?>
                                            </td>
                                            <td class="text-right">
                                                <?php if ($appt['status'] === 'pending'): ?>
                                                    <a href="?url=nurse/checkIn/<?php echo $appt['id']; ?>" class="btn-pill btn-sm">Check-in</a>
                                                <?php elseif ($appt['status'] === 'checked-in'): ?>
                                                    <a href="?url=nurse/markReady/<?php echo $appt['id']; ?>" class="btn-pill btn-sm btn-approve">Mark Ready</a>
                                                <?php endif; ?>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                        <div class="text-center mt-10">
                            <a href="?url=nurse/appointments" class="link-back">View Full Patient Queue →</a>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </main>
</div>

<?php require_once __DIR__ . '/../../views/layouts/footer.php'; ?>
