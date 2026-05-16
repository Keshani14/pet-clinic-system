<?php
$pageTitle = 'Owner Dashboard — Furry Friends';
$bodyClass = 'dashboard-layout';
require_once __DIR__ . '/../../views/layouts/header.php';
?>

<div class="dashboard-wrapper" style="background: linear-gradient(135deg, #fffcfd 0%, #fff0f5 100%); min-height: 100vh;">
    <?php require_once __DIR__ . '/../../views/layouts/owner_sidebar.php'; ?>
    
    <main class="main-content" style="padding: 40px; max-width: 1600px; margin: 0 auto; width: 100%;">
        <!-- ✨ Glassmorphic Welcome Header -->
        <header class="dashboard-header mb-40" style="display: flex; justify-content: space-between; align-items: center; background: rgba(255, 255, 255, 0.7); backdrop-filter: blur(20px); padding: 30px 45px; border-radius: 35px; border: 1px solid rgba(255, 255, 255, 0.8); box-shadow: 0 10px 40px rgba(0,0,0,0.02);">
            <div style="display: flex; align-items: center; gap: 20px;">
                <div style="background: linear-gradient(135deg, #db2777, #f472b6); width: 60px; height: 60px; border-radius: 20px; display: flex; align-items: center; justify-content: center; font-size: 1.8rem; box-shadow: 0 10px 25px rgba(219, 39, 119, 0.2);">🏡</div>
                <div>
                    <h1 style="margin: 0; font-size: 2.2rem; font-weight: 900; color: #1e293b; letter-spacing: -1.5px;">Welcome back, <?php echo explode(' ', trim($name))[0]; ?>!</h1>
                    <p style="margin: 0; color: #64748b; font-weight: 700; font-size: 1rem;">Managing your furry family at <span class="text-pink-500">Furry Friends</span></p>
                </div>
            </div>
            
            <div style="display: flex; align-items: center; gap: 25px;">
                <div style="text-align: right;">
                    <div style="font-size: 0.75rem; font-weight: 800; color: #94a3b8; text-transform: uppercase; letter-spacing: 1px;">Member Status</div>
                    <div style="color: #db2777; font-weight: 900; font-size: 1rem; display: flex; align-items: center; gap: 6px;">
                        <span style="background: #fdf2f8; padding: 4px 12px; border-radius: 50px; border: 1px solid #fce7f3;">💎 Platinum Member</span>
                    </div>
                </div>
                <div style="width: 55px; height: 55px; border-radius: 50%; overflow: hidden; border: 3px solid white; box-shadow: 0 5px 15px rgba(0,0,0,0.05);">
                    <?php if (Auth::photo()): ?>
                        <img src="<?php echo htmlspecialchars(Auth::photo()); ?>" style="width: 100%; height: 100%; object-fit: cover;" alt="Profile">
                    <?php else: ?>
                        <div style="width: 100%; height: 100%; background: #fdf2f8; display: flex; align-items: center; justify-content: center; font-size: 1.5rem;">👤</div>
                    <?php endif; ?>
                </div>
            </div>
        </header>

        <!-- 🐾 My Family Carousel (Interactive Pet Grid) -->
        <div class="mb-40">
            <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 25px; padding: 0 10px;">
                <h2 style="font-size: 1.6rem; font-weight: 900; color: #1e293b; margin: 0; display: flex; align-items: center; gap: 15px;">
                    <span style="background: #fdf2f8; color: #db2777; width: 45px; height: 45px; border-radius: 14px; display: flex; align-items: center; justify-content: center; font-size: 1.2rem;">🐾</span>
                    My Furry Family
                </h2>
                <a href="?url=pet/addPet" class="btn-pill" style="padding: 10px 20px; font-size: 0.85rem; background: #fff1f2; color: #db2777; border: 1.5px solid #fce7f3;">+ Add Family Member</a>
            </div>

            <div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(280px, 1fr)); gap: 30px;">
                <?php if (empty($pets)): ?>
                    <div style="grid-column: 1 / -1; padding: 60px; background: white; border-radius: 40px; text-align: center; box-shadow: 0 10px 30px rgba(0,0,0,0.02);">
                        <div style="font-size: 4rem; margin-bottom: 20px;">🐕</div>
                        <h3 style="color: #1e293b; font-weight: 800;">Your family list is empty</h3>
                        <p style="color: #64748b; font-weight: 600;">Add your first pet to start tracking their health journey!</p>
                    </div>
                <?php else: ?>
                    <?php foreach ($pets as $pet): ?>
                        <div class="pet-card-premium" style="background: white; border-radius: 35px; padding: 25px; box-shadow: 0 15px 45px rgba(0,0,0,0.03); transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275); cursor: pointer; border: 2px solid transparent;" onclick="window.location.href='?url=medical/viewHistory&pet_id=<?php echo $pet['id']; ?>'">
                            <div style="display: flex; align-items: center; gap: 20px; margin-bottom: 20px;">
                                <div style="width: 80px; height: 80px; border-radius: 25px; overflow: hidden; border: 3px solid #fdf2f8; box-shadow: 0 8px 20px rgba(0,0,0,0.05);">
                                    <?php if ($pet['photo']): ?>
                                        <img src="<?php echo htmlspecialchars($pet['photo']); ?>" style="width: 100%; height: 100%; object-fit: cover;" alt="Pet">
                                    <?php else: ?>
                                        <div style="width: 100%; height: 100%; background: #fdf2f8; display: flex; align-items: center; justify-content: center; font-size: 1.8rem;">🐾</div>
                                    <?php endif; ?>
                                </div>
                                <div>
                                    <h4 style="margin: 0; font-size: 1.25rem; font-weight: 900; color: #1e293b;"><?php echo htmlspecialchars($pet['name']); ?></h4>
                                    <div style="font-size: 0.8rem; color: #db2777; font-weight: 800; text-transform: uppercase; letter-spacing: 0.5px;"><?php echo htmlspecialchars($pet['type']); ?> • <?php echo htmlspecialchars($pet['breed']); ?></div>
                                </div>
                            </div>
                            <div style="display: flex; justify-content: space-between; align-items: center; background: #f8fafc; padding: 12px 20px; border-radius: 20px;">
                                <div style="font-size: 0.85rem; font-weight: 800; color: #64748b;">Health Status</div>
                                <div style="font-size: 0.85rem; font-weight: 900; color: #10b981;">Up-to-date ✅</div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php endif; ?>
            </div>
        </div>

        <div style="display: grid; grid-template-columns: 1fr 380px; gap: 40px; align-items: start;">
            <!-- 📅 Upcoming Schedule -->
            <div class="card" style="background: white; border-radius: 40px; border: none; box-shadow: 0 20px 60px rgba(0,0,0,0.03); overflow: hidden;">
                <div style="padding: 35px 45px; border-bottom: 2px solid #f8fafc; display: flex; justify-content: space-between; align-items: center;">
                    <h2 style="font-size: 1.4rem; font-weight: 900; color: #1e293b; margin: 0; display: flex; align-items: center; gap: 15px;">
                        <span style="background: #eef2ff; color: #6366f1; width: 40px; height: 40px; border-radius: 12px; display: flex; align-items: center; justify-content: center; font-size: 1.1rem;">🗓️</span>
                        Upcoming Visits
                    </h2>
                    <a href="?url=appointment/create" class="btn-pill btn-approve" style="padding: 10px 20px; font-size: 0.85rem;">Book New Visit +</a>
                </div>
                <div class="card-body" style="padding: 0;">
                    <?php if (empty($appointments)): ?>
                        <div style="padding: 60px; text-align: center;">
                            <div style="font-size: 3rem; margin-bottom: 15px;">☕</div>
                            <h4 style="color: #1e293b; font-weight: 800;">No scheduled visits</h4>
                            <p style="color: #64748b; font-weight: 600;">Your pets are all caught up!</p>
                        </div>
                    <?php else: ?>
                        <div class="table-responsive">
                            <table class="table" style="margin: 0;">
                                <tbody>
                                    <?php foreach ($appointments as $appt): ?>
                                        <tr style="transition: all 0.3s; border-bottom: 1px solid #f8fafc;">
                                            <td style="padding: 25px 45px;">
                                                <div style="display: flex; align-items: center; gap: 20px;">
                                                    <div style="width: 50px; height: 50px; background: #fff1f2; border-radius: 15px; display: flex; align-items: center; justify-content: center; font-size: 1.3rem;">🐶</div>
                                                    <div>
                                                        <div style="font-weight: 900; color: #1e293b; font-size: 1.1rem;"><?php echo htmlspecialchars($appt['pet_name_display']); ?></div>
                                                        <div style="font-size: 0.8rem; color: #94a3b8; font-weight: 800; text-transform: uppercase;"><?php echo htmlspecialchars($appt['appointment_type'] ?? 'Consultation'); ?></div>
                                                    </div>
                                                </div>
                                            </td>
                                            <td style="padding: 25px 20px;">
                                                <div style="font-weight: 800; color: #1e293b;"><?php echo date('D, M d', strtotime($appt['appointment_date'])); ?></div>
                                                <div style="font-size: 0.85rem; color: #db2777; font-weight: 800;"><?php echo date('h:i A', strtotime($appt['appointment_date'])); ?></div>
                                            </td>
                                            <td style="padding: 25px 45px; text-align: right;">
                                                <span style="background: #fdf2f8; color: #db2777; padding: 8px 20px; border-radius: 50px; font-size: 0.85rem; font-weight: 900; text-transform: uppercase; border: 1.5px solid rgba(219, 39, 119, 0.05);">Confirmed</span>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    <?php endif; ?>
                </div>
            </div>

            <!-- 🏥 Health Summary Panel -->
            <div style="display: flex; flex-direction: column; gap: 30px;">
                <div class="card" style="background: white; border-radius: 40px; padding: 35px; border: none; box-shadow: 0 20px 60px rgba(0,0,0,0.03); position: relative; overflow: hidden;">
                    <div style="position: absolute; top: -15px; right: -15px; background: #fdf2f8; width: 100px; height: 100px; border-radius: 50%; opacity: 0.5;"></div>
                    <h3 style="font-size: 1.1rem; font-weight: 900; color: #1e293b; margin-bottom: 25px; position: relative; display: flex; align-items: center; gap: 10px;">
                        <span style="background: #fff1f2; padding: 8px; border-radius: 10px;">💉</span>
                        Health Reminders
                    </h3>
                    
                    <?php if (empty($reminders)): ?>
                        <div style="padding: 20px; text-align: center; background: #f0fdf4; border-radius: 25px; border: 1px solid #dcfce7;">
                            <div style="font-size: 2rem; margin-bottom: 10px;">✅</div>
                            <div style="color: #16a34a; font-weight: 800; font-size: 0.9rem;">All pets are fully protected!</div>
                        </div>
                    <?php else: ?>
                        <div style="display: flex; flex-direction: column; gap: 15px;">
                            <?php foreach (array_slice($reminders, 0, 3) as $reminder): ?>
                                <div style="background: #f8fafc; padding: 18px; border-radius: 20px; border: 1px solid #f1f5f9;">
                                    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 8px;">
                                        <span style="font-weight: 900; color: #1e293b; font-size: 0.95rem;"><?php echo htmlspecialchars($reminder['pet_name']); ?></span>
                                        <span style="font-size: 0.75rem; color: #db2777; font-weight: 800; text-transform: uppercase; letter-spacing: 0.5px;">Upcoming</span>
                                    </div>
                                    <div style="font-size: 0.85rem; color: #64748b; font-weight: 700;"><?php echo htmlspecialchars($reminder['vaccine_name']); ?> Booster</div>
                                    <div style="margin-top: 10px; font-size: 0.8rem; color: #94a3b8; font-weight: 800; display: flex; align-items: center; gap: 6px;">
                                        📅 Due: <?php echo date('M d, Y', strtotime($reminder['due_date'])); ?>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    <?php endif; ?>
                </div>

                <!-- 💡 Clinic Tip Card -->
                <div class="card" style="background: linear-gradient(135deg, #db2777, #ec4899); border-radius: 40px; padding: 35px; border: none; box-shadow: 0 20px 60px rgba(219, 39, 119, 0.2); color: white;">
                    <h3 style="font-size: 1.1rem; font-weight: 900; margin-bottom: 15px; display: flex; align-items: center; gap: 10px;">
                        <span>💡</span> Health Tip
                    </h3>
                    <p style="margin: 0; font-weight: 700; line-height: 1.6; opacity: 0.9; font-size: 0.95rem;">
                        Regular dental checkups can add up to 3 years to your pet's life. Book a dental screening today and keep those smiles bright!
                    </p>
                    <button class="btn-pill" style="margin-top: 20px; background: white; color: #db2777; width: 100%; font-weight: 900; border: none;">Learn More</button>
                </div>
            </div>
        </div>
    </main>
</div>

<style>
    .pet-card-premium:hover {
        transform: translateY(-10px);
        border-color: #fce7f3;
        box-shadow: 0 30px 70px rgba(219, 39, 119, 0.08);
    }
    .main-content > * {
        animation: fadeIn 0.6s ease both;
    }
    @keyframes fadeIn {
        from { opacity: 0; transform: translateY(20px); }
        to { opacity: 1; transform: translateY(0); }
    }
</style>

<?php require_once __DIR__ . '/../../views/layouts/footer.php'; ?>
