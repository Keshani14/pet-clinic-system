<?php
$pageTitle = 'Prepare Patient — Pet Clinic';
$bodyClass = 'dashboard-layout';
require_once __DIR__ . '/../../views/layouts/header.php';
?>

<div class="dashboard-wrapper">
    <?php require_once __DIR__ . '/../../views/layouts/nurse_sidebar.php'; ?>
    <main class="main-content">
        <div class="card card--xl">
            <div class="card-header">
                <span class="paw-icon" aria-hidden="true">📝</span>
                <h1>Prepare Case</h1>
                <p>Record vital signs for <strong><?php echo htmlspecialchars($appointment['pet_name_display']); ?></strong> before the consultation.</p>
            </div>
            
            <div class="card-body">
                <form action="?url=nurse/saveVitals/<?php echo $appointment['id']; ?>" method="POST" class="modern-form">
                    <div class="form-grid" style="grid-template-columns: 1fr 1fr; gap: 24px;">
                        <div class="form-group">
                            <label for="weight">Weight (kg) <span class="required">*</span></label>
                            <div class="input-wrap">
                                <span class="icon">⚖️</span>
                                <input type="text" name="weight" id="weight" placeholder="e.g. 5.4" required>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="temperature">Temperature (°C) <span class="required">*</span></label>
                            <div class="input-wrap">
                                <span class="icon">🌡️</span>
                                <input type="text" name="temperature" id="temperature" placeholder="e.g. 38.5" required>
                            </div>
                        </div>
                    </div>

                    <div class="form-group" style="margin-top: 20px;">
                        <label for="vitals_notes">Nurse Observation Notes</label>
                        <div class="input-wrap">
                            <span class="icon">✍️</span>
                            <textarea name="vitals_notes" id="vitals_notes" rows="4" placeholder="Any initial observations (e.g. skin rash, lethargy)..."></textarea>
                        </div>
                    </div>

                    <div class="divider-line"></div>

                    <div class="form-actions" style="display: flex; gap: 12px; justify-content: flex-end;">
                        <a href="?url=nurse/appointments" class="btn-pill" style="background: var(--gray-100); color: var(--gray-600);">Cancel</a>
                        <button type="submit" class="btn-pill btn-approve">Mark as Ready for Vet 🚀</button>
                    </div>
                </form>
            </div>
        </div>
    </main>
</div>

<?php require_once __DIR__ . '/../../views/layouts/footer.php'; ?>
