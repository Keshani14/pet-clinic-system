<?php
// Determine the active link based on the current URL
$currentUrl = $_GET['url'] ?? 'home/index';
?>
<aside class="sidebar">
    <div class="sidebar-header">
        <span class="paw-icon" aria-hidden="true">🩺</span>
        <h2>Vet Portal</h2>
    </div>
    
    <nav class="sidebar-nav">
        <a href="?url=vet/dashboard" class="sidebar-link <?php echo ($currentUrl === 'vet/dashboard') ? 'active' : ''; ?>">
            Dashboard
        </a>
        <a href="?url=pet/listPets" class="sidebar-link <?php echo ($currentUrl === 'pet/listPets') ? 'active' : ''; ?>">
            Patient Records
        </a>
        <a href="?url=medical/index" class="sidebar-link <?php echo (strpos($currentUrl, 'medical/') === 0) ? 'active' : ''; ?>">
            Medical Records
        </a>
        <a href="?url=vet/appointments" class="sidebar-link <?php echo ($currentUrl === 'vet/appointments') ? 'active' : ''; ?>">
            Appointments
        </a>
    </nav>
    
    <div style="margin-top: auto; padding-top: 20px; border-top: 1px solid var(--pink-100);">
        <a href="?url=user/logout" class="sidebar-link" style="color: var(--pink-500);">
            Log Out
        </a>
    </div>
</aside>
