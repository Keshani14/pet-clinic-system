<?php
$pageTitle = 'Vaccine Templates — Admin';
$bodyClass = 'dashboard-layout';
require_once __DIR__ . '/../../views/layouts/header.php';
?>

<div class="dashboard-wrapper">
    <?php require_once __DIR__ . '/../../views/layouts/admin_sidebar.php'; ?>

    <main class="main-content">
        <h1 class="text-gray-800 mb-20">🛡️ Vaccine Templates</h1>
        <p class="text-gray-600 mb-30">Manage global vaccination schedules for different pet types.</p>

        <div class="summary-grid mb-30">
            <div class="card card--lg" style="margin-left: 0;">
                <div class="card-header" style="background: linear-gradient(135deg, var(--pink-600), var(--pink-500)); color: white;">
                    <h2 style="font-size: 1.2rem; margin: 0;">Add New Template</h2>
                </div>
                <div class="card-body">
                    <form action="?url=vaccinetemplate/store" method="POST" class="modern-form">
                        <div class="form-row">
                            <div class="form-group">
                                <label>Pet Type</label>
                                <select name="pet_type" required>
                                    <option value="Dog">Dog</option>
                                    <option value="Cat">Cat</option>
                                    <option value="Rabbit">Rabbit</option>
                                    <option value="Bird">Bird</option>
                                    <option value="Hamster">Hamster</option>
                                    <option value="Exotic">Exotic</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label>Vaccine Name</label>
                                <input type="text" name="vaccine_name" required placeholder="e.g. Rabies">
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-group">
                                <label>Rec. Age (Weeks)</label>
                                <input type="number" name="recommended_age_weeks" required value="12">
                            </div>
                            <div class="form-group">
                                <label>Booster Interval (Months)</label>
                                <input type="number" name="booster_interval_months" value="12">
                            </div>
                        </div>
                        <div class="form-group">
                            <label>Description</label>
                            <textarea name="description" rows="2"></textarea>
                        </div>
                        <button type="submit" class="btn-pill btn-approve">Save Template</button>
                    </form>
                </div>
            </div>
        </div>

        <div class="card card--xl" style="margin-left: 0;">
            <div class="card-body" style="padding: 0;">
                <table class="table">
                    <thead>
                        <tr>
                            <th>Pet Type</th>
                            <th>Vaccine Name</th>
                            <th>Age (Weeks)</th>
                            <th>Booster (Mo)</th>
                            <th>Status</th>
                            <th class="text-right">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($templates as $t): ?>
                        <tr>
                            <td><span class="badge badge-vet"><?php echo htmlspecialchars($t['pet_type']); ?></span></td>
                            <td><strong><?php echo htmlspecialchars($t['vaccine_name']); ?></strong></td>
                            <td><?php echo $t['recommended_age_weeks']; ?> wks</td>
                            <td><?php echo $t['booster_interval_months'] > 0 ? $t['booster_interval_months'] . ' mo' : 'N/A'; ?></td>
                            <td><span class="status-dot <?php echo $t['is_active'] ? 'pulse-green' : 'pulse-red'; ?>"></span> Active</td>
                            <td class="text-right">
                                <a href="?url=vaccinetemplate/delete/<?php echo $t['id']; ?>" class="btn-pill" style="color: #ef4444; background: #fee2e2;" onclick="return confirm('Remove this template?')">Delete</a>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                        <?php if (empty($templates)): ?>
                        <tr>
                            <td colspan="6" class="text-center text-gray-500" style="padding: 40px;">No templates found. Add one above.</td>
                        </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </main>
</div>

<?php require_once __DIR__ . '/../../views/layouts/footer.php'; ?>
