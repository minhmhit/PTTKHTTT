<?php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header("Location: ../login.php");
    exit();
}
include '../includes/db.php';
include 'includes/sidebar.php';
include '../includes/header.php';

if (isset($_POST['add_coupon'])) {
    $code = filter_input(INPUT_POST, 'code', FILTER_SANITIZE_STRING);
    $description = filter_input(INPUT_POST, 'description', FILTER_SANITIZE_STRING);
    $discount_percentage = filter_input(INPUT_POST, 'discount_percentage', FILTER_VALIDATE_FLOAT);
    $valid_from = filter_input(INPUT_POST, 'valid_from', FILTER_SANITIZE_STRING);
    $valid_to = filter_input(INPUT_POST, 'valid_to', FILTER_SANITIZE_STRING);
    $usage_limit = filter_input(INPUT_POST, 'usage_limit', FILTER_VALIDATE_INT);

    if ($code && $discount_percentage && $valid_from && $valid_to && $usage_limit) {
        $stmt = $conn->prepare("INSERT INTO coupons (code, description, discount_percentage, valid_from, valid_to, usage_limit) VALUES (?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("ssdssi", $code, $description, $discount_percentage, $valid_from, $valid_to, $usage_limit);
        if ($stmt->execute()) {
            $_SESSION['message'] = 'Mã giảm giá đã được thêm';
            header("Location: coupons.php");
            exit();
        }
    }
}

$stmt = $conn->prepare("SELECT * FROM coupons");
$stmt->execute();
$result = $stmt->get_result();
?>

<main>
    <h1>Quản lý mã giảm giá</h1>
    <form method="post">
        <input type="text" name="code" placeholder="Mã giảm giá" required>
        <textarea name="description" placeholder="Mô tả"></textarea>
        <input type="number" name="discount_percentage" placeholder="Phần trăm giảm giá" step="0.01" required>
        <input type="date" name="valid_from" required>
        <input type="date" name="valid_to" required>
        <input type="number" name="usage_limit" placeholder="Số lần sử dụng" required>
        <button type="submit" name="add_coupon">Thêm</button>
    </form>

    <div id="coupon-list">
        <?php if ($result->num_rows === 0): ?>
            <p>Không có mã giảm giá nào.</p>
        <?php else: ?>
            <?php while ($row = $result->fetch_assoc()): ?>
            <div>
                <h3><?php echo htmlspecialchars($row['code']); ?> - <?php echo $row['discount_percentage']; ?>%</h3>
                <p>Hiệu lực: <?php echo $row['valid_from']; ?> đến <?php echo $row['valid_to']; ?></p>
            </div>
            <?php endwhile; ?>
        <?php endif; ?>
    </div>
</main>

<?php include '../includes/footer.php'; ?>