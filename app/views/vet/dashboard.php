<?php
$pageTitle = 'Vet Dashboard — Furry Friends';
$bodyClass = 'dashboard-layout';
require_once __DIR__ . '/../../views/layouts/header.php';
?>

<div class="dashboard-wrapper" style="background: linear-gradient(135deg, #f8fafc 0%, #f1f5f9 100%); min-height: 100vh;">
    <?php require_once __DIR__ . '/../../views/layouts/vet_sidebar.php'; ?>

    <main class="main-content" style="padding: 40px; max-width: 1600px; margin: 0 auto; width: 100%;">
        <!-- ✨ Glassmorphic Command Header -->
        <header class="dashboard-header mb-40" style="display: flex; justify-content: space-between; align-items: flex-start; background: rgba(255, 255, 255, 0.7); backdrop-filter: blur(20px); padding: 35px 45px; border-radius: 35px; border: 1px solid rgba(255, 255, 255, 0.8); box-shadow: 0 10px 40px rgba(0,0,0,0.02);">
            <div style="display: flex; align-items: center; gap: 25px;">
                <div style="background: linear-gradient(135deg, #6366f1, #818cf8); width: 65px; height: 65px; border-radius: 22px; display: flex; align-items: center; justify-content: center; font-size: 2rem; box-shadow: 0 10px 25px rgba(99, 102, 241, 0.2);">🩺</div>
                <div>
                    <h1 style="margin: 0; font-size: 2.2rem; font-weight: 900; color: #1e293b; letter-spacing: -1.5px;">Clinical Command</h1>
                    <p style="margin: 0; color: #64748b; font-weight: 700; font-size: 1rem;">Welcome back, <span class="text-pink-600">Dr. <?php echo explode(' ', trim($name))[0]; ?></span></p>
                </div>
            </div>
            
            <div style="display: flex; align-items: center; gap: 20px;">
                <div style="text-align: right;">
                    <div style="font-size: 0.75rem; font-weight: 800; color: #94a3b8; text-transform: uppercase; letter-spacing: 1px;">Clinical Status</div>
                    <div style="color: #10b981; font-weight: 800; display: flex; align-items: center; gap: 6px; justify-content: flex-end;">
                        <span class="status-dot pulse-green"></span> Live & Connected
                    </div>
                </div>
                <div class="profile-pill" style="display: flex; align-items: center; gap: 15px; background: white; padding: 10px 25px; border-radius: 50px; border: 1px solid #f1f5f9; box-shadow: 0 4px 15px rgba(0,0,0,0.03);">
                    <div style="width: 48px; height: 48px; border-radius: 50%; overflow: hidden; border: 3px solid #fdf2f8;">
                        <?php if (Auth::photo()): ?>
                            <img src="<?php echo htmlspecialchars(Auth::photo()); ?>" style="width: 100%; height: 100%; object-fit: cover;" alt="Profile">
                        <?php else: ?>
                            <div style="width: 100%; height: 100%; background: #fdf2f8; display: flex; align-items: center; justify-content: center; font-size: 1.5rem;">👤</div>
                        <?php endif; ?>
                    </div>
                    <div style="text-align: left;">
                        <div style="font-weight: 900; color: #1e293b; font-size: 1rem; line-height: 1.2;"><?php echo htmlspecialchars($name); ?></div>
                        <div style="color: #6366f1; font-weight: 800; font-size: 0.75rem; text-transform: uppercase; letter-spacing: 0.5px;">VETERINARIAN</div>
                    </div>
                </div>
            </div>
        </header>

        <!-- 📊 High-Contrast Stat Deck -->
        <div style="display: grid; grid-template-columns: repeat(4, 1fr); gap: 30px; margin-bottom: 50px;">
            <div class="premium-stat-card" style="background: white; padding: 35px; border-radius: 35px; box-shadow: 0 10px 30px rgba(0,0,0,0.02); position: relative; overflow: hidden; border: 1.5px solid rgba(99, 102, 241, 0.05);">
                <div style="position: absolute; top: -15px; right: -15px; background: #eef2ff; width: 80px; height: 80px; border-radius: 50%; opacity: 0.5;"></div>
                <div style="color: #94a3b8; font-weight: 800; font-size: 0.75rem; text-transform: uppercase; letter-spacing: 1px; margin-bottom: 10px; position: relative;">Patients Waiting</div>
                <div id="waiting-count" style="font-size: 2.8rem; font-weight: 900; color: #6366f1; position: relative;"><?php echo $stats['waiting']; ?></div>
            </div>
            
            <div class="premium-stat-card" style="background: white; padding: 35px; border-radius: 35px; box-shadow: 0 10px 30px rgba(0,0,0,0.02); position: relative; overflow: hidden; border: 1.5px solid rgba(16, 185, 129, 0.05);">
                <div style="position: absolute; top: -15px; right: -15px; background: #ecfdf5; width: 80px; height: 80px; border-radius: 50%; opacity: 0.5;"></div>
                <div style="color: #94a3b8; font-weight: 800; font-size: 0.75rem; text-transform: uppercase; letter-spacing: 1px; margin-bottom: 10px; position: relative;">Consultations Done</div>
                <div id="completed-count" style="font-size: 2.8rem; font-weight: 900; color: #10b981; position: relative;"><?php echo $stats['completed_today']; ?></div>
            </div>

            <div class="premium-stat-card" style="background: white; padding: 35px; border-radius: 35px; box-shadow: 0 10px 30px rgba(0,0,0,0.02); position: relative; overflow: hidden; border: 1.5px solid rgba(249, 115, 22, 0.05);">
                <div style="position: absolute; top: -15px; right: -15px; background: #fff7ed; width: 80px; height: 80px; border-radius: 50%; opacity: 0.5;"></div>
                <div style="color: #94a3b8; font-weight: 800; font-size: 0.75rem; text-transform: uppercase; letter-spacing: 1px; margin-bottom: 10px; position: relative;">Average Prep Time</div>
                <div style="font-size: 2.8rem; font-weight: 900; color: #f97316; position: relative;">12<small style="font-size: 1.2rem; margin-left: 5px;">min</small></div>
            </div>

            <div class="premium-stat-card" style="background: linear-gradient(135deg, #6366f1, #4f46e5); padding: 35px; border-radius: 35px; box-shadow: 0 15px 35px rgba(99, 102, 241, 0.2); position: relative; overflow: hidden;">
                <div style="position: absolute; top: -15px; right: -15px; background: rgba(255,255,255,0.1); width: 100px; height: 100px; border-radius: 50%;"></div>
                <div style="color: rgba(255,255,255,0.8); font-weight: 800; font-size: 0.75rem; text-transform: uppercase; letter-spacing: 1px; margin-bottom: 10px; position: relative;">Clinic Load</div>
                <div style="font-size: 2.2rem; font-weight: 900; color: white; position: relative;">OPTIMAL</div>
                <div style="margin-top: 10px; height: 6px; background: rgba(255,255,255,0.2); border-radius: 10px; overflow: hidden;">
                    <div style="width: 65%; height: 100%; background: #10b981; border-radius: 10px;"></div>
                </div>
            </div>
        </div>

        <!-- 📋 Consultation Queue Table -->
        <div id="dashboard-queue" class="card" style="background: white; border-radius: 40px; border: none; box-shadow: 0 20px 60px rgba(0,0,0,0.03); overflow: hidden; width: 100%; max-width: none;">
            <div style="padding: 40px 50px; border-bottom: 2px solid #f8fafc; display: flex; justify-content: space-between; align-items: center;">
                <h2 style="font-size: 1.6rem; font-weight: 900; color: #1e293b; margin: 0; display: flex; align-items: center; gap: 15px;">
                    <span style="background: #eef2ff; color: #6366f1; width: 45px; height: 45px; border-radius: 14px; display: flex; align-items: center; justify-content: center; font-size: 1.2rem;">👨‍⚕️</span>
                    Ready for Consultation
                </h2>
                <?php if ($stats['waiting'] > 0): ?>
                    <span style="background: #fdf2f8; color: #db2777; padding: 10px 24px; border-radius: 50px; font-weight: 900; font-size: 0.85rem; border: 1.5px solid rgba(219, 39, 119, 0.1);">
                        Priority List: <?php echo $stats['waiting']; ?> waiting
                    </span>
                <?php endif; ?>
            </div>

            <div class="card-body" style="padding: 0;">
                <?php if (empty($waiting_list)): ?>
                    <div style="padding: 100px; text-align: center;">
                        <div style="font-size: 5rem; margin-bottom: 25px; opacity: 0.3;">☕</div>
                        <h3 style="color: #1e293b; font-weight: 800; margin-bottom: 12px; font-size: 1.5rem;">No patients waiting</h3>
                        <p style="color: #64748b; font-weight: 600; font-size: 1.1rem;">Take a short break! Your clinical queue is currently empty.</p>
                        <p style="color: #94a3b8; font-size: 0.9rem;">(New cases will appear here once prepared by nursing staff)</p>
                    </div>
                <?php else: ?>
                    <div class="table-responsive">
                        <table class="table" style="margin: 0; border: none;">
                            <thead style="background: #fdfdfd;">
                                <tr>
                                    <th style="padding: 25px 50px; color: #94a3b8; letter-spacing: 1px; font-weight: 800; text-transform: uppercase; font-size: 0.75rem;">Pet & Owner Identity</th>
                                    <th style="padding: 25px 20px; color: #94a3b8; letter-spacing: 1px; font-weight: 800; text-transform: uppercase; font-size: 0.75rem;">Clinical Vitals</th>
                                    <th style="padding: 25px 20px; color: #94a3b8; letter-spacing: 1px; font-weight: 800; text-transform: uppercase; font-size: 0.75rem;">Nurse Observations</th>
                                    <th style="padding: 25px 50px; color: #94a3b8; letter-spacing: 1px; font-weight: 800; text-transform: uppercase; font-size: 0.75rem; text-align: right;">Consultation</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($waiting_list as $appt): ?>
                                    <tr class="consultation-row" style="transition: all 0.3s; border-bottom: 1px solid #f8fafc;">
                                        <td style="padding: 30px 50px;">
                                            <div style="display: flex; align-items: center; gap: 20px;">
                                                <div style="width: 55px; height: 55px; background: #fff1f2; border-radius: 16px; display: flex; align-items: center; justify-content: center; font-size: 1.8rem; box-shadow: 0 8px 20px rgba(219, 39, 119, 0.05);">🐾</div>
                                                <div>
                                                    <div style="font-weight: 900; color: #1e293b; font-size: 1.2rem;"><?php echo htmlspecialchars($appt['pet_name_display']); ?></div>
                                                    <div style="font-size: 0.85rem; color: #db2777; font-weight: 800; text-transform: uppercase; letter-spacing: 0.5px;">Owner: <?php echo htmlspecialchars($appt['owner_name']); ?></div>
                                                </div>
                                            </div>
                                        </td>
                                        <td style="padding: 30px 20px;">
                                            <div style="display: flex; gap: 15px;">
                                                <div style="background: #f1f5f9; padding: 12px 18px; border-radius: 15px; border: 1px solid #e2e8f0;">
                                                    <div style="font-size: 0.7rem; color: #94a3b8; font-weight: 800; text-transform: uppercase; margin-bottom: 4px;">Weight</div>
                                                    <div style="font-weight: 900; color: #1e293b; font-size: 1.1rem;"><?php echo htmlspecialchars($appt['weight'] ?? '-'); ?> <small style="font-size: 0.7rem;">KG</small></div>
                                                </div>
                                                <div style="background: #fffcfd; padding: 12px 18px; border-radius: 15px; border: 1px solid #fce7f3;">
                                                    <div style="font-size: 0.7rem; color: #db2777; font-weight: 800; text-transform: uppercase; margin-bottom: 4px;">Temp</div>
                                                    <div style="font-weight: 900; color: #1e293b; font-size: 1.1rem;"><?php echo htmlspecialchars($appt['temperature'] ?? '-'); ?> <small style="font-size: 0.7rem;">°C</small></div>
                                                </div>
                                            </div>
                                        </td>
                                        <td style="padding: 30px 20px;">
                                            <div style="max-width: 350px;">
                                                <div style="font-weight: 800; color: #1e293b; font-size: 0.95rem; margin-bottom: 5px;">Symptoms: <span style="font-weight: 600; color: #64748b;"><?php echo htmlspecialchars($appt['symptoms'] ?? 'Routine'); ?></span></div>
                                                <div style="font-size: 0.85rem; color: #94a3b8; font-weight: 600; line-height: 1.5; font-style: italic;">
                                                    "<?php echo htmlspecialchars($appt['nurse_notes'] ?? 'No extra notes provided.'); ?>"
                                                </div>
                                            </div>
                                        </td>
                                        <td style="padding: 30px 50px; text-align: right;">
                                            <a href="?url=vet/consult/<?php echo $appt['id']; ?>" class="btn-pill btn-approve" style="padding: 14px 30px; font-weight: 900; box-shadow: 0 10px 20px rgba(16, 185, 129, 0.15);">Start Consultation 🩺</a>
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

