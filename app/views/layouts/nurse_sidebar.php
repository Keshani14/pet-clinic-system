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
            <span class="icon">📊</span> Dashboard
        </a>
        <a href="?url=appointment/create" class="sidebar-link <?php echo ($currentUrl === 'appointment/create') ? 'active' : ''; ?>">
            <span class="icon">🗓️</span> Book Appointment
        </a>
        <a href="?url=nurse/appointments" class="sidebar-link <?php echo (strpos($currentUrl, 'nurse/appointments') === 0) ? 'active' : ''; ?>">
            <span class="icon">📋</span> Patient Queue
        </a>
        <a href="?url=pet/listPets" class="sidebar-link <?php echo (strpos($currentUrl, 'pet/') === 0) ? 'active' : ''; ?>">
            <span class="icon">🐾</span> All Pets
        </a>

        <a href="?url=user/profile" class="sidebar-link <?php echo ($currentUrl === 'user/profile') ? 'active' : ''; ?>">
            <span class="icon">👤</span> My Profile
        </a>
    </nav>
    
    <div style="margin-top: auto; padding-top: 20px; border-top: 1px solid var(--pink-100);">
        <a href="?url=user/logout" class="sidebar-link" style="color: var(--pink-500);">
            Log Out
        </a>
    </div>
</aside>
