<?php
$pageTitle = 'Book Appointment — Pet Clinic';
$bodyClass = 'dashboard-layout';
require_once __DIR__ . '/../../views/layouts/header.php';
?>

<div class="dashboard-wrapper">
    <?php 
    if (file_exists(__DIR__ . '/../../views/layouts/owner_sidebar.php')) {
        require_once __DIR__ . '/../../views/layouts/owner_sidebar.php';
    }
    ?>
    <main class="main-content">
        <div class="card card--xl">
            <div class="card-header">
                <span class="paw-icon" aria-hidden="true">📅</span>
                <h1>Book Appointment</h1>
                <p>Schedule a visit for your furry friend.</p>
            </div>
            
            <div class="card-body">
                <?php if (!empty($errors['general'])): ?>
                    <div class="alert alert-error"><?php echo $errors['general']; ?></div>
                <?php endif; ?>

                <form action="?url=appointment/store" method="POST">
                    <div class="form-group">
                        <label for="pet_id">Select Pet <span class="required">*</span></label>
                        <div class="input-wrap">
                            <span class="icon">🐾</span>
                            <select name="pet_id" id="pet_id" class="<?php echo isset($errors['pet_id']) ? 'is-invalid' : ''; ?>" required>
                                <option value="">-- Choose your pet --</option>
                                <?php foreach ($pets as $pet): ?>
                                    <option value="<?php echo $pet['id']; ?>" <?php echo (isset($old['pet_id']) && $old['pet_id'] == $pet['id']) ? 'selected' : ''; ?>>
                                        <?php echo htmlspecialchars($pet['name']); ?> (<?php echo htmlspecialchars($pet['type']); ?>)
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <?php if (isset($errors['pet_id'])): ?>
                            <span class="field-error"><?php echo $errors['pet_id']; ?></span>
                        <?php endif; ?>
                    </div>

                    <div class="form-group">
                        <label for="appointment_date">Date & Time <span class="required">*</span></label>
                        <div class="input-wrap">
                            <span class="icon">⏰</span>
                            <input type="datetime-local" name="appointment_date" id="appointment_date" 
                                   value="<?php echo htmlspecialchars($old['appointment_date'] ?? ''); ?>"
                                   class="<?php echo isset($errors['appointment_date']) ? 'is-invalid' : ''; ?>" required>
                        </div>
                        <?php if (isset($errors['appointment_date'])): ?>
                            <span class="field-error"><?php echo $errors['appointment_date']; ?></span>
                        <?php endif; ?>
                    </div>

                    <div class="form-group">
                        <label for="reason">Reason for Visit <span class="required">*</span></label>
                        <div class="input-wrap">
                            <span class="icon">📝</span>
                            <textarea name="reason" id="reason" rows="4" placeholder="Briefly describe why you are booking this appointment..." 
                                      class="<?php echo isset($errors['reason']) ? 'is-invalid' : ''; ?>" required><?php echo htmlspecialchars($old['reason'] ?? ''); ?></textarea>
                        </div>
                        <?php if (isset($errors['reason'])): ?>
                            <span class="field-error"><?php echo $errors['reason']; ?></span>
                        <?php endif; ?>
                    </div>

                    <div class="my-20">
                        <button type="submit" class="btn-primary">Confirm Booking 🐾</button>
                    </div>
                </form>

                <div class="divider-line"></div>
                <div class="text-center">
                    <a href="?url=appointment/myAppointments" class="link-back">← View My Appointments</a>
                </div>
            </div>
        </div>
    </main>
</div>

<?php require_once __DIR__ . '/../../views/layouts/footer.php'; ?>
