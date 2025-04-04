<?php require_once __DIR__ . '/../layouts/header.php'; ?>
<h1>Tạo đơn hàng</h1>
<form action="<?php echo BASE_URL; ?>order/create" method="post">
    <div class="mb-3">
        <label for="shipping_address" class="form-label">Địa chỉ giao hàng</label>
        <input type="text" class="form-control" id="shipping_address" name="shipping_address" required>
    </div>
    <div class="mb-3">
        <label for="phone" class="form-label">Số điện thoại</label>
        <input type="text" class="form-control" id="phone" name="phone" required>
    </div>
    <div class="mb-3">
        <label for="note" class="form-label">Ghi chú</label>
        <textarea class="form-control" id="note" name="note" rows="3"></textarea>
    </div>
    <button type="submit" class="btn btn-primary">Đặt hàng</button>
</form>
<?php require_once __DIR__ . '/../layouts/footer.php'; ?>