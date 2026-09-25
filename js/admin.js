// Admin JavaScript
document.addEventListener('DOMContentLoaded', function() {
    // View order details
    document.querySelectorAll('.view-order').forEach(btn => {
        btn.addEventListener('click', function() {
            const orderId = this.getAttribute('data-order');
            alert('View order details for order ID: ' + orderId);
        });
    });

    // Edit order
    document.querySelectorAll('.edit-order').forEach(btn => {
        btn.addEventListener('click', function() {
            const orderId = this.getAttribute('data-order');
            alert('Edit order: ' + orderId);
        });
    });

    // Quick action cards hover effects
    document.querySelectorAll('.quick-action-card').forEach(card => {
        card.addEventListener('mouseenter', function() {
            this.style.transform = 'translateY(-5px)';
        });
        
        card.addEventListener('mouseleave', function() {
            this.style.transform = 'translateY(0)';
        });
    });

    // Profile dropdown in admin
    const profileBtn = document.querySelector('.profile-btn');
    const dropdownMenu = document.querySelector('.dropdown-menu');
    
    if (profileBtn && dropdownMenu) {
        profileBtn.addEventListener('click', function(e) {
            e.stopPropagation();
            dropdownMenu.classList.toggle('show');
        });
        
        document.addEventListener('click', function() {
            dropdownMenu.classList.remove('show');
        });
    }
});

// Admin logout handler
function handleAdminLogout() {
    showLogoutAlert();
}

// Show logout confirmation alert
function showLogoutAlert() {
    removeExistingAlerts();

    const alert = document.createElement('div');
    alert.className = 'logout-alert';
    alert.style.cssText = `
        position: fixed;
        top: 100px;
        right: 20px;
        background: linear-gradient(135deg, #2e8b57, #228b22);
        color: white;
        padding: 20px;
        border-radius: 12px;
        box-shadow: 0 10px 30px rgba(0,0,0,0.3);
        z-index: 9999;
        display: flex;
        align-items: center;
        gap: 15px;
        max-width: 350px;
        animation: slideInRight 0.3s ease-out;
        border-left: 5px solid #90ee90;
    `;

    alert.innerHTML = `
        <i class="fas fa-sign-out-alt" style="font-size: 1.5rem;"></i>
        <div style="flex: 1;">
            <strong style="font-size: 1.1rem;">Logout Confirmation</strong>
            <p style="margin: 8px 0 0 0; font-size: 0.95rem; opacity: 0.9; line-height: 1.4;">
                Are you sure you want to logout from the admin panel?<br>
                <small style="opacity: 0.7;">You will be redirected to the main store.</small>
            </p>
        </div>
        <div style="display: flex; gap: 10px; flex-direction: column;">
            <button id="confirm-logout-btn" style="
                background: rgba(255,255,255,0.25);
                border: 2px solid rgba(255,255,255,0.4);
                color: white;
                padding: 8px 16px;
                border-radius: 6px;
                cursor: pointer;
                font-size: 0.9rem;
                font-weight: 600;
                transition: all 0.3s;
                white-space: nowrap;
            ">Yes, Logout</button>
            <button id="cancel-logout-btn" style="
                background: transparent;
                border: 2px solid rgba(255,255,255,0.3);
                color: white;
                padding: 8px 16px;
                border-radius: 6px;
                cursor: pointer;
                font-size: 0.9rem;
                font-weight: 600;
                transition: all 0.3s;
                white-space: nowrap;
            ">Cancel</button>
        </div>
    `;

    document.body.appendChild(alert);

    document.getElementById('confirm-logout-btn').addEventListener('click', function() {
        performLogout(alert);
    });

    document.getElementById('cancel-logout-btn').addEventListener('click', function() {
        removeAlert(alert);
    });

    setTimeout(() => {
        if (document.body.contains(alert)) {
            removeAlert(alert);
        }
    }, 15000);
}

// Remove existing alerts
function removeExistingAlerts() {
    const existingAlerts = document.querySelectorAll('.logout-alert');
    existingAlerts.forEach(alert => {
        alert.style.animation = 'slideOutRight 0.3s ease-out';
        setTimeout(() => {
            if (document.body.contains(alert)) {
                document.body.removeChild(alert);
            }
        }, 300);
    });
}

// Remove alert with animation
function removeAlert(alert) {
    alert.style.animation = 'slideOutRight 0.3s ease-out';
    setTimeout(() => {
        if (document.body.contains(alert)) {
            document.body.removeChild(alert);
        }
    }, 300);
}

// Perform the actual logout
async function performLogout(alert) {
    alert.innerHTML = `
        <i class="fas fa-spinner fa-spin" style="font-size: 1.2rem;"></i>
        <div style="flex: 1;">
            <strong>Logging out...</strong>
            <p style="margin: 5px 0 0 0; font-size: 0.9rem; opacity: 0.9;">Please wait</p>
        </div>
    `;

    try {
        const response = await fetch('auth/logout.php', {
            method: 'POST',
            headers: {
                'X-Requested-With': 'XMLHttpRequest',
                'Content-Type': 'application/json'
            }
        });
        
        if (!response.ok) {
            throw new Error('Network response was not ok');
        }
        
        const data = await response.json();
        
        if (data.success) {
            localStorage.removeItem('currentUser');
            sessionStorage.removeItem('currentUser');
            
            setTimeout(() => {
                window.location.href = 'index.html?action=logout&from=admin&t=' + new Date().getTime();
            }, 500);
        } else {
            throw new Error(data.message || 'Logout failed');
        }
    } catch (error) {
        console.error('Logout error:', error);
        localStorage.removeItem('currentUser');
        sessionStorage.removeItem('currentUser');
        setTimeout(() => {
            window.location.href = 'index.html?action=logout&from=admin&t=' + new Date().getTime();
        }, 500);
    }
}

// Add animation styles
const style = document.createElement('style');
style.textContent = `
    @keyframes slideInRight {
        from {
            transform: translateX(400px);
            opacity: 0;
        }
        to {
            transform: translateX(0);
            opacity: 1;
        }
    }
    @keyframes slideOutRight {
        from {
            transform: translateX(0);
            opacity: 1;
        }
        to {
            transform: translateX(400px);
            opacity: 0;
        }
    }
    .dropdown-menu.show {
        display: block;
    }
`;
document.head.appendChild(style);