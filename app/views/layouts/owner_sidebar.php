<?php
// Determine the active link based on the current URL
$currentUrl = $_GET['url'] ?? 'home/index';
?>
<aside class="sidebar">
    <div class="sidebar-header">
        <span class="paw-icon" aria-hidden="true">🏠</span>
        <h2>Owner Portal</h2>
    </div>
    
    <nav class="sidebar-nav">
        <a href="?url=owner/dashboard" class="sidebar-link <?php echo ($currentUrl === 'owner/dashboard') ? 'active' : ''; ?>">
            Dashboard
        </a>
        <a href="?url=pet/listPets" class="sidebar-link <?php echo ($currentUrl === 'pet/listPets') ? 'active' : ''; ?>">
            My Pets 🐾
        </a>
        <a href="?url=appointment/myAppointments" class="sidebar-link <?php echo (strpos($currentUrl, 'appointment/') === 0) ? 'active' : ''; ?>">
            Appointments 🗓️
        </a>
        <a href="#" class="sidebar-link">
            Health Tips
        </a>
    </nav>
    
    <div style="margin-top: auto; padding-top: 20px; border-top: 1px solid var(--pink-100);">
        <a href="?url=user/logout" class="sidebar-link" style="color: var(--pink-500);">
            Log Out
        </a>
    </div>
</aside>
