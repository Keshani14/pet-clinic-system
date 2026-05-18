<?php
$pageTitle = 'Consultation — PetSync';
$bodyClass = 'dashboard-layout';
require_once __DIR__ . '/../../views/layouts/header.php';
?>

<style>
    .main-content { background-color: #fcfcfd; }
    .modern-form .form-group { margin-bottom: 30px; }
    .modern-form textarea { 
        padding: 20px 20px 20px 50px; 
        border-radius: 20px; 
        border: 2px solid #f1f5f9; 
        background: #fdfdfd; 
        font-size: 1rem;
        line-height: 1.6;
    }
    .modern-form textarea:focus { 
        background: #fff; 
        border-color: var(--pink-500); 
        box-shadow: 0 10px 25px -5px rgba(219, 39, 119, 0.1);
    }
    .modern-form .input-wrap .icon { 
        top: 22px; 
        left: 20px;
        font-size: 1.4rem; 
        opacity: 0.7;
    }
    .vitals-card {
        background: #fff5f8; 
        border: 1px solid #ffe4ef; 
        border-radius: 24px; 
        padding: 30px; 
        margin-bottom: 40px; 
        display: flex; 
        gap: 50px; 
        flex-wrap: wrap; 
        box-shadow: var(--shadow-sm);
    }
</style>

<div class="dashboard-wrapper">
    <?php require_once __DIR__ . '/../../views/layouts/vet_sidebar.php'; ?>
    <main class="main-content">
        <div class="card card--xl">
            <div class="card-header" style="background: linear-gradient(135deg, var(--pink-600), var(--pink-500)); text-align: left; padding: 30px 40px;">
                <div style="display: flex; align-items: center; gap: 15px;">
                    <span class="paw-icon" style="font-size: 2rem; margin: 0;">🩺</span>
                    <div>
                        <h1 style="margin: 0; font-size: 1.5rem;">Clinical Consultation</h1>
                        <p style="margin: 0; color: rgba(255,255,255,0.9);">Examining <strong><?php echo htmlspecialchars($appointment['pet_name_display']); ?></strong> (<?php echo htmlspecialchars($appointment['display_type']); ?>)</p>
                    </div>
                </div>
            </div>
            
            <div class="card-body" style="padding: 40px;">
                <!-- Vitals Summary Box -->
                <div class="vitals-card">
                    <div>
                        <small class="text-gray-500" style="display: block; margin-bottom: 4px; text-transform: uppercase; font-weight: 700;">Weight</small>
                        <span style="font-size: 1.5rem; font-weight: 800; color: var(--gray-800);"><?php echo htmlspecialchars($nurseNote['weight'] ?? '-'); ?> <small style="font-size: 0.9rem;">kg</small></span>
                    </div>
                    <div>
                        <small class="text-gray-500" style="display: block; margin-bottom: 4px; text-transform: uppercase; font-weight: 700;">Temperature</small>
                        <span style="font-size: 1.5rem; font-weight: 800; color: var(--gray-800);"><?php echo htmlspecialchars($nurseNote['temperature'] ?? '-'); ?> <small style="font-size: 0.9rem;">°C</small></span>
                    </div>
                    <div style="flex: 1; min-width: 250px;">
                        <small class="text-gray-500" style="display: block; margin-bottom: 4px; text-transform: uppercase; font-weight: 700;">Symptoms</small>
                        <p class="text-gray-700" style="font-style: italic; margin: 0;">"<?php echo htmlspecialchars($nurseNote['symptoms'] ?? 'None recorded'); ?>"</p>
                    </div>
                    <?php if (!empty($nurseNote['notes'])): ?>
                    <div style="flex: 1; min-width: 250px;">
                        <small class="text-gray-500" style="display: block; margin-bottom: 4px; text-transform: uppercase; font-weight: 700;">Nurse Notes</small>
                        <p class="text-gray-700" style="font-size: 0.9rem; margin: 0;"><?php echo nl2br(htmlspecialchars($nurseNote['notes'])); ?></p>
                    </div>
                    <?php endif; ?>
                </div>

                <form action="?url=vet/complete/<?php echo $appointment['id']; ?>" method="POST" class="modern-form">
                    <input type="hidden" name="appointment_type" value="<?php echo htmlspecialchars($appointment['appointment_type'] ?? 'general'); ?>">
                    
                    <?php if (($appointment['appointment_type'] ?? 'general') === 'vaccination'): ?>
                    <div style="background: #eff6ff; border: 1px solid #bfdbfe; border-radius: 12px; padding: 25px; margin-bottom: 30px;">
                        <h3 style="color: #1e40af; font-size: 1rem; margin-bottom: 20px; display: flex; align-items: center; gap: 8px;">
                            <span>💉</span> Vaccination Administration details
                        </h3>
                        <div class="form-row">
                            <div class="form-group">
                                <label>Vaccine Name <span class="required">*</span></label>
                                <input type="text" name="vaccine_name" value="<?php echo htmlspecialchars($appointment['reason'] ?? ''); ?>" required placeholder="e.g. Rabies Booster">
                            </div>
                            <div class="form-group">
                                <label>Batch / Lot Number</label>
                                <input type="text" name="batch_number" placeholder="e.g. B-2023-XYZ">
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-group">
                                <label>Date Administered</label>
                                <input type="date" name="date_given" value="<?php echo date('Y-m-d'); ?>" required>
                            </div>
                            <div class="form-group">
                                <label>Next Due Date <span class="required">*</span></label>
                                <input type="date" name="next_due_date" value="<?php echo date('Y-m-d', strtotime('+1 year')); ?>" required>
                            </div>
                        </div>
                    </div>
                    <?php endif; ?>
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
