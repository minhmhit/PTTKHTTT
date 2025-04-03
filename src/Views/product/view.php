
<?php 
require_once '../../config/app.php';
require_once '../../config/database.php';
require_once APP_ROOT . '/Views/layouts/header.php'; ?>
<h1><?php echo $data['product']['name']; ?></h1>
<div class="row">
    <div class="col-md-6">
        <img src="<?php echo BASE_URL . $data['product']['image']; ?>" class="img-fluid" alt="<?php echo $data['product']['name']; ?>">
    </div>
    <div class="col-md-6">
        <p><strong>Giá:</strong> <?php echo number_format($data['product']['price'], 0, ',', '.'); ?> VNĐ</p>
        <p><strong>Mô tả:</strong> <?php echo $data['product']['description']; ?></p>
        <p><strong>Số lượng còn lại:</strong> <?php echo $data['product']['stock']; ?></p>
        <form action="<?php echo BASE_URL; ?>product/cart" method="post">
            <input type="hidden" name="product_id" value="<?php echo $data['product']['id']; ?>">
            <div class="mb-3">
                <label for="quantity" class="form-label">Số lượng</label>
                <input type="number" class="form-control" id="quantity" name="quantity" min="1" max="<?php echo $data['product']['stock']; ?>" value="1" required>
            </div>
            <button type="submit" class="btn btn-primary" name="add_to_cart">Thêm vào giỏ hàng</button>
        </form>
    </div>
</div>
<?php require_once APP_ROOT . '/Views/layouts/footer.php'; ?>