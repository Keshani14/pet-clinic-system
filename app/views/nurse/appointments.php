<?php
$pageTitle = 'Patient Queue — Pet Clinic';
$bodyClass = 'dashboard-layout';
require_once __DIR__ . '/../../views/layouts/header.php';
?>

<div class="dashboard-wrapper">
    <?php require_once __DIR__ . '/../../views/layouts/nurse_sidebar.php'; ?>
    <main class="main-content">
        <div class="card card--xl">
            <div class="card-header" style="background: linear-gradient(135deg, var(--pink-600), var(--pink-500)); padding: 30px 40px;">
                <span class="paw-icon" aria-hidden="true">📋</span>
                <h1 style="color: white; margin-bottom: 5px;">Nurse Control Center</h1>
                <p style="color: rgba(255,255,255,0.8);">Manage patient intake and clinical workflow.</p>
            </div>
            
            <div class="card-body">
                <?php if (isset($_SESSION['flash_success'])): ?>
                    <div class="alert alert-success">
                        <?php echo $_SESSION['flash_success']; unset($_SESSION['flash_success']); ?>
                    </div>
                <?php endif; ?>

                <!-- Quick Stats -->
                <div class="summary-grid" style="grid-template-columns: repeat(5, 1fr); gap: 15px; margin-bottom: 30px;">
                    <div class="summary-card" style="border-top-color: #f59e0b; padding: 15px;">
                        <h3 style="font-size: 0.85rem;">Pending</h3>
                        <div class="value" style="font-size: 1.8rem;"><?php echo $stats['pending']; ?></div>
                    </div>
                    <div class="summary-card" style="border-top-color: #10b981; padding: 15px;">
                        <h3 style="font-size: 0.85rem;">Confirmed</h3>
                        <div class="value" style="font-size: 1.8rem;"><?php echo $stats['confirmed']; ?></div>
                    </div>
                    <div class="summary-card" style="border-top-color: #8b5cf6; padding: 15px;">
                        <h3 style="font-size: 0.85rem;">In Clinic</h3>
                        <div class="value" style="font-size: 1.8rem;"><?php echo $stats['checked_in']; ?></div>
                    </div>
                    <div class="summary-card" style="border-top-color: #3b82f6; padding: 15px;">
                        <h3 style="font-size: 0.85rem;">Ready</h3>
                        <div class="value" style="font-size: 1.8rem;"><?php echo $stats['ready']; ?></div>
                    </div>
                    <div class="summary-card" style="border-top-color: var(--pink-600); padding: 15px;">
                        <h3 style="font-size: 0.85rem;">Total Today</h3>
                        <div class="value" style="font-size: 1.8rem;"><?php echo $stats['total_today']; ?></div>
                    </div>
                </div>

                <!-- Search & Filters -->
                <div style="background: #f8fafc; padding: 20px; border-radius: 12px; margin-bottom: 25px; border: 1px solid #e2e8f0;">
                    <form action="" method="GET" style="display: flex; gap: 15px; align-items: flex-end; flex-wrap: wrap;">
                        <input type="hidden" name="url" value="nurse/dashboard">
                        
                        <div style="flex: 1; min-width: 200px;">
                            <label style="display: block; font-size: 0.8rem; font-weight: 700; color: var(--gray-500); margin-bottom: 5px;">Search Patient/Owner</label>
                            <input type="text" name="q" value="<?php echo htmlspecialchars($filters['q'] ?? ''); ?>" placeholder="Name..." style="width: 100%; padding: 10px; border-radius: 8px; border: 1px solid #cbd5e1;">
                        </div>

                        <div>
                            <label style="display: block; font-size: 0.8rem; font-weight: 700; color: var(--gray-500); margin-bottom: 5px;">Status</label>
                            <select name="status" style="padding: 10px; border-radius: 8px; border: 1px solid #cbd5e1; background: white;">
                                <option value="all">All Statuses</option>
                                <option value="pending" <?php echo ($filters['status'] === 'pending') ? 'selected' : ''; ?>>Pending</option>
                                <option value="confirmed" <?php echo ($filters['status'] === 'confirmed') ? 'selected' : ''; ?>>Confirmed</option>
                                <option value="checked-in" <?php echo ($filters['status'] === 'checked-in') ? 'selected' : ''; ?>>Checked-In</option>
                                <option value="ready" <?php echo ($filters['status'] === 'ready') ? 'selected' : ''; ?>>Ready</option>
                                <option value="completed" <?php echo ($filters['status'] === 'completed') ? 'selected' : ''; ?>>Completed</option>
                            </select>
                        </div>

                        <div>
                            <label style="display: block; font-size: 0.8rem; font-weight: 700; color: var(--gray-500); margin-bottom: 5px;">Date</label>
                            <input type="date" name="date" value="<?php echo htmlspecialchars($filters['date'] ?? date('Y-m-d')); ?>" style="padding: 9px; border-radius: 8px; border: 1px solid #cbd5e1;">
                        </div>

                        <button type="submit" class="btn-pill" style="background: var(--pink-500); color: white; border: none; padding: 10px 20px;">Apply Filters</button>
                        <a href="?url=nurse/dashboard" class="btn-pill" style="background: var(--gray-200); color: var(--gray-600); border: none; padding: 10px 20px;">Reset</a>
                    </form>
                </div>

                <?php if (empty($appointments)): ?>
                    <div class="empty-state">
                        <span class="icon-lg">🔍</span>
                        <p>No appointments found matching your criteria.</p>
                    </div>
                <?php else: ?>
                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>Pet & Owner</th>
                                    <th>Time</th>
                                    <th>Status</th>
                                    <th class="text-right">Workflow Action</th>
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
                                                <span class="badge" style="background: #fef3c7; color: #92400e;">Pending</span>
                                            <?php elseif ($appt['status'] === 'confirmed'): ?>
                                                <span class="badge" style="background: #dcfce7; color: #166534;">Confirmed</span>
                                            <?php elseif ($appt['status'] === 'checked-in'): ?>
                                                <span class="badge" style="background: #dbeafe; color: #1e40af;">Checked-In</span>
                                            <?php elseif ($appt['status'] === 'ready'): ?>
                                                <span class="badge" style="background: #f0fdf4; color: #15803d; border: 1px solid #bbf7d0;">Ready for Vet</span>
                                            <?php elseif ($appt['status'] === 'completed'): ?>
                                                <span class="badge" style="background: #f3f4f6; color: #374151;">Completed</span>
                                            <?php else: ?>
                                                <span class="badge"><?php echo ucfirst($appt['status']); ?></span>
                                            <?php endif; ?>
                                        </td>
                                        <td class="text-right">
                                            <div style="display: flex; gap: 8px; justify-content: flex-end;">
                                                <?php if ($appt['status'] === 'pending'): ?>
                                                    <a href="?url=nurse/confirm/<?php echo $appt['id']; ?>" class="btn-pill btn-sm btn-approve">Confirm Appointment</a>
                                                <?php elseif ($appt['status'] === 'confirmed'): ?>
                                                    <a href="?url=nurse/checkIn/<?php echo $appt['id']; ?>" class="btn-pill btn-sm" style="background: #8b5cf6; color: white;">Check-In Patient</a>
                                                <?php elseif ($appt['status'] === 'checked-in'): ?>
                                                    <a href="?url=nurse/prepare/<?php echo $appt['id']; ?>" class="btn-pill btn-sm btn-dark">Prepare for Vet</a>
                                                <?php endif; ?>
                                                
                                                <a href="?url=medical/viewHistory&pet_id=<?php echo $appt['pet_id']; ?>" class="btn-pill btn-sm" style="background: white; border: 1px solid #e2e8f0; color: #64748b;">History</a>
                                            </div>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </main>
</div>

<?php require_once __DIR__ . '/../../views/layouts/footer.php'; ?>
