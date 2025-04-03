
<?php require_once APP_ROOT . '/Views/layouts/header.php'; ?>
<h1>Chào mừng đến với Coffee Shop</h1>
<p>Khám phá các sản phẩm cà phê tuyệt vời của chúng tôi.</p>
<div class="row">
    <?php foreach ($data['newProducts'] as $product): ?>
    <div class="col-md-3 mb-4">
        <div class="card">
            <img src="uploads/<?php echo $product['image']; ?>" class="card-img-top" alt="<?php echo $product['name']; ?>">
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