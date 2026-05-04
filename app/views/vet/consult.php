<?php
$pageTitle = 'Consultation — Pet Clinic';
$bodyClass = 'dashboard-layout';
require_once __DIR__ . '/../../views/layouts/header.php';
?>

<div class="dashboard-wrapper">
    <?php require_once __DIR__ . '/../../views/layouts/vet_sidebar.php'; ?>
    <main class="main-content">
        <div class="card card--xl">
            <div class="card-header" style="background: linear-gradient(135deg, #fdf2f8 0%, #fce7f3 100%);">
                <span class="paw-icon" aria-hidden="true">🩺</span>
                <h1>Consultation</h1>
                <p>Examining <strong><?php echo htmlspecialchars($appointment['pet_name_display']); ?></strong> (<?php echo htmlspecialchars($appointment['display_type']); ?>)</p>
            </div>
            
            <div class="card-body">
                <!-- Vitals Summary Box -->
                <div style="background: #f8fafc; border: 1px solid #e2e8f0; border-radius: 12px; padding: 20px; margin-bottom: 30px; display: flex; gap: 40px;">
                    <div>
                        <small class="text-gray-500" style="display: block; margin-bottom: 4px; text-transform: uppercase; font-weight: 700;">Weight</small>
                        <span style="font-size: 1.5rem; font-weight: 800; color: var(--gray-800);"><?php echo htmlspecialchars($appointment['weight'] ?? '-'); ?> <small style="font-size: 0.9rem;">kg</small></span>
                    </div>
                    <div>
                        <small class="text-gray-500" style="display: block; margin-bottom: 4px; text-transform: uppercase; font-weight: 700;">Temperature</small>
                        <span style="font-size: 1.5rem; font-weight: 800; color: var(--gray-800);"><?php echo htmlspecialchars($appointment['temperature'] ?? '-'); ?> <small style="font-size: 0.9rem;">°C</small></span>
                    </div>
                    <div style="flex: 1;">
                        <small class="text-gray-500" style="display: block; margin-bottom: 4px; text-transform: uppercase; font-weight: 700;">Nurse Notes</small>
                        <p class="text-gray-700" style="font-style: italic; margin: 0;">"<?php echo htmlspecialchars($appointment['vitals_notes'] ?? 'No special observations recorded.'); ?>"</p>
                    </div>
                </div>

                <form action="?url=vet/complete/<?php echo $appointment['id']; ?>" method="POST" class="modern-form">
                    <div class="form-group">
                        <label for="diagnosis">Diagnosis & Findings <span class="required">*</span></label>
                        <div class="input-wrap">
                            <span class="icon">🔍</span>
                            <textarea name="diagnosis" id="diagnosis" rows="5" placeholder="Detailed findings from the examination..." required></textarea>
                        </div>
                    </div>

                    <div class="form-group" style="margin-top: 20px;">
                        <label for="prescription">Prescription & Treatment Plan <span class="required">*</span></label>
                        <div class="input-wrap">
                            <span class="icon">💊</span>
                            <textarea name="prescription" id="prescription" rows="5" placeholder="List medicines, dosage, and follow-up instructions..." required></textarea>
                        </div>
                    </div>

                    <div class="divider-line"></div>

                    <div class="form-actions" style="display: flex; gap: 12px; justify-content: flex-end;">
                        <a href="?url=vet/dashboard" class="btn-pill" style="background: var(--gray-100); color: var(--gray-600);">Suspend</a>
                        <button type="submit" class="btn-pill btn-approve" style="padding: 12px 30px;">Complete Consultation & Close Case 🏁</button>
                    </div>
                </form>
            </div>
        </div>
    </main>
</div>

<?php require_once __DIR__ . '/../../views/layouts/footer.php'; ?>
