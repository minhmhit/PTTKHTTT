<?php
include 'includes/db.php';
include 'includes/header.php';

if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    die("ID sản phẩm không hợp lệ.");
}

$product_id = (int)$_GET['id'];
$stmt = $conn->prepare("SELECT * FROM products WHERE id = ?");
$stmt->bind_param("i", $product_id);
$stmt->execute();
$product = $stmt->get_result()->fetch_assoc();

if (!$product) {
    die("Sản phẩm không tồn tại.");
}
?>

<main>
    <h1><?php echo htmlspecialchars($product['name']); ?></h1>
    <img src="public/images/<?php echo htmlspecialchars($product['image']); ?>" alt="<?php echo htmlspecialchars($product['name']); ?>">
    <p><?php echo htmlspecialchars($product['description']); ?></p>
    <p>Giá: <?php echo number_format($product['price'], 0, ',', '.'); ?>đ</p>

    <form id="add-to-cart-form">
        <input type="hidden" name="product_id" value="<?php echo $product['id']; ?>">
        <input type="number" name="quantity" value="1" min="1">
        <button type="submit">Thêm vào giỏ hàng</button>
    </form>
    <div id="message"></div>
</main>

<script>
$(document).ready(function() {
    $('#add-to-cart-form').on('submit', function(e) {
        e.preventDefault();
        const quantity = $('input[name="quantity"]').val();
        if (quantity < 1) {
            Swal.fire('Lỗi', 'Số lượng phải lớn hơn 0.', 'error');
            return;
        }
        $.ajax({
            url: 'ajax/add_to_cart.php',
            method: 'POST',
            data: $(this).serialize(),
            success: function(response) {
                Swal.fire('Thành công', response, 'success');
            },
            error: function() {
                Swal.fire('Lỗi', 'Không thể thêm vào giỏ hàng.', 'error');
            }
        });
    });
});
</script>

<?php include 'includes/footer.php'; ?>