<style>
    .status-dot { width: 10px; height: 10px; border-radius: 50%; background: #10b981; }
    .pulse-green { animation: pulseGreen 2s infinite; }
    @keyframes pulseGreen {
        0% { box-shadow: 0 0 0 0 rgba(16, 185, 129, 0.7); }
        70% { box-shadow: 0 0 0 10px rgba(16, 185, 129, 0); }
        100% { box-shadow: 0 0 0 0 rgba(16, 185, 129, 0); }
    }
    
    .consultation-row:hover {
        background: #fffcfd !important;
        transform: scale(1.002);
    }
    
    .premium-stat-card {
        transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
    }
    .premium-stat-card:hover {
        transform: translateY(-8px);
        box-shadow: 0 25px 50px rgba(0,0,0,0.06);
    }

    @keyframes fadeIn {
        from { opacity: 0; transform: translateY(20px); }
        to { opacity: 1; transform: translateY(0); }
    }
    .main-content > * {
        animation: fadeIn 0.6s ease both;
    }
</style>

<script>
// Real-time polling for Vet Dashboard
function refreshDashboard() {
    fetch('?url=vet/dashboard&ajax=1')
        .then(response => response.text())
        .then(html => {
            const parser = new DOMParser();
            const doc = parser.parseFromString(html, 'text/html');
            
            // Update stats
            const waitingCount = doc.getElementById('waiting-count');
            const completedCount = doc.getElementById('completed-count');
            const queue = doc.getElementById('dashboard-queue');
            
            if(waitingCount) document.getElementById('waiting-count').innerHTML = waitingCount.innerHTML;
            if(completedCount) document.getElementById('completed-count').innerHTML = completedCount.innerHTML;
            if(queue) document.getElementById('dashboard-queue').innerHTML = queue.innerHTML;
        })
        .catch(err => console.error('Dashboard refresh failed:', err));
}

// Poll every 5 seconds
setInterval(refreshDashboard, 5000);
</script>

<?php require_once __DIR__ . '/../../views/layouts/footer.php'; ?>
