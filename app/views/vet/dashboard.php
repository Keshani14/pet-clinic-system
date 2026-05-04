<?php
$pageTitle = 'Vet Dashboard — Pet Clinic';
$bodyClass = 'dashboard-layout';
require_once __DIR__ . '/../../views/layouts/header.php';
?>

<div class="dashboard-wrapper">
    <?php require_once __DIR__ . '/../../views/layouts/vet_sidebar.php'; ?>

    <main class="main-content">
        <h1 class="text-gray-800 mb-10">Welcome back, Dr. <?php echo htmlspecialchars($name ?? 'Vet'); ?>!</h1>
        <p class="text-gray-600 mb-30">Your clinical queue for today.</p>

        <div class="summary-grid" style="margin-bottom: 40px;">
            <div class="summary-card">
                <h3>Patients Waiting</h3>
                <div class="value" style="color: var(--pink-500);"><?php echo $stats['waiting']; ?></div>
            </div>
            <div class="summary-card">
                <h3>Completed Today</h3>
                <div class="value" style="color: #10b981;"><?php echo $stats['completed_today']; ?></div>
            </div>
            <div class="summary-card">
                <h3>System Status</h3>
                <div class="value" style="font-size: 1.2rem; color: var(--gray-600);">Online 🟢</div>
            </div>
        </div>

        <h2 class="text-gray-800 mb-20" style="font-size: 1.4rem; display: flex; align-items: center; gap: 10px;">
            <span>👨‍⚕️ Ready for Consultation</span>
            <?php if ($stats['waiting'] > 0): ?>
                <span class="badge badge-vet" style="font-size: 0.8rem; padding: 4px 10px;"><?php echo $stats['waiting']; ?> waiting</span>
            <?php endif; ?>
        </h2>

        <div class="card card--xl" style="margin-left: 0; width: 100%; max-width: 100%;">
            <div class="card-body" style="padding: 0;">
                <?php if (empty($waiting_list)): ?>
                    <div class="empty-state" style="padding: 60px;">
                        <span class="icon-lg">☕</span>
                        <p>No patients are currently marked as ready. <br><small class="text-gray-500">New cases will appear here once the nurse completes the intake.</small></p>
                    </div>
                <?php else: ?>
                    <table class="table" style="margin: 0;">
                        <thead>
                            <tr>
                                <th>Pet & Owner</th>
                                <th>Vitals</th>
                                <th>Nurse Notes</th>
                                <th class="text-right">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($waiting_list as $appt): ?>
                                <tr>
                                    <td>
                                        <strong class="text-pink-bold" style="font-size: 1.1rem;"><?php echo htmlspecialchars($appt['pet_name_display']); ?></strong><br>
                                        <span class="text-gray-600">Owner: <?php echo htmlspecialchars($appt['owner_name']); ?></span>
                                    </td>
                                    <td>
                                        <div style="display: flex; gap: 15px;">
                                            <span title="Weight">⚖️ <strong><?php echo htmlspecialchars($appt['weight'] ?? '-'); ?></strong> kg</span>
                                            <span title="Temperature">🌡️ <strong><?php echo htmlspecialchars($appt['temperature'] ?? '-'); ?></strong> °C</span>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="text-gray-600" style="max-width: 250px; font-style: italic; font-size: 0.9rem;">
                                            "<?php echo htmlspecialchars($appt['vitals_notes'] ?? 'No notes'); ?>"
                                        </div>
                                    </td>
                                    <td class="text-right">
                                        <a href="?url=vet/consult/<?php echo $appt['id']; ?>" class="btn-pill btn-approve">Start Consultation 🩺</a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                <?php endif; ?>
            </div>
        </div>
    </main>
</div>

<?php require_once __DIR__ . '/../../views/layouts/footer.php'; ?>
