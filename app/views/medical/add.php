<?php
$pageTitle = 'Add Medical Record — Pet Clinic';
$bodyClass = (Auth::role() === 'vet') ? 'dashboard-layout' : '';
require_once __DIR__ . '/../../views/layouts/header.php';
?>

<?php if (Auth::role() === 'vet'): ?>
<div class="dashboard-wrapper">
    <?php require_once __DIR__ . '/../../views/layouts/vet_sidebar.php'; ?>
    <main class="main-content">
<?php endif; ?>

<div class="<?php echo (Auth::role() === 'vet') ? '' : 'card card--sm'; ?>">
    <div class="card-header">
        <span class="paw-icon" aria-hidden="true">🩺</span>
        <h1>New Medical Entry</h1>
        <p>Adding record for <strong><?php echo htmlspecialchars($pet['name']); ?></strong> (<?php echo htmlspecialchars($pet['type']); ?>)</p>
    </div>
    
    <div class="card-body">
        <?php if (!empty($errors['general'])): ?>
            <div class="alert alert-error">
                <span aria-hidden="true">⚠</span> <?php echo htmlspecialchars($errors['general']); ?>
            </div>
        <?php endif; ?>

        <form method="POST" action="?url=medical/store" novalidate>
            <input type="hidden" name="pet_id" value="<?php echo $pet['id']; ?>">
            
            <div class="form-row">
                <div class="form-group">
                    <label for="treatment_date">Treatment Date <span class="required">*</span></label>
                    <div class="input-wrap">
                        <span class="icon" aria-hidden="true">📅</span>
                        <input type="date" id="treatment_date" name="treatment_date"
                               value="<?php echo htmlspecialchars($old['treatment_date'] ?? date('Y-m-d')); ?>"
                               class="<?php echo !empty($errors['treatment_date']) ? 'is-invalid' : ''; ?>" required>
                    </div>
                    <?php if (!empty($errors['treatment_date'])): ?>
                        <span class="field-error"><?php echo htmlspecialchars($errors['treatment_date']); ?></span>
                    <?php endif; ?>
                </div>

                <div class="form-group">
                    <label for="diagnosis">Diagnosis <span class="required">*</span></label>
                    <div class="input-wrap">
                        <span class="icon" aria-hidden="true">🔍</span>
                        <input type="text" id="diagnosis" name="diagnosis" placeholder="e.g., Seasonal Allergies"
                               value="<?php echo htmlspecialchars($old['diagnosis'] ?? ''); ?>"
                               class="<?php echo !empty($errors['diagnosis']) ? 'is-invalid' : ''; ?>" required>
                    </div>
                    <?php if (!empty($errors['diagnosis'])): ?>
                        <span class="field-error"><?php echo htmlspecialchars($errors['diagnosis']); ?></span>
                    <?php endif; ?>
                </div>
            </div>

            <div class="form-group">
                <label for="treatment">Treatment Plan <span class="required">*</span></label>
                <div class="input-wrap">
                    <textarea id="treatment" name="treatment" rows="3" placeholder="Describe the treatment procedure..."
                              class="<?php echo !empty($errors['treatment']) ? 'is-invalid' : ''; ?>" required><?php echo htmlspecialchars($old['treatment'] ?? ''); ?></textarea>
                </div>
                <?php if (!empty($errors['treatment'])): ?>
                    <span class="field-error"><?php echo htmlspecialchars($errors['treatment']); ?></span>
                <?php endif; ?>
            </div>

            <div class="form-group">
                <label for="medicines">Prescribed Medicines & Durations</label>
                <div class="input-wrap">
                    <textarea id="medicines" name="medicines" rows="3" placeholder="e.g., Amoxicillin 250mg - 2x daily for 7 days"><?php echo htmlspecialchars($old['medicines'] ?? ''); ?></textarea>
                </div>
                <p class="label-hint" style="margin-top: 5px; font-size: 0.8rem;">List medications with their dosage and how long they should be taken.</p>
            </div>

            <div class="form-group">
                <label for="notes">Additional Notes</label>
                <div class="input-wrap">
                    <textarea id="notes" name="notes" rows="2" placeholder="Any extra observations..."><?php echo htmlspecialchars($old['notes'] ?? ''); ?></textarea>
                </div>
            </div>

            <button type="submit" class="btn-primary">Save Medical Record 💾</button>
        </form>
        
        <div class="divider-line"></div>
        <div class="text-center">
            <a href="?url=medical/viewHistory&pet_id=<?php echo $pet['id']; ?>" class="link-back">← Back to History</a>
        </div>
    </div>
</div>

<?php if (Auth::role() === 'vet'): ?>
    </main>
</div>
<?php endif; ?>

<?php require_once __DIR__ . '/../../views/layouts/footer.php'; ?>
