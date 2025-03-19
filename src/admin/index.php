<?php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header("Location: ../login.php");
    exit();
}
include '../includes/db.php';
include 'includes/sidebar.php';
include '../includes/header.php';

$total_products = $conn->query("SELECT COUNT(*) FROM products")->fetch_row()[0] ?? 0;
$total_orders = $conn->query("SELECT COUNT(*) FROM orders")->fetch_row()[0] ?? 0;
$total_sales = $conn->query("SELECT SUM(total_price) FROM orders WHERE status = 'delivered'")->fetch_row()[0] ?? 0;
?>

<main>
    <h1>Dashboard</h1>
    <p>Tổng số sản phẩm: <?php echo $total_products; ?></p>
    <p>Tổng số đơn hàng: <?php echo $total_orders; ?></p>
    <p>Tổng doanh thu: <?php echo number_format($total_sales, 0, ',', '.'); ?>đ</p>
</main>

<?php include '../includes/footer.php'; ?>