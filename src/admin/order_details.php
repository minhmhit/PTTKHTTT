<?php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header("Location: ../login.php");
    exit();
}
include '../includes/db.php';
include 'includes/sidebar.php';
include '../includes/header.php';

if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    die("ID đơn hàng không hợp lệ.");
}

$order_id = (int)$_GET['id'];
$stmt = $conn->prepare("SELECT * FROM orders WHERE id = ?");
$stmt->bind_param("i", $order_id);
$stmt->execute();
$order = $stmt->get_result()->fetch_assoc();

if (!$order) {
    die("Đơn hàng không tồn tại.");
}

$stmt = $conn->prepare("SELECT oi.*, p.name FROM order_items oi LEFT JOIN products p ON oi.product_id = p.id WHERE oi.order_id = ?");
$stmt->bind_param("i", $order_id);
$stmt->execute();
$result = $stmt->get_result();
?>

<main>
    <h1>Chi tiết đơn hàng #<?php echo $order_id; ?></h1>
    <?php if ($result->num_rows === 0): ?>
        <p>Không có sản phẩm trong đơn hàng.</p>
    <?php else: ?>
        <?php while ($row = $result->fetch_assoc()): ?>
        <p><?php echo htmlspecialchars($row['name'] ?? 'Sản phẩm không xác định'); ?> x <?php echo $row['quantity']; ?> - <?php echo number_format($row['price'] * $row['quantity'], 0, ',', '.'); ?>đ</p>
        <?php endwhile; ?>
    <?php endif; ?>
    <p>Tổng tiền: <?php echo number_format($order['total_price'], 0, ',', '.'); ?>đ</p>
    <p>Trạng thái: <?php echo htmlspecialchars($order['status']); ?></p>

    <form method="post" action="update_order.php">
        <input type="hidden" name="order_id" value="<?php echo $order_id; ?>">
        <select name="status">
            <option value="pending" <?php echo $order['status'] === 'pending' ? 'selected' : ''; ?>>Đang chờ</option>
            <option value="shipped" <?php echo $order['status'] === 'shipped' ? 'selected' : ''; ?>>Đã giao</option>
            <option value="delivered" <?php echo $order['status'] === 'delivered' ? 'selected' : ''; ?>>Đã nhận</option>
        </select>
        <button type="submit">Cập nhật</button>
    </form>
</main>

<?php include '../includes/footer.php'; ?>