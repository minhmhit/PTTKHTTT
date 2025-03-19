<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: ../login.php");
    exit();
}
include '../includes/db.php';
include '../includes/header.php';

$user_id = $_SESSION['user_id'];
$stmt = $conn->prepare("SELECT w.*, p.name, p.price FROM wishlist w LEFT JOIN products p ON w.product_id = p.id WHERE w.user_id = ?");
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
?>

<main>
    <h1>Danh sách yêu thích</h1>
    <div id="wishlist">
        <?php if ($result->num_rows === 0): ?>
            <p>Không có sản phẩm nào trong danh sách yêu thích.</p>
        <?php else: ?>
            <?php while ($row = $result->fetch_assoc()): ?>
            <div>
                <h3><?php echo htmlspecialchars($row['name'] ?? 'Sản phẩm không xác định'); ?></h3>
                <p>Giá: <?php echo number_format($row['price'] ?? 0, 0, ',', '.'); ?>đ</p>
            </div>
            <?php endwhile; ?>
        <?php endif; ?>
    </div>
</main>

<?php include '../includes/footer.php'; ?>