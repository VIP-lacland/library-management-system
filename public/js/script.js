// Hàm hiển thị thông báo lỗi
function showErrors(errors) {
    const alertContainer = document.querySelector('.alert-container');
    
    // Tạo HTML cho error alert
    const errorHTML = `
        <div class="alert-danger">
            <ul>
                ${errors.map(error => `<li>${escapeHtml(error)}</li>`).join('')}
            </ul>
        </div>
    `;
    
    // Chèn error vào container
    alertContainer.innerHTML = errorHTML;
}

// Hàm hiển thị thông báo thành công
function showSuccess(message) {
    const alertContainer = document.querySelector('.alert-container');
    
    const successHTML = `
        <div class="alert-success">
            ${escapeHtml(message)}
        </div>
    `;
    
    alertContainer.innerHTML = successHTML;
}

// Hàm xóa thông báo
function clearAlerts() {
    const alertContainer = document.querySelector('.alert-container');
    alertContainer.innerHTML = '';
}

// Hàm escape HTML để tránh XSS
function escapeHtml(text) {
    const div = document.createElement('div');
    div.textContent = text;
    return div.innerHTML;
}

// Validate form khi submit
document.querySelector('form').addEventListener('submit', function(e) {
    e.preventDefault(); // Tạm dừng submit để validate
    
    // Xóa thông báo cũ
    clearAlerts();
    
    // Lấy giá trị từ form
    const username = document.getElementById('username').value.trim();
    const email = document.getElementById('email').value.trim();
    const password = document.getElementById('password').value;
    const confirmPassword = document.getElementById('confirm_password').value;
    
    // Mảng chứa lỗi
    const errors = [];
    
    // Validate username
    if (username.length < 3) {
        errors.push('Tên người dùng phải có ít nhất 3 ký tự');
    }
    
    // Validate email
    const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    if (!emailRegex.test(email)) {
        errors.push('Email không hợp lệ');
    }
    
    // Validate password
    if (password.length < 8) {
        errors.push('Mật khẩu phải có ít nhất 8 ký tự');
    }
    
    // Validate confirm password
    if (password !== confirmPassword) {
        errors.push('Mật khẩu xác nhận không khớp');
    }
    
    // Nếu có lỗi, hiển thị
    if (errors.length > 0) {
        showErrors(errors);
        
        // Scroll đến vị trí alert
        document.querySelector('.alert-container').scrollIntoView({ 
            behavior: 'smooth', 
            block: 'center' 
        });
        
        return false;
    }
    
    // Nếu không có lỗi, submit form
    this.submit();
});

// Tự động ẩn thông báo sau 5 giây (nếu muốn)
document.addEventListener('DOMContentLoaded', function() {
    const alerts = document.querySelectorAll('.alert-danger, .alert-success');
    
    if (alerts.length > 0) {
        setTimeout(() => {
            alerts.forEach(alert => {
                alert.style.animation = 'slideUp 0.3s ease';
                setTimeout(() => {
                    clearAlerts();
                }, 300);
            });
        }, 5000);
    }
});

// Animation cho slideUp
const style = document.createElement('style');
style.textContent = `
    @keyframes slideUp {
        from {
            opacity: 1;
            transform: translateY(0);
        }
        to {
            opacity: 0;
            transform: translateY(-10px);
        }
    }
`;
document.head.appendChild(style);