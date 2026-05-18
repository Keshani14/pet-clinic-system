<?php
$pageTitle = 'Owner Dashboard — Furry Friends';
$bodyClass = 'dashboard-layout';
require_once __DIR__ . '/../../views/layouts/header.php';

// Calculate active alerts/status
$activeAlertCount = count($reminders);
$hasAlerts = $activeAlertCount > 0;
?>

<div class="dashboard-wrapper" style="background: linear-gradient(180deg, #faf9fb 0%, #f5f1f8 40%, #ede9f5 100%); min-height: 100vh;">
    <?php require_once __DIR__ . '/../../views/layouts/owner_sidebar.php'; ?>
    
    <main class="main-content" style="padding: 50px 45px; max-width: 1700px; margin: 0 auto; width: 100%; box-sizing: border-box;">
        <!-- ✨ Luxury Personalized Header -->
        <header class="dashboard-header" style="display: flex; justify-content: space-between; align-items: center; background: linear-gradient(135deg, rgba(255, 255, 255, 0.95) 0%, rgba(255, 248, 250, 0.9) 100%); backdrop-filter: blur(40px); padding: 40px 55px; border-radius: 50px; border: 2px solid rgba(219, 39, 119, 0.08); box-shadow: 0 25px 70px rgba(219, 39, 119, 0.08), 0 8px 25px rgba(0, 0, 0, 0.02); margin-bottom: 50px; flex-wrap: wrap; gap: 30px; animation: slideUp 0.6s cubic-bezier(0.16, 1, 0.3, 1);">
            <div style="display: flex; align-items: center; gap: 28px; flex: 1; min-width: 300px;">
                <div style="background: linear-gradient(135deg, #db2777, #f472b6); width: 76px; height: 76px; border-radius: 28px; display: flex; align-items: center; justify-content: center; font-size: 2.2rem; box-shadow: 0 16px 40px rgba(219, 39, 119, 0.28); animation: pulseGlow 3s infinite alternate; flex-shrink: 0;">🏠</div>
                <div>
                    <h1 style="margin: 0; font-size: 2.8rem; font-weight: 900; color: #1e293b; letter-spacing: -1.5px; line-height: 1.1; background: linear-gradient(135deg, #1e293b 0%, #db2777 100%); -webkit-background-clip: text; -webkit-text-fill-color: transparent; background-clip: text;">Welcome, <?php echo htmlspecialchars(explode(' ', trim($name))[0]); ?></h1>
                    <p style="margin: 10px 0 0; color: #64748b; font-weight: 600; font-size: 1.1rem; letter-spacing: -0.3px;">Let's keep your furry family <span style="color: #db2777; font-weight: 800;">happy & healthy</span></p>
                </div>
            </div>
            
            <!-- High-end Member status -->
            <div style="display: flex; align-items: center; gap: 28px; flex-wrap: wrap;">
                <div style="text-align: right;">
                    <div style="font-size: 0.7rem; font-weight: 800; color: #94a3b8; text-transform: uppercase; letter-spacing: 1.2px; margin-bottom: 8px;">Membership Tier</div>
                    <div class="platinum-badge" style="background: linear-gradient(135deg, #fff5f8, #ffe4ef); padding: 10px 24px; border-radius: 50px; border: 2px solid #fce7f3; font-size: 0.85rem; font-weight: 900; color: #db2777; display: inline-flex; align-items: center; gap: 8px; box-shadow: 0 10px 30px rgba(219, 39, 119, 0.1); transition: all 0.35s cubic-bezier(0.16, 1, 0.3, 1); cursor: pointer;">
                        <span style="font-size: 1.1rem; animation: diamondShine 2s infinite alternate;">💎</span> Platinum
                    </div>
                </div>
                <div style="width: 70px; height: 70px; border-radius: 50%; overflow: hidden; border: 4px solid white; box-shadow: 0 12px 35px rgba(219, 39, 119, 0.15); flex-shrink: 0;">
                    <?php if (Auth::photo()): ?>
                        <img src="<?php echo htmlspecialchars(Auth::photo()); ?>" style="width: 100%; height: 100%; object-fit: cover;" alt="Profile">
                    <?php else: ?>
                        <div style="width: 100%; height: 100%; background: linear-gradient(135deg, #fff5f8, #fce7f3); display: flex; align-items: center; justify-content: center; font-size: 2rem; font-weight: 800; color: #db2777;">👤</div>
                    <?php endif; ?>
                </div>
            </div>
        </header>

        <!-- 📊 Stat Highlights Deck -->
        <div class="stat-deck" style="display: grid; grid-template-columns: repeat(4, 1fr); gap: 28px; margin-bottom: 55px; animation: slideUp 0.6s cubic-bezier(0.16, 1, 0.3, 1) both; animation-delay: 0.1s;">
            <div class="stat-deck-card" style="background: linear-gradient(135deg, #ffffff 0%, #fafafe 100%); border-radius: 35px; padding: 28px 32px; box-shadow: 0 12px 40px rgba(0,0,0,0.03); border: 1.5px solid rgba(219, 39, 119, 0.05); display: flex; align-items: center; gap: 20px; transition: all 0.35s cubic-bezier(0.16, 1, 0.3, 1);">
                <div style="background: linear-gradient(135deg, #fff1f2, #ffeef5); color: #db2777; width: 68px; height: 68px; border-radius: 22px; display: flex; align-items: center; justify-content: center; font-size: 1.8rem;">🐾</div>
                <div>
                    <div style="font-size: 0.75rem; font-weight: 800; color: #94a3b8; text-transform: uppercase; letter-spacing: 0.8px; margin-bottom: 4px;">Family Roster</div>
                    <div style="font-size: 2.2rem; font-weight: 900; color: #1e293b; margin-top: 2px;"><?php echo count($pets); ?></div>
                </div>
            </div>
            
            <div class="stat-deck-card" style="background: linear-gradient(135deg, #ffffff 0%, #fafafe 100%); border-radius: 35px; padding: 28px 32px; box-shadow: 0 12px 40px rgba(0,0,0,0.03); border: 1.5px solid rgba(219, 39, 119, 0.05); display: flex; align-items: center; gap: 20px; transition: all 0.35s cubic-bezier(0.16, 1, 0.3, 1);">
                <div style="background: <?php echo $hasAlerts ? 'linear-gradient(135deg, #fffbeb, #ffedd5)' : 'linear-gradient(135deg, #f0fdf4, #f1fde0)'; ?>; color: <?php echo $hasAlerts ? '#b45309' : '#16a34a'; ?>; width: 68px; height: 68px; border-radius: 22px; display: flex; align-items: center; justify-content: center; font-size: 1.8rem; position: relative;">
                    <?php if ($hasAlerts): ?>
                        <span style="position: absolute; top: -5px; right: -5px; width: 14px; height: 14px; background: #f59e0b; border-radius: 50%; border: 3px solid white; animation: pulseAmber 1.5s infinite;"></span>
                    <?php endif; ?>
                    💉
                </div>
                <div>
                    <div style="font-size: 0.75rem; font-weight: 800; color: #94a3b8; text-transform: uppercase; letter-spacing: 0.8px; margin-bottom: 4px;">Active Reminders</div>
                    <div style="font-size: 2.2rem; font-weight: 900; color: #1e293b; margin-top: 2px;"><?php echo $activeAlertCount; ?></div>
                </div>
            </div>
            
            <div class="stat-deck-card" style="background: linear-gradient(135deg, #ffffff 0%, #fafafe 100%); border-radius: 35px; padding: 28px 32px; box-shadow: 0 12px 40px rgba(0,0,0,0.03); border: 1.5px solid rgba(219, 39, 119, 0.05); display: flex; align-items: center; gap: 20px; transition: all 0.35s cubic-bezier(0.16, 1, 0.3, 1);">
                <div style="background: linear-gradient(135deg, #eef2ff, #e0e7ff); color: #6366f1; width: 68px; height: 68px; border-radius: 22px; display: flex; align-items: center; justify-content: center; font-size: 1.8rem;">📅</div>
                <div>
                    <div style="font-size: 0.75rem; font-weight: 800; color: #94a3b8; text-transform: uppercase; letter-spacing: 0.8px; margin-bottom: 4px;">Scheduled Visits</div>
                    <div style="font-size: 2.2rem; font-weight: 900; color: #1e293b; margin-top: 2px;"><?php echo count($appointments); ?></div>
                </div>
            </div>
            
            <div class="stat-deck-card" style="background: linear-gradient(135deg, #ffffff 0%, #fafafe 100%); border-radius: 35px; padding: 28px 32px; box-shadow: 0 12px 40px rgba(0,0,0,0.03); border: 1.5px solid rgba(219, 39, 119, 0.05); display: flex; align-items: center; gap: 20px; transition: all 0.35s cubic-bezier(0.16, 1, 0.3, 1);">
                <div style="background: linear-gradient(135deg, #ecfdf5, #e1f9f0); color: #10b981; width: 68px; height: 68px; border-radius: 22px; display: flex; align-items: center; justify-content: center; font-size: 1.8rem;">❤️</div>
                <div>
                    <div style="font-size: 0.75rem; font-weight: 800; color: #94a3b8; text-transform: uppercase; letter-spacing: 0.8px; margin-bottom: 4px;">Wellness Status</div>
                    <div style="font-size: 1.4rem; font-weight: 900; color: #10b981; margin-top: 2px; text-transform: uppercase; letter-spacing: 0.5px;">Optimal</div>
                </div>
            </div>
        </div>

        <!-- 🐾 Enlarged Pet Profile Cards (Hierarchy Upgrade) -->
        <section class="mb-45" style="animation: slideUp 0.6s cubic-bezier(0.16, 1, 0.3, 1) both; animation-delay: 0.2s;">
            <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 32px; padding: 0 5px;">
                <h2 style="font-size: 1.9rem; font-weight: 900; color: #1e293b; margin: 0; display: flex; align-items: center; gap: 16px; letter-spacing: -0.8px;">
                    <span style="background: linear-gradient(135deg, #fff1f2, #ffeef5); color: #db2777; width: 52px; height: 52px; border-radius: 16px; display: flex; align-items: center; justify-content: center; font-size: 1.5rem;">🐾</span>
                    My Furry Family
                </h2>
                <a href="?url=pet/addPet" class="btn-pill" style="padding: 13px 28px; font-size: 0.85rem; background: linear-gradient(135deg, #db2777, #f472b6); color: white; border: none; font-weight: 900; box-shadow: 0 8px 25px rgba(219, 39, 119, 0.25); border-radius: 50px; text-decoration: none; transition: all 0.35s cubic-bezier(0.16, 1, 0.3, 1); letter-spacing: 0.5px;">+ Add Member</a>
            </div>

            <div class="pet-cards-grid" style="display: grid; grid-template-columns: repeat(auto-fill, minmax(380px, 1fr)); gap: 45px;">
                <?php if (empty($pets)): ?>
                    <div style="grid-column: 1 / -1; padding: 100px 50px; background: linear-gradient(135deg, #ffffff 0%, #fafafe 100%); border-radius: 45px; text-align: center; box-shadow: 0 18px 50px rgba(0,0,0,0.02); border: 2.5px dashed rgba(219, 39, 119, 0.1);">
                        <div style="font-size: 5.5rem; margin-bottom: 28px; opacity: 0.15;">🐾</div>
                        <h3 style="color: #1e293b; font-weight: 900; font-size: 1.7rem; letter-spacing: -0.8px;">No family members yet</h3>
                        <p style="color: #64748b; font-weight: 700; font-size: 1.05rem; margin: 15px 0 30px;">Add your first pet to start scheduling visits and tracking health!</p>
                        <a href="?url=pet/addPet" class="btn-pill" style="padding: 14px 32px; font-weight: 900; background: linear-gradient(135deg, #db2777, #f472b6); color: white; border: none; border-radius: 50px; text-decoration: none; transition: all 0.3s; display: inline-block; box-shadow: 0 8px 25px rgba(219, 39, 119, 0.25);">Register Pet +</a>
                    </div>
                <?php else: ?>
                    <?php foreach ($pets as $pet): 
                        // Check if this pet has active reminders
                        $petHasReminders = false;
                        foreach ($reminders as $rem) {
                            if ($rem['pet_name'] === $pet['name']) {
                                $petHasReminders = true;
                                break;
                            }
                        }
                    ?>
                        <div class="pet-card-premium-enlarged" style="background: linear-gradient(135deg, #ffffff 0%, #fafafe 100%); border-radius: 42px; padding: 32px; box-shadow: 0 18px 50px rgba(0,0,0,0.02); transition: all 0.4s cubic-bezier(0.16, 1, 0.3, 1); border: 1.5px solid rgba(219, 39, 119, 0.05); position: relative; overflow: hidden; display: flex; flex-direction: column; justify-content: space-between; min-height: 320px;">
                            <div style="display: flex; gap: 24px; align-items: flex-start; margin-bottom: 28px;">
                                <!-- Photo Frame -->
                                <div class="pet-photo-wrapper" style="width: 110px; height: 110px; border-radius: 32px; overflow: hidden; border: 4px solid #fff5f8; box-shadow: 0 12px 32px rgba(219, 39, 119, 0.08); transition: transform 0.4s cubic-bezier(0.16, 1, 0.3, 1); flex-shrink: 0;">
                                    <?php if (!empty($pet['photo'])): ?>
                                        <img src="/pet_clinic/public/<?php echo htmlspecialchars($pet['photo']); ?>" style="width: 100%; height: 100%; object-fit: cover;" alt="Pet Photo">
                                    <?php else: ?>
                                        <div style="width: 100%; height: 100%; background: linear-gradient(135deg, #fff1f2, #ffeef5); display: flex; align-items: center; justify-content: center; font-size: 2.5rem;">🐾</div>
                                    <?php endif; ?>
                                </div>
                                
                                <div style="flex-grow: 1;">
                                    <h4 style="margin: 0; font-size: 1.6rem; font-weight: 900; color: #1e293b; letter-spacing: -0.8px; line-height: 1.2;"><?php echo htmlspecialchars($pet['name']); ?></h4>
                                    <div style="font-size: 0.85rem; color: #db2777; font-weight: 800; text-transform: uppercase; letter-spacing: 0.8px; margin-top: 6px;">
                                        <?php echo htmlspecialchars($pet['breed'] ?? 'Breed Unknown'); ?>
                                    </div>
                                    <div style="font-size: 0.8rem; color: #94a3b8; font-weight: 700; margin-top: 4px;">
                                        <?php echo htmlspecialchars($pet['type']); ?> • <?php echo htmlspecialchars($pet['age']); ?>
                                    </div>
                                </div>
                            </div>
                            
                            <!-- Health Badge & Action Row -->
                            <div>
                                <div style="margin-bottom: 22px;">
                                    <?php if ($petHasReminders): ?>
                                        <div style="display: inline-flex; align-items: center; gap: 8px; background: linear-gradient(135deg, #fffbeb, #ffedd5); padding: 10px 20px; border-radius: 50px; border: 1.5px solid #fef3c7; font-size: 0.8rem; font-weight: 900; color: #b45309; box-shadow: 0 5px 12px rgba(245,158,11,0.08);">
                                            <span style="width: 8px; height: 8px; border-radius: 50%; background: #f59e0b; animation: pulseAmber 1.5s infinite;"></span>
                                            Needs Attention
                                        </div>
                                    <?php else: ?>
                                        <div style="display: inline-flex; align-items: center; gap: 8px; background: linear-gradient(135deg, #ecfdf5, #e1f9f0); padding: 10px 20px; border-radius: 50px; border: 1.5px solid #dcfce7; font-size: 0.8rem; font-weight: 900; color: #047857; box-shadow: 0 5px 12px rgba(16,185,129,0.08);">
                                            <span style="width: 8px; height: 8px; border-radius: 50%; background: #10b981;"></span>
                                            Up-to-Date ✓
                                        </div>
                                    <?php endif; ?>
                                </div>

                                <!-- Action Buttons -->
                                <div style="display: flex; gap: 12px; width: 100%;">
                                    <a href="?url=appointment/create&pet_id=<?php echo $pet['id']; ?>" class="pet-action-btn pet-btn-book" style="flex: 1; text-align: center; text-decoration: none; font-weight: 900; font-size: 0.85rem; padding: 12px 15px; border-radius: 22px; border: 2px solid #db2777; background: white; color: #db2777; display: inline-flex; align-items: center; justify-content: center; gap: 6px; transition: all 0.35s cubic-bezier(0.16, 1, 0.3, 1);">
                                        🗓️ Book
                                    </a>
                                    <a href="?url=medical/viewHistory&pet_id=<?php echo $pet['id']; ?>" class="pet-action-btn pet-btn-records" style="flex: 1; text-align: center; text-decoration: none; font-weight: 900; font-size: 0.85rem; padding: 12px 15px; border-radius: 22px; background: linear-gradient(135deg, #1e293b, #334155); color: white; display: inline-flex; align-items: center; justify-content: center; gap: 6px; transition: all 0.35s cubic-bezier(0.16, 1, 0.3, 1); box-shadow: 0 6px 18px rgba(30, 41, 59, 0.12);">
                                        📋 Records
                                    </a>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php endif; ?>
            </div>
        </section>

        <!-- 📅 Upcoming Visits Calendar Grid & Health Insights -->
        <div class="dashboard-split-grid" style="display: grid; grid-template-columns: 1fr; gap: 50px; align-items: start; margin-top: 65px; animation: slideUp 0.6s cubic-bezier(0.16, 1, 0.3, 1) both; animation-delay: 0.3s; width: 100%; min-width: 0;">
            <!-- Calendar Roster -->
            <div class="card upcoming-visits-card" style="background: linear-gradient(135deg, #ffffff 0%, #fafafe 100%); border-radius: 45px; border: 2px solid rgba(219, 39, 119, 0.08); box-shadow: 0 25px 70px rgba(219, 39, 119, 0.08), 0 8px 25px rgba(0, 0, 0, 0.02); overflow: hidden; transition: all 0.35s cubic-bezier(0.16, 1, 0.3, 1); width: 100%; max-width: none; min-width: 0; box-sizing: border-box;">
                <div style="padding: 40px 48px; border-bottom: 2px solid rgba(219, 39, 119, 0.05); display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 20px;">
                    <h2 style="font-size: 1.65rem; font-weight: 900; color: #1e293b; margin: 0; display: flex; align-items: center; gap: 16px; letter-spacing: -0.8px;">
                        <span style="background: linear-gradient(135deg, #eef2ff, #e0e7ff); color: #6366f1; width: 50px; height: 50px; border-radius: 14px; display: flex; align-items: center; justify-content: center; font-size: 1.4rem;">🗓️</span>
                        Upcoming Visits
                    </h2>
                    <a href="?url=appointment/create" class="btn-pill btn-approve" style="padding: 11px 24px; font-size: 0.85rem; font-weight: 900; background: linear-gradient(135deg, #db2777, #f472b6); color: white; border: none; border-radius: 50px; text-decoration: none; transition: all 0.35s; box-shadow: 0 8px 20px rgba(219, 39, 119, 0.2);">+ Book Visit</a>
                </div>
                
                <div class="card-body" style="padding: 30px 48px;">
                    <?php if (empty($appointments)): ?>
                        <div style="padding: 70px 30px; text-align: center;">
                            <div style="font-size: 4rem; margin-bottom: 22px; opacity: 0.12;">📅</div>
                            <h4 style="color: #1e293b; font-weight: 900; font-size: 1.35rem; letter-spacing: -0.5px;">All caught up!</h4>
                            <p style="color: #64748b; font-weight: 700; margin-top: 8px; font-size: 0.95rem;">No appointments scheduled. Keep your pets healthy with regular checkups!</p>
                        </div>
                    <?php else: ?>
                        <div class="upcoming-visits-list" style="display: flex; flex-direction: row; gap: 28px; flex-wrap: nowrap; align-items: flex-start; overflow-x: auto; overflow-y: hidden; padding-bottom: 10px; scroll-snap-type: x proximity; width: 100%; max-width: 100%; box-sizing: border-box;">
                            <?php foreach ($appointments as $appt): 
                                $dateObj = new DateTime($appt['appointment_date']);
                                $monthStr = strtoupper($dateObj->format('M'));
                                $dayStr = $dateObj->format('d');
                                $weekdayStr = $dateObj->format('l');
                                $timeStr = $dateObj->format('h:i A');
                                
                                // Color code statuses
                                $status = strtolower($appt['status'] ?? 'confirmed');
                                $statusLabel = ucfirst($status);
                                $statusStyles = 'background: linear-gradient(135deg, #eff6ff, #dbeafe); color: #1e40af; border: 1.5px solid #bfdbfe;'; // Default Confirmed / Checked-in
                                if ($status === 'completed') {
                                    $statusStyles = 'background: linear-gradient(135deg, #ecfdf5, #dcfce7); color: #047857; border: 1.5px solid #bbf7d0;';
                                } elseif ($status === 'pending') {
                                    $statusStyles = 'background: linear-gradient(135deg, #fffbeb, #ffedd5); color: #b45309; border: 1.5px solid #fef3c7;';
                                }
                            ?>
                                <div class="calendar-visit-row" style="background: linear-gradient(135deg, #f8fafc, #f5f7fb); border-radius: 28px; padding: 22px 24px; border: 1.5px solid rgba(219, 39, 119, 0.04); display: flex; flex-direction: column; align-items: center; justify-content: flex-start; transition: all 0.35s cubic-bezier(0.16, 1, 0.3, 1); gap: 16px; min-width: 280px; flex: 0 0 280px; text-align: center; scroll-snap-align: start;">
                                    <!-- Mini Calendar Badge -->
                                    <div class="calendar-badge" style="width: 74px; height: 82px; background: white; border-radius: 22px; overflow: hidden; box-shadow: 0 10px 28px rgba(0,0,0,0.05); border: 1.5px solid #e2e8f0; display: flex; flex-direction: column; text-align: center; transition: transform 0.35s cubic-bezier(0.16, 1, 0.3, 1);">
                                            <div style="background: linear-gradient(135deg, #db2777, #ec4899); color: white; font-size: 0.7rem; font-weight: 900; letter-spacing: 1px; padding: 5px 0; text-transform: uppercase;">
                                                <?php echo htmlspecialchars($monthStr); ?>
                                            </div>
                                            <div style="flex-grow: 1; display: flex; align-items: center; justify-content: center; font-size: 1.8rem; font-weight: 900; color: #1e293b; line-height: 1;">
                                                <?php echo htmlspecialchars($dayStr); ?>
                                            </div>
                                        </div>

                                    <!-- Patient Info -->
                                    <div style="width: 100%;">
                                        <div style="display: flex; align-items: center; justify-content: center; gap: 6px; margin-bottom: 6px;">
                                            <span style="font-size: 1.2rem;">🐶</span>
                                            <strong style="font-size: 1.1rem; font-weight: 900; color: #1e293b; letter-spacing: -0.3px;"><?php echo htmlspecialchars($appt['pet_name_display']); ?></strong>
                                        </div>
                                        <div style="font-size: 0.8rem; color: #64748b; font-weight: 700; margin-bottom: 10px;">
                                            <div style="color: #db2777; font-weight: 800; margin-bottom: 3px;"><?php echo htmlspecialchars($appt['appointment_type'] ?? 'Consultation'); ?></div>
                                            <div><?php echo htmlspecialchars($weekdayStr); ?> at <?php echo htmlspecialchars($timeStr); ?></div>
                                        </div>
                                    </div>
                                    
                                    <!-- Status Pill -->
                                    <div style="display: flex; align-items: center; justify-content: center; width: 100%;">
                                        <span class="visit-status-badge" style="<?php echo $statusStyles; ?> padding: 7px 16px; border-radius: 50px; font-size: 0.75rem; font-weight: 900; text-transform: uppercase; letter-spacing: 0.5px; display: inline-flex; align-items: center; gap: 5px; box-shadow: 0 4px 12px rgba(0,0,0,0.02);">
                                            <?php if ($status === 'confirmed'): ?>
                                                <span style="width: 6px; height: 6px; border-radius: 50%; background: #3b82f6; display: inline-block;"></span>
                                            <?php elseif ($status === 'pending'): ?>
                                                <span style="width: 6px; height: 6px; border-radius: 50%; background: #f59e0b; display: inline-block;"></span>
                                            <?php else: ?>
                                                <span style="width: 6px; height: 6px; border-radius: 50%; background: #10b981; display: inline-block;"></span>
                                            <?php endif; ?>
                                            <?php echo htmlspecialchars($statusLabel); ?>
                                        </span>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    <?php endif; ?>
                </div>
            </div>

            <!-- Health Summary Panel & Dynamic Tips Carousel -->
            <div style="display: flex; flex-direction: column; gap: 32px;">
                <!-- Card: Health Reminders -->
                <div class="card" style="background: linear-gradient(135deg, #ffffff 0%, #fafafe 100%); border-radius: 45px; padding: 40px; border: 2px solid rgba(219, 39, 119, 0.08); box-shadow: 0 25px 70px rgba(219, 39, 119, 0.08), 0 8px 25px rgba(0, 0, 0, 0.02); position: relative; overflow: hidden; transition: all 0.35s cubic-bezier(0.16, 1, 0.3, 1);">
                    <div style="position: absolute; top: -30px; right: -30px; background: linear-gradient(135deg, #fff1f2, #ffeef5); width: 140px; height: 140px; border-radius: 50%; opacity: 0.35;"></div>
                    <h3 style="font-size: 1.4rem; font-weight: 900; color: #1e293b; margin-bottom: 30px; position: relative; display: flex; align-items: center; gap: 14px; letter-spacing: -0.6px;">
                        <span style="background: linear-gradient(135deg, #fff1f2, #ffeef5); color: #db2777; width: 44px; height: 44px; border-radius: 14px; display: flex; align-items: center; justify-content: center; font-size: 1.3rem; box-shadow: 0 6px 16px rgba(219, 39, 119, 0.12);">💉</span>
                        Health Reminders
                    </h3>
                    
                    <?php if (empty($reminders)): ?>
                        <div style="padding: 45px 30px; text-align: center; background: linear-gradient(135deg, #ecfdf5, #dcfce7); border-radius: 32px; border: 2px solid #bbf7d0; box-shadow: 0 16px 35px rgba(16,185,129,0.08);">
                            <div style="font-size: 3rem; margin-bottom: 16px;">✅</div>
                            <div style="color: #047857; font-weight: 900; font-size: 1.1rem; letter-spacing: -0.4px;">All fully protected!</div>
                            <p style="color: #64748b; font-size: 0.85rem; font-weight: 700; margin: 8px 0 0;">Your pets are fully up to date.</p>
                        </div>
                    <?php else: ?>
                        <div style="display: flex; flex-direction: column; gap: 18px;">
                            <?php foreach (array_slice($reminders, 0, 3) as $reminder): ?>
                                <div class="reminder-card-hover" style="background: linear-gradient(135deg, #ffffff 0%, #fafafe 100%); padding: 24px; border-radius: 28px; border: 1.5px solid rgba(219, 39, 119, 0.08); transition: all 0.35s cubic-bezier(0.16, 1, 0.3, 1); position: relative; box-shadow: 0 6px 16px rgba(0,0,0,0.02);">
                                    <div style="display: flex; justify-content: space-between; align-items: flex-start; margin-bottom: 12px; gap: 10px;">
                                        <span style="font-weight: 900; color: #1e293b; font-size: 1.1rem; line-height: 1.2;"><?php echo htmlspecialchars($reminder['pet_name']); ?></span>
                                        <span style="font-size: 0.7rem; background: linear-gradient(135deg, #fffbeb, #ffedd5); color: #b45309; padding: 6px 14px; border-radius: 50px; font-weight: 900; text-transform: uppercase; letter-spacing: 0.7px; border: 1.5px solid #fef3c7; box-shadow: 0 4px 10px rgba(245,158,11,0.08); white-space: nowrap;">Booster</span>
                                    </div>
                                    <div style="font-size: 0.88rem; color: #475569; font-weight: 800; margin-bottom: 12px;"><?php echo htmlspecialchars($reminder['vaccine_name']); ?> Booster</div>
                                    <div style="font-size: 0.8rem; color: #94a3b8; font-weight: 800; display: flex; align-items: center; gap: 6px;">
                                        📅 <span style="color: #db2777; font-weight: 900;">Due: <?php echo date('M d, Y', strtotime($reminder['due_date'])); ?></span>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    <?php endif; ?>
                </div>

                <!-- 💡 Premium Engaging Health Tips Carousel Box with illustrations -->
                <div class="card health-tip-interactive-card" style="background: linear-gradient(135deg, #db2777 0%, #f472b6 100%); border-radius: 45px; padding: 38px; border: none; box-shadow: 0 22px 60px rgba(219, 39, 119, 0.22); color: white; position: relative; overflow: hidden; transition: all 0.4s cubic-bezier(0.16, 1, 0.3, 1);">
                    <!-- SVG Illustration Background -->
                    <div style="position: absolute; right: -30px; top: -30px; width: 160px; height: 160px; opacity: 0.1; pointer-events: none;">
                        <svg viewBox="0 0 100 100" fill="white">
                            <path d="M50 15 C40 15 35 25 35 35 C35 55 50 85 50 85 C50 85 65 55 65 35 C65 25 60 15 50 15 Z" />
                            <circle cx="50" cy="35" r="8" fill="#db2777" />
                        </svg>
                    </div>
                    
                    <h3 style="font-size: 1.3rem; font-weight: 900; margin-bottom: 18px; display: flex; align-items: center; gap: 12px; letter-spacing: -0.5px; position: relative; z-index: 2;">
                        <span style="font-size: 1.5rem;">💡</span> Wellness Tip
                    </h3>
                    
                    <!-- Carousel Slides container -->
                    <div style="min-height: 130px; display: flex; flex-direction: column; justify-content: space-between; position: relative; z-index: 2;">
                        <p id="health-tip-content" style="margin: 0; font-weight: 700; line-height: 1.65; opacity: 0.95; font-size: 0.95rem; transition: all 0.3s ease;">
                            Regular dental checkups can add up to 3 years to your pet's life. Book a dental screening today and keep those smiles bright!
                        </p>
                        
                        <!-- Carousel Dots & Actions -->
                        <div style="display: flex; align-items: center; justify-content: space-between; margin-top: 28px; gap: 15px;">
                            <div style="display: flex; gap: 6px;" id="carousel-dots">
                                <span class="tip-dot active-dot" data-index="0"></span>
                                <span class="tip-dot" data-index="1"></span>
                                <span class="tip-dot" data-index="2"></span>
                                <span class="tip-dot" data-index="3"></span>
                                <span class="tip-dot" data-index="4"></span>
                            </div>
                            
                            <div style="display: flex; gap: 10px;">
                                <button class="tip-nav-btn" id="prev-tip-btn" style="background: rgba(255, 255, 255, 0.18); border: 1.5px solid rgba(255, 255, 255, 0.3); width: 38px; height: 38px; border-radius: 50%; display: flex; align-items: center; justify-content: center; color: white; cursor: pointer; font-size: 0.95rem; transition: all 0.3s cubic-bezier(0.16, 1, 0.3, 1); font-weight: 800;">←</button>
                                <button class="tip-nav-btn" id="next-tip-btn" style="background: rgba(255, 255, 255, 0.18); border: 1.5px solid rgba(255, 255, 255, 0.3); width: 38px; height: 38px; border-radius: 50%; display: flex; align-items: center; justify-content: center; color: white; cursor: pointer; font-size: 0.95rem; transition: all 0.3s cubic-bezier(0.16, 1, 0.3, 1); font-weight: 800;">→</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
