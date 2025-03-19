<?php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header("Location: ../login.php");
    exit();
}
include '../includes/db.php';
include 'includes/sidebar.php';
include '../includes/header.php';

$categories = $conn->query("SELECT * FROM categories");
$suppliers = $conn->query("SELECT * FROM suppliers");

if (isset($_POST['add_product'])) {
    $name = filter_input(INPUT_POST, 'name', FILTER_SANITIZE_STRING);
    $description = filter_input(INPUT_POST, 'description', FILTER_SANITIZE_STRING);
    $price = filter_input(INPUT_POST, 'price', FILTER_VALIDATE_FLOAT);
    $type = filter_input(INPUT_POST, 'type', FILTER_SANITIZE_STRING);
    $origin = filter_input(INPUT_POST, 'origin', FILTER_SANITIZE_STRING);
    $category_id = filter_input(INPUT_POST, 'category_id', FILTER_VALIDATE_INT);
    $supplier_id = filter_input(INPUT_POST, 'supplier_id', FILTER_VALIDATE_INT);
    $image = $_FILES['image']['name'];

    if ($name && $price && $type && $category_id && $supplier_id && $image && in_array($type, ['hat', 'bot', 'goi'])) {
        if (move_uploaded_file($_FILES['image']['tmp_name'], "../public/images/$image")) {
            $stmt = $conn->prepare("INSERT INTO products (name, description, price, image, type, origin, category_id, supplier_id) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
            $stmt->bind_param("ssdsssii", $name, $description, $price, $image, $type, $origin, $category_id, $supplier_id);
            if ($stmt->execute()) {
                $_SESSION['message'] = 'Sản phẩm đã được thêm';
                header("Location: products.php");
                exit();
            }
        }
    }
}

$stmt = $conn->prepare("SELECT p.*, c.name AS category_name, s.name AS supplier_name FROM products p JOIN categories c ON p.category_id = c.id JOIN suppliers s ON p.supplier_id = s.id");
$stmt->execute();
$result = $stmt->get_result();
?>

<main>
    <h1>Quản lý sản phẩm</h1>
    <form method="post" enctype="multipart/form-data">
        <input type="text" name="name" placeholder="Tên sản phẩm" required>
        <textarea name="description" placeholder="Mô tả"></textarea>
        <input type="number" name="price" placeholder="Giá" step="0.01" required>
        <select name="type" required>
            <option value="hat">Cà phê hạt</option>
            <option value="bot">Cà phê bột</option>
            <option value="goi">Cà phê gói</option>
        </select>
        <input type="text" name="origin" placeholder="Xuất xứ">
        <select name="category_id" required>
            <?php while ($row = $categories->fetch_assoc()): ?>
                <option value="<?php echo $row['id']; ?>"><?php echo htmlspecialchars($row['name']); ?></option>
            <?php endwhile; ?>
        </select>
        <select name="supplier_id" required>
            <?php while ($row = $suppliers->fetch_assoc()): ?>
                <option value="<?php echo $row['id']; ?>"><?php echo htmlspecialchars($row['name']); ?></option>
            <?php endwhile; ?>
        </select>
        <input type="file" name="image" required>
        <button type="submit" name="add_product">Thêm</button>
    </form>

    <div id="product-list">
        <?php if ($result->num_rows === 0): ?>
            <p>Không có sản phẩm nào.</p>
        <?php else: ?>
            <?php while ($row = $result->fetch_assoc()): ?>
            <div>
                <h3><?php echo htmlspecialchars($row['name']); ?></h3>
                <p>Danh mục: <?php echo htmlspecialchars($row['category_name']); ?> - Nhà cung cấp: <?php echo htmlspecialchars($row['supplier_name']); ?></p>
            </div>
            <?php endwhile; ?>
        <?php endif; ?>
    </div>
</main>

<?php include '../includes/footer.php'; ?>