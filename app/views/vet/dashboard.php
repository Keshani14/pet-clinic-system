<?php
$pageTitle = 'Vet Dashboard — Pet Clinic';
$bodyClass = 'dashboard-layout';
require_once __DIR__ . '/../../views/layouts/header.php';
?>

<div class="dashboard-wrapper">
    <!-- Load the sidebar partial -->
    <?php require_once __DIR__ . '/../../views/layouts/vet_sidebar.php'; ?>

    <!-- Main feed area -->
    <main class="main-content">
        <h1 class="text-gray-800 mb-10">Welcome back, Dr. <?php echo htmlspecialchars($name ?? 'Vet'); ?>!</h1>
        <p class="text-gray-600 mb-30">Here is your clinic summary for today.</p>

        <!-- Summary Statistics Grid -->
        <div class="summary-grid">
            <div class="summary-card">
                <h3>Total Patients</h3>
                <div class="value"><?php echo htmlspecialchars($totalPets ?? 0); ?></div>
            </div>
            <div class="summary-card">
                <h3>Appointments Today</h3>
                <div class="value">0</div> <!-- Placeholder -->
            </div>
            <div class="summary-card">
                <h3>Pending Actions</h3>
                <div class="value" style="color: var(--pink-500);">2</div> <!-- Placeholder -->
            </div>
        </div>

        <!-- Recent Activity Feed -->
        <h2 class="text-gray-800 mb-20" style="font-size: 1.4rem;">Recent Patient Registrations</h2>
        <div class="card" style="max-width: 100%;">
            <div class="card-body" style="padding: 0;">
                <?php if (empty($recentPets)): ?>
                    <p class="empty-state">No patients have been registered yet.</p>
                <?php else: ?>
                    <table class="table" style="margin-top: 0;">
                        <thead>
                            <tr>
                                <th>Photo</th>
                                <th>Name</th>
                                <th>Type</th>
                                <th>Breed</th>
                                <th>Owner</th>
                                <th>Phone</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($recentPets as $pet): ?>
                                <tr>
                                    <td>
                                        <?php if (!empty($pet['photo'])): ?>
                                            <img src="/pet_clinic/public/<?php echo htmlspecialchars($pet['photo']); ?>" alt="Pet Photo" class="pet-thumbnail">
                                        <?php else: ?>
                                            <span class="pet-thumbnail-placeholder" aria-hidden="true">🐾</span>
                                        <?php endif; ?>
                                    </td>
                                    <td class="text-pink-bold"><?php echo htmlspecialchars($pet['name']); ?></td>
                                    <td class="text-gray-600"><?php echo htmlspecialchars($pet['type']); ?></td>
                                    <td class="text-gray-600"><?php echo htmlspecialchars($pet['breed'] ?? 'Unknown'); ?></td>
                                    <td class="text-gray-600">
                                        <?php 
                                        $displayOwnerName = !empty($pet['owner_name']) ? $pet['owner_name'] : trim($pet['owner_first_name'] . ' ' . $pet['owner_last_name']);
                                        echo htmlspecialchars($displayOwnerName); 
                                        ?>
                                    </td>
                                    <td class="text-gray-600">
                                        <?php 
                                        $displayOwnerPhone = !empty($pet['owner_phone']) ? $pet['owner_phone'] : ($pet['owner_phone_user'] ?? 'No phone');
                                        echo htmlspecialchars($displayOwnerPhone); 
                                        ?>
                                    </td>
                                    <td>
                                        <a href="?url=medical/viewHistory&pet_id=<?php echo $pet['id']; ?>" class="btn-pill btn-sm btn-dark">History 🏥</a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                <?php endif; ?>
            </div>
        </div>
    </main>
</div>

<?php require_once __DIR__ . '/../../views/layouts/footer.php'; ?>
