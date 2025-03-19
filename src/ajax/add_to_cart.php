<?php
session_start();
include '../includes/db.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    die("Phương thức không hợp lệ.");
}

$product_id = filter_input(INPUT_POST, 'product_id', FILTER_VALIDATE_INT);
$quantity = filter_input(INPUT_POST, 'quantity', FILTER_VALIDATE_INT);

if (!$product_id || $quantity < 1) {
    die("Dữ liệu không hợp lệ.");
}

if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = [];
}

if (isset($_SESSION['cart'][$product_id])) {
    $_SESSION['cart'][$product_id] += $quantity;
} else {
    $_SESSION['cart'][$product_id] = $quantity;
}

echo "Đã thêm vào giỏ hàng!";
?>