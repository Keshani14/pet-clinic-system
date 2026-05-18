<?php
$pageTitle = 'Patient Directory — PetSync';
$userRole = Auth::role();
$hasSidebar = in_array($userRole, ['vet', 'admin', 'owner', 'nurse']);

if ($hasSidebar) {
    $bodyClass = 'dashboard-layout';
}
require_once __DIR__ . '/../../views/layouts/header.php';
?>

<?php if ($hasSidebar): ?>
<div class="dashboard-wrapper" style="background: linear-gradient(135deg, #f8fafc 0%, #f1f5f9 100%); min-height: 100vh;">
    <?php 
    if ($userRole === 'vet') {
        require_once __DIR__ . '/../../views/layouts/vet_sidebar.php';
    } elseif ($userRole === 'admin') {
        require_once __DIR__ . '/../../views/layouts/admin_sidebar.php';
    } elseif ($userRole === 'nurse') {
        require_once __DIR__ . '/../../views/layouts/nurse_sidebar.php';
    } else {
        require_once __DIR__ . '/../../views/layouts/owner_sidebar.php';
    }
    ?>
    <main class="main-content" style="padding: 40px; max-width: 1700px; margin: 0 auto; width: 100%;">
<?php endif; ?>

<div style="display: flex; flex-direction: column; gap: 35px;">
    <!-- 🏢 Directory Header & Quick Action -->
    <header style="display: flex; justify-content: space-between; align-items: flex-end; flex-wrap: wrap; gap: 20px;">
        <div>
            <h1 style="margin: 0; font-size: 2.5rem; font-weight: 900; color: #1e293b; letter-spacing: -1.5px;">Patient <span class="text-pink-600">Directory</span></h1>
            <p style="margin: 8px 0 0; color: #64748b; font-weight: 700; font-size: 1.1rem;">Complete roster of registered patients at PetSync.</p>
        </div>
        <div style="display: flex; gap: 15px; align-items: center;">
            <div style="position: relative; width: 350px;">
                <input type="text" id="patient-dir-search" placeholder="Search by name, breed, or owner..." style="width: 100%; padding: 14px 20px 14px 50px; border-radius: 20px; border: 2px solid #f1f5f9; background: white; font-weight: 700; box-shadow: 0 4px 15px rgba(0,0,0,0.02); outline: none; transition: all 0.3s;">
                <span style="position: absolute; left: 18px; top: 50%; transform: translateY(-50%); font-size: 1.2rem; opacity: 0.4;">🔍</span>
            </div>
            <a href="?url=pet/addPet" class="btn-pill" style="padding: 14px 28px; background: #db2777; color: white; box-shadow: 0 10px 20px rgba(219, 39, 119, 0.15);">Add New Patient +</a>
        </div>
    </header>

    <!-- 📋 Main Directory Vault -->
    <div class="card" style="width: 100%; max-width: none; border-radius: 35px; border: none; box-shadow: 0 20px 60px rgba(0,0,0,0.03); background: white; overflow: hidden;">
        <div class="card-body" style="padding: 0;">
            <?php if (!empty($_SESSION['flash_success'])): ?>
                <div style="margin: 20px 40px; padding: 15px 25px; background: #f0fdf4; border-radius: 15px; color: #16a34a; font-weight: 800; display: flex; align-items: center; gap: 12px; border: 1px solid #bbf7d0;">
                    <span>✅</span> <?php echo htmlspecialchars($_SESSION['flash_success']); unset($_SESSION['flash_success']); ?>
                </div>
            <?php endif; ?>

            <?php if (empty($pets)): ?>
                <div style="padding: 100px 40px; text-align: center;">
                    <div style="font-size: 5rem; margin-bottom: 25px; opacity: 0.2;">🐾</div>
                    <h2 style="color: #1e293b; font-weight: 900;">Directory is Clear</h2>
                    <p style="color: #64748b; font-weight: 600; font-size: 1.1rem; margin-bottom: 30px;">No patients are currently registered in the system.</p>
                    <a href="?url=pet/addPet" class="btn-pill" style="display: inline-block;">Register First Patient</a>
                </div>
            <?php else: ?>
                <div class="table-responsive">
                    <table class="table" style="width: 100%; border-collapse: separate; border-spacing: 0;">
                        <thead>
                            <tr style="background: #f8fafc;">
                                <th style="padding: 25px 40px; color: #94a3b8; font-weight: 800; text-transform: uppercase; font-size: 0.75rem; letter-spacing: 1px; border-bottom: 1px solid #f1f5f9;">Patient</th>
                                <th style="padding: 25px 20px; color: #94a3b8; font-weight: 800; text-transform: uppercase; font-size: 0.75rem; letter-spacing: 1px; border-bottom: 1px solid #f1f5f9;">Species & Breed</th>
                                <th style="padding: 25px 20px; color: #94a3b8; font-weight: 800; text-transform: uppercase; font-size: 0.75rem; letter-spacing: 1px; border-bottom: 1px solid #f1f5f9;">Age & Status</th>
                                <?php if (Auth::role() !== 'owner'): ?>
                                    <th style="padding: 25px 20px; color: #94a3b8; font-weight: 800; text-transform: uppercase; font-size: 0.75rem; letter-spacing: 1px; border-bottom: 1px solid #f1f5f9;">Owner Details</th>
                                <?php endif; ?>
                                <th style="padding: 25px 40px; color: #94a3b8; font-weight: 800; text-transform: uppercase; font-size: 0.75rem; letter-spacing: 1px; border-bottom: 1px solid #f1f5f9; text-align: center;">Clinical Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($pets as $pet): ?>
                                <tr class="directory-row" style="transition: all 0.3s; cursor: default;">
                                    <td style="padding: 25px 40px; border-bottom: 1px solid #f8fafc;">
                                        <div style="display: flex; align-items: center; gap: 20px;">
                                            <div style="width: 60px; height: 60px; border-radius: 18px; overflow: hidden; box-shadow: 0 5px 15px rgba(0,0,0,0.05); border: 2px solid white;">
                                                <?php if (!empty($pet['photo'])): ?>
                                                    <img src="/pet_clinic/public/<?php echo htmlspecialchars($pet['photo']); ?>" style="width: 100%; height: 100%; object-fit: cover;" alt="Pet">
                                                <?php else: ?>
                                                    <div style="width: 100%; height: 100%; background: #fdf2f8; display: flex; align-items: center; justify-content: center; font-size: 1.5rem;">🐾</div>
                                                <?php endif; ?>
                                            </div>
                                            <div>
                                                <div style="font-weight: 900; color: #1e293b; font-size: 1.1rem; line-height: 1.2;" class="search-target-name"><?php echo htmlspecialchars($pet['name']); ?></div>
                                                <div style="font-size: 0.75rem; font-weight: 800; color: #db2777; margin-top: 4px; text-transform: uppercase; letter-spacing: 0.5px;">#PET-<?php echo str_pad($pet['id'], 4, '0', STR_PAD_LEFT); ?></div>
                                            </div>
                                        </div>
                                    </td>
                                    <td style="padding: 25px 20px; border-bottom: 1px solid #f8fafc;">
                                        <div style="font-weight: 800; color: #475569; font-size: 0.95rem;" class="search-target-breed"><?php echo htmlspecialchars($pet['breed'] ?? 'Unknown Breed'); ?></div>
                                        <div style="font-size: 0.8rem; font-weight: 700; color: #94a3b8; margin-top: 2px;"><?php echo ucfirst(htmlspecialchars($pet['type'])); ?></div>
                                    </td>
                                    <td style="padding: 25px 20px; border-bottom: 1px solid #f8fafc;">
                                        <div style="font-weight: 800; color: #475569; font-size: 0.95rem;"><?php echo htmlspecialchars($pet['age']); ?></div>
                                        <div style="display: flex; align-items: center; gap: 5px; margin-top: 5px;">
                                            <span style="width: 8px; height: 8px; border-radius: 50%; background: #10b981;"></span>
                                            <span style="font-size: 0.75rem; font-weight: 800; color: #10b981; text-transform: uppercase;">Active Profile</span>
                                        </div>
                                    </td>
                                    <?php if (Auth::role() !== 'owner'): ?>
                                        <td style="padding: 25px 20px; border-bottom: 1px solid #f8fafc;">
                                            <div style="font-weight: 800; color: #475569; font-size: 0.95rem;" class="search-target-owner">
                                                <?php 
                                                $displayOwnerName = !empty($pet['owner_name']) ? $pet['owner_name'] : trim(($pet['owner_first_name']??'') . ' ' . ($pet['owner_last_name']??''));
                                                echo htmlspecialchars($displayOwnerName ?: 'General Public');
                                                ?>
                                            </div>
                                            <div style="font-size: 0.8rem; font-weight: 700; color: #94a3b8; margin-top: 2px;">
                                                <?php 
                                                $displayOwnerPhone = !empty($pet['owner_phone']) ? $pet['owner_phone'] : ($pet['owner_phone_user'] ?? 'No direct contact');
                                                echo htmlspecialchars($displayOwnerPhone);
                                                ?>
                                            </div>
                                        </td>
                                    <?php endif; ?>
                                    <td style="padding: 25px 40px; border-bottom: 1px solid #f8fafc; text-align: center;">
                                        <div style="display: flex; justify-content: center; gap: 8px;">
                                            <a href="?url=medical/viewHistory&pet_id=<?php echo $pet['id']; ?>" class="action-btn-pill btn-history" title="Medical History">
                                                <span>📋</span> History
                                            </a>
                                            <?php if (in_array(Auth::role(), ['owner'])): ?>
                                                <a href="?url=appointment/create&pet_id=<?php echo $pet['id']; ?>" class="action-btn-pill btn-book" title="Book Appointment">
                                                    <span>🗓️</span>
                                                </a>
                                            <?php endif; ?>
                                            <a href="?url=pet/edit&id=<?php echo $pet['id']; ?>" class="action-btn-pill btn-edit" title="Edit Profile">
                                                <span>✏️</span>
                                            </a>
                                            <a href="?url=pet/delete&id=<?php echo $pet['id']; ?>" class="action-btn-pill btn-delete" title="Remove Patient" onclick="return confirm('Are you sure you want to delete this patient profile?');">
                                                <span>🗑️</span>
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>

