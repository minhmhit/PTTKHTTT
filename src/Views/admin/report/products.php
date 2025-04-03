<?php require_once APP_ROOT . '/Views/layouts/admin_header.php'; ?>
<h1>Báo cáo sản phẩm bán chạy</h1>
<table class="table table-striped">
    <thead>
        <tr>
            <th>ID</th>
            <th>Tên sản phẩm</th>
            <th>Giá</th>
            <th>Số lượng bán</th>
            <th>Tổng doanh thu</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($data['bestSellingProducts'] as $product): ?>
        <tr>
            <td><?php echo $product['id']; ?></td>
            <td><?php echo $product['name']; ?></td>
            <td><?php echo number_format($product['price'], 0, ',', '.'); ?> VNĐ</td>
            <td><?php echo $product['total_quantity']; ?></td>
            <td><?php echo number_format($product['total_revenue'], 0, ',', '.'); ?> VNĐ</td>
        </tr>
        <?php endforeach; ?>
    </tbody>
</table>
<?php require_once APP_ROOT . '/Views/layouts/footer.php'; ?>