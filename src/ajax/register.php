<?php
include '../includes/db.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    die("Phương thức không hợp lệ.");
}

$username = filter_input(INPUT_POST, 'username', FILTER_SANITIZE_STRING);
$email = filter_input(INPUT_POST, 'email', FILTER_VALIDATE_EMAIL);
$password = filter_input(INPUT_POST, 'password', FILTER_SANITIZE_STRING);

if (!$username || !$email || !$password || strlen($username) < 3 || strlen($password) < 6) {
    echo "Dữ liệu không hợp lệ.";
    exit();
}

$stmt = $conn->prepare("SELECT id FROM users WHERE username = ? OR email = ?");
$stmt->bind_param("ss", $username, $email);
$stmt->execute();
if ($stmt->get_result()->num_rows > 0) {
    echo "Username hoặc email đã tồn tại.";
    exit();
}

$hashed_password = password_hash($password, PASSWORD_DEFAULT);
$stmt = $conn->prepare("INSERT INTO users (username, password, email) VALUES (?, ?, ?)");
$stmt->bind_param("sss", $username, $hashed_password, $email);

if ($stmt->execute()) {
    echo "Đăng ký thành công!";
} else {
    echo "Lỗi: " . $conn->error;
}
?>