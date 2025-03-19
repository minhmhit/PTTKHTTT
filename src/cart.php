<?php
include 'includes/db.php';
include 'includes/header.php';

if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = [];
}

$cart_items = [];
if (!empty($_SESSION['cart'])) {
    $ids = implode(',', array_map('intval', array_keys($_SESSION['cart'])));
    $stmt = $conn->prepare("SELECT * FROM products WHERE id IN ($ids)");
    $stmt->execute();
    $result = $stmt->get_result();
    while ($row = $result->fetch_assoc()) {
        $cart_items[] = $row;
    }
}
?>

<main>
    <h1>Giỏ hàng</h1>
    <?php if (empty($cart_items)): ?>
        <p>Giỏ hàng trống.</p>
    <?php else: ?>
        <table>
            <tr><th>Sản phẩm</th><th>Số lượng</th><th>Giá</th><th>Tổng</th></tr>
            <?php foreach ($cart_items as $item): ?>
            <tr>
                <td><?php echo htmlspecialchars($item['name']); ?></td>
                <td><input type="number" value="<?php echo (int)$_SESSION['cart'][$item['id']]; ?>" min="1" onchange="updateCart(<?php echo $item['id']; ?>, this.value)"></td>
                <td><?php echo number_format($item['price'], 0, ',', '.'); ?>đ</td>
                <td><?php echo number_format($item['price'] * $_SESSION['cart'][$item['id']], 0, ',', '.'); ?>đ</td>
            </tr>
            <?php endforeach; ?>
        </table>
        <a href="checkout.php">Thanh toán</a>
    <?php endif; ?>
</main>

<script>
function updateCart(productId, quantity) {
    if (quantity < 1) quantity = 1;
    $.ajax({
        url: 'ajax/update_cart.php',
        method: 'POST',
        data: { product_id: productId, quantity: quantity },
        success: function(response) {
            Swal.fire('Thành công', response, 'success').then(() => location.reload());
        },
        error: function() {
            Swal.fire('Lỗi', 'Không thể cập nhật giỏ hàng.', 'error');
        }
    });
}
</script>

<?php include 'includes/footer.php'; ?>