<?php require_once APP_ROOT . '/Views/layouts/footer.php'; ?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $data['title']; ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header">
                        <h3 class="text-center"><?php echo $data['title']; ?></h3>
                    </div>
                    <div class="card-body text-center">
                        <?php flash('success'); ?>
                        <?php flash('error'); ?>
                        <p>Bạn đã đăng xuất thành công!</p>
                        <a href="<?php echo BASE_URL; ?>user/login" class="btn btn-primary">Đăng nhập lại</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>