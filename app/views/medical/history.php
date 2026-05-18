<?php
$pageTitle = 'Pet Record: ' . htmlspecialchars($pet['name']) . ' — PetSync';
$isVet = (Auth::role() === 'vet' || Auth::role() === 'admin');
$bodyClass = $isVet ? 'dashboard-layout' : '';
require_once __DIR__ . '/../../views/layouts/header.php';

// Mock/Fetch additional data for elite UI
$ownerEmail = 'jane.doe@email.com'; 
$ownerPhone = $pet['owner_phone'] ?? '+1 (555) 019-2834';
$ownerAddress = '123 Maple St, Austin, TX';
$microchipId = 'MC-88291-XX';
$allergies = ['PENICILLIN (SEVERE)'];
?>

<div class="dashboard-wrapper" style="background: linear-gradient(135deg, #f8fafc 0%, #f1f5f9 100%); min-height: 100vh;">
    <?php if ($isVet): ?>
        <?php require_once __DIR__ . '/../../views/layouts/vet_sidebar.php'; ?>
        <main class="main-content" style="padding: 40px; max-width: 1700px; margin: 0 auto; width: 100%;">
    <?php else: ?>
        <main class="main-content" style="padding: 40px; max-width: 1500px; margin: 0 auto; width: 100%;">
    <?php endif; ?>

        <!-- 🏷️ Elite Patient Identity Banner -->
        <header class="dashboard-header mb-40" style="display: flex; justify-content: space-between; align-items: center; background: rgba(255, 255, 255, 0.7); backdrop-filter: blur(20px); padding: 35px 45px; border-radius: 35px; border: 1px solid rgba(255, 255, 255, 0.8); box-shadow: 0 10px 40px rgba(0,0,0,0.02);">
            <div style="display: flex; align-items: center; gap: 30px;">
                <div style="width: 100px; height: 100px; border-radius: 50%; overflow: hidden; border: 4px solid white; box-shadow: 0 10px 25px rgba(0,0,0,0.1);">
                    <?php if ($pet['photo']): ?>
                        <img src="<?php echo htmlspecialchars($pet['photo']); ?>" style="width: 100%; height: 100%; object-fit: cover;" alt="Pet Photo">
                    <?php else: ?>
                        <div style="width: 100%; height: 100%; background: #fdf2f8; display: flex; align-items: center; justify-content: center; font-size: 2.5rem;">🐾</div>
                    <?php endif; ?>
                </div>
                <div>
                    <h1 style="margin: 0; font-size: 2.5rem; font-weight: 900; color: #1e293b; letter-spacing: -1.5px;">Pet Record: <span class="text-pink-600"><?php echo htmlspecialchars($pet['name']); ?></span></h1>
                    <div style="margin-top: 8px; display: flex; align-items: center; gap: 15px; color: #64748b; font-weight: 700; font-size: 1.1rem;">
                        <span>Male (Neutered)</span>
                        <span style="opacity: 0.3;">•</span>
                        <span><?php echo htmlspecialchars($pet['age']); ?></span>
                        <span style="opacity: 0.3;">•</span>
                        <span>32.4 kg</span>
                    </div>
                </div>
            </div>
            <a href="?url=pet/listPets" class="btn-pill" style="background: white; color: #64748b; border: 1.5px solid #e2e8f0; padding: 12px 25px; font-weight: 800;">Back to Patient List</a>
        </header>

        <div style="display: grid; grid-template-columns: 280px 1fr 280px; gap: 30px; align-items: start;">
            <!-- 👤 Left Column: Bio & Bio-Metrics -->
            <div style="display: flex; flex-direction: column; gap: 30px;">
                <div class="card" style="background: white; border-radius: 30px; padding: 30px; border: none; box-shadow: 0 10px 30px rgba(0,0,0,0.02);">
                    <h3 style="font-size: 0.9rem; font-weight: 800; color: #94a3b8; text-transform: uppercase; letter-spacing: 1px; margin-bottom: 20px;">Owner Details</h3>
                    <div style="display: flex; flex-direction: column; gap: 12px;">
                        <div style="font-weight: 800; color: #1e293b; font-size: 1.1rem;"><?php echo htmlspecialchars($pet['owner_name'] ?? 'Jane Doe'); ?></div>
                        <div style="color: #64748b; font-weight: 600; font-size: 0.9rem;"><?php echo htmlspecialchars($ownerPhone); ?></div>
                        <div style="color: #64748b; font-weight: 600; font-size: 0.9rem;"><?php echo htmlspecialchars($ownerEmail); ?></div>
                        <div style="color: #64748b; font-weight: 600; font-size: 0.9rem; line-height: 1.4;"><?php echo htmlspecialchars($ownerAddress); ?></div>
                    </div>
                    <div class="divider-line" style="margin: 20px 0;"></div>
                    <h3 style="font-size: 0.9rem; font-weight: 800; color: #94a3b8; text-transform: uppercase; letter-spacing: 1px; margin-bottom: 20px;">Core Vitals</h3>
                    <div style="color: #64748b; font-weight: 600; font-size: 0.85rem; line-height: 1.4; margin-bottom: 15px;">
                        Weight, Microchip ID: <strong><?php echo $microchipId; ?></strong>, Allergies/Alerts
                    </div>
                    <?php foreach($allergies as $allergy): ?>
                        <div style="background: #fee2e2; color: #b91c1c; padding: 10px 15px; border-radius: 12px; font-weight: 900; font-size: 0.75rem; text-transform: uppercase; display: flex; align-items: center; gap: 8px; border: 1.5px solid rgba(185, 28, 28, 0.1);">
                            ⚠️ <?php echo $allergy; ?>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>

            <!-- 📋 Center Column: Clinical Timeline & Tabs -->
            <div style="display: flex; flex-direction: column; gap: 30px;">
                <!-- 🚀 Clinical Command Grid (Tabbed Cards) -->
                <div style="display: grid; grid-template-columns: repeat(4, 1fr); gap: 15px;">
                    <div id="btn-history" class="command-card active" onclick="switchTab('history')" style="background: white; border-radius: 20px; padding: 20px 15px; text-align: center; border: 2px solid #db2777; box-shadow: 0 10px 25px rgba(219, 39, 119, 0.08); cursor: pointer; transition: all 0.3s;">
                        <div style="font-size: 1.5rem; margin-bottom: 8px;">📑</div>
                        <div style="font-weight: 900; color: #db2777; font-size: 0.85rem; line-height: 1.2;">Medical History<br><span style="font-size: 0.7rem; opacity: 0.8;">(Active)</span></div>
                    </div>
                    
                    <div id="btn-diagnostics" class="command-card" onclick="switchTab('diagnostics')" style="background: white; border-radius: 20px; padding: 20px 15px; text-align: center; border: 2px solid #f1f5f9; box-shadow: 0 5px 15px rgba(0,0,0,0.02); cursor: pointer; transition: all 0.3s;">
                        <div style="font-size: 1.5rem; margin-bottom: 8px;">📊</div>
                        <div style="font-weight: 800; color: #94a3b8; font-size: 0.85rem; line-height: 1.2;">Diagnostics<br>& Labs</div>
                    </div>

                    <div id="btn-prescriptions" class="command-card" onclick="switchTab('prescriptions')" style="background: white; border-radius: 20px; padding: 20px 15px; text-align: center; border: 2px solid #f1f5f9; box-shadow: 0 5px 15px rgba(0,0,0,0.02); cursor: pointer; transition: all 0.3s;">
                        <div style="font-size: 1.5rem; margin-bottom: 8px;">💊</div>
                        <div style="font-weight: 800; color: #94a3b8; font-size: 0.85rem; line-height: 1.2;">Active<br>Prescriptions</div>
                    </div>

                    <div id="btn-reminders" class="command-card" onclick="switchTab('reminders')" style="background: white; border-radius: 20px; padding: 20px 15px; text-align: center; border: 2px solid #f1f5f9; box-shadow: 0 5px 15px rgba(0,0,0,0.02); cursor: pointer; transition: all 0.3s;">
                        <div style="font-size: 1.5rem; margin-bottom: 8px;">💉</div>
                        <div style="font-weight: 800; color: #94a3b8; font-size: 0.85rem; line-height: 1.2;">Reminders<br>& Vax</div>
                    </div>
                </div>

                <div class="card" style="background: white; border-radius: 30px; border: none; box-shadow: 0 15px 45px rgba(0,0,0,0.03); overflow: hidden;">
                    <!-- 📑 Tab: Medical History -->
                    <div id="tab-history" class="tab-content" style="padding: 40px 50px;">
                        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 35px;">
                            <h2 style="font-size: 1.6rem; font-weight: 900; color: #1e293b; margin: 0;">Clinical History</h2>
                            <?php if ($isVet): ?>
                                <a href="?url=medical/addRecord&pet_id=<?php echo $pet['id']; ?>" class="btn-pill btn-approve" style="padding: 10px 22px; font-size: 0.85rem;">+ New Consultation</a>
                            <?php endif; ?>
                        </div>

                        <?php if (empty($history)): ?>
                            <div style="padding: 60px; text-align: center;">
                                <div style="font-size: 4rem; opacity: 0.2; margin-bottom: 20px;">📅</div>
                                <h3 style="color: #1e293b; font-weight: 800;">No records found</h3>
                                <p style="color: #64748b;">The clinical timeline for this patient is currently clear.</p>
                            </div>
                        <?php else: ?>
                            <div class="clinical-timeline" style="position: relative; padding-left: 30px; border-left: 3px solid #f1f5f9;">
                                <?php foreach ($history as $record): ?>
                                    <div style="position: relative; margin-bottom: 40px;">
                                        <div style="position: absolute; left: -39px; top: 5px; width: 15px; height: 15px; background: #db2777; border-radius: 50%; border: 3px solid white; box-shadow: 0 0 0 3px #f1f5f9;"></div>
                                        <div class="history-item-card" style="background: white; border: 1.5px solid #f8fafc; border-radius: 20px; padding: 25px; transition: all 0.3s; box-shadow: 0 5px 15px rgba(0,0,0,0.01);">
                                            <div style="display: flex; justify-content: space-between; align-items: flex-start; margin-bottom: 12px;">
                                                <div>
                                                    <h3 style="font-weight: 900; color: #1e293b; margin: 0; font-size: 1.15rem;"><?php echo htmlspecialchars($record['diagnosis']); ?> — <span style="font-weight: 700; color: #64748b;">Dr. <?php echo htmlspecialchars($record['vet_last_name']); ?></span></h3>
                                                </div>
                                                <span style="font-size: 0.85rem; color: #94a3b8; font-weight: 800;"><?php echo date('M d, Y', strtotime($record['treatment_date'])); ?></span>
                                            </div>
                                            <p style="color: #475569; font-size: 0.95rem; line-height: 1.6; font-weight: 600; margin-bottom: 15px;">
                                                <strong>Notes:</strong> <?php echo nl2br(htmlspecialchars($record['treatment'])); ?>
                                            </p>
                                            <?php if (!empty($record['medicines'])): ?>
                                                <div style="display: flex; align-items: center; gap: 10px; color: #1e40af; background: #eff6ff; padding: 10px 15px; border-radius: 12px; font-size: 0.85rem; font-weight: 700; border: 1px solid #dbeafe;">
                                                    <span>💊</span> <strong>Rx:</strong> <?php echo htmlspecialchars($record['medicines']); ?>
                                                </div>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                <?php endforeach; ?>
                            </div>
                        <?php endif; ?>
                    </div>

                    <!-- 📊 Tab: Diagnostics -->
                    <div id="tab-diagnostics" class="tab-content" style="padding: 40px 50px; display: none;">
                        <h2 style="font-size: 1.6rem; font-weight: 900; color: #1e293b; margin-bottom: 30px;">Laboratory Results</h2>
                        <div class="table-responsive">
                            <table class="table">
                                <thead style="background: #f8fafc;">
                                    <tr>
                                        <th style="padding: 15px;">Test Type</th>
                                        <th>Date</th>
                                        <th>Result</th>
                                        <th>Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td style="padding: 15px; font-weight: 800;">Complete Blood Count (CBC)</td>
                                        <td>May 10, 2026</td>
                                        <td style="color: #10b981; font-weight: 800;">Normal Range</td>
                                        <td><span class="btn-pill" style="padding: 4px 12px; font-size: 0.75rem; background: #dcfce7; color: #10b981;">Verified</span></td>
                                    </tr>
                                    <tr>
                                        <td style="padding: 15px; font-weight: 800;">X-Ray: Right Hind Leg</td>
                                        <td>March 14, 2026</td>
                                        <td style="color: #f59e0b; font-weight: 800;">Minor Inflammation</td>
                                        <td><span class="btn-pill" style="padding: 4px 12px; font-size: 0.75rem; background: #fef3c7; color: #f59e0b;">Reviewed</span></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <!-- 💊 Tab: Prescriptions -->
                    <div id="tab-prescriptions" class="tab-content" style="padding: 40px 50px; display: none;">
                        <h2 style="font-size: 1.6rem; font-weight: 900; color: #1e293b; margin-bottom: 30px;">Active Medications</h2>
                        <div style="display: grid; gap: 20px;">
                            <div style="background: #eff6ff; border: 1px solid #dbeafe; border-radius: 20px; padding: 25px;">
                                <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 10px;">
                                    <h3 style="margin: 0; color: #1e40af; font-weight: 900;">NexGard (Afoxolaner)</h3>
                                    <span style="background: #1e40af; color: white; padding: 4px 12px; border-radius: 50px; font-size: 0.75rem; font-weight: 800;">ONCE MONTHLY</span>
                                </div>
                                <p style="margin: 0; color: #60a5fa; font-weight: 700; font-size: 0.9rem;">Flea and tick protection. Administer with food.</p>
                            </div>
                            <div style="background: #fdf2f8; border: 1px solid #fce7f3; border-radius: 20px; padding: 25px;">
                                <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 10px;">
                                    <h3 style="margin: 0; color: #db2777; font-weight: 900;">Heartgard Plus</h3>
                                    <span style="background: #db2777; color: white; padding: 4px 12px; border-radius: 50px; font-size: 0.75rem; font-weight: 800;">EVERY 30 DAYS</span>
                                </div>
                                <p style="margin: 0; color: #f472b6; font-weight: 700; font-size: 0.9rem;">Heartworm prevention. Chewable tablet.</p>
                            </div>
                        </div>
                    </div>

                    <!-- 💉 Tab: Reminders -->
                    <div id="tab-reminders" class="tab-content" style="padding: 40px 50px; display: none;">
                        <h2 style="font-size: 1.6rem; font-weight: 900; color: #1e293b; margin-bottom: 30px;">Vaccination Schedule</h2>
                        <div class="table-responsive">
                            <table class="table">
                                <thead style="background: #fdf2f8;">
                                    <tr>
                                        <th style="padding: 15px;">Vaccine Name</th>
                                        <th>Last Given</th>
                                        <th>Next Due</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td style="padding: 15px; font-weight: 800;">Rabies (1-Year)</td>
                                        <td>May 07, 2023</td>
                                        <td style="color: #ef4444; font-weight: 900;">May 07, 2024</td>
                                        <td><button class="btn-pill" style="padding: 6px 15px; font-size: 0.75rem; background: #fff1f2; color: #db2777; border: 1px solid #fce7f3;">Schedule Booster</button></td>
                                    </tr>
                                    <tr>
                                        <td style="padding: 15px; font-weight: 800;">DHPP (Distemper/Parvo)</td>
                                        <td>May 13, 2023</td>
                                        <td style="color: #ef4444; font-weight: 900;">May 13, 2024</td>
                                        <td><button class="btn-pill" style="padding: 6px 15px; font-size: 0.75rem; background: #fff1f2; color: #db2777; border: 1px solid #fce7f3;">Schedule Booster</button></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            <!-- ⚡ Right Column: Actions & Prevention -->
            <div style="display: flex; flex-direction: column; gap: 30px;">
                <div class="card" style="background: white; border-radius: 30px; padding: 30px; border: none; box-shadow: 0 10px 30px rgba(0,0,0,0.02);">
                    <h3 style="font-size: 0.9rem; font-weight: 800; color: #94a3b8; text-transform: uppercase; letter-spacing: 1px; margin-bottom: 25px;">Quick Actions</h3>
                    <div style="display: flex; flex-direction: column; gap: 15px;">
                        <button style="text-align: left; background: #f8fafc; border: 1px solid #f1f5f9; padding: 15px 20px; border-radius: 15px; font-weight: 800; color: #1e293b; display: flex; align-items: center; gap: 12px; cursor: pointer;">
                            <span>➕</span> New Consultation
                        </button>
                        <button style="text-align: left; background: #f8fafc; border: 1px solid #f1f5f9; padding: 15px 20px; border-radius: 15px; font-weight: 800; color: #1e293b; display: flex; align-items: center; gap: 12px; cursor: pointer;">
                            <span>📅</span> Book Appointment
                        </button>
                        <button style="text-align: left; background: #f8fafc; border: 1px solid #f1f5f9; padding: 15px 20px; border-radius: 15px; font-weight: 800; color: #1e293b; display: flex; align-items: center; gap: 12px; cursor: pointer;">
                            <span>📄</span> [ Print Record ]
                        </button>
                    </div>
                    <div class="divider-line" style="margin: 30px 0;"></div>
                    <h3 style="font-size: 0.9rem; font-weight: 800; color: #94a3b8; text-transform: uppercase; letter-spacing: 1px; margin-bottom: 20px;">Preventive Care Due</h3>
                    <div style="display: flex; flex-direction: column; gap: 15px;">
                        <div style="display: flex; justify-content: space-between; align-items: center; font-size: 0.85rem; font-weight: 700;">
                            <span style="color: #64748b;">Rabies Vaccine:</span>
                            <span style="color: #ef4444;">7 May 2024</span>
                        </div>
                        <div style="display: flex; justify-content: space-between; align-items: center; font-size: 0.85rem; font-weight: 700;">
                            <span style="color: #64748b;">DHPP:</span>
                            <span style="color: #ef4444;">13 May 2024</span>
                        </div>
                    </div>
                    <div class="divider-line" style="margin: 30px 0;"></div>
                    <h3 style="font-size: 0.9rem; font-weight: 800; color: #94a3b8; text-transform: uppercase; letter-spacing: 1px; margin-bottom: 20px;">Active Prescriptions</h3>
                    <div style="display: flex; flex-direction: column; gap: 10px;">
                        <div style="font-weight: 800; color: #1e40af; font-size: 0.9rem;">NexGard</div>
                        <div style="font-weight: 800; color: #1e40af; font-size: 0.9rem;">Heartgard Plus</div>
                    </div>
                </div>
            </div>
        </div>
    </main>
