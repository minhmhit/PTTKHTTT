<?php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 'admin') {
    header("Location: ../login.php");
    exit();
}
include '../includes/db.php';

$id = $_GET['id'];
$stmt = $conn->prepare("UPDATE reviews SET status = 'approved' WHERE id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
header("Location: reviews.php");
exit();
?>