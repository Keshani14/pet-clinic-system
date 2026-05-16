<?php
$pageTitle = 'My Profile — Furry Friends';
$bodyClass = 'dashboard-layout';
require_once __DIR__ . '/../../views/layouts/header.php';

// Determine which sidebar to load based on role
$role = $user['role'] ?? 'nurse';
$sidebarPath = ($role === 'nurse') ? '/../../views/layouts/nurse_sidebar.php' : '/../../views/layouts/vet_sidebar.php';
?>

<div class="dashboard-wrapper" style="background: linear-gradient(135deg, #fff5f7 0%, #f0fdf4 50%, #eff6ff 100%); min-height: 100vh;">
    <?php require_once __DIR__ . $sidebarPath; ?>
    
    <main class="main-content" style="max-width: 1200px; margin: 0 auto; padding: 40px 30px;">
        <!-- ✨ Modern Header -->
        <div class="profile-page-header mb-40" style="display: flex; justify-content: space-between; align-items: center; background: rgba(255,255,255,0.6); padding: 25px 40px; border-radius: 30px; backdrop-filter: blur(10px); border: 1px solid rgba(255,255,255,0.8); box-shadow: 0 10px 30px rgba(0,0,0,0.02);">
            <div style="display: flex; align-items: center; gap: 20px;">
                <div style="background: var(--pink-500); width: 50px; height: 50px; border-radius: 15px; display: flex; align-items: center; justify-content: center; font-size: 1.5rem; color: white; box-shadow: 0 8px 20px rgba(219, 39, 119, 0.2);">🏥</div>
                <div>
                    <h1 style="margin: 0; font-size: 2rem; font-weight: 900; color: #1e293b; letter-spacing: -1px;">My Profile</h1>
                    <p style="margin: 0; color: #64748b; font-weight: 700; font-size: 0.95rem;">Staff Management Portal • Furry Friends Clinic</p>
                </div>
            </div>
            <div class="notification-bell" style="background: white; width: 50px; height: 50px; border-radius: 50%; display: flex; align-items: center; justify-content: center; box-shadow: 0 4px 15px rgba(0,0,0,0.05); position: relative; cursor: pointer;">
                🔔 <span style="position: absolute; top: 12px; right: 12px; width: 10px; height: 10px; background: #f43f5e; border-radius: 50%; border: 2px solid white;"></span>
            </div>
        </div>

        <div class="profile-grid" style="display: grid; grid-template-columns: 380px 1fr; gap: 40px; align-items: start;">
            <!-- 📸 Left Column: Professional Identity Card -->
            <div class="card" style="background: white; border-radius: 40px; padding: 50px 40px; text-align: center; border: 1px solid rgba(255,255,255,0.8); box-shadow: 0 20px 60px rgba(0,0,0,0.05); position: sticky; top: 30px;">
                <div class="photo-section" style="position: relative; display: inline-block; margin-bottom: 35px; group">
                    <div class="profile-avatar-wrapper" style="width: 170px; height: 170px; border-radius: 50%; border: 8px solid #f8fafc; background: #fffcfd; display: flex; align-items: center; justify-content: center; overflow: hidden; box-shadow: 0 15px 35px rgba(0,0,0,0.08); transition: transform 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275); position: relative;">
                        <?php if (Auth::photo()): ?>
                            <img src="<?php echo htmlspecialchars(Auth::photo()); ?>" style="width: 100%; height: 100%; object-fit: cover;" alt="Profile">
                        <?php else: ?>
                            <span style="font-size: 5rem; opacity: 0.3;">👤</span>
                        <?php endif; ?>
                        
                        <!-- Hover Overlay -->
                        <div class="avatar-overlay" style="position: absolute; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0,0,0,0.4); display: flex; align-items: center; justify-content: center; opacity: 0; transition: all 0.3s; cursor: pointer;">
                            <span style="color: white; font-weight: 800; font-size: 0.85rem; text-transform: uppercase; letter-spacing: 1px;">Change Photo</span>
                        </div>
                    </div>
                    
                    <form id="photo-upload-form" action="?url=user/uploadPhoto" method="POST" enctype="multipart/form-data">
                        <input type="file" id="profile_photo_input" name="profile_photo" accept="image/*" style="display: none;" onchange="document.getElementById('photo-upload-form').submit();">
                        <button type="button" onclick="document.getElementById('profile_photo_input').click();" class="upload-badge" style="position: absolute; bottom: 5px; right: 5px; background: var(--pink-500); color: white; border: 5px solid white; border-radius: 50%; width: 52px; height: 52px; display: flex; align-items: center; justify-content: center; cursor: pointer; box-shadow: 0 10px 25px rgba(219, 39, 119, 0.3); font-size: 1.3rem; transition: all 0.3s;">
                            📸
                        </button>
                    </form>
                </div>

                <h2 style="margin: 0; color: #1e293b; font-weight: 900; font-size: 1.8rem; letter-spacing: -1px;"><?php echo htmlspecialchars($user['first_name'] . ' ' . $user['last_name']); ?></h2>
                <div style="margin: 15px 0 30px;">
                    <span style="background: #fdf2f8; color: #db2777; font-weight: 800; padding: 10px 24px; border-radius: 50px; font-size: 0.85rem; border: 1px solid #fce7f3; display: inline-flex; align-items: center; gap: 8px;">
                        <span style="width: 8px; height: 8px; background: #db2777; border-radius: 50%; display: inline-block;"></span>
                        <?php echo ucfirst($user['role']); ?> • Active
                    </span>
                </div>

                <div style="background: #f8fafc; border-radius: 25px; padding: 30px; text-align: left; border: 1px solid #f1f5f9;">
                    <div style="margin-bottom: 20px;">
                        <label style="display: block; font-size: 0.75rem; text-transform: uppercase; letter-spacing: 2px; color: #94a3b8; font-weight: 800; margin-bottom: 8px;">Registration ID</label>
                        <div style="font-weight: 900; color: #1e293b; font-size: 1.1rem; letter-spacing: 0.5px;">FF-<?php echo strtoupper(substr($user['role'], 0, 3)); ?>-<?php echo str_pad($user['id'], 5, '0', STR_PAD_LEFT); ?></div>
                    </div>
                    <div>
                        <label style="display: block; font-size: 0.75rem; text-transform: uppercase; letter-spacing: 2px; color: #94a3b8; font-weight: 800; margin-bottom: 8px;">Security Level</label>
                        <div style="display: flex; align-items: center; gap: 10px;">
                            <span style="color: #10b981; font-weight: 800; font-size: 1rem;">Verified Professional</span>
                            <span style="background: #dcfce7; width: 22px; height: 22px; border-radius: 50%; display: flex; align-items: center; justify-content: center; color: #059669; font-size: 0.8rem;">✓</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- 📝 Right Column: Clinical Profile Form -->
            <div style="display: flex; flex-direction: column; gap: 30px;">
                <form action="?url=user/updateProfile" method="POST">
                    <div class="card" style="background: white; border-radius: 40px; padding: 50px; border: 1px solid rgba(255,255,255,0.8); box-shadow: 0 20px 60px rgba(0,0,0,0.05);">
                        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 45px; border-bottom: 2px solid #f8fafc; padding-bottom: 25px;">
                            <h3 style="font-size: 1.6rem; font-weight: 900; color: #1e293b; margin: 0; display: flex; align-items: center; gap: 15px;">
                                <span style="background: #eff6ff; color: #3b82f6; width: 45px; height: 45px; border-radius: 12px; display: flex; align-items: center; justify-content: center; font-size: 1.2rem;">📋</span>
                                Personal Information
                            </h3>
                        </div>

                        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 35px 45px;">
                            <div class="form-group">
                                <label style="display: block; font-weight: 800; color: #64748b; font-size: 0.85rem; text-transform: uppercase; letter-spacing: 1px; margin-bottom: 12px; margin-left: 5px;">First Name</label>
                                <input type="text" name="first_name" value="<?php echo htmlspecialchars($user['first_name']); ?>" class="clinic-input" required>
                            </div>

                            <div class="form-group">
                                <label style="display: block; font-weight: 800; color: #64748b; font-size: 0.85rem; text-transform: uppercase; letter-spacing: 1px; margin-bottom: 12px; margin-left: 5px;">Last Name</label>
                                <input type="text" name="last_name" value="<?php echo htmlspecialchars($user['last_name']); ?>" class="clinic-input" required>
                            </div>

                            <div class="form-group">
                                <label style="display: block; font-weight: 800; color: #64748b; font-size: 0.85rem; text-transform: uppercase; letter-spacing: 1px; margin-bottom: 12px; margin-left: 5px;">Email Address</label>
                                <input type="email" name="email" value="<?php echo htmlspecialchars($user['email']); ?>" class="clinic-input" required>
                            </div>

                            <div class="form-group">
                                <label style="display: block; font-weight: 800; color: #64748b; font-size: 0.85rem; text-transform: uppercase; letter-spacing: 1px; margin-bottom: 12px; margin-left: 5px;">Contact Number</label>
                                <input type="text" name="phone" value="<?php echo htmlspecialchars($user['phone'] ?? ''); ?>" class="clinic-input" placeholder="+94 77 XXX XXXX">
                            </div>
                        </div>

                        <div style="margin-top: 50px; padding-top: 40px; border-top: 2px solid #f8fafc; display: flex; justify-content: flex-end; gap: 20px;">
                            <a href="?url=<?php echo $role; ?>/dashboard" class="btn-clinic btn-grey">Cancel Changes</a>
                            <button type="submit" class="btn-clinic btn-green">Update Profile</button>
                        </div>
                    </div>
                </form>

                <!-- 📊 Bottom Info Bar -->
                <div style="display: grid; grid-template-columns: 1.5fr 1fr; gap: 30px;">
                    <div class="card" style="background: #f0fdf4; border-radius: 30px; padding: 25px 40px; border: 1px solid #dcfce7; display: flex; align-items: center; justify-content: space-between;">
                        <div style="display: flex; align-items: center; gap: 20px;">
                            <div style="background: white; width: 55px; height: 55px; border-radius: 18px; display: flex; align-items: center; justify-content: center; font-size: 1.4rem; box-shadow: 0 4px 10px rgba(0,0,0,0.02);">📅</div>
                            <div>
                                <div style="font-size: 0.75rem; font-weight: 800; color: #166534; text-transform: uppercase; letter-spacing: 1px;">Upcoming Duty</div>
                                <div style="font-size: 1.15rem; font-weight: 900; color: #064e3b;">Tomorrow, 8:00 AM</div>
                            </div>
                        </div>
                        <span style="background: #10b981; color: white; padding: 6px 16px; border-radius: 10px; font-size: 0.75rem; font-weight: 800;">ON SHIFT</span>
                    </div>
                    <div class="card" style="background: #f8fafc; border-radius: 30px; padding: 25px 35px; border: 1px solid #e2e8f0; display: flex; align-items: center; justify-content: center;">
                        <div style="text-align: center;">
                            <div style="font-size: 0.7rem; font-weight: 800; color: #94a3b8; text-transform: uppercase; letter-spacing: 2px; margin-bottom: 5px;">System Version</div>
                            <div style="font-size: 0.95rem; font-weight: 900; color: #475569;">Staff Portal v2.0</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
