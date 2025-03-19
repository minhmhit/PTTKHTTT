<?php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    echo "error";
    exit();
}
include '../includes/db.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo "error";
    exit();
}

$id = filter_input(INPUT_POST, 'id', FILTER_VALIDATE_INT);
if (!$id) {
    echo "error";
    exit();
}

$stmt = $conn->prepare("DELETE FROM products WHERE id = ?");
$stmt->bind_param("i", $id);
if ($stmt->execute() && $stmt->affected_rows > 0) {
    echo "success";
} else {
    echo "error";
}
?>