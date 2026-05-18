<?php
$pageTitle = 'Nurse Dashboard — PetSync';
$bodyClass = 'dashboard-layout';
require_once __DIR__ . '/../../views/layouts/header.php';
?>

<div class="dashboard-wrapper">
    <?php require_once __DIR__ . '/../../views/layouts/nurse_sidebar.php'; ?>
    <main class="main-content">
        <?php if (isset($_SESSION['flash_success'])): ?>
            <div class="alert alert-success" style="margin-bottom: 25px; border-radius: 12px; animation: slideDown 0.4s ease;">
                <?php echo $_SESSION['flash_success']; unset($_SESSION['flash_success']); ?>
            </div>
        <?php endif; ?>

        <?php if (isset($_SESSION['flash_error'])): ?>
            <div class="alert alert-danger" style="margin-bottom: 25px; border-radius: 12px;">
                <?php echo $_SESSION['flash_error']; unset($_SESSION['flash_error']); ?>
            </div>
        <?php endif; ?>

        <!-- 👤 Personalized Command Header -->
        <header class="dashboard-header mb-40" style="display: flex; justify-content: space-between; align-items: flex-start; gap: 30px; flex-wrap: wrap;">
            <div class="header-info">
                <h1 class="text-3xl font-900 text-gray-800">Clinical Overview</h1>
                <p class="text-gray-500">Monitoring patient flow at <span class="text-pink-600 font-700">PetSync</span></p>
            </div>

            <!-- 🔍 Quick Command Search -->
            <div class="search-command-wrapper" style="flex: 1; max-width: 450px; position: relative;">
                <input type="text" id="patient-search" placeholder="Quick find: Name or ID..." style="width: 100%; padding: 14px 20px 14px 50px; border-radius: 20px; border: 2px solid #f1f5f9; background: white; font-family: 'Nunito', sans-serif; font-weight: 700; box-shadow: 0 4px 15px rgba(0,0,0,0.02); transition: all 0.3s; outline: none;">
                <span style="position: absolute; left: 18px; top: 50%; transform: translateY(-50%); font-size: 1.2rem; opacity: 0.5;">🔍</span>
            </div>
            
            <div style="display: flex; align-items: center; gap: 20px;">
                <div class="notification-bell">
                    🔔 <span class="bell-dot"></span>
                </div>
                <div class="profile-pill" style="display: flex; align-items: center; gap: 15px; background: white; padding: 8px 20px; border-radius: 50px; border: 1px solid #f1f5f9; box-shadow: 0 4px 15px rgba(0,0,0,0.03);">
                    <div style="width: 45px; height: 45px; border-radius: 50%; overflow: hidden; border: 2px solid #fdf2f8;">
                        <?php if (Auth::photo()): ?>
                            <img src="<?php echo htmlspecialchars(Auth::photo()); ?>" style="width: 100%; height: 100%; object-fit: cover;" alt="Profile">
                        <?php else: ?>
                            <div style="width: 100%; height: 100%; background: #fdf2f8; display: flex; align-items: center; justify-content: center; font-size: 1.5rem;">👤</div>
                        <?php endif; ?>
                    </div>
                    <div>
                        <div class="font-800 text-gray-800" style="font-size: 0.95rem; line-height: 1.2;"><?php echo htmlspecialchars($name); ?></div>
                        <div class="text-pink-500 font-700" style="font-size: 0.75rem;">Nurse • Station A</div>
                    </div>
                </div>
            </div>
        </header>

        <!-- CSS for Pet Preview Tooltip -->
        <style>
            .pet-preview-trigger {
                cursor: help;
                border-bottom: 2px dashed var(--pink-200);
                padding-bottom: 2px;
                transition: all 0.2s;
                position: relative;
            }
            .pet-preview-trigger:hover {
                color: var(--pink-600);
                border-bottom-color: var(--pink-500);
            }
            
            .preview-tooltip {
                position: absolute;
                bottom: 120%;
                left: 0;
                width: 280px;
                background: rgba(255, 255, 255, 0.95);
                backdrop-filter: blur(10px);
                border: 1px solid var(--pink-100);
                border-radius: 20px;
                padding: 20px;
                box-shadow: 0 15px 40px rgba(219, 39, 119, 0.12);
                z-index: 1000;
                opacity: 0;
                visibility: hidden;
                transition: all 0.3s cubic-bezier(0.175, 0.885, 0.32, 1.275);
                transform: translateY(10px) scale(0.95);
                pointer-events: none;
                text-align: left;
            }
            
            .pet-preview-trigger:hover .preview-tooltip {
                opacity: 1;
                visibility: visible;
                transform: translateY(0) scale(1);
            }
            
            #patient-search:focus {
                border-color: var(--pink-400);
                box-shadow: 0 10px 25px rgba(219, 39, 119, 0.08);
                transform: translateY(-2px);
            }
            
            .row-hidden {
                display: none !important;
            }
        </style>
        
        <!-- 📐 Aesthetic Breathing Space -->
        <div style="height: 40px;"></div>

        <!-- 📊 High-Contrast Priority Stats -->
        <div class="summary-grid" style="grid-template-columns: repeat(4, 1fr); gap: 20px; margin-bottom: 40px;">
            <div class="summary-card" style="border-top-color: #3b82f6; background: #eff6ff;">
                <div class="stat-icon" style="background: #dbeafe; color: #1e40af;">📅</div>
                <div class="stat-details">
                    <h3>Today's Load</h3>
                    <div class="value" style="color: #1e40af;"><?php echo $stats['total_today']; ?></div>
                </div>
            </div>

            <div class="summary-card" style="border-top-color: #f59e0b; background: #fffbeb;">
                <div class="stat-icon" style="background: #fef3c7; color: #b45309;">⌛</div>
                <div class="stat-details">
                    <h3>Awaiting Prep</h3>
                    <div class="value" style="color: #b45309;"><?php echo $stats['pending']; ?></div>
                </div>
            </div>

            <div class="summary-card" style="border-top-color: #f97316; background: #fff7ed;">
                <div class="stat-icon" style="background: #ffedd5; color: #c2410c;">🏥</div>
                <div class="stat-details">
                    <h3>In Preparation</h3>
                    <div class="value" style="color: #c2410c;"><?php echo $stats['checked_in']; ?></div>
                </div>
            </div>

            <div class="summary-card" style="border-top-color: #10b981; background: #f0fdf4;">
                <div class="stat-icon" style="background: #dcfce7; color: #047857;">🎯</div>
                <div class="stat-details">
                    <h3>Ready for Vet</h3>
                    <div class="value" style="color: #047857;"><?php echo $stats['ready']; ?></div>
                </div>
            </div>
        </div>

        <!-- 🕒 Activity Timeline View -->
        <div class="card" style="border-radius: 32px; border: none; box-shadow: 0 20px 60px rgba(0,0,0,0.04); background: white; width: 100%; max-width: none;">
            <div class="card-body" style="padding: 40px;">
                <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 30px;">
                    <h2 class="text-gray-800 font-800" style="font-size: 1.5rem; display: flex; align-items: center; gap: 12px;">
                        <span style="background: white; padding: 10px; border-radius: 12px; box-shadow: 0 4px 10px rgba(0,0,0,0.05);">📑</span> 
                        Recent Activity (Today)
                    </h2>
                    <a href="?url=nurse/appointments" class="btn-pill" style="background: white; color: var(--pink-600); border: 1.5px solid var(--pink-100); font-weight: 800;">View Full Queue →</a>
                </div>

                <?php if (empty($recent)): ?>
                    <div class="empty-state" style="padding: 60px 0; background: white; border-radius: 20px;">
                        <div style="font-size: 4rem; margin-bottom: 20px;">☕</div>
                        <h3 class="text-gray-800">Quiet for now...</h3>
                        <p class="text-gray-500">No activity recorded for today yet.</p>
                    </div>
                <?php else: ?>
                    <div class="table-responsive">
                        <table class="table table-hover" id="activity-table">
                            <thead>
                                <tr style="background: #f8fafc;">
                                    <th style="padding: 15px 20px;">Pet & Owner</th>
                                    <th>Time</th>
                                    <th>Current Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($recent as $appt): ?>
                                    <tr class="activity-row">
                                        <td style="padding: 20px;">
                                            <div style="display: flex; align-items: center; gap: 15px;">
                                                <div style="width: 45px; height: 45px; background: #f1f5f9; border-radius: 12px; display: flex; align-items: center; justify-content: center; font-size: 1.2rem;">🐾</div>
                                                <div>
                                                    <span class="pet-preview-trigger">
                                                        <strong class="text-gray-800 search-target-name"><?php echo htmlspecialchars($appt['pet_name_display']); ?></strong>
                                                        <div class="preview-tooltip">
                                                            <div style="font-weight: 900; color: var(--pink-600); margin-bottom: 10px; border-bottom: 1px solid var(--pink-50); padding-bottom: 5px;">🐾 Patient Snapshot</div>
                                                            <div style="display: grid; grid-template-columns: 80px 1fr; gap: 8px; font-size: 0.85rem; color: #475569;">
                                                                <span style="font-weight: 800; color: #94a3b8;">Species:</span> <strong><?php echo htmlspecialchars($appt['display_type']); ?></strong>
                                                                <span style="font-weight: 800; color: #94a3b8;">Age:</span> <strong><?php echo htmlspecialchars($appt['pet_age'] ?? 'Unknown'); ?> yrs</strong>
                                                                <span style="font-weight: 800; color: #94a3b8;">ID:</span> <strong class="search-target-id">#PET-<?php echo str_pad($appt['pet_id'], 4, '0', STR_PAD_LEFT); ?></strong>
                                                            </div>
                                                            <div style="margin-top: 12px; padding-top: 10px; border-top: 1px solid #f1f5f9;">
                                                                <div style="font-weight: 800; color: #94a3b8; font-size: 0.75rem; text-transform: uppercase; margin-bottom: 5px;">Medical Notes</div>
                                                                <div style="font-size: 0.8rem; line-height: 1.4; color: #64748b; italic"><?php echo htmlspecialchars($appt['reason'] ?? 'Routine checkup'); ?></div>
                                                            </div>
                                                        </div>
                                                    </span>
                                                    <br>
                                                    <span class="text-gray-500" style="font-size: 0.85rem;">Owner: <?php echo htmlspecialchars($appt['owner_name']); ?></span>
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            <span style="font-weight: 700; color: #475569;"><?php echo date('h:i A', strtotime($appt['appointment_date'])); ?></span>
                                        </td>
                                        <td>
                                            <?php if ($appt['status'] === 'ready'): ?>
                                                <a href="?url=nurse/prepare/<?php echo $appt['id']; ?>" class="status-badge-premium badge-ready" style="text-decoration: none; display: inline-flex; background: #ecfdf5; color: #059669; border: 1.5px solid #a7f3d0; padding: 6px 14px; border-radius: 50px; font-weight: 800; font-size: 0.75rem;">Ready for Vet 🔗</a>
                                            <?php elseif ($appt['status'] === 'checked-in'): ?>
                                                <span class="status-badge-premium" style="display: inline-flex; background: #fff7ed; color: #c2410c; border: 1.5px solid #ffedd5; padding: 6px 14px; border-radius: 50px; font-weight: 800; font-size: 0.75rem;">In Preparation</span>
                                            <?php elseif ($appt['status'] === 'confirmed'): ?>
                                                <span class="status-badge-premium" style="display: inline-flex; background: #eff6ff; color: #1e40af; border: 1.5px solid #dbeafe; padding: 6px 14px; border-radius: 50px; font-weight: 800; font-size: 0.75rem;">Confirmed</span>
                                            <?php elseif ($appt['status'] === 'completed'): ?>
                                                <span class="status-badge-premium" style="display: inline-flex; background: #f0fdf4; color: #16a34a; border: 1.5px solid #bbf7d0; padding: 6px 14px; border-radius: 50px; font-weight: 900; font-size: 0.75rem;">Completed</span>
                                            <?php else: ?>
                                                <span class="badge" style="background: #f1f5f9; color: #475569; padding: 6px 14px; border-radius: 50px; font-weight: 800; font-size: 0.75rem;"><?php echo ucfirst($appt['status']); ?></span>
                                            <?php endif; ?>
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

<script>
document.addEventListener('DOMContentLoaded', function() {
    const searchInput = document.getElementById('patient-search');
    const tableRows = document.querySelectorAll('.activity-row');

    searchInput.addEventListener('input', function(e) {
        const term = e.target.value.toLowerCase().trim();
        
        tableRows.forEach(row => {
            const name = row.querySelector('.search-target-name').textContent.toLowerCase();
            const id = row.querySelector('.search-target-id').textContent.toLowerCase();
            
            if (name.includes(term) || id.includes(term)) {
                row.classList.remove('row-hidden');
            } else {
                row.classList.add('row-hidden');
            }
        });
    });
});
</script>

<?php require_once __DIR__ . '/../../views/layouts/footer.php'; ?>
