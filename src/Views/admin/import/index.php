<?php require_once APP_ROOT . '/Views/layouts/admin_header.php'; ?>
<div class="container">
    <h1><?php echo $data['title']; ?></h1>
    <?php flash('success'); ?>
    <?php flash('error'); ?>
    <a href="<?php echo BASE_URL; ?>admin/import/add" class="btn btn-primary mb-3">Thêm nhập hàng</a>
    <table class="table table-striped">
        <thead>
            <tr>
                <th>ID</th>
                <th>Nhân viên</th>
                <th>Nhà cung cấp</th>
                <th>Tổng chi phí</th>
                <th>Trạng thái</th>
                <th>Ngày tạo</th>
                <th>Hành động</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($data['imports'] as $import): ?>
                <tr>
                    <td><?php echo $import['id']; ?></td>
                    <td><?php echo $import['user_name']; ?></td>
                    <td><?php echo $import['supplier_name']; ?></td>
                    <td><?php echo number_format($import['total_cost']); ?></td>
                    <td><?php echo $import['status']; ?></td>
                    <td><?php echo $import['created_at']; ?></td>
                    <td>
                        <a href="<?php echo BASE_URL; ?>admin/import/view/<?php echo $import['id']; ?>" class="btn btn-info btn-sm">Xem</a>
                        <a href="<?php echo BASE_URL; ?>admin/import/edit/<?php echo $import['id']; ?>" class="btn btn-warning btn-sm">Sửa</a>
                        <a href="<?php echo BASE_URL; ?>admin/import/delete/<?php echo $import['id']; ?>" class="btn btn-danger btn-sm" onclick="return confirm('Bạn có chắc muốn xóa?');">Xóa</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>
<?php require_once APP_ROOT . '/Views/layouts/footer.php'; ?>