</div>

<script>
function switchTab(tabId) {
    // Hide all tab content
    document.querySelectorAll('.tab-content').forEach(content => {
        content.style.display = 'none';
    });
    
    // Show selected tab content
    document.getElementById('tab-' + tabId).style.display = 'block';
    
    // Update button states
    document.querySelectorAll('.command-card').forEach(btn => {
        btn.classList.remove('active');
        btn.style.borderColor = '#f1f5f9';
        btn.style.boxShadow = '0 5px 15px rgba(0,0,0,0.02)';
        const labels = btn.querySelectorAll('div');
        if(labels.length > 1) {
            labels[1].style.color = '#94a3b8';
            labels[1].style.fontWeight = '800';
        }
    });
    
    const activeBtn = document.getElementById('btn-' + tabId);
    activeBtn.classList.add('active');
    activeBtn.style.borderColor = '#db2777';
    activeBtn.style.boxShadow = '0 10px 25px rgba(219, 39, 119, 0.08)';
    const activeLabels = activeBtn.querySelectorAll('div');
    if(activeLabels.length > 1) {
        activeLabels[1].style.color = '#db2777';
        activeLabels[1].style.fontWeight = '900';
    }
}
</script>

<style>
    .command-card:hover:not(.active) {
        transform: translateY(-5px);
        border-color: #fce7f3 !important;
        box-shadow: 0 15px 30px rgba(219, 39, 119, 0.05) !important;
    }
    .command-card.active {
        transform: translateY(-2px);
    }
    .history-item-card:hover {
        transform: translateX(5px);
        border-color: #db2777;
        box-shadow: 0 10px 25px rgba(219, 39, 119, 0.05);
    }
    @keyframes fadeIn {
        from { opacity: 0; transform: translateY(20px); }
        to { opacity: 1; transform: translateY(0); }
    }
    .main-content > * {
        animation: fadeIn 0.6s ease both;
    }
</style>

<?php require_once __DIR__ . '/../../views/layouts/footer.php'; ?>
