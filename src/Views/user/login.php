<?php require_once APP_ROOT . '/Views/layouts/header.php'; ?>
<h1>Đăng nhập</h1>
<?php if (isset($data['errors']['login'])): ?>
    <div class="alert alert-danger"><?php echo $data['errors']['login']; ?></div>
<?php endif; ?>
<form action="<?php echo BASE_URL; ?>user/login" method="post">
    <div class="mb-3">
        <label for="email" class="form-label">Email</label>
        <input type="email" class="form-control" id="email" name="email" required>
    </div>
    <div class="mb-3">
        <label for="password" class="form-label">Mật khẩu</label>
        <input type="password" class="form-control" id="password" name="password" required>
    </div>
    <button type="submit" class="btn btn-primary">Đăng nhập</button>
</form>
<?php require_once APP_ROOT . '/Views/layouts/footer.php'; ?>