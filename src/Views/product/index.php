<?php require_once APP_ROOT . '/Views/layouts/header.php'; ?>
<h1>Danh sách sản phẩm</h1>
<div class="row">
    <?php foreach ($data['products'] as $product): ?>
    <div class="col-md-3 mb-4">
        <div class="card">
            <img src="<?php echo BASE_URL . $product['image']; ?>" class="card-img-top" alt="<?php echo $product['name']; ?>">
            <div class="card-body">
                <h5 class="card-title"><?php echo $product['name']; ?></h5>
                <p class="card-text"><?php echo number_format($product['price'], 0, ',', '.'); ?> VNĐ</p>
                <a href="<?php echo BASE_URL; ?>product/view/<?php echo $product['id']; ?>" class="btn btn-primary">Xem chi tiết</a>
            </div>
        </div>
    </div>
    <?php endforeach; ?>
</div>
<?php require_once APP_ROOT . '/Views/layouts/footer.php'; ?>