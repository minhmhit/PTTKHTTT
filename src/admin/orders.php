<?php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header("Location: ../login.php");
    exit();
}
include '../includes/db.php';
include 'includes/sidebar.php';
include '../includes/header.php';

$stmt = $conn->prepare("SELECT o.*, u.username FROM orders o LEFT JOIN users u ON o.user_id = u.id");
$stmt->execute();
$result = $stmt->get_result();
?>

<main>
    <h1>Quản lý đơn hàng</h1>
    <div id="order-list">
        <?php if ($result->num_rows === 0): ?>
            <p>Không có đơn hàng nào.</p>
        <?php else: ?>
            <?php while ($row = $result->fetch_assoc()): ?>
            <div>
                <p>Đơn hàng #<?php echo $row['id']; ?> - Khách hàng: <?php echo htmlspecialchars($row['username'] ?? 'Khách vãng lai'); ?> - Trạng thái: <?php echo htmlspecialchars($row['status']); ?></p>
                <a href="order_details.php?id=<?php echo $row['id']; ?>">Xem chi tiết</a>
            </div>
            <?php endwhile; ?>
        <?php endif; ?>
    </div>
</main>

<?php include '../includes/footer.php'; ?>