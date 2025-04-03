<?php require_once APP_ROOT . '/Views/layouts/admin_header.php'; ?>
<h1>Trang tổng quan</h1>
<div class="row">
    <div class="col-md-3">
        <div class="card text-white bg-primary mb-3">
            <div class="card-body">
                <h5 class="card-title">Tổng đơn hàng</h5>
                <p class="card-text"><?php echo $data['totalOrders']; ?></p>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card text-white bg-success mb-3">
            <div class="card-body">
                <h5 class="card-title">Doanh thu</h5>
                <p class="card-text"><?php echo number_format($data['totalRevenue'], 0, ',', '.'); ?> VNĐ</p>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card text-white bg-info mb-3">
            <div class="card-body">
                <h5 class="card-title">Sản phẩm</h5>
                <p class="card-text"><?php echo $data['totalProducts']; ?></p>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card text-white bg-warning mb-3">
            <div class="card-body">
                <h5 class="card-title">Người dùng</h5>
                <p class="card-text"><?php echo $data['totalUsers']; ?></p>
            </div>
        </div>
    </div>
</div>

    
    <div class="col-md-6">
        <div class="card">
            <div class="card-header">Nhập hàng gần đây</div>
            <div class="card-body">
                <table class="table">
                    <tr><th>ID</th><th>Nhà cung cấp</th><th>Tổng chi phí</th></tr>
                    <?php foreach ($data['recentImports'] as $import): ?>
                        <tr>
                            <td><?php echo $import['id']; ?></td>
                            <td><?php echo $import['supplier_name']; ?></td>
                            <td><?php echo number_format($import['total_cost']); ?></td>
                        </tr>
                    <?php endforeach; ?>
                </table>
            </div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="card">
            <div class="card-header">Hoạt động gần đây</div>
            <div class="card-body">
                <ul>
                    <?php foreach ($data['recentLogs'] as $log): ?>
                        <li><?php echo $log['action'] . ' - ' . $log['created_at']; ?></li>
                    <?php endforeach; ?>
                </ul>
            </div>
        </div>
    </div>


<h3>Đơn hàng gần đây</h3>
<table class="table table-striped">
    <thead>
        <tr>
            <th>ID</th>
            <th>Khách hàng</th>
            <th>Tổng tiền</th>
            <th>Trạng thái</th>
            <th>Hành động</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($data['recentOrders'] as $order): ?>
        <tr>
            <td><?php echo $order['id']; ?></td>
            <td><?php echo $order['user_name']; ?></td>
            <td><?php echo number_format($order['total_amount'], 0, ',', '.'); ?> VNĐ</td>
            <td><?php echo $order['status']; ?></td>
            <td>
                <a href="<?php echo BASE_URL; ?>admin/order/view/<?php echo $order['id']; ?>" class="btn btn-sm btn-info">Xem</a>
            </td>
        </tr>
        <?php endforeach; ?>
    </tbody>
</table>

<h3>Sản phẩm bán chạy</h3>
<table class="table table-striped">
    <thead>
        <tr>
            <th>ID</th>
            <th>Tên sản phẩm</th>
            <th>Số lượng bán</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($data['bestSellingProducts'] as $product): ?>
        <tr>
            <td><?php echo $product['id']; ?></td>
            <td><?php echo $product['name']; ?></td>
            <td><?php echo $product['total_quantity']; ?></td>
        </tr>
        <?php endforeach; ?>
    </tbody>
</table>
<?php require_once APP_ROOT . '/Views/layouts/footer.php'; ?>