<?php
$currentUrl = $_GET['url'] ?? 'nurse/dashboard';
?>
<aside class="sidebar">
    <div class="sidebar-header">
        <span class="paw-icon" aria-hidden="true">👩‍⚕️</span>
        <h2>Nurse Portal</h2>
    </div>
    
    <nav class="sidebar-nav">
        <a href="?url=nurse/dashboard" class="sidebar-link <?php echo ($currentUrl === 'nurse/dashboard') ? 'active' : ''; ?>">
            Dashboard
        </a>
        <a href="?url=nurse/appointments" class="sidebar-link <?php echo (strpos($currentUrl, 'nurse/appointments') === 0) ? 'active' : ''; ?>">
            Patient Queue 📋
        </a>
        <a href="?url=pet/listPets" class="sidebar-link <?php echo (strpos($currentUrl, 'pet/') === 0) ? 'active' : ''; ?>">
            All Pets 🐾
        </a>
    </nav>
    
    <div style="margin-top: auto; padding-top: 20px; border-top: 1px solid var(--pink-100);">
        <a href="?url=user/logout" class="sidebar-link" style="color: var(--pink-500);">
            Log Out
        </a>
    </div>
</aside>
