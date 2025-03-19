<?php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 'admin') {
    header("Location: ../login.php");
    exit();
}
include '../includes/db.php';
include 'includes/sidebar.php';
include '../includes/header.php';

// Hiển thị danh sách người dùng
$stmt = $conn->prepare("SELECT * FROM users");
$stmt->execute();
$result = $stmt->get_result();
?>

<h2>Quản lý người dùng</h2>
<div id="user-list">
    <?php while ($row = $result->fetch_assoc()): ?>
    <div>
        <p><?php echo htmlspecialchars($row['username']); ?> - <?php echo htmlspecialchars($row['email']); ?> - <?php echo $row['role']; ?></p>
        <a href="edit_user.php?id=<?php echo $row['id']; ?>">Sửa</a>
    </div>
    <?php endwhile; ?>
</div>

<?php include '../includes/footer.php'; ?>