<?php require_once APP_ROOT . '/Views/layouts/admin_header.php'; ?>
<h1>Thêm danh mục</h1>
<?php if (isset($data['errors'])): ?>
    <div class="alert alert-danger">
        <ul>
            <?php foreach ($data['errors'] as $error): ?>
                <li><?php echo $error; ?></li>
            <?php endforeach; ?>
        </ul>
    </div>
<?php endif; ?>
<form action="<?php echo BASE_URL; ?>admin/category/add" method="post">
    <div class="mb-3">
        <label for="name" class="form-label">Tên danh mục</label>
        <input type="text" class="form-control" id="name" name="name" required>
    </div>
    <div class="mb-3">
        <label for="description" class="form-label">Mô tả</label>
        <textarea class="form-control" id="description" name="description" rows="3"></textarea>
    </div>
    <button type="submit" class="btn btn-primary">Thêm</button>
</form>
<?php require_once APP_ROOT . '/Views/layouts/footer.php'; ?>