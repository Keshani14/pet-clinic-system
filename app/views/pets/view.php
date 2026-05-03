<?php
$pageTitle = htmlspecialchars($pet['name']) . ' — Pet Profile';
$bodyClass = 'dashboard-layout';
require_once __DIR__ . '/../../views/layouts/header.php';
?>

<div class="dashboard-wrapper">
    <?php 
    // Show appropriate sidebar based on role
    $role = Auth::role();
    if ($role === 'admin') require_once __DIR__ . '/../../views/layouts/admin_sidebar.php';
    elseif ($role === 'vet') require_once __DIR__ . '/../../views/layouts/vet_sidebar.php';
    elseif ($role === 'nurse') require_once __DIR__ . '/../../views/layouts/nurse_sidebar.php';
    elseif ($role === 'owner') require_once __DIR__ . '/../../views/layouts/owner_sidebar.php';
    ?>

    <main class="main-content">
        <div class="card card--xl">
            <div class="card-header">
                <span class="paw-icon" aria-hidden="true">🐾</span>
                <h1>Pet Profile: <?php echo htmlspecialchars($pet['name']); ?></h1>
                <p>Detailed information and medical history.</p>
            </div>
            
            <div class="card-body">
                <div class="form-row">
                    <div class="card" style="background: var(--pink-50); border: 2px solid var(--pink-100);">
                        <div class="card-body">
                            <h3 class="text-gray-800 mb-10">Basic Info</h3>
                            <p><strong>Type:</strong> <?php echo htmlspecialchars($pet['type']); ?></p>
                            <p><strong>Breed:</strong> <?php echo htmlspecialchars($pet['breed']); ?></p>
                            <p><strong>Age:</strong> <?php echo htmlspecialchars($pet['age']); ?> years</p>
                        </div>
                    </div>
                    <div class="card" style="background: #f0fdf4; border: 2px solid #dcfce7;">
                        <div class="card-body">
                            <h3 class="text-gray-800 mb-10">Ownership</h3>
                            <p><strong>Owner Name:</strong> <?php echo htmlspecialchars($pet['owner_name']); ?></p>
                            <p><strong>Phone:</strong> <?php echo htmlspecialchars($pet['owner_phone']); ?></p>
                        </div>
                    </div>
                </div>

                <div class="divider-line"></div>

                <div class="mt-30">
                    <h2 class="text-gray-800 mb-20">🩺 Medical History</h2>
                    <?php if (empty($history)): ?>
                        <div class="empty-state">
                            <p>No medical records found for this pet.</p>
                        </div>
                    <?php else: ?>
                        <div class="table-responsive">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>Date</th>
                                        <th>Diagnosis</th>
                                        <th>Treatment</th>
                                        <th>Prescribed Medicines</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($history as $record): ?>
                                        <tr>
                                            <td><strong><?php echo date('M d, Y', strtotime($record['treatment_date'])); ?></strong></td>
                                            <td><?php echo htmlspecialchars($record['diagnosis']); ?></td>
                                            <td><?php echo htmlspecialchars($record['treatment']); ?></td>
                                            <td>
                                                <div class="text-pink-bold"><?php echo nl2br(htmlspecialchars($record['medicines'] ?? 'None')); ?></div>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    <?php endif; ?>
                </div>

                <div class="divider-line"></div>
                <div class="text-center">
                    <button onclick="window.history.back();" class="link-back">← Go Back</button>
                </div>
            </div>
        </div>
    </main>
</div>

<?php require_once __DIR__ . '/../../views/layouts/footer.php'; ?>
