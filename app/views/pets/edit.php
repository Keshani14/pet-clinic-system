<?php
$pageTitle = 'Edit Pet — Pet Clinic';
require_once __DIR__ . '/../../views/layouts/header.php';

$petId       = $pet['id'] ?? '';
$name        = $pet['name'] ?? '';
$type        = $pet['type'] ?? '';
$breed       = $pet['breed'] ?? '';
$age         = $pet['age'] ?? '';
$ownerName   = $pet['owner_name'] ?? '';
$ownerPhone  = $pet['owner_phone'] ?? '';
?>

<div class="card card--sm">
    <div class="card-header">
        <span class="paw-icon" aria-hidden="true">✏️</span>
        <h1>Edit Pet</h1>
        <p>Update details for <?php echo htmlspecialchars($name); ?>.</p>
    </div>
    
    <div class="card-body">
        <?php if (!empty($errors['general'])): ?>
            <div class="alert alert-error" role="alert">
                <span aria-hidden="true">⚠</span> <?php echo htmlspecialchars($errors['general']); ?>
            </div>
        <?php endif; ?>

        <form method="POST" action="?url=pet/update" enctype="multipart/form-data" novalidate>
            <input type="hidden" name="id" value="<?php echo htmlspecialchars($petId); ?>">
            
            <!-- Pet Name -->
            <div class="form-group">
                <label for="name">Pet Name <span class="required">*</span></label>
                <div class="input-wrap">
                    <span class="icon" aria-hidden="true">🐶</span>
                    <input type="text" id="name" name="name" placeholder="Fluffy"
                           value="<?php echo htmlspecialchars($name); ?>"
                           class="<?php echo !empty($errors['name']) ? 'is-invalid' : ''; ?>" required>
                </div>
            </div>

            <!-- Pet Type -->
            <div class="form-group">
                <label for="type">Pet Type <span class="required">*</span></label>
                <div class="input-wrap">
                    <span class="icon" aria-hidden="true">🏷️</span>
                    <input type="text" id="type" name="type" placeholder="Dog, Cat, Bird..."
                           value="<?php echo htmlspecialchars($type); ?>"
                           class="<?php echo !empty($errors['type']) ? 'is-invalid' : ''; ?>" required>
                </div>
            </div>

            <!-- Pet Breed -->
            <div class="form-group">
                <label for="breed">Breed <span class="required">*</span></label>
                <div class="input-wrap">
                    <span class="icon" aria-hidden="true">🧬</span>
                    <input type="text" id="breed" name="breed" placeholder="Golden Retriever, Siamese..."
                           value="<?php echo htmlspecialchars($breed); ?>"
                           class="<?php echo !empty($errors['breed']) ? 'is-invalid' : ''; ?>" required>
                </div>
            </div>

            <!-- Pet Age -->
            <div class="form-group">
                <label for="age">Age (Years) <span class="required">*</span></label>
                <div class="input-wrap">
                    <span class="icon" aria-hidden="true">🎂</span>
                    <input type="number" id="age" name="age" placeholder="2" min="1"
                           value="<?php echo htmlspecialchars($age); ?>"
                           class="<?php echo !empty($errors['age']) ? 'is-invalid' : ''; ?>" required>
                </div>
            </div>

            <!-- Pet Photo (Optional) -->
            <div class="form-group">
                <label for="photo">Update Photo (Optional)</label>
                <div class="input-wrap">
                    <span class="icon" aria-hidden="true">📸</span>
                    <input type="file" id="photo" name="photo" accept="image/png, image/jpeg, image/gif"
                           class="<?php echo !empty($errors['photo']) ? 'is-invalid' : ''; ?>">
                </div>
            </div>

            <?php if (Auth::role() !== 'owner'): ?>
            <!-- Owner Name (For Vets/Nurses) -->
            <div class="form-group">
                <label for="owner_name">Owner Name</label>
                <div class="input-wrap">
                    <span class="icon" aria-hidden="true">👤</span>
                    <input type="text" id="owner_name" name="owner_name" placeholder="John Doe"
                           value="<?php echo htmlspecialchars($ownerName); ?>"
                           class="<?php echo !empty($errors['owner_name']) ? 'is-invalid' : ''; ?>">
                </div>
            </div>

            <!-- Owner Phone (For Vets/Nurses) -->
            <div class="form-group">
                <label for="owner_phone">Owner Phone</label>
                <div class="input-wrap">
                    <span class="icon" aria-hidden="true">📞</span>
                    <input type="text" id="owner_phone" name="owner_phone" placeholder="555-1234"
                           value="<?php echo htmlspecialchars($ownerPhone); ?>"
                           class="<?php echo !empty($errors['owner_phone']) ? 'is-invalid' : ''; ?>">
                </div>
            </div>
            <?php endif; ?>

            <button type="submit" class="btn-primary">Save Changes 💾</button>
        </form>
        
        <div class="divider-line"></div>
        <div class="text-center">
            <a href="?url=pet/listPets" class="link-back">Cancel</a>
        </div>
    </div>
</div>

<?php require_once __DIR__ . '/../../views/layouts/footer.php'; ?>
