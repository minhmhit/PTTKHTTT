<?php require_once APP_ROOT . '/Views/layouts/admin_header.php'; ?>
<div class="container">
    <h1><?php echo $data['title']; ?></h1>
    <?php flash('success'); ?>
    <?php flash('error'); ?>
    <a href="<?php echo BASE_URL; ?>admin/role/add" class="btn btn-primary mb-3">Thêm vai trò</a>
    <table class="table table-striped">
        <thead>
            <tr>
                <th>ID</th>
                <th>Tên vai trò</th>
                <th>Mô tả</th>
                <th>Hành động</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($data['roles'] as $role): ?>
                <tr>
                    <td><?php echo $role['id']; ?></td>
                    <td><?php echo $role['name']; ?></td>
                    <td><?php echo $role['description']; ?></td>
                    <td>
                        <a href="<?php echo BASE_URL; ?>admin/role/edit/<?php echo $role['id']; ?>" class="btn btn-warning btn-sm">Sửa</a>
                        <a href="<?php echo BASE_URL; ?>admin/role/delete/<?php echo $role['id']; ?>" class="btn btn-danger btn-sm" onclick="return confirm('Bạn có chắc muốn xóa?');">Xóa</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>
<?php require_once APP_ROOT . '/Views/layouts/footer.php'; ?>