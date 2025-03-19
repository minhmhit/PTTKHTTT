<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quán Cà Phê</title>
    <link rel="stylesheet" href="public/css/style.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
<body>
    <nav>
        <a href="index.php">Trang chủ</a>
        <a href="cart.php">Giỏ hàng</a>
        <?php
        session_start();
        if (isset($_SESSION['user_id'])): ?>
            <a href="account/addresses.php">Địa chỉ</a>
            <a href="account/wishlist.php">Yêu thích</a>
            <?php if (isset($_SESSION['role']) && $_SESSION['role'] == 'admin'): ?>
                <a href="admin/index.php">Admin</a>
            <?php endif; ?>
            <a href="logout.php">Đăng xuất</a>
        <?php else: ?>
            <a href="login.php">Đăng nhập</a>
            <a href="register.php">Đăng ký</a>
        <?php endif; ?>
    </nav>