<?php
class AuthMiddleware {
    public function handle() {
        // Kiểm tra đã đăng nhập chưa
        if (!isset($_SESSION['user_id'])) {
            // Chuyển hướng đến trang đăng nhập
            header('Location: ' . BASE_URL . 'user/login');
            exit;
        }
    }
}