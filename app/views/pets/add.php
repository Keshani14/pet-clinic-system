<?php
$pageTitle = 'Add Pet — Pet Clinic';
$userRole = Auth::role();
$bodyClass = 'dashboard-layout';

require_once __DIR__ . '/../../views/layouts/header.php';
?>

<div class="dashboard-wrapper">
    <?php 
    if ($userRole === 'vet') {
        require_once __DIR__ . '/../../views/layouts/vet_sidebar.php';
    } elseif ($userRole === 'admin') {
        require_once __DIR__ . '/../../views/layouts/admin_sidebar.php';
    } else {
        require_once __DIR__ . '/../../views/layouts/owner_sidebar.php';
    }
    ?>
    <main class="main-content">
        <div class="card card--lg" style="margin: 0 auto;">
            <div class="card-header">
                <span class="paw-icon" aria-hidden="true">🐾</span>
                <h1>Add a New Pet</h1>
                <p>Register your furry friend to our clinic.</p>
            </div>

            <div class="card-body">
                <?php if (!empty($errors['general'])): ?>
                    <div class="alert alert-danger" role="alert">
                        <span aria-hidden="true">⚠️</span>
                        <?php echo htmlspecialchars($errors['general']); ?>
                    </div>
                <?php endif; ?>

                <form method="POST" action="?url=pet/store" enctype="multipart/form-data" novalidate>
                    <!-- Pet Name -->
                    <div class="form-group">
                        <label for="name">Pet Name <span class="required">*</span></label>
                        <div class="input-wrap">
                            <span class="icon" aria-hidden="true">🐶</span>
                            <input type="text" id="name" name="name" placeholder="Buddy"
                                   value="<?php echo htmlspecialchars($old['name'] ?? ''); ?>"
                                   class="<?php echo !empty($errors['name']) ? 'is-invalid' : ''; ?>" required>
                        </div>
                        <?php if (!empty($errors['name'])): ?>
                            <span class="field-error"><span aria-hidden="true">⚠</span> <?php echo htmlspecialchars($errors['name']); ?></span>
                        <?php endif; ?>
                    </div>

                    <!-- Pet Type -->
                    <div class="form-group">
                        <label for="type">Pet Type <span class="required">*</span></label>
                        <div class="input-wrap">
                            <span class="icon" aria-hidden="true">🏷️</span>
                            <input type="text" id="type" name="type" placeholder="Dog, Cat, Bird..."
                                   value="<?php echo htmlspecialchars($old['type'] ?? ''); ?>"
                                   class="<?php echo !empty($errors['type']) ? 'is-invalid' : ''; ?>" required>
                        </div>
                        <?php if (!empty($errors['type'])): ?>
                            <span class="field-error"><span aria-hidden="true">⚠</span> <?php echo htmlspecialchars($errors['type']); ?></span>
                        <?php endif; ?>
                    </div>

                    <!-- Pet Breed -->
                    <div class="form-group">
                        <label for="breed">Breed <span class="required">*</span></label>
                        <div class="input-wrap">
                            <span class="icon" aria-hidden="true">🧬</span>
                            <input type="text" id="breed" name="breed" placeholder="Golden Retriever, Siamese..."
                                   value="<?php echo htmlspecialchars($old['breed'] ?? ''); ?>"
                                   class="<?php echo !empty($errors['breed']) ? 'is-invalid' : ''; ?>" required>
                        </div>
                        <?php if (!empty($errors['breed'])): ?>
                            <span class="field-error"><span aria-hidden="true">⚠</span> <?php echo htmlspecialchars($errors['breed']); ?></span>
                        <?php endif; ?>
                    </div>

                    <!-- Pet Date of Birth -->
                    <div class="form-group">
                        <label for="dob">Date of Birth <span class="required">*</span></label>
                        <div class="input-wrap">
                            <span class="icon" aria-hidden="true">📅</span>
                            <input type="date" id="dob" name="dob"
                                   value="<?php echo htmlspecialchars($old['dob'] ?? ''); ?>"
                                   class="<?php echo !empty($errors['dob']) ? 'is-invalid' : ''; ?>" required>
                        </div>
                        <?php if (!empty($errors['dob'])): ?>
                            <span class="field-error"><span aria-hidden="true">⚠</span> <?php echo htmlspecialchars($errors['dob']); ?></span>
                        <?php endif; ?>
                    </div>

                    <!-- Vaccination Section -->
                    <div class="divider-line"><span>💉 Vaccination Status</span></div>
                    
                    <div class="form-group">
                        <label for="vac_status">Current Vaccination Status</label>
                        <div class="input-wrap">
                            <span class="icon">🛡️</span>
                            <select name="vac_status" id="vac_status" onchange="toggleVacHistory(this.value)">
                                <option value="not_vaccinated">Not Vaccinated</option>
                                <option value="partially_vaccinated">Partially Vaccinated</option>
                                <option value="already_vaccinated">Already Vaccinated</option>
                            </select>
                        </div>
                    </div>

                    <div id="vac-history-section" style="display: none; background: #fff5f8; padding: 25px; border-radius: 20px; margin-bottom: 25px; border: 1px solid #ffe4ef; animation: slideUp 0.4s ease;">
                        <h3 style="font-size: 0.95rem; color: var(--pink-600); margin-bottom: 15px; display: flex; align-items: center; gap: 8px;">
                            <span>📜</span> Last Vaccination Record
                        </h3>
                        <div class="form-group">
                            <label>Vaccine Name</label>
                            <input type="text" name="history_vac_name" placeholder="e.g. Rabies, DHPPi" style="padding-left: 15px;">
                        </div>
                        <div class="form-row">
                            <div class="form-group">
                                <label>Date Given</label>
                                <input type="date" name="history_vac_date">
                            </div>
                            <div class="form-group">
                                <label>Next Due Date</label>
                                <input type="date" name="history_vac_next">
                            </div>
                        </div>
                        <p style="font-size: 0.8rem; color: var(--gray-500); margin: 0;">* Future booster schedules will be calculated from these dates.</p>
                    </div>

                    <script>
                    function toggleVacHistory(status) {
                        const section = document.getElementById('vac-history-section');
                        if (status === 'already_vaccinated' || status === 'partially_vaccinated') {
                            section.style.display = 'block';
                        } else {
                            section.style.display = 'none';
                        }
                    }
                    </script>

                    <!-- Pet Photo (Optional) -->
                    <div class="form-group">
                        <label for="photo">Photo (Optional)</label>
                        <div class="input-wrap">
                            <span class="icon" aria-hidden="true">📸</span>
                            <input type="file" id="photo" name="photo" accept="image/png, image/jpeg, image/gif"
                                   class="<?php echo !empty($errors['photo']) ? 'is-invalid' : ''; ?>">
                        </div>
                        <?php if (!empty($errors['photo'])): ?>
                            <span class="field-error"><span aria-hidden="true">⚠</span> <?php echo htmlspecialchars($errors['photo']); ?></span>
                        <?php endif; ?>
                    </div>

                    <?php if (Auth::role() !== 'owner'): ?>
                    <!-- Owner Name (For Vets/Nurses) -->
                    <div class="form-group">
                        <label for="owner_name">Owner Name <span class="required">*</span></label>
                        <div class="input-wrap">
                            <span class="icon" aria-hidden="true">👤</span>
                            <input type="text" id="owner_name" name="owner_name" placeholder="John Doe"
                                   value="<?php echo htmlspecialchars($old['owner_name'] ?? ''); ?>"
                                   class="<?php echo !empty($errors['owner_name']) ? 'is-invalid' : ''; ?>" required>
                        </div>
                    </div>

                    <!-- Owner Phone (For Vets/Nurses) -->
                    <div class="form-group">
                        <label for="owner_phone">Owner Phone <span class="required">*</span></label>
                        <div class="input-wrap">
                            <span class="icon" aria-hidden="true">📞</span>
                            <input type="text" id="owner_phone" name="owner_phone" placeholder="555-1234"
                                   value="<?php echo htmlspecialchars($old['owner_phone'] ?? ''); ?>"
                                   class="<?php echo !empty($errors['owner_phone']) ? 'is-invalid' : ''; ?>" required>
                        </div>
                    </div>
                    <?php endif; ?>

                    <button type="submit" class="btn-primary">Add Pet 🐾</button>
                </form>
                
                <div class="divider-text">
                    <a href="?url=pet/listPets">Back to My Pets</a>
                </div>
            </div>
        </div>
    </main>
</div>

<?php require_once __DIR__ . '/../../views/layouts/footer.php'; ?>
