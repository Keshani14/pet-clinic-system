<?php
$pageTitle = 'Pet Roster — Pet Clinic';
$isVet = (Auth::role() === 'vet');
if ($isVet) {
    $bodyClass = 'dashboard-layout';
}
require_once __DIR__ . '/../../views/layouts/header.php';
?>

<?php if ($isVet): ?>
<div class="dashboard-wrapper">
    <?php require_once __DIR__ . '/../../views/layouts/vet_sidebar.php'; ?>
    <main class="main-content">
<?php endif; ?>

<div class="<?php echo $isVet ? '' : 'card card--lg'; ?>">
    <?php if (!$isVet): ?>
    <div class="card-header">
        <span class="paw-icon" aria-hidden="true">📋</span>
        <h1>Pet Roster</h1>
        <p>List of registered pets.</p>
    </div>
    <?php else: ?>
        <h1 class="text-gray-800 mb-10">Patient Records</h1>
        <p class="text-gray-600 mb-30">Complete list of registered pets across the clinic.</p>
    <?php endif; ?>
    
    <div class="card-body" <?php echo $isVet ? 'style="padding: 0; background: transparent;"' : ''; ?>>
        <?php if (!empty($_SESSION['flash_success'])): ?>
            <div class="alert alert-success" role="status">
                <span aria-hidden="true">✅</span>
                <?php
                    echo htmlspecialchars($_SESSION['flash_success']);
                    unset($_SESSION['flash_success']);
                ?>
            </div>
        <?php endif; ?>

        <div class="mb-20 text-right">
            <a href="?url=pet/addPet" class="btn-pill">Add New Pet +</a>
        </div>

        <?php if (empty($pets)): ?>
            <p class="empty-state">No pets found. Start by adding one!</p>
        <?php else: ?>
            <div class="card" style="max-width: 100%; padding: 0;">
                <table class="table" style="margin-top: 0;">
                    <thead>
                        <tr>
                            <th>Photo</th>
                            <th>Name</th>
                            <th>Type</th>
                            <th>Breed</th>
                            <th>Age</th>
                            <?php if (Auth::role() !== 'owner'): ?>
                                <th>Owner</th>
                                <th>Phone</th>
                            <?php endif; ?>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($pets as $pet): ?>
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
                                <td class="text-gray-600"><?php echo htmlspecialchars($pet['age']); ?> yrs</td>
                                <?php if (Auth::role() !== 'owner'): ?>
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
                                <?php endif; ?>
                                <td>
                                    <a href="?url=medical/viewHistory&pet_id=<?php echo $pet['id']; ?>" class="btn-pill btn-sm btn-dark">History 🏥</a>
                                    <a href="?url=pet/edit&id=<?php echo $pet['id']; ?>" class="btn-pill btn-sm">Edit ✏️</a>
                                    <a href="?url=pet/delete&id=<?php echo $pet['id']; ?>" class="btn-secondary btn-sm btn-danger" onclick="return confirm('Are you sure you want to delete this pet?');">Delete 🗑️</a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        <?php endif; ?>
        
        <?php if (!$isVet): ?>
            <div class="divider-line"></div>
            <div class="text-center">
                <a href="?url=<?php echo Auth::role(); ?>/dashboard" class="link-back">← Back to Dashboard</a>
            </div>
        <?php endif; ?>
    </div>
</div>

<?php if ($isVet): ?>
    </main>
</div>
<?php endif; ?>

<?php require_once __DIR__ . '/../../views/layouts/footer.php'; ?>
