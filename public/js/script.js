// Hàm hiển thị thông báo lỗi
function showErrors(errors) {
  const alertContainer = document.querySelector(".alert-container");

  // Tạo HTML cho error alert
  const errorHTML = `
        <div class="alert-danger">
            <ul>
                ${errors.map((error) => `<li>${escapeHtml(error)}</li>`).join("")}
            </ul>
        </div>
    `;

  // Chèn error vào container
  alertContainer.innerHTML = errorHTML;
}

// Hàm hiển thị thông báo thành công
function showSuccess(message) {
  const alertContainer = document.querySelector(".alert-container");

  const successHTML = `
        <div class="alert-success">
            ${escapeHtml(message)}
        </div>
    `;

  alertContainer.innerHTML = successHTML;
}

// Hàm xóa thông báo
function clearAlerts() {
  const alertContainer = document.querySelector(".alert-container");
  alertContainer.innerHTML = "";
}

// Hàm escape HTML để tránh XSS
function escapeHtml(text) {
  const div = document.createElement("div");
  div.textContent = text;
  return div.innerHTML;
}

// Tự động ẩn thông báo sau 5 giây (nếu muốn)
document.addEventListener("DOMContentLoaded", function () {
  const alerts = document.querySelectorAll(".alert-danger, .alert-success");

  if (alerts.length > 0) {
    setTimeout(() => {
      alerts.forEach((alert) => {
        alert.style.animation = "slideUp 0.3s ease";
        setTimeout(() => {
          clearAlerts();
        }, 300);
      });
    }, 5000);
  }
});

// Animation cho slideUp
const style = document.createElement("style");
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

function toggleMenu() {
  const navMenu = document.getElementById("navMenu");
  navMenu.classList.toggle("active");
}

document.addEventListener("click", function (event) {
  const navMenu = document.getElementById("navMenu");
  const menuToggle = document.querySelector(".menu-toggle");

  if (!event.target.closest("nav") && navMenu.classList.contains("active")) {
    navMenu.classList.remove("active");
  }
});

// Handle dropdown on mobile
document.querySelectorAll(".nav-item").forEach((item) => {
  item.addEventListener("click", function (e) {
    if (window.innerWidth <= 992) {
      if (this.querySelector(".dropdown-content")) {
        e.preventDefault();
        this.classList.toggle("active");
      }
    }
  });
});
