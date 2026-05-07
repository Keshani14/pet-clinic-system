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
            <div class="summary-card" style="border-left: 5px solid var(--pink-500);">
                <h3 style="font-size: 0.9rem; color: var(--gray-600); margin-bottom: 5px;">Patients Waiting</h3>
                <div class="value" id="waiting-count" style="color: var(--pink-500); font-size: 2.2rem; font-weight: 900;"><?php echo $stats['waiting']; ?></div>
            </div>
            <div class="summary-card" style="border-left: 5px solid #10b981;">
                <h3 style="font-size: 0.9rem; color: var(--gray-600); margin-bottom: 5px;">Completed Today</h3>
                <div class="value" id="completed-count" style="color: #10b981; font-size: 2.2rem; font-weight: 900;"><?php echo $stats['completed_today']; ?></div>
            </div>
            <div class="summary-card" style="border-left: 5px solid #6366f1;">
                <h3 style="font-size: 0.9rem; color: var(--gray-600); margin-bottom: 5px;">Clinical Monitor</h3>
                <div class="value" id="system-status" style="font-size: 1.1rem; color: var(--gray-800); font-weight: 700; display: flex; align-items: center; gap: 8px;">
                    <span class="status-dot pulse-green"></span> Live & Connected
                </div>
                <small class="text-gray-500" style="font-size: 0.7rem;">Dashboard auto-updates every 5s</small>
            </div>
        </div>

        <div id="dashboard-queue">
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
                                            <div class="text-gray-600" style="max-width: 300px; font-size: 0.85rem;">
                                                <strong>Symptoms:</strong> <?php echo htmlspecialchars($appt['symptoms'] ?? 'None'); ?><br>
                                                <strong>Note:</strong> <span style="font-style: italic;">"<?php echo htmlspecialchars($appt['nurse_notes'] ?? 'No extra notes'); ?>"</span>
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
        </div>
    </main>
</div>

<style>
.status-dot { width: 10px; height: 10px; border-radius: 50%; background: #10b981; }
.pulse-green { animation: pulseGreen 2s infinite; }
@keyframes pulseGreen {
    0% { box-shadow: 0 0 0 0 rgba(16, 185, 129, 0.7); }
    70% { box-shadow: 0 0 0 10px rgba(16, 185, 129, 0); }
    100% { box-shadow: 0 0 0 0 rgba(16, 185, 129, 0); }
}
</style>

<script>
// Real-time polling for Vet Dashboard
function refreshDashboard() {
    fetch('?url=vet/dashboard&ajax=1')
        .then(response => response.text())
        .then(html => {
            const parser = new DOMParser();
            const doc = parser.parseFromString(html, 'text/html');
            
            // Update stats
            document.getElementById('waiting-count').innerHTML = doc.getElementById('waiting-count').innerHTML;
            document.getElementById('completed-count').innerHTML = doc.getElementById('completed-count').innerHTML;
            
            // Update queue list
            document.getElementById('dashboard-queue').innerHTML = doc.getElementById('dashboard-queue').innerHTML;
        })
        .catch(err => console.error('Dashboard refresh failed:', err));
}

// Poll every 5 seconds
setInterval(refreshDashboard, 5000);
</script>

<?php require_once __DIR__ . '/../../views/layouts/footer.php'; ?>
