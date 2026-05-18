<?php
$pageTitle = 'Book Appointment — PetSync';
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
    if (Auth::role() === 'nurse') {
        require_once __DIR__ . '/../../views/layouts/nurse_sidebar.php';
    } elseif (Auth::role() === 'vet') {
        require_once __DIR__ . '/../../views/layouts/vet_sidebar.php';
    } elseif (Auth::role() === 'owner') {
        require_once __DIR__ . '/../../views/layouts/owner_sidebar.php';
    }
    ?>
    <main class="main-content">
        <div class="card card--xl">
            <div class="card-header">
                <span class="paw-icon" aria-hidden="true">📅</span>
                <h1><?php echo (Auth::role() === 'owner') ? 'Book Appointment' : 'Register Walk-in / Booking'; ?></h1>
                <p><?php echo (Auth::role() === 'owner') ? 'Schedule a visit for your furry friend.' : 'Register a patient arrival or schedule a new clinical slot.'; ?></p>
            </div>
            
            <div class="card-body">
                <?php if (empty($pets)): ?>
                    <div class="text-center py-40">
                        <div class="icon-lg mb-20" style="font-size: 4rem;">🐾</div>
                        <h2 class="text-gray-800 mb-10">No Patients Found</h2>
                        <p class="text-gray-600 mb-30" style="font-size: 1.1rem;">
                            The clinic database is currently clear.
                        </p>
                        <?php if (Auth::role() === 'owner'): ?>
                            <a href="?url=pet/addPet" class="btn-primary" style="max-width: 250px; margin: 0 auto; display: block;">
                                Add Pet +
                            </a>
                        <?php endif; ?>
                    </div>
                <?php else: ?>
                    <?php if (!empty($errors['general'])): ?>
                        <div class="alert alert-error"><?php echo $errors['general']; ?></div>
                    <?php endif; ?>

                    <?php 
                    $reqType = $_GET['type'] ?? 'general';
                    $isVaccination = ($reqType === 'vaccination');
                    ?>
                    <form action="?url=appointment/store" method="POST" id="appointmentForm">
                        <input type="hidden" name="appointment_type" value="<?php echo htmlspecialchars($reqType); ?>">
                        
                        <?php if ($isVaccination): ?>
                        <div class="alert alert-info" style="margin-bottom: 25px; background: #fff5f5; border: 1px solid #fecaca; color: #991b1b;">
                            <strong>🛡️ Vaccination Appointment:</strong> You are booking an immunization for this patient.
                        </div>
                        <?php endif; ?>

                        <div class="alert alert-info no-close" style="margin-bottom: 25px; background: #f8fafc; border: 1px solid #e2e8f0; color: #475569; display: flex; align-items: center; gap: 15px;">
                            <div style="font-size: 1.5rem;">🕒</div>
                            <div>
                                <strong style="color: #1e293b; display: block; margin-bottom: 3px;">Clinic Working Hours:</strong>
                                <small>Mon–Fri: 8 AM – 6 PM | Sat: 9 AM – 4 PM | Sun: Closed</small>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-group">
                                <label for="pet_id"><?php echo (Auth::role() === 'owner') ? 'Select Pet' : 'Search Patient'; ?> <span class="required">*</span></label>
                                <div class="input-wrap">
                                    <span class="icon">🐾</span>
                                    <select name="pet_id" id="pet_id" 
                                            class="<?php echo isset($errors['pet_id']) ? 'is-invalid' : ''; ?>" required>
                                        <option value="">-- Choose a Patient --</option>
                                        <?php foreach ($pets as $pet): ?>
                                            <option value="<?php echo $pet['id']; ?>"
                                                <?php echo (isset($old['pet_id']) && $old['pet_id'] == $pet['id']) ? 'selected' : ''; ?>>
                                                <?php echo htmlspecialchars($pet['name']); ?> 
                                                (<?php echo htmlspecialchars($pet['type']); ?>) 
                                                <?php if (Auth::role() !== 'owner'): ?>
                                                    — Owner: <?php echo htmlspecialchars($pet['owner_name'] ?? 'N/A'); ?>
                                                <?php endif; ?>
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
                                <textarea name="reason" id="reason" rows="4" placeholder="Briefly describe why this appointment is being booked..." 
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
                    <?php if (Auth::role() === 'owner'): ?>
                        <a href="?url=appointment/myAppointments" class="link-back">← View My Appointments</a>
                    <?php else: ?>
                        <a href="?url=nurse/dashboard" class="link-back">← Back to Dashboard</a>
                    <?php endif; ?>
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
        disable: [
            function(date) { return (date.getDay() === 0); }, // Disable Sundays
            ...bookedSlots.map(slot => {
                const start = new Date(new Date(slot.replace(' ', 'T')).getTime() - 29 * 60000);
                const end = new Date(new Date(slot.replace(' ', 'T')).getTime() + 29 * 60000);
                return { from: start, to: end };
            })
        ],
        onValueUpdate: function(selectedDates, dateStr, instance) {
            if (selectedDates.length > 0) {
                const dt = selectedDates[0];
                const now = new Date();
                
                // 1. Check if it's in the past
                if (dt < now) {
                    showToast("You cannot book an appointment in the past. Please select a future time.");
                    instance.clear();
                    return;
                }

                // 2. Dynamic Hour Restrictions
                const day = dt.getDay();
                const hours = dt.getHours();
                const minutes = dt.getMinutes();
                const timeStr = hours.toString().padStart(2, '0') + ':' + minutes.toString().padStart(2, '0');

                let isValid = true;
                let errorMsg = "";

                if (day === 6) { // Saturday
                    if (timeStr < '09:00' || timeStr > '15:30') {
                        isValid = false;
                        errorMsg = "Saturday appointments are only available between 9:00 AM and 4:00 PM.";
                    }
                } else { // Weekdays
                    if (timeStr < '08:00' || timeStr > '17:30') {
                        isValid = false;
                        errorMsg = "Weekday appointments are only available between 8:00 AM and 6:00 PM.";
                    }
                }

                if (!isValid) {
                    showToast(errorMsg);
                    instance.clear();
                }
            }
        },
        onDayCreate: function(dObj, dStr, fp, dayElem) {
            if (dayElem.dateObj.getDay() === 0) {
                dayElem.title = "Clinic is Closed on Sundays";
            }
        }
    });
</script>

<?php require_once __DIR__ . '/../../views/layouts/footer.php'; ?>
