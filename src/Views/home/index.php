<?php require_once APP_ROOT . '/Views/layouts/header.php'; ?>
<div class="container mt-5">
    <h1><?php echo $data['title']; ?></h1>
    <p>Chào mừng bạn đến với Coffee Shop!</p>

    <h2>Sản phẩm mới</h2>
    <?php if (!empty($data['newProducts'])): ?>
        <div class="row">
            <?php foreach ($data['newProducts'] as $product): ?>
                <div class="col-md-4 mb-3">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title"><?php echo $product['name']; ?></h5>
                            <p class="card-text">Danh mục: <?php echo $product['category_name'] ?? 'Chưa có'; ?></p>
                            <p class="card-text">Giá: <?php echo number_format($product['price']); ?> VNĐ</p>
                            <p class="card-text">Tồn kho: <?php echo $product['stock']; ?></p>
                            <a href="<?php echo BASE_URL; ?>product/detail/<?php echo $product['id']; ?>" class="btn btn-primary">Xem chi tiết</a>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    <?php else: ?>
        <p>Chưa có sản phẩm nào.</p>
    <?php endif; ?>
</div>
<?php require_once APP_ROOT . '/Views/layouts/footer.php'; ?>