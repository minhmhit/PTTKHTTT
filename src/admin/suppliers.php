<?php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 'admin') {
    header("Location: ../login.php");
    exit();
}
include '../includes/db.php';
include 'includes/sidebar.php';
include '../includes/header.php';

// Thêm nhà cung cấp
if (isset($_POST['add_supplier'])) {
    $name = $_POST['name'];
    $contact_name = $_POST['contact_name'];
    $contact_email = $_POST['contact_email'];
    $phone = $_POST['phone'];
    $address = $_POST['address'];

    $stmt = $conn->prepare("INSERT INTO suppliers (name, contact_name, contact_email, phone, address) VALUES (?, ?, ?, ?, ?)");
    $stmt->bind_param("sssss", $name, $contact_name, $contact_email, $phone, $address);
    $stmt->execute();
    $_SESSION['message'] = 'Nhà cung cấp đã được thêm';
    header("Location: suppliers.php");
    exit();
}

// Hiển thị danh sách nhà cung cấp
$stmt = $conn->prepare("SELECT * FROM suppliers");
$stmt->execute();
$result = $stmt->get_result();
?>

<h2>Quản lý nhà cung cấp</h2>
<form method="post">
    <input type="text" name="name" placeholder="Tên nhà cung cấp" required>
    <input type="text" name="contact_name" placeholder="Tên liên hệ">
    <input type="email" name="contact_email" placeholder="Email liên hệ">
    <input type="text" name="phone" placeholder="Số điện thoại">
    <textarea name="address" placeholder="Địa chỉ"></textarea>
    <button type="submit" name="add_supplier">Thêm</button>
</form>

<div id="supplier-list">
    <?php while ($row = $result->fetch_assoc()): ?>
    <div>
        <h3><?php echo htmlspecialchars($row['name']); ?></h3>
        <p><?php echo htmlspecialchars($row['contact_email']); ?></p>
        <a href="edit_supplier.php?id=<?php echo $row['id']; ?>">Sửa</a>
    </div>
    <?php endwhile; ?>
</div>

<?php include '../includes/footer.php'; ?>