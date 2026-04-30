<?php
$pageTitle = 'Medical History — Pet Clinic';
$isVet = (Auth::role() === 'vet');
$bodyClass = $isVet ? 'dashboard-layout' : '';
require_once __DIR__ . '/../../views/layouts/header.php';
?>

<?php if ($isVet): ?>
<div class="dashboard-wrapper">
    <?php require_once __DIR__ . '/../../views/layouts/vet_sidebar.php'; ?>
    <main class="main-content">
<?php endif; ?>

<div class="<?php echo $isVet ? '' : 'card card--lg'; ?>">
    <div class="card-header flex-header" style="display: flex; justify-content: space-between; align-items: center;">
        <div>
            <span class="paw-icon" aria-hidden="true">📜</span>
            <h1>Medical History</h1>
            <p>Records for <strong><?php echo htmlspecialchars($pet['name']); ?></strong></p>
        </div>
        <?php if ($isVet): ?>
            <a href="?url=medical/addRecord&pet_id=<?php echo $pet['id']; ?>" class="btn-pill">Add New Entry +</a>
        <?php endif; ?>
    </div>
    
    <div class="card-body">
        <?php if (!empty($_SESSION['flash_success'])): ?>
            <div class="alert alert-success">
                <span aria-hidden="true">✅</span> <?php echo htmlspecialchars($_SESSION['flash_success']); unset($_SESSION['flash_success']); ?>
            </div>
        <?php endif; ?>

        <?php if (empty($history)): ?>
            <p class="empty-state">No medical records found for this pet.</p>
        <?php else: ?>
            <div class="timeline">
                <?php foreach ($history as $record): ?>
                    <div class="timeline-item">
                        <div class="timeline-date">
                            <?php echo date('M d, Y', strtotime($record['treatment_date'])); ?>
                        </div>
                        <div class="timeline-content card">
                            <div class="card-body">
                                <h3 class="text-pink-bold" style="margin-top: 0;">Diagnosis: <?php echo htmlspecialchars($record['diagnosis']); ?></h3>
                                <p class="text-gray-800"><strong>Treatment:</strong> <?php echo nl2br(htmlspecialchars($record['treatment'])); ?></p>
                                <?php if (!empty($record['medicines'])): ?>
                                    <p class="text-gray-800"><strong>💊 Prescribed Medicines:</strong><br><?php echo nl2br(htmlspecialchars($record['medicines'])); ?></p>
                                <?php endif; ?>
                                <?php if (!empty($record['notes'])): ?>
                                    <p class="text-gray-600" style="font-style: italic; border-left: 3px solid var(--pink-100); padding-left: 10px;">
                                        Notes: <?php echo nl2br(htmlspecialchars($record['notes'])); ?>
                                    </p>
                                <?php endif; ?>
                                <div class="timeline-meta text-gray-500" style="font-size: 0.8rem; margin-top: 15px;">
                                    Recorded by: Dr. <?php echo htmlspecialchars($record['vet_first_name'] . ' ' . $record['vet_last_name']); ?>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>

        <div class="divider-line"></div>
        <div class="text-center">
            <a href="?url=pet/listPets" class="link-back">← Back to Roster</a>
        </div>
    </div>
</div>

<?php if ($isVet): ?>
    </main>
</div>
<?php endif; ?>

<?php require_once __DIR__ . '/../../views/layouts/footer.php'; ?>