<style>
    .directory-row:hover {
        background: #fdf2f8 !important;
        transform: scale(1.002);
    }
    .action-btn-pill {
        display: flex;
        align-items: center;
        gap: 8px;
        padding: 10px 18px;
        border-radius: 12px;
        font-weight: 800;
        font-size: 0.85rem;
        text-decoration: none;
        transition: all 0.2s;
        border: 1.5px solid transparent;
    }
    .btn-history {
        background: #1e293b;
        color: white;
        box-shadow: 0 4px 12px rgba(30, 41, 59, 0.15);
    }
    .btn-history:hover {
        background: #0f172a;
        transform: translateY(-2px);
    }
    .btn-edit {
        background: white;
        color: #64748b;
        border-color: #e2e8f0;
        padding: 10px;
    }
    .btn-edit:hover {
        color: #db2777;
        border-color: #fce7f3;
        background: #fff1f2;
    }
    .btn-delete {
        background: white;
        color: #94a3b8;
        border-color: #f1f5f9;
        padding: 10px;
    }
    .btn-delete:hover {
        color: #ef4444;
        border-color: #fee2e2;
        background: #fef2f2;
    }
    .btn-book {
        background: white;
        color: #10b981;
        border-color: #dcfce7;
        padding: 10px;
    }
    #patient-dir-search:focus {
        border-color: #db2777;
        box-shadow: 0 10px 25px rgba(219, 39, 119, 0.08);
    }
    .row-hidden {
        display: none !important;
    }
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const searchInput = document.getElementById('patient-dir-search');
    const rows = document.querySelectorAll('.directory-row');

    searchInput.addEventListener('input', function(e) {
        const term = e.target.value.toLowerCase().trim();
        rows.forEach(row => {
            const name = row.querySelector('.search-target-name').textContent.toLowerCase();
            const breed = row.querySelector('.search-target-breed').textContent.toLowerCase();
            const owner = row.querySelector('.search-target-owner') ? row.querySelector('.search-target-owner').textContent.toLowerCase() : '';
            
            if (name.includes(term) || breed.includes(term) || owner.includes(term)) {
                row.classList.remove('row-hidden');
            } else {
                row.classList.add('row-hidden');
            }
        });
    });
});
</script>

<?php if ($hasSidebar): ?>
    </main>
</div>
<?php endif; ?>

<?php require_once __DIR__ . '/../../views/layouts/footer.php'; ?>
