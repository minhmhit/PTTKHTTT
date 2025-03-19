<?php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header("Location: ../login.php");
    exit();
}
include '../includes/db.php';
include 'includes/sidebar.php';
include '../includes/header.php';

if (isset($_POST['add_category'])) {
    $name = filter_input(INPUT_POST, 'name', FILTER_SANITIZE_STRING);
    $description = filter_input(INPUT_POST, 'description', FILTER_SANITIZE_STRING);

    if ($name) {
        $stmt = $conn->prepare("INSERT INTO categories (name, description) VALUES (?, ?)");
        $stmt->bind_param("ss", $name, $description);
        if ($stmt->execute()) {
            $_SESSION['message'] = 'Danh mục đã được thêm';
            header("Location: categories.php");
            exit();
        }
    }
}

$stmt = $conn->prepare("SELECT * FROM categories");
$stmt->execute();
$result = $stmt->get_result();
?>

<main>
    <h1>Quản lý danh mục</h1>
    <form method="post">
        <input type="text" name="name" placeholder="Tên danh mục" required>
        <textarea name="description" placeholder="Mô tả"></textarea>
        <button type="submit" name="add_category">Thêm</button>
    </form>

    <div id="category-list">
        <?php if ($result->num_rows === 0): ?>
            <p>Không có danh mục nào.</p>
        <?php else: ?>
            <?php while ($row = $result->fetch_assoc()): ?>
            <div>
                <h3><?php echo htmlspecialchars($row['name']); ?></h3>
                <p><?php echo htmlspecialchars($row['description'] ?? ''); ?></p>
            </div>
            <?php endwhile; ?>
        <?php endif; ?>
    </div>
</main>

<?php include '../includes/footer.php'; ?>