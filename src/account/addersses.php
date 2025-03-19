<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: ../login.php");
    exit();
}
include '../includes/db.php';
include '../includes/header.php';

if (isset($_POST['add_address'])) {
    $user_id = $_SESSION['user_id'];
    $address_line1 = filter_input(INPUT_POST, 'address_line1', FILTER_SANITIZE_STRING);
    $city = filter_input(INPUT_POST, 'city', FILTER_SANITIZE_STRING);
    $country = filter_input(INPUT_POST, 'country', FILTER_SANITIZE_STRING);
    $is_default = isset($_POST['is_default']) ? 1 : 0;

    if ($address_line1 && $city && $country) {
        $stmt = $conn->prepare("INSERT INTO addresses (user_id, address_line1, city, country, is_default) VALUES (?, ?, ?, ?, ?)");
        $stmt->bind_param("isssi", $user_id, $address_line1, $city, $country, $is_default);
        if ($stmt->execute()) {
            $_SESSION['message'] = 'Địa chỉ đã được thêm';
            header("Location: addresses.php");
            exit();
        }
    }
}

$user_id = $_SESSION['user_id'];
$stmt = $conn->prepare("SELECT * FROM addresses WHERE user_id = ?");
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
?>

<main>
    <h1>Quản lý địa chỉ</h1>
    <form method="post">
        <input type="text" name="address_line1" placeholder="Địa chỉ" required>
        <input type="text" name="city" placeholder="Thành phố" required>
        <input type="text" name="country" placeholder="Quốc gia" required>
        <label><input type="checkbox" name="is_default"> Mặc định</label>
        <button type="submit" name="add_address">Thêm</button>
    </form>

    <div id="address-list">
        <?php if ($result->num_rows === 0): ?>
            <p>Không có địa chỉ nào.</p>
        <?php else: ?>
            <?php while ($row = $result->fetch_assoc()): ?>
            <div>
                <p><?php echo htmlspecialchars($row['address_line1'] . ', ' . $row['city'] . ', ' . $row['country']); ?></p>
            </div>
            <?php endwhile; ?>
        <?php endif; ?>
    </div>
</main>

<?php include '../includes/footer.php'; ?>