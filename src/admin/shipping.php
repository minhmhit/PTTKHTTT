<?php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 'admin') {
    header("Location: ../login.php");
    exit();
}
include '../includes/db.php';
include 'includes/sidebar.php';
include '../includes/header.php';

// Hiển thị danh sách vận chuyển
$stmt = $conn->prepare("SELECT s.*, o.id as order_id FROM shipping s JOIN orders o ON s.order_id = o.id");
$stmt->execute();
$result = $stmt->get_result();
?>

<h2>Quản lý vận chuyển</h2>
<div id="shipping-list">
    <?php while ($row = $result->fetch_assoc()): ?>
    <div>
        <p>Đơn hàng #<?php echo $row['order_id']; ?> - Phương thức: <?php echo $row['shipping_method']; ?> - Chi phí: <?php echo number_format($row['shipping_cost'], 0, ',', '.'); ?>đ</p>
        <a href="edit_shipping.php?id=<?php echo $row['id']; ?>">Sửa</a>
    </div>
    <?php endwhile; ?>
</div>

<?php include '../includes/footer.php'; ?>