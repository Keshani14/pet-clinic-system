<?php
$pageTitle = 'My Pets\' Vaccinations — Furry Friends';
$bodyClass = 'dashboard-layout';
require_once __DIR__ . '/../../views/layouts/header.php';
?>

<div class="dashboard-wrapper">
    <?php require_once __DIR__ . '/../../views/layouts/owner_sidebar.php'; ?>
    <main class="main-content">
        <div class="card card--xl">
            <div class="card-header" style="background: linear-gradient(135deg, var(--pink-600), var(--pink-500)); padding: 40px;">
                <span class="paw-icon" aria-hidden="true">💉</span>
                <h1 style="color: white; margin-bottom: 10px;">Vaccination Records</h1>
                <p style="color: rgba(255,255,255,0.8);">Keep your pets protected and track their immunization history.</p>
            </div>
            
            <div class="card-body">
                <?php if (empty($pets)): ?>
                    <div class="empty-state">
                        <span class="icon-lg">🐾</span>
                        <p>No pets found. <a href="?url=pet/addPet">Register your first pet!</a></p>
                    </div>
                <?php else: ?>
                    <?php foreach ($pets as $pet): ?>
                        <section style="margin-bottom: 50px; border: 1px solid #fce7f3; border-radius: 16px; overflow: hidden;">
                            <div style="background: #fff5f5; padding: 20px; border-bottom: 1px solid #fce7f3; display: flex; justify-content: space-between; align-items: center;">
                                <h2 style="color: var(--pink-700); margin: 0; display: flex; align-items: center; gap: 10px;">
                                    <?php if (!empty($pet['photo'])): ?>
                                        <img src="<?php echo htmlspecialchars($pet['photo']); ?>" style="width: 40px; height: 40px; border-radius: 50%; object-fit: cover;">
                                    <?php else: ?>
                                        <span>🐶</span>
                                    <?php endif; ?>
                                    <?php echo htmlspecialchars($pet['name']); ?>'s Schedule
                                </h2>
                                <a href="?url=appointment/create&type=vaccination&pet_id=<?php echo $pet['id']; ?>" class="btn-pill btn-sm" style="background: var(--pink-600); color: white;">Book Vaccine +</a>
                            </div>

                            <div style="padding: 20px;">
                                <!-- Upcoming / Overdue -->
                                <h3 style="font-size: 0.9rem; text-transform: uppercase; letter-spacing: 1px; color: var(--gray-500); margin-bottom: 15px;">📅 Upcoming & Overdue</h3>
                                <?php if (empty($schedules[$pet['id']])): ?>
                                    <p class="text-gray-500" style="font-style: italic; padding-left: 10px;">No upcoming vaccinations scheduled.</p>
                                <?php else: ?>
                                    <div class="table-responsive">
                                        <table class="table">
                                            <thead>
                                                <tr>
                                                    <th>Vaccine Name</th>
                                                    <th>Due Date</th>
                                                    <th>Status</th>
                                                    <th>Action</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php foreach ($schedules[$pet['id']] as $sch): ?>
                                                    <?php if ($sch['status'] !== 'Completed'): ?>
                                                    <tr>
                                                        <td class="text-pink-bold"><?php echo htmlspecialchars($sch['vaccine_name']); ?></td>
                                                        <td><?php echo date('M d, Y', strtotime($sch['due_date'])); ?></td>
                                                        <td>
                                                            <?php if ($sch['status'] === 'Overdue'): ?>
                                                                <span class="badge" style="background: #fee2e2; color: #b91c1c;">Overdue</span>
                                                            <?php else: ?>
                                                                <span class="badge" style="background: #fef3c7; color: #92400e;">Upcoming</span>
                                                            <?php endif; ?>
                                                        </td>
                                                        <td>
                                                            <a href="?url=appointment/create&type=vaccination&pet_id=<?php echo $pet['id']; ?>&vaccine=<?php echo urlencode($sch['vaccine_name']); ?>&date=<?php echo urlencode($sch['due_date'] . ' 09:00'); ?>" class="btn-pill btn-sm" style="font-size: 0.8rem; padding: 4px 12px; background: #fff; border: 1px solid #fce7f3; color: var(--pink-600);">Book</a>
                                                        </td>
                                                    </tr>
                                                    <?php endif; ?>
                                                <?php endforeach; ?>
                                            </tbody>
                                        </table>
                                    </div>
                                <?php endif; ?>

                                <div class="divider-line" style="margin: 30px 0;"></div>

                                <!-- Completed History -->
                                <h3 style="font-size: 0.9rem; text-transform: uppercase; letter-spacing: 1px; color: var(--gray-500); margin-bottom: 15px;">✅ Vaccination History</h3>
                                <?php if (empty($history[$pet['id']])): ?>
                                    <p class="text-gray-500" style="font-style: italic; padding-left: 10px;">No completed vaccinations recorded yet.</p>
                                <?php else: ?>
                                    <div class="table-responsive">
                                        <table class="table">
                                            <thead>
                                                <tr>
                                                    <th>Vaccine</th>
                                                    <th>Date Given</th>
                                                    <th>Next Due</th>
                                                    <th>Source / Admin By</th>
                                                    <th>Notes</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php foreach ($history[$pet['id']] as $h): ?>
                                                    <tr>
                                                        <td style="font-weight: 600; color: #059669;">
                                                            <span style="margin-right: 5px;">💉</span>
                                                            <?php echo htmlspecialchars($h['vaccine_name']); ?>
                                                        </td>
                                                        <td><?php echo date('M d, Y', strtotime($h['date_given'])); ?></td>
                                                        <td style="color: var(--pink-600); font-weight: 500;"><?php echo $h['next_due_date'] ? date('M d, Y', strtotime($h['next_due_date'])) : '-'; ?></td>
                                                        <td>
                                                            <?php if ($h['source'] === 'Clinic'): ?>
                                                                <span class="badge" style="background: #ecfdf5; color: #059669; font-size: 0.7rem;">🏥 Clinic</span><br>
                                                                <small class="text-gray-500">Dr. <?php echo htmlspecialchars($h['vet_name']); ?></small>
                                                            <?php else: ?>
                                                                <span class="badge" style="background: #fdf2f8; color: #db2777; font-size: 0.7rem;">📜 Imported</span><br>
                                                                <small class="text-gray-500"><?php echo htmlspecialchars($h['vet_name']); ?></small>
                                                            <?php endif; ?>
                                                        </td>
                                                        <td><small class="text-gray-600"><?php echo htmlspecialchars($h['notes'] ?? '-'); ?></small></td>
                                                    </tr>
                                                <?php endforeach; ?>
                                            </tbody>
                                        </table>
                                    </div>
                                <?php endif; ?>
                            </div>
                        </section>
                    <?php endforeach; ?>
                <?php endif; ?>
            </div>
        </div>
    </main>
</div>

<?php require_once __DIR__ . '/../../views/layouts/footer.php'; ?>
