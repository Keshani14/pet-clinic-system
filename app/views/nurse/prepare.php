<?php
$pageTitle = 'Prepare Patient — Furry Friends';
$bodyClass = 'dashboard-layout';
require_once __DIR__ . '/../../views/layouts/header.php';
?>

<div class="dashboard-wrapper" style="background: linear-gradient(135deg, #fffcfd 0%, #fff0f5 100%); min-height: 100vh;">
    <?php require_once __DIR__ . '/../../views/layouts/nurse_sidebar.php'; ?>
    
    <main class="main-content" style="padding: 40px; max-width: 1400px; margin: 0 auto; width: 100%;">
        <!-- ✨ Glassmorphic Header & Identity Pill -->
        <header class="dashboard-header mb-40" style="display: flex; justify-content: space-between; align-items: center; background: rgba(255, 255, 255, 0.7); backdrop-filter: blur(20px); padding: 30px 45px; border-radius: 35px; border: 1px solid rgba(255, 255, 255, 0.8); box-shadow: 0 10px 40px rgba(0,0,0,0.02);">
            <div style="display: flex; align-items: center; gap: 25px;">
                <div style="background: #fdf2f8; width: 60px; height: 60px; border-radius: 20px; display: flex; align-items: center; justify-content: center; font-size: 1.8rem; box-shadow: 0 10px 25px rgba(219, 39, 119, 0.05);">🏥</div>
                <div>
                    <h1 style="margin: 0; font-size: 2.2rem; font-weight: 900; color: #1e293b; letter-spacing: -1.5px;">Prepare Patient</h1>
                    <p style="margin: 0; color: #64748b; font-weight: 700; font-size: 1rem;">Clinical prep for consultation</p>
                </div>
            </div>
            
            <div class="patient-identity-pill" style="display: flex; align-items: center; gap: 15px; background: white; padding: 12px 25px; border-radius: 50px; border: 1.5px solid #fce7f3; box-shadow: 0 5px 20px rgba(219, 39, 119, 0.03);">
                <div style="width: 45px; height: 45px; background: #fff1f2; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 1.3rem;">🐾</div>
                <div>
                    <div style="font-weight: 900; color: #1e293b; font-size: 1.1rem;"><?php echo htmlspecialchars($appointment['pet_name_display']); ?></div>
                    <div style="font-size: 0.75rem; color: #db2777; font-weight: 800; text-transform: uppercase; letter-spacing: 0.5px;">Owner: <?php echo htmlspecialchars($appointment['owner_name']); ?></div>
                </div>
            </div>
        </header>

        <form action="?url=nurse/saveVitals/<?php echo $appointment['id']; ?>" method="POST">
            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 40px;">
                <!-- 🌡️ Vitals Dashboard -->
                <div class="card" style="background: white; border-radius: 40px; padding: 45px; border: none; box-shadow: 0 20px 60px rgba(0,0,0,0.03);">
                    <h2 style="font-size: 1.4rem; font-weight: 900; color: #1e293b; margin-bottom: 35px; display: flex; align-items: center; gap: 12px;">
                        <span style="background: #f1f5f9; width: 40px; height: 40px; border-radius: 12px; display: flex; align-items: center; justify-content: center; font-size: 1.1rem;">📊</span>
                        Vital Signs
                    </h2>
                    
                    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 30px;">
                        <div class="vitals-input-card" style="background: #f8fafc; padding: 25px; border-radius: 30px; border: 1px solid #f1f5f9; transition: all 0.3s;">
                            <label style="display: block; color: #94a3b8; font-weight: 800; text-transform: uppercase; font-size: 0.7rem; letter-spacing: 1px; margin-bottom: 10px;">Weight (kg)</label>
                            <div style="display: flex; align-items: center; gap: 15px;">
                                <span style="font-size: 1.8rem;">⚖️</span>
                                <input type="text" name="weight" id="weight" value="<?php echo htmlspecialchars($appointment['weight'] ?? ''); ?>" placeholder="0.0" required 
                                       style="width: 100%; background: transparent; border: none; font-size: 2.2rem; font-weight: 900; color: #1e293b; outline: none; padding: 0;">
                            </div>
                        </div>

                        <div class="vitals-input-card" style="background: #fffcfd; padding: 25px; border-radius: 30px; border: 1px solid #fce7f3; transition: all 0.3s;">
                            <label style="display: block; color: #db2777; font-weight: 800; text-transform: uppercase; font-size: 0.7rem; letter-spacing: 1px; margin-bottom: 10px;">Temp (°C)</label>
                            <div style="display: flex; align-items: center; gap: 15px;">
                                <span style="font-size: 1.8rem;">🌡️</span>
                                <input type="text" name="temperature" id="temperature" value="<?php echo htmlspecialchars($appointment['temperature'] ?? ''); ?>" placeholder="00.0" required 
                                       style="width: 100%; background: transparent; border: none; font-size: 2.2rem; font-weight: 900; color: #1e293b; outline: none; padding: 0;">
                            </div>
                        </div>
                    </div>
                    
                    <div style="margin-top: 40px; padding: 20px; background: #fdf2f8; border-radius: 20px; border: 1px solid rgba(219, 39, 119, 0.05);">
                        <p style="margin: 0; color: #db2777; font-size: 0.85rem; font-weight: 700; line-height: 1.5;">
                            <span style="font-size: 1.1rem; margin-right: 5px;">💡</span> 
                            Tip: Accuracy is crucial for correct medication dosage. Please double-check these readings.
                        </p>
                    </div>
                </div>

                <!-- 🤒 Clinical Observations -->
                <div class="card" style="background: white; border-radius: 40px; padding: 45px; border: none; box-shadow: 0 20px 60px rgba(0,0,0,0.03);">
                    <h2 style="font-size: 1.4rem; font-weight: 900; color: #1e293b; margin-bottom: 35px; display: flex; align-items: center; gap: 12px;">
                        <span style="background: #f1f5f9; width: 40px; height: 40px; border-radius: 12px; display: flex; align-items: center; justify-content: center; font-size: 1.1rem;">🩺</span>
                        Clinical Observations
                    </h2>

                    <div style="margin-bottom: 25px;">
                        <label style="display: block; color: #64748b; font-weight: 800; margin-bottom: 12px; font-size: 0.95rem;">Observed Symptoms <span style="color: #db2777;">*</span></label>
                        <textarea name="symptoms" id="symptoms" rows="3" placeholder="e.g. Coughing, sneezing, loss of appetite..." required 
                                  style="width: 100%; border-radius: 20px; border: 2px solid #f1f5f9; padding: 20px; font-family: inherit; font-size: 1rem; font-weight: 600; color: #1e293b; outline: none; transition: all 0.3s;"><?php echo htmlspecialchars($appointment['symptoms'] ?? ''); ?></textarea>
                    </div>

                    <div>
                        <label style="display: block; color: #64748b; font-weight: 800; margin-bottom: 12px; font-size: 0.95rem;">Additional Nurse Notes</label>
                        <textarea name="notes" id="notes" rows="3" placeholder="Any other relevant information for the Vet..." 
                                  style="width: 100%; border-radius: 20px; border: 2px solid #f1f5f9; padding: 20px; font-family: inherit; font-size: 1rem; font-weight: 600; color: #1e293b; outline: none; transition: all 0.3s;"><?php echo htmlspecialchars($appointment['nurse_notes'] ?? ''); ?></textarea>
                    </div>
                </div>
            </div>

            <!-- 🚀 Action Bar -->
            <footer style="margin-top: 40px; background: white; padding: 30px 45px; border-radius: 30px; box-shadow: 0 10px 40px rgba(0,0,0,0.02); display: flex; justify-content: space-between; align-items: center;">
                <div style="color: #94a3b8; font-weight: 700; font-size: 0.95rem;">
                    Patient is currently in <span style="color: #db2777;">Preparation Mode</span>
                </div>
                <div style="display: flex; gap: 15px;">
                    <a href="?url=nurse/dashboard" class="btn-pill" style="background: #f1f5f9; color: #64748b; border: none; padding: 14px 30px;">Cancel</a>
                    <button type="submit" class="btn-pill btn-approve" style="padding: 14px 40px; font-size: 1.05rem; box-shadow: 0 10px 20px rgba(16, 185, 129, 0.15);">Save & Mark Ready 🚀</button>
                </div>
            </footer>
        </form>
    </main>
</div>

<style>
    .vitals-input-card:focus-within {
        transform: translateY(-5px);
        box-shadow: 0 15px 35px rgba(219, 39, 119, 0.08);
        border-color: #db2777 !important;
    }
    textarea:focus {
        border-color: #db2777 !important;
        box-shadow: 0 10px 25px rgba(219, 39, 119, 0.05);
        transform: translateY(-2px);
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
