<?php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header("Location: ../login.php");
    exit();
}
include '../includes/db.php';
include 'includes/sidebar.php';
include '../includes/header.php';

$stmt = $conn->prepare("SELECT r.*, p.name AS product_name, u.username FROM reviews r LEFT JOIN products p ON r.product_id = p.id LEFT JOIN users u ON r.user_id = u.id");
$stmt->execute();
$result = $stmt->get_result();
?>

<main>
    <h1>Quản lý đánh giá</h1>
    <div id="review-list">
        <?php if ($result->num_rows === 0): ?>
            <p>Không có đánh giá nào.</p>
        <?php else: ?>
            <?php while ($row = $result->fetch_assoc()): ?>
            <div>
                <p>Sản phẩm: <?php echo htmlspecialchars($row['product_name'] ?? 'Không xác định'); ?> - Đánh giá: <?php echo $row['rating']; ?>/5 - <?php echo htmlspecialchars($row['comment'] ?? ''); ?></p>
                <a href="delete_review.php?id=<?php echo $row['id']; ?>" onclick="return confirm('Bạn có chắc muốn xóa?')">Xóa</a>
            </div>
            <?php endwhile; ?>
        <?php endif; ?>
    </div>
</main>

<?php include '../includes/footer.php'; ?>