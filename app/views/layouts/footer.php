<style>
/* Toast Container */
#toast-container {
    position: fixed;
    top: 20px;
    right: 20px;
    z-index: 9999;
    display: flex;
    flex-direction: column;
    gap: 10px;
    max-width: 400px;
    width: 90%;
}
.alert { animation: slideInRight 0.4s ease forwards; }
@keyframes slideInRight {
    from { opacity: 0; transform: translateX(100%); }
    to   { opacity: 1; transform: translateX(0);    }
}
</style>
<div id="toast-container"></div>
<script>
// Global Toast Helper
window.showToast = function(message, type = 'danger') {
    const container = document.getElementById('toast-container');
    const alert = document.createElement('div');
    alert.className = `alert alert-${type}`;
    
    // Icon mapping
    const icons = {
        'danger': '⚠️',
        'success': '✅',
        'info': 'ℹ️'
    };
    
    alert.innerHTML = `<span>${icons[type] || '🔔'}</span> ${message}`;
    container.appendChild(alert);
    
    // Auto-remove after 5 seconds
    setTimeout(() => {
        if (alert.parentElement) {
            alert.style.opacity = '0';
            setTimeout(() => alert.remove(), 300);
        }
    }, 5000);
};

// Global Alert Close Helper
document.addEventListener('DOMContentLoaded', function() {
    // Helper to add button to an alert
    function addCloseBtn(alert) {
        if (!alert.querySelector('.alert-close') && !alert.classList.contains('no-close')) {
            const closeBtn = document.createElement('button');
            closeBtn.className = 'alert-close';
            closeBtn.innerHTML = '×';
            closeBtn.setAttribute('aria-label', 'Close');
            alert.appendChild(closeBtn);
        }
    }

    // 1. Initial alerts
    document.querySelectorAll('.alert').forEach(addCloseBtn);

    // 2. Delegate click event for closing
    document.addEventListener('click', function(e) {
        if (e.target.classList.contains('alert-close')) {
            const alert = e.target.closest('.alert');
            if (alert) {
                alert.style.opacity = '0';
                setTimeout(() => alert.remove(), 300);
            }
        }
    });

    // 3. Watch for new alerts (for dynamic messages)
    const observer = new MutationObserver((mutations) => {
        mutations.forEach((mutation) => {
            mutation.addedNodes.forEach((node) => {
                if (node.nodeType === 1) {
                    if (node.classList.contains('alert')) addCloseBtn(node);
                    node.querySelectorAll('.alert').forEach(addCloseBtn);
                }
            });
        });
    });
    observer.observe(document.body, { childList: true, subtree: true });
});
</script>
</body>
</html>
