<?php require_once APP_ROOT . '/Views/layouts/header.php'; ?>
<div class="container mt-5">
    <h1><?php echo $data['title']; ?></h1>
    <?php flash('success'); ?>
    <?php flash('error'); ?>
    <?php if (!empty($data['cart'])): ?>
        <table class="table table-striped">
            <thead>
                <tr><th>ID Sản phẩm</th><th>Số lượng</th><th>Hành động</th></tr>
            </thead>
            <tbody>
                <?php foreach ($data['cart'] as $productId => $quantity): ?>
                    <tr>
                        <td><?php echo $productId; ?></td>
                        <td><?php echo $quantity; ?></td>
                        <td>
                            <a href="<?php echo BASE_URL; ?>cart/remove/<?php echo $productId; ?>" class="btn btn-danger btn-sm">Xóa</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php else: ?>
        <p>Giỏ hàng trống.</p>
    <?php endif; ?>
    <a href="<?php echo BASE_URL; ?>" class="btn btn-secondary">Tiếp tục mua sắm</a>
</div>
<?php require_once APP_ROOT . '/Views/layouts/footer.php'; ?>