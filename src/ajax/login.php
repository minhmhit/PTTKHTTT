<?php
session_start();
include '../includes/db.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    die("Phương thức không hợp lệ.");
}

$username = filter_input(INPUT_POST, 'username', FILTER_SANITIZE_STRING);
$password = filter_input(INPUT_POST, 'password', FILTER_SANITIZE_STRING);

if (empty($username) || empty($password)) {
    echo "Vui lòng nhập đầy đủ thông tin.";
    exit();
}

$stmt = $conn->prepare("SELECT * FROM users WHERE username = ?");
$stmt->bind_param("s", $username);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
    echo "Tài khoản không tồn tại!";
    exit();
}

$user = $result->fetch_assoc();
if (password_verify($password, $user['password'])) {
    $_SESSION['user_id'] = $user['id'];
    $_SESSION['role'] = $user['role'];
    echo "success";
} else {
    echo "Sai mật khẩu!";
}
?>