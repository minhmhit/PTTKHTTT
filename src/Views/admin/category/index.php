<?php require_once APP_ROOT . '/Views/layouts/admin_header.php'; ?>
<h1>Quản lý danh mục</h1>
<a href="<?php echo BASE_URL; ?>admin/category/add" class="btn btn-primary mb-3">Thêm danh mục</a>
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
            <th>Mô tả</th>
            <th>Hành động</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($data['categories'] as $category): ?>
        <tr>
            <td><?php echo $category['id']; ?></td>
            <td><?php echo $category['name']; ?></td>
            <td><?php echo $category['description']; ?></td>
            <td>
                <a href="<?php echo BASE_URL; ?>admin/category/edit/<?php echo $category['id']; ?>" class="btn btn-sm btn-warning">Sửa</a>
                <a href="<?php echo BASE_URL; ?>admin/category/delete/<?php echo $category['id']; ?>" class="btn btn-sm btn-danger" onclick="return confirm('Bạn có chắc muốn xóa?');">Xóa</a>
            </td>
        </tr>
        <?php endforeach; ?>
    </tbody>
</table>
<?php require_once APP_ROOT . '/Views/layouts/footer.php'; ?>