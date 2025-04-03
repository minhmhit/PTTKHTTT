<?php require_once APP_ROOT . '/Views/layouts/header.php'; ?>
<h1>Giỏ hàng</h1>
<?php if (empty($_SESSION['cart'])): ?>
    <p>Giỏ hàng của bạn đang trống.</p>
<?php else: ?>
    <table class="table table-striped">
        <thead>
            <tr>
                <th>Sản phẩm</th>
                <th>Số lượng</th>
                <th>Giá</th>
                <th>Thành tiền</th>
                <th>Hành động</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($_SESSION['cart'] as $item): ?>
            <tr>
                <td><?php echo $item['name']; ?></td>
                <td>
                    <form action="<?php echo BASE_URL; ?>product/cart" method="post">
                        <input type="hidden" name="product_id" value="<?php echo $item['id']; ?>">
                        <input type="number" name="quantity" value="<?php echo $item['quantity']; ?>" min="1" max="<?php echo $item['stock']; ?>">
                        <button type="submit" name="update_cart" class="btn btn-sm btn-primary">Cập nhật</button>
                    </form>
                </td>
                <td><?php echo number_format($item['price'], 0, ',', '.'); ?> VNĐ</td>
                <td><?php echo number_format($item['price'] * $item['quantity'], 0, ',', '.'); ?> VNĐ</td>
                <td>
                    <form action="<?php echo BASE_URL; ?>product/cart" method="post">
                        <input type="hidden" name="product_id" value="<?php echo $item['id']; ?>">
                        <button type="submit" name="remove_item" class="btn btn-sm btn-danger">Xóa</button>
                    </form>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
    <p><strong>Tổng cộng:</strong> <?php echo number_format($data['total'], 0, ',', '.'); ?> VNĐ</p>
    <a href="<?php echo BASE_URL; ?>order/create" class="btn btn-success">Thanh toán</a>
    <form action="<?php echo BASE_URL; ?>product/cart" method="post">
        <button type="submit" name="clear_cart" class="btn btn-danger">Xóa giỏ hàng</button>
    </form>
<?php endif; ?>
<?php require_once APP_ROOT . '/Views/layouts/footer.php'; ?>