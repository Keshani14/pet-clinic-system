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
                    <p class="empty-state">No medical records found in the system.</p>
                <?php else: ?>
                    <div class="table-responsive">
                        <table class="data-table">
                            <thead>
                                <tr>
                                    <th>Date</th>
                                    <th>Patient</th>
                                    <th>Diagnosis</th>
                                    <th>Vet</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($records as $record): ?>
                                    <tr>
                                        <td class="text-gray-600"><?php echo date('M d, Y', strtotime($record['treatment_date'])); ?></td>
                                        <td>
                                            <strong><?php echo htmlspecialchars($record['pet_name']); ?></strong>
                                            <br><small class="text-gray-500"><?php echo htmlspecialchars($record['pet_type']); ?></small>
                                        </td>
                                        <td class="text-pink-bold"><?php echo htmlspecialchars($record['diagnosis']); ?></td>
                                        <td class="text-gray-600">Dr. <?php echo htmlspecialchars($record['vet_first_name']); ?></td>
                                        <td>
                                            <a href="?url=medical/viewHistory&pet_id=<?php echo $record['pet_id']; ?>" class="btn-pill btn-sm btn-dark">View History 📜</a>
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
