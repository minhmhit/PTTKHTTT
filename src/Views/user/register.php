<?php require_once APP_ROOT . '/Views/layouts/header.php'; ?>
<h1>Đăng ký</h1>
<?php if (isset($data['errors'])): ?>
    <div class="alert alert-danger">
        <ul>
            <?php foreach ($data['errors'] as $error): ?>
                <li><?php echo $error; ?></li>
            <?php endforeach; ?>
        </ul>
    </div>
<?php endif; ?>
<form action="<?php echo BASE_URL; ?>user/register" method="post">
    <div class="mb-3">
        <label for="name" class="form-label">Tên</label>
        <input type="text" class="form-control" id="name" name="name" required>
    </div>
    <div class="mb-3">
        <label for="email" class="form-label">Email</label>
        <input type="email" class="form-control" id="email" name="email" required>
    </div>
    <div class="mb-3">
        <label for="password" class="form-label">Mật khẩu</label>
        <input type="password" class="form-control" id="password" name="password" required>
    </div>
    <div class="mb-3">
        <label for="confirm_password" class="form-label">Xác nhận mật khẩu</label>
        <input type="password" class="form-control" id="confirm_password" name="confirm_password" required>
    </div>
    <div class="mb-3">
        <label for="phone" class="form-label">Số điện thoại</label>
        <input type="text" class="form-control" id="phone" name="phone" required>
    </div>
    <div class="mb-3">
        <label for="address" class="form-label">Địa chỉ</label>
        <input type="text" class="form-control" id="address" name="address" required>
    </div>
    <button type="submit" class="btn btn-primary">Đăng ký</button>
</form>
<?php require_once APP_ROOT . '/Views/layouts/footer.php'; ?>