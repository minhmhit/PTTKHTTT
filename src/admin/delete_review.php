<?php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header("Location: ../login.php");
    exit();
}
include '../includes/db.php';

if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    header("Location: reviews.php");
    exit();
}

$id = (int)$_GET['id'];
$stmt = $conn->prepare("DELETE FROM reviews WHERE id = ?");
$stmt->bind_param("i", $id);
if ($stmt->execute() && $stmt->affected_rows > 0) {
    header("Location: reviews.php");
} else {
    echo "Lỗi khi xóa đánh giá.";
}
exit();
?>