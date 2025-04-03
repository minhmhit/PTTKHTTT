<?php require_once APP_ROOT . '/Views/layouts/admin_header.php'; ?>
<h1>Quản lý đơn hàng</h1>
<?php if (isset($_SESSION['success'])): ?>
    <div class="alert alert-success"><?php echo $_SESSION['success']; unset($_SESSION['success']); ?></div>
<?php endif; ?>
<?php if (isset($_SESSION['error'])): ?>
    <div class="alert alert-danger"><?php echo $_SESSION['error']; unset($_SESSION['error']); ?></div>
<?php endif; ?>
<table class="table table-striped">
    <thead>
        <tr>
            <th>ID</th>
            <th>Khách hàng</th>
            <th>Tổng tiền</th>
            <th>Trạng thái</th>
            <th>Ngày đặt</th>
            <th>Hành động</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($data['orders'] as $order): ?>
        <tr>
            <td><?php echo $order['id']; ?></td>
            <td><?php echo $order['user_name']; ?></td>
            <td><?php echo number_format($order['total_amount'], 0, ',', '.'); ?> VNĐ</td>
            <td><?php echo $order['status']; ?></td>
            <td><?php echo $order['created_at']; ?></td>
            <td>
                <a href="<?php echo BASE_URL; ?>admin/order/view/<?php echo $order['id']; ?>" class="btn btn-sm btn-info">Xem</a>
            </td>
        </tr>
        <?php endforeach; ?>
    </tbody>
</table>
<?php require_once APP_ROOT . '/Views/layouts/footer.php'; ?>