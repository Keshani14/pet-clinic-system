<?php
$pageTitle = 'Medical Records Summary — Pet Clinic';
$bodyClass = 'dashboard-layout';
require_once __DIR__ . '/../../views/layouts/header.php';
?>

<div class="dashboard-wrapper">
    <?php require_once __DIR__ . '/../../views/layouts/vet_sidebar.php'; ?>
    <main class="main-content">
        <div class="card card--lg">
            <div class="card-header">
                <span class="paw-icon" aria-hidden="true">📋</span>
                <h1>Medical Records Summary</h1>
                <p>Overview of all patient treatments and history.</p>
            </div>
            
            <div class="card-body">
                <?php if (empty($records)): ?>
                    <div class="empty-state">
                        <span class="icon-lg">📂</span>
                        <p>No medical records found in the system.</p>
                    </div>
                <?php else: ?>
                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>Date</th>
                                    <th>Patient</th>
                                    <th>Diagnosis</th>
                                    <th>Vet</th>
                                    <th class="text-right">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($records as $record): ?>
                                    <tr>
                                        <td class="text-gray-600">
                                            <div style="display: flex; flex-direction: column;">
                                                <span style="font-weight: 700; color: var(--gray-800);">
                                                    <?php echo date('M d', strtotime($record['treatment_date'])); ?>
                                                </span>
                                                <small style="font-size: 0.75rem;">
                                                    <?php echo date('Y', strtotime($record['treatment_date'])); ?>
                                                </small>
                                            </div>
                                        </td>
                                        <td>
                                            <div style="display: flex; align-items: center; gap: 10px;">
                                                <?php if (!empty($record['pet_photo'])): ?>
                                                    <img src="/pet_clinic/public/<?php echo htmlspecialchars($record['pet_photo']); ?>" alt="Pet Photo" class="pet-thumbnail">
                                                <?php else: ?>
                                                    <span class="pet-thumbnail-placeholder" aria-hidden="true">🐾</span>
                                                <?php endif; ?>
                                                <div>
                                                    <strong style="display: block;"><?php echo htmlspecialchars($record['pet_name']); ?></strong>
                                                    <small class="text-gray-500"><?php echo htmlspecialchars($record['pet_type']); ?></small>
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            <span class="text-pink-bold" style="font-size: 0.95rem; display: block; max-width: 250px; overflow: hidden; text-overflow: ellipsis; white-space: nowrap;" title="<?php echo htmlspecialchars($record['diagnosis']); ?>">
                                                <?php echo htmlspecialchars($record['diagnosis']); ?>
                                            </span>
                                        </td>
                                        <td class="text-gray-600">
                                            <span style="display: flex; align-items: center; gap: 5px;">
                                                <span aria-hidden="true">🧑‍⚕️</span>
                                                Dr. <?php echo htmlspecialchars($record['vet_first_name']); ?>
                                            </span>
                                        </td>
                                        <td class="text-right">
                                            <a href="?url=medical/viewHistory&pet_id=<?php echo $record['pet_id']; ?>" class="btn-pill btn-sm btn-dark" style="padding: 8px 16px; font-size: 0.8rem;">
                                                View Full History 📜
                                            </a>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </main>
</div>

<?php require_once __DIR__ . '/../../views/layouts/footer.php'; ?>
