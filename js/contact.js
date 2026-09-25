// Contact form handling
document.addEventListener('DOMContentLoaded', function() {
    const contactForm = document.getElementById('contact-form');
    
    if (contactForm) {
        contactForm.addEventListener('submit', function(e) {
            e.preventDefault();
            
            // Get form data
            const formData = new FormData(this);
            const data = Object.fromEntries(formData);
            
            // Validate form
            if (!data.name || !data.email || !data.message) {
                showNotification('Please fill in all required fields', 'error');
                return;
            }
            
            // Validate email
            const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
            if (!emailRegex.test(data.email)) {
                showNotification('Please enter a valid email address', 'error');
                return;
            }
            
            // Simulate form submission (replace with actual backend call if needed)
            submitContactForm(data);
        });
    }
});

function submitContactForm(data) {
    // Show loading state
    const submitBtn = document.querySelector('#contact-form button[type="submit"]');
    const originalText = submitBtn.innerHTML;
    submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Sending...';
    submitBtn.disabled = true;
    
    // Simulate API call (replace with actual fetch to backend)
    setTimeout(() => {
        // Reset button
        submitBtn.innerHTML = originalText;
        submitBtn.disabled = false;
        
        // Show success message
        showContactSuccess();
        
        // Reset form
        document.getElementById('contact-form').reset();
    }, 1500);
}

function showContactSuccess() {
    const successModal = document.createElement('div');
    successModal.className = 'modal';
    successModal.id = 'success-modal';
    successModal.style.display = 'block';
    
    successModal.innerHTML = `
        <div class="modal-content" style="max-width: 500px; text-align: center; padding: 40px;">
            <div style="color: #4caf50; font-size: 60px; margin-bottom: 20px;">
                <i class="fas fa-check-circle"></i>
            </div>
            <h2 style="color: #333; margin-bottom: 15px;">Message Sent Successfully!</h2>
            <p style="color: #666; font-size: 16px; line-height: 1.6;">
                Thank you for contacting HEALTHFORGE. We have received your message and will get back to you within 24 hours.
            </p>
            <button onclick="closeSuccessModal()" class="btn-primary" style="margin-top: 25px; padding: 12px 30px;">
                <i class="fas fa-check"></i> OK
            </button>
        </div>
    `;
    
    document.body.appendChild(successModal);
    document.body.style.overflow = 'hidden';
    
    // Auto close after 5 seconds
    setTimeout(() => {
        closeSuccessModal();
    }, 5000);
}

function closeSuccessModal() {
    const modal = document.getElementById('success-modal');
    if (modal) {
        modal.style.display = 'none';
        document.body.style.overflow = 'auto';
        modal.remove();
    }
}

function showNotification(message, type = 'info') {
    const notification = document.createElement('div');
    notification.className = `notification notification-${type}`;
    notification.innerHTML = `
        <div class="notification-content">
            <i class="fas fa-${type === 'success' ? 'check-circle' : type === 'error' ? 'exclamation-circle' : 'info-circle'}"></i>
            <span>${message}</span>
        </div>
    `;
    
    // Add CSS if not exists
    if (!document.getElementById('notification-styles')) {
        const style = document.createElement('style');
        style.id = 'notification-styles';
        style.textContent = `
            .notification {
                position: fixed;
                top: 100px;
                right: 20px;
                padding: 15px 20px;
                border-radius: 8px;
                box-shadow: 0 4px 12px rgba(0,0,0,0.15);
                z-index: 10000;
                animation: slideIn 0.3s ease-out;
                max-width: 350px;
            }
            .notification-success { background: #4caf50; color: white; }
            .notification-error { background: #f44336; color: white; }
            .notification-info { background: #2196f3; color: white; }
            .notification-content { display: flex; align-items: center; gap: 10px; }
            @keyframes slideIn {
                from { transform: translateX(400px); opacity: 0; }
                to { transform: translateX(0); opacity: 1; }
            }
        `;
        document.head.appendChild(style);
    }
    
    document.body.appendChild(notification);
    
    setTimeout(() => {
        notification.style.animation = 'slideIn 0.3s ease-out reverse';
        setTimeout(() => notification.remove(), 300);
    }, 3000);
}