</div>

<style>
    .clinic-input {
        width: 100%;
        background: #f8fafc;
        border: 2px solid #f1f5f9;
        border-radius: 16px;
        padding: 16px 20px;
        font-size: 1rem;
        font-weight: 700;
        color: #1e293b;
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        outline: none;
    }
    .clinic-input:focus {
        background: white;
        border-color: #3b82f6;
        box-shadow: 0 12px 25px rgba(59, 130, 246, 0.08);
        transform: translateY(-2px);
    }
    .btn-clinic {
        padding: 16px 40px;
        border-radius: 18px;
        font-weight: 800;
        font-size: 1rem;
        cursor: pointer;
        transition: all 0.3s;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        border: none;
    }
    .btn-grey {
        background: #f1f5f9;
        color: #64748b;
    }
    .btn-grey:hover {
        background: #e2e8f0;
        color: #475569;
        transform: translateY(-2px);
    }
    .btn-green {
        background: #10b981;
        color: white;
        box-shadow: 0 10px 20px rgba(16, 185, 129, 0.2);
    }
    .btn-green:hover {
        background: #059669;
        box-shadow: 0 15px 30px rgba(16, 185, 129, 0.3);
        transform: translateY(-2px);
    }
    .profile-avatar-wrapper:hover .avatar-overlay {
        opacity: 1;
    }
    .profile-avatar-wrapper:hover {
        transform: scale(1.02);
    }
    .upload-badge:hover {
        transform: scale(1.1) rotate(10deg);
        filter: brightness(1.1);
    }
    
    @media (max-width: 1024px) {
        .profile-grid {
            grid-template-columns: 1fr !important;
        }
        .main-content {
            padding: 20px !important;
        }
    }
</style>

<?php require_once __DIR__ . '/../../views/layouts/footer.php'; ?>