</div>

<!-- 📐 Custom Advanced Aesthetics & Micro-interactions CSS -->
<style>
    @keyframes pulseGlow {
        from { box-shadow: 0 12px 30px rgba(219, 39, 119, 0.25); transform: scale(1); }
        to { box-shadow: 0 16px 45px rgba(219, 39, 119, 0.4); transform: scale(1.03); }
    }
    
    @keyframes pulseAmber {
        0% { transform: scale(1); box-shadow: 0 0 0 0 rgba(245, 158, 11, 0.7); }
        70% { transform: scale(1.15); box-shadow: 0 0 0 10px rgba(245, 158, 11, 0); }
        100% { transform: scale(1); box-shadow: 0 0 0 0 rgba(245, 158, 11, 0); }
    }

    @keyframes diamondShine {
        from { filter: drop-shadow(0 0 3px rgba(219, 39, 119, 0.3)); transform: scale(1); }
        to { filter: drop-shadow(0 0 10px rgba(219, 39, 119, 0.7)); transform: scale(1.15); }
    }

    .platinum-badge:hover {
        background: linear-gradient(135deg, #ffeef5, #fce7f3) !important;
        transform: translateY(-3px);
        box-shadow: 0 16px 35px rgba(219, 39, 119, 0.18) !important;
    }

    .stat-deck-card:hover {
        transform: translateY(-8px);
        box-shadow: 0 24px 50px rgba(219, 39, 119, 0.08);
        border-color: rgba(219, 39, 119, 0.12);
        background: linear-gradient(135deg, #ffffff 0%, #fffbfd 100%);
    }

    /* Enlarged Pet Card Premium Styling */
    .pet-card-premium-enlarged:hover {
        transform: translateY(-12px);
        border-color: rgba(219, 39, 119, 0.15) !important;
        box-shadow: 0 35px 80px rgba(219, 39, 119, 0.12) !important;
    }
    
    .pet-card-premium-enlarged:hover .pet-photo-wrapper {
        transform: scale(1.08);
    }

    .pet-btn-book:hover {
        background: linear-gradient(135deg, #db2777, #f472b6) !important;
        color: white !important;
        border-color: transparent !important;
        transform: translateY(-3px);
        box-shadow: 0 8px 22px rgba(219, 39, 119, 0.22);
    }

    .pet-btn-records:hover {
        background: linear-gradient(135deg, #0f172a, #1e293b) !important;
        transform: translateY(-3px);
        box-shadow: 0 10px 28px rgba(30, 41, 59, 0.25);
    }

    /* Calendar row styling */
    .calendar-visit-row:hover {
        background: linear-gradient(135deg, #fdf2f8, #faf2f9) !important;
        border-color: rgba(219, 39, 119, 0.12) !important;
        transform: translateY(-4px);
        box-shadow: 0 14px 35px rgba(219, 39, 119, 0.08);
    }

    .calendar-visit-row:hover .calendar-badge {
        transform: scale(1.08);
        border-color: #fce7f3;
        box-shadow: 0 14px 35px rgba(219, 39, 119, 0.12);
    }

    .upcoming-visits-card {
        justify-self: stretch;
    }

    .upcoming-visits-list {
        scrollbar-width: thin;
        scrollbar-color: rgba(219, 39, 119, 0.35) transparent;
    }

    .upcoming-visits-list::-webkit-scrollbar {
        height: 8px;
    }

    .upcoming-visits-list::-webkit-scrollbar-track {
        background: transparent;
    }

    .upcoming-visits-list::-webkit-scrollbar-thumb {
        background: rgba(219, 39, 119, 0.25);
        border-radius: 999px;
    }

    .reminder-card-hover:hover {
        background: linear-gradient(135deg, #ffffff, #fafafe) !important;
        border-color: rgba(219, 39, 119, 0.12) !important;
        transform: translateX(6px);
        box-shadow: 0 10px 28px rgba(219, 39, 119, 0.08);
    }

    /* tip carousel dots */
    .tip-dot {
        width: 8px;
        height: 8px;
        border-radius: 50%;
        background: rgba(255, 255, 255, 0.35);
        display: inline-block;
        transition: all 0.35s cubic-bezier(0.16, 1, 0.3, 1);
        cursor: pointer;
    }

    .active-dot {
        background: white !important;
        width: 22px !important;
        border-radius: 4px !important;
    }

    .tip-nav-btn:hover {
        background: rgba(255, 255, 255, 0.35) !important;
        color: white !important;
        transform: scale(1.12);
    }

    .health-tip-interactive-card:hover {
        transform: translateY(-8px);
        box-shadow: 0 30px 80px rgba(219, 39, 119, 0.3);
    }

    .main-content > * {
        animation: slideUp 0.6s cubic-bezier(0.16, 1, 0.3, 1) both;
    }

    /* Enhanced Button Styles */
    .btn-pill {
        transition: all 0.35s cubic-bezier(0.16, 1, 0.3, 1);
    }

    .btn-pill:hover {
        transform: translateY(-2px);
        box-shadow: 0 12px 32px rgba(219, 39, 119, 0.28) !important;
    }

    /* ── Responsive Styling ── */
    @media (max-width: 1400px) {
        .main-content {
            padding: 40px 35px !important;
        }
    }

    @media (max-width: 1200px) {
        .dashboard-split-grid {
            grid-template-columns: 1fr !important;
        }
        
        .main-content {
            padding: 35px 30px !important;
        }
    }

    @media (max-width: 992px) {
        .stat-deck {
            grid-template-columns: repeat(2, 1fr) !important;
        }
        
        .dashboard-header {
            flex-direction: column !important;
            gap: 20px !important;
        }
    }

    @media (max-width: 768px) {
        .dashboard-header {
            padding: 28px 32px !important;
            margin-bottom: 35px !important;
        }
        
        .main-content {
            padding: 25px 18px !important;
        }
        
        .stat-deck {
            grid-template-columns: 1fr !important;
            gap: 18px !important;
            margin-bottom: 40px !important;
        }
        
        .pet-cards-grid {
            grid-template-columns: 1fr !important;
            gap: 24px !important;
        }
        
        .calendar-visit-row {
            padding: 18px 20px !important;
            flex-direction: column !important;
            flex-basis: 260px !important;
            min-width: 260px !important;
        }
        
        h1 {
            font-size: 2rem !important;
        }
        
        h2 {
            font-size: 1.4rem !important;
        }

        .dashboard-split-grid {
            gap: 30px !important;
        }

        .upcoming-visits-card .card-body {
            padding: 24px 24px 28px !important;
        }
    }

    @media (max-width: 480px) {
        .dashboard-header {
            padding: 24px 24px !important;
        }
        
        .main-content {
            padding: 18px 12px !important;
        }
        
        .stat-deck-card {
            padding: 22px 24px !important;
        }

        .upcoming-visits-card {
            border-radius: 32px !important;
        }

        .upcoming-visits-card .card-body {
            padding: 20px 18px 24px !important;
        }
        
        h1 {
            font-size: 1.7rem !important;
        }
        
        .stat-deck-card div:first-child {
            width: 58px !important;
            height: 58px !important;
            font-size: 1.6rem !important;
        }
    }
</style>

<!-- 🧠 Dynamic Interactive Health Tip Carousel System JavaScript -->
<script>
document.addEventListener('DOMContentLoaded', function() {
    const tips = [
        "Regular dental checkups can add up to 3 years to your pet's life. Book a dental screening today and keep those smiles bright!",
        "Keep your pet hydrated! Always supply fresh, clean water, especially during warm weather or after outdoor playtime.",
        "Ticks and fleas carry harmful infections. Administer monthly preventative care to protect your family members fully.",
        "Overfeeding can lead to obesity and heart conditions. Feed customized portions based on your pet's age and activity levels.",
        "Regular mental stimulation (like puzzle toys or scent walks) keeps dogs calm, reduces anxiety, and enhances behavior!"
    ];
    
    let currentTipIndex = 0;
    const tipEl = document.getElementById('health-tip-content');
    const prevBtn = document.getElementById('prev-tip-btn');
    const nextBtn = document.getElementById('next-tip-btn');
    const dotElements = document.querySelectorAll('.tip-dot');
    
    function updateTip(newIndex) {
        if (!tipEl) return;
        
        // Transition effect
        tipEl.style.opacity = 0;
        tipEl.style.transform = 'translateY(-10px)';
        
        setTimeout(() => {
            currentTipIndex = newIndex;
            tipEl.textContent = tips[currentTipIndex];
            
            // Update dots active class
            dotElements.forEach((dot, idx) => {
                if (idx === currentTipIndex) {
                    dot.classList.add('active-dot');
                } else {
                    dot.classList.remove('active-dot');
                }
            });
            
            // Fade back in
            tipEl.style.opacity = 0.95;
            tipEl.style.transform = 'translateY(0)';
        }, 250);
    }
    
    if (nextBtn && prevBtn) {
        nextBtn.addEventListener('click', function() {
            let nextIndex = (currentTipIndex + 1) % tips.length;
            updateTip(nextIndex);
        });
        
        prevBtn.addEventListener('click', function() {
            let prevIndex = (currentTipIndex - 1 + tips.length) % tips.length;
            updateTip(prevIndex);
        });
        
        dotElements.forEach((dot, index) => {
            dot.addEventListener('click', function() {
                updateTip(index);
            });
        });
    }
});
</script>

<?php require_once __DIR__ . '/../../views/layouts/footer.php'; ?>
