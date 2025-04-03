<?php require_once APP_ROOT . '/Views/layouts/admin_header.php'; ?>
<div class="container">
    <h1><?php echo $data['title']; ?></h1>
    <?php flash('success'); ?>
    <?php flash('error'); ?>
    <a href="<?php echo BASE_URL; ?>admin/supplier/add" class="btn btn-primary mb-3">Thêm nhà cung cấp</a>
    <table class="table table-striped">
        <thead>
            <tr>
                <th>ID</th>
                <th>Tên</th>
                <th>Liên hệ</th>
                <th>Số điện thoại</th>
                <th>Email</th>
                <th>Hành động</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($data['suppliers'] as $supplier): ?>
                <tr>
                    <td><?php echo $supplier['id']; ?></td>
                    <td><?php echo $supplier['name']; ?></td>
                    <td><?php echo $supplier['contact_name']; ?></td>
                    <td><?php echo $supplier['phone']; ?></td>
                    <td><?php echo $supplier['email']; ?></td>
                    <td>
                        <a href="<?php echo BASE_URL; ?>admin/supplier/edit/<?php echo $supplier['id']; ?>" class="btn btn-warning btn-sm">Sửa</a>
                        <a href="<?php echo BASE_URL; ?>admin/supplier/delete/<?php echo $supplier['id']; ?>" class="btn btn-danger btn-sm" onclick="return confirm('Bạn có chắc muốn xóa?');">Xóa</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>
<?php require_once APP_ROOT . '/Views/layouts/footer.php'; ?>