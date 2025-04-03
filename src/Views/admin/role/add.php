<?php require_once APP_ROOT . '/Views/layouts/admin_header.php'; ?>
<div class="container">
    <h1><?php echo $data['title']; ?></h1>
    <?php flash('success'); ?>
    <?php flash('error'); ?>
    <form action="<?php echo BASE_URL; ?>admin/role/add" method="POST">
        <div class="mb-3">
            <label for="name" class="form-label">Tên vai trò</label>
            <input type="text" name="name" id="name" class="form-control" required>
        </div>
        <div class="mb-3">
            <label for="description" class="form-label">Mô tả</label>
            <textarea name="description" id="description" class="form-control"></textarea>
        </div>
        <div class="mb-3">
            <label class="form-label">Quyền</label>
            <?php foreach ($data['permissions'] as $permission): ?>
                <div class="form-check">
                    <input type="checkbox" name="permissions[]" value="<?php echo $permission['id']; ?>" id="perm_<?php echo $permission['id']; ?>" class="form-check-input">
                    <label for="perm_<?php echo $permission['id']; ?>" class="form-check-label"><?php echo $permission['name']; ?></label>
                </div>
            <?php endforeach; ?>
        </div>
        <button type="submit" class="btn btn-primary">Thêm</button>
        <a href="<?php echo BASE_URL; ?>admin/role" class="btn btn-secondary">Quay lại</a>
    </form>
</div>
<?php require_once APP_ROOT . '/Views/layouts/footer.php'; ?>