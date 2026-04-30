<?php
$pageTitle = 'Add Pet — Pet Clinic';
require_once __DIR__ . '/../../views/layouts/header.php';
?>

<main class="card" role="main">
    <div class="card-header">
        <span class="paw-icon" aria-hidden="true">🐾</span>
        <h1>Add a New Pet</h1>
        <p>Register your furry friend to our clinic.</p>
    </div>

    <div class="card-body">
        <?php if (!empty($errors['general'])): ?>
            <div class="alert alert-danger" role="alert">
                <span aria-hidden="true">⚠️</span>
                <?php echo htmlspecialchars($errors['general']); ?>
            </div>
        <?php endif; ?>

        <form method="POST" action="?url=pet/store" enctype="multipart/form-data" novalidate>
            <!-- Pet Name -->
            <div class="form-group">
                <label for="name">Pet Name <span class="required">*</span></label>
                <div class="input-wrap">
                    <span class="icon" aria-hidden="true">🐶</span>
                    <input type="text" id="name" name="name" placeholder="Buddy"
                           value="<?php echo htmlspecialchars($old['name'] ?? ''); ?>"
                           class="<?php echo !empty($errors['name']) ? 'is-invalid' : ''; ?>" required>
                </div>
                <?php if (!empty($errors['name'])): ?>
                    <span class="field-error"><span aria-hidden="true">⚠</span> <?php echo htmlspecialchars($errors['name']); ?></span>
                <?php endif; ?>
            </div>

            <!-- Pet Type -->
            <div class="form-group">
                <label for="type">Pet Type <span class="required">*</span></label>
                <div class="input-wrap">
                    <span class="icon" aria-hidden="true">🏷️</span>
                    <input type="text" id="type" name="type" placeholder="Dog, Cat, Bird..."
                           value="<?php echo htmlspecialchars($old['type'] ?? ''); ?>"
                           class="<?php echo !empty($errors['type']) ? 'is-invalid' : ''; ?>" required>
                </div>
                <?php if (!empty($errors['type'])): ?>
                    <span class="field-error"><span aria-hidden="true">⚠</span> <?php echo htmlspecialchars($errors['type']); ?></span>
                <?php endif; ?>
            </div>

            <!-- Pet Breed -->
            <div class="form-group">
                <label for="breed">Breed <span class="required">*</span></label>
                <div class="input-wrap">
                    <span class="icon" aria-hidden="true">🧬</span>
                    <input type="text" id="breed" name="breed" placeholder="Golden Retriever, Siamese..."
                           value="<?php echo htmlspecialchars($old['breed'] ?? ''); ?>"
                           class="<?php echo !empty($errors['breed']) ? 'is-invalid' : ''; ?>" required>
                </div>
                <?php if (!empty($errors['breed'])): ?>
                    <span class="field-error"><span aria-hidden="true">⚠</span> <?php echo htmlspecialchars($errors['breed']); ?></span>
                <?php endif; ?>
            </div>

            <!-- Pet Age -->
            <div class="form-group">
                <label for="age">Age (Years) <span class="required">*</span></label>
                <div class="input-wrap">
                    <span class="icon" aria-hidden="true">🎂</span>
                    <input type="number" id="age" name="age" placeholder="2" min="1"
                           value="<?php echo htmlspecialchars($old['age'] ?? ''); ?>"
                           class="<?php echo !empty($errors['age']) ? 'is-invalid' : ''; ?>" required>
                </div>
                <?php if (!empty($errors['age'])): ?>
                    <span class="field-error"><span aria-hidden="true">⚠</span> <?php echo htmlspecialchars($errors['age']); ?></span>
                <?php endif; ?>
            </div>

            <!-- Pet Photo (Optional) -->
            <div class="form-group">
                <label for="photo">Photo (Optional)</label>
                <div class="input-wrap">
                    <span class="icon" aria-hidden="true">📸</span>
                    <input type="file" id="photo" name="photo" accept="image/png, image/jpeg, image/gif"
                           class="<?php echo !empty($errors['photo']) ? 'is-invalid' : ''; ?>">
                </div>
                <?php if (!empty($errors['photo'])): ?>
                    <span class="field-error"><span aria-hidden="true">⚠</span> <?php echo htmlspecialchars($errors['photo']); ?></span>
                <?php endif; ?>
            </div>

            <?php if (Auth::role() !== 'owner'): ?>
            <!-- Owner Name (For Vets/Nurses) -->
            <div class="form-group">
                <label for="owner_name">Owner Name <span class="required">*</span></label>
                <div class="input-wrap">
                    <span class="icon" aria-hidden="true">👤</span>
                    <input type="text" id="owner_name" name="owner_name" placeholder="John Doe"
                           value="<?php echo htmlspecialchars($old['owner_name'] ?? ''); ?>"
                           class="<?php echo !empty($errors['owner_name']) ? 'is-invalid' : ''; ?>" required>
                </div>
            </div>

            <!-- Owner Phone (For Vets/Nurses) -->
            <div class="form-group">
                <label for="owner_phone">Owner Phone <span class="required">*</span></label>
                <div class="input-wrap">
                    <span class="icon" aria-hidden="true">📞</span>
                    <input type="text" id="owner_phone" name="owner_phone" placeholder="555-1234"
                           value="<?php echo htmlspecialchars($old['owner_phone'] ?? ''); ?>"
                           class="<?php echo !empty($errors['owner_phone']) ? 'is-invalid' : ''; ?>" required>
                </div>
            </div>
            <?php endif; ?>

            <button type="submit" class="btn-primary">Add Pet 🐾</button>
        </form>
        
        <div class="divider-text">
            <a href="?url=pet/listPets">Back to My Pets</a>
        </div>
    </div>
</main>

<?php require_once __DIR__ . '/../../views/layouts/footer.php'; ?>
