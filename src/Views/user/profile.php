<?php require_once APP_ROOT . '/Views/layouts/header.php'; ?>
<h1>Hồ sơ người dùng</h1>
<?php if (isset($_SESSION['success'])): ?>
    <div class="alert alert-success"><?php echo $_SESSION['success']; unset($_SESSION['success']); ?></div>
<?php endif; ?>
<?php if (isset($data['errors'])): ?>
    <div class="alert alert-danger">
        <ul>
            <?php foreach ($data['errors'] as $error): ?>
                <li><?php echo $error; ?></li>
            <?php endforeach; ?>
        </ul>
    </div>
<?php endif; ?>
<form action="<?php echo BASE_URL; ?>user/profile" method="post">
    <div class="mb-3">
        <label for="name" class="form-label">Tên</label>
        <input type="text" class="form-control" id="name" name="name" value="<?php echo $data['user']['name']; ?>" required>
    </div>
    <div class="mb-3">
        <label for="phone" class="form-label">Số điện thoại</label>
        <input type="text" class="form-control" id="phone" name="phone" value="<?php echo $data['user']['phone']; ?>" required>
    </div>
    <div class="mb-3">
        <label for="address" class="form-label">Địa chỉ</label>
        <input type="text" class="form-control" id="address" name="address" value="<?php echo $data['user']['address']; ?>" required>
    </div>
    <button type="submit" class="btn btn-primary">Cập nhật</button>
</form>
<?php require_once APP_ROOT . '/Views/layouts/footer.php'; ?>