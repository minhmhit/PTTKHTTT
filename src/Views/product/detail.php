<?php require_once APP_ROOT . '/Views/layouts/header.php'; ?>
<div class="container mt-5">
    <h1><?php echo $data['title']; ?></h1>
    <div class="card">
        <div class="card-body">
            <h5 class="card-title"><?php echo $data['product']['name']; ?></h5>
            <p class="card-text">Danh mục: <?php echo $data['product']['category_name'] ?? 'Chưa có'; ?></p>
            <p class="card-text">Giá: <?php echo number_format($data['product']['price']); ?> VNĐ</p>
            <p class="card-text">Tồn kho: <?php echo $data['product']['stock']; ?></p>
            <p class="card-text">Mô tả: <?php echo $data['product']['description'] ?? 'Không có'; ?></p>
            <a href="<?php echo BASE_URL; ?>cart/add/<?php echo $data['product']['id']; ?>" class="btn btn-success">Thêm vào giỏ hàng</a>
            <a href="<?php echo BASE_URL; ?>" class="btn btn-secondary">Quay lại</a>
        </div>
    </div>
</div>
<?php require_once APP_ROOT . '/Views/layouts/footer.php'; ?>