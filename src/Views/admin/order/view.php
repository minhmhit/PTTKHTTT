<?php require_once APP_ROOT . '/Views/layouts/admin_header.php'; ?>
<h1>Chi tiết đơn hàng #<?php echo $data['order']['id']; ?></h1>
<div class="card mb-3">
    <div class="card-body">
        <h5 class="card-title">Thông tin khách hàng</h5>
        <p><strong>Tên:</strong> <?php echo $data['order']['user_name']; ?></p>
        <p><strong>Email:</strong> <?php echo $data['order']['user_email']; ?></p>
        <p><strong>Địa chỉ giao hàng:</strong> <?php echo $data['order']['shipping_address']; ?></p>
        <p><strong>Số điện thoại:</strong> <?php echo $data['order']['phone']; ?></p>
    </div>
</div>
<div class="card mb-3">
    <div class="card-body">
        <h5 class="card-title">Thông tin đơn hàng</h5>
        <p><strong>Tổng tiền:</strong> <?php echo number_format($data['order']['total_amount'], 0, ',', '.'); ?> VNĐ</p>
        <p><strong>Trạng thái:</strong> <?php echo $data['order']['status']; ?></p>
        <p><strong>Ngày đặt:</strong> <?php echo $data['order']['created_at']; ?></p>
        <p><strong>Ghi chú:</strong> <?php echo $data['order']['note']; ?></p>
    </div>
</div>
<h3>Sản phẩm trong đơn hàng</h3>
<table class="table table-striped">
    <thead>
        <tr>
            <th>ID</th>
            <th>Tên sản phẩm</th>
            <th>Số lượng</th>
            <th>Giá</th>
            <th>Thành tiền</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($data['orderDetails'] as $detail): ?>
        <tr>
            <td><?php echo $detail['product_id']; ?></td>
            <td><?php echo $detail['product_name']; ?></td>
            <td><?php echo $detail['quantity']; ?></td>
            <td><?php echo number_format($detail['price'], 0, ',', '.'); ?> VNĐ</td>
            <td><?php echo number_format($detail['quantity'] * $detail['price'], 0, ',', '.'); ?> VNĐ</td>
        </tr>
        <?php endforeach; ?>
    </tbody>
</table>
<form action="<?php echo BASE_URL; ?>admin/order/updateStatus/<?php echo $data['order']['id']; ?>" method="post">
    <div class="mb-3">
        <label for="status" class="form-label">Cập nhật trạng thái</label>
        <select class="form-select" id="status" name="status">
            <option value="pending" <?php echo $data['order']['status'] == 'pending' ? 'selected' : ''; ?>>Đang chờ</option>
            <option value="processing" <?php echo $data['order']['status'] == 'processing' ? 'selected' : ''; ?>>Đang xử lý</option>
            <option value="shipped" <?php echo $data['order']['status'] == 'shipped' ? 'selected' : ''; ?>>Đã giao</option>
            <option value="completed" <?php echo $data['order']['status'] == 'completed' ? 'selected' : ''; ?>>Hoàn thành</option>
            <option value="cancelled" <?php echo $data['order']['status'] == 'cancelled' ? 'selected' : ''; ?>>Đã hủy</option>
        </select>
    </div>
    <button type="submit" class="btn btn-primary">Cập nhật</button>
</form>
<?php require_once APP_ROOT . '/Views/layouts/footer.php'; ?>