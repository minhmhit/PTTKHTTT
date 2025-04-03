<?php require_once APP_ROOT . '/Views/layouts/admin_header.php'; ?>
<div class="container">
    <h1><?php echo $data['title']; ?></h1>
    <?php flash('success'); ?>
    <?php flash('error'); ?>
    <form action="<?php echo BASE_URL; ?>admin/supplier/add" method="POST">
        <div class="mb-3">
            <label for="name" class="form-label">Tên nhà cung cấp</label>
            <input type="text" name="name" id="name" class="form-control" required>
        </div>
        <div class="mb-3">
            <label for="contact_name" class="form-label">Tên liên hệ</label>
            <input type="text" name="contact_name" id="contact_name" class="form-control" required>
        </div>
        <div class="mb-3">
            <label for="phone" class="form-label">Số điện thoại</label>
            <input type="text" name="phone" id="phone" class="form-control" required>
        </div>
        <div class="mb-3">
            <label for="email" class="form-label">Email</label>
            <input type="email" name="email" id="email" class="form-control" required>
        </div>
        <div class="mb-3">
            <label for="address" class="form-label">Địa chỉ</label>
            <textarea name="address" id="address" class="form-control" required></textarea>
        </div>
        <button type="submit" class="btn btn-primary">Thêm</button>
        <a href="<?php echo BASE_URL; ?>admin/supplier" class="btn btn-secondary">Quay lại</a>
    </form>
</div>
<?php require_once APP_ROOT . '/Views/layouts/footer.php'; ?>