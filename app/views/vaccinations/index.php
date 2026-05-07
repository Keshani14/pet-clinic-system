<?php
$pageTitle = 'Required Vaccinations — Pet Clinic';
$bodyClass = 'dashboard-layout';

$extraHead = '
<style>
    .vaccine-container {
        display: flex;
        flex-direction: column;
        gap: 30px;
    }
    
    .pet-vaccine-card {
        background: var(--white);
        border-radius: 20px;
        box-shadow: var(--shadow);
        overflow: hidden;
        animation: slideUp 0.5s ease forwards;
    }

    .pet-vaccine-header {
        background: var(--pink-50);
        padding: 25px 30px;
        display: flex;
        align-items: center;
        gap: 20px;
        border-bottom: 1px solid var(--pink-100);
    }

    .pet-avatar {
        width: 60px;
        height: 60px;
        border-radius: 50%;
        background: var(--pink-500);
        color: white;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.8rem;
        border: 3px solid white;
        box-shadow: 0 4px 10px rgba(0,0,0,0.1);
    }

    .pet-info h2 {
        font-size: 1.4rem;
        color: var(--gray-800);
        margin: 0;
    }

    .pet-info p {
        margin: 0;
        color: var(--pink-500);
        font-weight: 700;
        font-size: 0.9rem;
    }

    .vaccine-content {
        padding: 30px;
    }

    .vaccine-section {
        margin-bottom: 25px;
    }

    .vaccine-section-title {
        display: flex;
        align-items: center;
        gap: 10px;
        font-size: 1rem;
        font-weight: 800;
        color: var(--gray-700);
        margin-bottom: 15px;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    .vaccine-table {
        width: 100%;
        border-collapse: separate;
        border-spacing: 0;
        border: 1px solid var(--pink-50);
        border-radius: 12px;
        overflow: hidden;
    }

    .vaccine-table th {
        background: var(--pink-50);
        padding: 12px 15px;
        text-align: left;
        font-size: 0.85rem;
        color: var(--gray-600);
    }

    .vaccine-table td {
        padding: 15px;
        border-top: 1px solid var(--pink-50);
        font-size: 0.95rem;
        color: var(--gray-600);
    }

    .vax-name { font-weight: 700; color: var(--gray-800); }
    .vax-freq { color: var(--pink-500); font-weight: 600; font-size: 0.85rem; }
    
    .badge-core {
        background: #dcfce7;
        color: #166534;
        padding: 2px 8px;
        border-radius: 4px;
        font-size: 0.7rem;
        font-weight: 800;
    }

    .empty-vaccine-state {
        text-align: center;
        padding: 60px;
        background: white;
        border-radius: 20px;
        box-shadow: var(--shadow);
    }
</style>
';

require_once __DIR__ . '/../layouts/header.php';
?>

<div class="dashboard-wrapper">
    <?php require __DIR__ . '/../layouts/owner_sidebar.php'; ?>
    
    <main class="main-content">
        <div class="mb-30">
            <h1 class="hero-title" style="text-align: left; font-size: 2.2rem;">Vaccination <span>Schedule</span></h1>
            <p class="text-gray-600">Ensure your pets are protected with these core and recommended vaccinations.</p>
        </div>

        <div class="vaccine-container">
            <?php if (empty($myPets)): ?>
                <div class="empty-vaccine-state">
                    <span class="icon-lg">🐾</span>
                    <h3>No pets found.</h3>
                    <p>Register your pets first to see their recommended vaccination schedules.</p>
                    <a href="?url=pet/addPet" class="btn-pill" style="margin-top: 20px;">Add a Pet +</a>
                </div>
            <?php else: ?>
                <?php foreach ($myPets as $pet): 
                    $type = $typeMapper($pet['type']);
                    $guide = $vaccineGuide[$type];
                ?>
                    <div class="pet-vaccine-card">
                        <div class="pet-vaccine-header">
                            <div class="pet-avatar">
                                <?php echo ($type === 'Dog') ? '🐶' : (($type === 'Cat') ? '🐱' : '🐾'); ?>
                            </div>
                            <div class="pet-info">
                                <h2><?php echo htmlspecialchars($pet['name']); ?></h2>
                                <p><?php echo htmlspecialchars($pet['breed']); ?> • <?php echo htmlspecialchars($pet['age']); ?> Years Old</p>
                            </div>
                        </div>

                        <div class="vaccine-content">
                            <!-- Core Vaccines -->
                            <div class="vaccine-section">
                                <div class="vaccine-section-title">
                                    <span>🛡️</span> Core Vaccinations (Essential)
                                </div>
                                <table class="vaccine-table">
                                    <thead>
                                        <tr>
                                            <th>Vaccine</th>
                                            <th>Why it matters</th>
                                            <th>Frequency</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach ($guide['core'] as $vax): ?>
                                            <tr>
                                                <td><span class="vax-name"><?php echo $vax['name']; ?></span></td>
                                                <td><?php echo $vax['desc']; ?></td>
                                                <td><span class="vax-freq"><?php echo $vax['frequency']; ?></span></td>
                                            </tr>
                                        <?php endforeach; ?>
                                    </tbody>
                                </table>
                            </div>

                            <!-- Non-Core Vaccines -->
                            <?php if (!empty($guide['non_core'])): ?>
                                <div class="vaccine-section">
                                    <div class="vaccine-section-title">
                                        <span>💉</span> Lifestyle Vaccinations (Recommended)
                                    </div>
                                    <table class="vaccine-table">
                                        <thead>
                                            <tr>
                                                <th>Vaccine</th>
                                                <th>Who needs it?</th>
                                                <th>Frequency</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php foreach ($guide['non_core'] as $vax): ?>
                                                <tr>
                                                    <td><span class="vax-name"><?php echo $vax['name']; ?></span></td>
                                                    <td><?php echo $vax['desc']; ?></td>
                                                    <td><span class="vax-freq"><?php echo $vax['frequency']; ?></span></td>
                                                </tr>
                                            <?php endforeach; ?>
                                        </tbody>
                                    </table>
                                </div>
                            <?php endif; ?>
                            
                            <div class="mt-20">
                                <p style="font-size: 0.85rem; color: var(--gray-500); font-style: italic;">
                                    * This schedule is a general guide. Please consult with our veterinary team during your next 
                                    <a href="?url=appointment/create" style="color: var(--pink-500); font-weight: 700;">appointment</a> for a personalized plan.
                                </p>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>
    </main>
</div>

<?php require_once __DIR__ . '/../layouts/footer.php'; ?>
