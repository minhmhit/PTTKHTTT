<?php require_once APP_ROOT . '/Views/layouts/admin_header.php'; ?>
<h1>Quản lý sản phẩm</h1>
<a href="<?php echo BASE_URL; ?>admin/product/add" class="btn btn-primary mb-3">Thêm sản phẩm</a>
<?php if (isset($_SESSION['success'])): ?>
    <div class="alert alert-success"><?php echo $_SESSION['success']; unset($_SESSION['success']); ?></div>
<?php endif; ?>
<?php if (isset($_SESSION['error'])): ?>
    <div class="alert alert-danger"><?php echo $_SESSION['error']; unset($_SESSION['error']); ?></div>
<?php endif; ?>
<table class="table table-striped">
    <thead>
        <tr>
            <th>ID</th>
            <th>Tên</th>
            <th>Danh mục</th>
            <th>Giá</th>
            <th>Số lượng</th>
            <th>Hành động</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($data['products'] as $product): ?>
        <tr>
            <td><?php echo $product['id']; ?></td>
            <td><?php echo $product['name']; ?></td>
            <td><?php echo $product['category_name']; ?></td>
            <td><?php echo number_format($product['price'], 0, ',', '.'); ?> VNĐ</td>
            <td><?php echo $product['stock']; ?></td>
            <td>
                <a href="<?php echo BASE_URL; ?>admin/product/edit/<?php echo $product['id']; ?>" class="btn btn-sm btn-warning">Sửa</a>
                <a href="<?php echo BASE_URL; ?>admin/product/delete/<?php echo $product['id']; ?>" class="btn btn-sm btn-danger" onclick="return confirm('Bạn có chắc muốn xóa?');">Xóa</a>
            </td>
        </tr>
        <?php endforeach; ?>
    </tbody>
</table>
<?php require_once APP_ROOT . '/Views/layouts/footer.php'; ?>