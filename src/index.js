document.addEventListener("DOMContentLoaded", function () {
    // Xử lý khi nhấn vào sản phẩm hoặc banner
    const products = document.querySelectorAll(".product img, .promo-img, .carousel-item img");
    products.forEach(product => {
        product.addEventListener("click", function () {
            showLoginAlert();
        });
    });

    // Xử lý khi nhấn vào nút Đăng nhập hoặc Đăng Ký trên navbar
    document.querySelectorAll(".nav-links a").forEach(link => {
        link.addEventListener("click", function (event) {
            if (this.textContent.trim() === "Đăng Nhập" || this.textContent.trim() === "Đăng Ký") {
                event.preventDefault(); // Ngăn chặn hành động mặc định
                window.location.href = "login.html"; // Chuyển hướng đến login.html
            }
        });
    });
});

// Hàm hiển thị bảng yêu cầu đăng nhập
function showLoginAlert() {
    const overlay = document.createElement("div");
    overlay.classList.add("overlay");
    overlay.innerHTML = `
        <div class="login-alert">
            <span class="close-btn" onclick="closeAlert()">&times;</span>
            <h3>Bạn cần đăng nhập để tiếp tục!</h3>
            <button onclick="redirectToLogin()">Đăng Nhập</button>
        </div>
    `;
    document.body.appendChild(overlay);
}

// Hàm chuyển hướng đến trang đăng nhập
function redirectToLogin() {
    window.location.href = "login.html";
}

// Hàm đóng bảng thông báo
function closeAlert() {
    document.querySelector(".overlay").remove();
}

// CSS để định dạng bảng thông báo
const style = document.createElement("style");
style.innerHTML = `
    .overlay {
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: rgba(0, 0, 0, 0.5);
        display: flex;
        justify-content: center;
        align-items: center;
    }
    .login-alert {
        background: white;
        padding: 30px;
        width: 350px;
        border-radius: 10px;
        text-align: center;
        position: relative;
    }
    .close-btn {
        position: absolute;
        top: 10px;
        right: 10px;
        font-size: 24px;
        cursor: pointer;
    }
    .login-alert button {
        margin: 15px;
        padding: 12px 24px;
        border: none;
        background:rgba(240, 167, 9, 0.77);
        color: white;
        cursor: pointer;
        border-radius: 5px;
        font-size: 16px;
    }
    .login-alert button:hover {
        background:rgba(122, 78, 1, 0.85);
    }
`;
document.head.appendChild(style);
