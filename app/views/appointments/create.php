<?php
$pageTitle = 'Book Appointment — Pet Clinic';
$bodyClass = 'dashboard-layout';

// Load Flatpickr for a premium date/time picker experience
$extraHead = '
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
<link rel="stylesheet" type="text/css" href="https://npmcdn.com/flatpickr/dist/themes/confetti.css">
<style>
    .flatpickr-calendar { box-shadow: var(--shadow-lg) !important; border: none !important; border-radius: 15px !important; }
    .flatpickr-day.selected { background: var(--pink-500) !important; border-color: var(--pink-500) !important; }
    .booked-slot-label { color: var(--danger-500); font-weight: 700; }
</style>
';

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
                <?php if (empty($myPets)): ?>
                    <div class="text-center py-40">
                        <div class="icon-lg mb-20" style="font-size: 4rem;">🐾</div>
                        <h2 class="text-gray-800 mb-10">No Pets Found</h2>
                        <p class="text-gray-600 mb-30" style="font-size: 1.1rem;">
                            Please add a pet before booking an appointment.
                        </p>
                        <a href="?url=pet/addPet" class="btn-primary" style="max-width: 250px; margin: 0 auto; display: block;">
                            Add Pet +
                        </a>
                    </div>
                <?php else: ?>
                    <?php if (!empty($errors['general'])): ?>
                        <div class="alert alert-error"><?php echo $errors['general']; ?></div>
                    <?php endif; ?>

                    <form action="?url=appointment/store" method="POST" id="appointmentForm">
                        <div class="form-row">
                            <div class="form-group">
                                <label for="pet_name">Select Pet <span class="required">*</span></label>
                                <div class="input-wrap">
                                    <span class="icon">🐾</span>
                                    <select name="pet_id" id="pet_id" 
                                            class="<?php echo isset($errors['pet_id']) ? 'is-invalid' : ''; ?>" required>
                                        <option value="">-- Choose a Pet --</option>
                                        <?php foreach ($myPets as $pet): ?>
                                            <option value="<?php echo $pet['id']; ?>"
                                                <?php echo (isset($old['pet_id']) && $old['pet_id'] == $pet['id']) ? 'selected' : ''; ?>>
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
                                    <input type="text" name="appointment_date" id="appointment_date" 
                                           placeholder="Select a date and time..."
                                           value="<?php echo htmlspecialchars($old['appointment_date'] ?? ''); ?>"
                                           class="<?php echo isset($errors['appointment_date']) ? 'is-invalid' : ''; ?>" required>
                                </div>
                                <?php if (isset($errors['appointment_date'])): ?>
                                    <span class="field-error"><?php echo $errors['appointment_date']; ?></span>
                                <?php endif; ?>
                            </div>
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
                            <button type="submit" class="btn-primary" style="max-width: 300px; margin: 0 auto;">Confirm Booking 🐾</button>
                        </div>
                    </form>
                <?php endif; ?>

                <div class="divider-line"></div>
                <div class="text-center">
                    <a href="?url=appointment/myAppointments" class="link-back">← View My Appointments</a>
                </div>
            </div>
        </div>
    </main>
</div>

<!-- Scripts -->
<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
<script>
    // Data from PHP
    const bookedSlots = <?php echo json_encode($bookedSlots ?? []); ?>;

    // Initialize Flatpickr
    flatpickr("#appointment_date", {
        enableTime: true,
        dateFormat: "Y-m-d H:i",
        minDate: "today",
        time_24hr: false,
        minuteIncrement: 30,
        disable: bookedSlots.map(slot => {
            const start = new Date(new Date(slot.replace(' ', 'T')).getTime() - 29 * 60000);
            const end = new Date(new Date(slot.replace(' ', 'T')).getTime() + 29 * 60000);
            return { from: start, to: end };
        }),
        onChange: function(selectedDates, dateStr, instance) {
            if (selectedDates.length > 0) {
                const selected = dateStr;
                const isTaken = bookedSlots.some(slot => {
                    const slotDate = new Date(slot.replace(' ', 'T'));
                    const selectedDate = new Date(selected.replace(' ', 'T'));
                    const diff = Math.abs(selectedDate - slotDate) / 60000;
                    return diff < 30;
                });

                if (isTaken) {
                    alert("⚠️ This time slot is already booked. Please select a different time.");
                    instance.clear();
                }
            }
        }
    });
</script>

<?php require_once __DIR__ . '/../../views/layouts/footer.php'; ?>
