<?php require_once APP_ROOT . '/Views/layouts/admin_header.php'; ?>
<div class="container">
    <h1><?php echo $data['title']; ?></h1>
    <div class="card">
        <div class="card-header">Thông tin nhập hàng</div>
        <div class="card-body">
            <p><strong>ID:</strong> <?php echo $data['import']['id']; ?></p>
            <p><strong>Nhân viên:</strong> <?php echo $data['import']['user_name']; ?></p>
            <p><strong>Nhà cung cấp:</strong> <?php echo $data['import']['supplier_name']; ?></p>
            <p><strong>Tổng chi phí:</strong> <?php echo number_format($data['import']['total_cost']); ?></p>
            <p><strong>Ghi chú:</strong> <?php echo $data['import']['note'] ?: 'Không có'; ?></p>
            <p><strong>Trạng thái:</strong> <?php echo $data['import']['status']; ?></p>
            <p><strong>Ngày tạo:</strong> <?php echo $data['import']['created_at']; ?></p>
        </div>
    </div>
    <div class="card mt-3">
        <div class="card-header">Chi tiết sản phẩm</div>
        <div class="card-body">
            <table class="table">
                <thead>
                    <tr><th>Sản phẩm</th><th>Số lượng</th><th>Chi phí</th></tr>
                </thead>
                <tbody>
                    <?php foreach ($data['details'] as $detail): ?>
                        <tr>
                            <td><?php echo $detail['product_name']; ?></td>
                            <td><?php echo $detail['quantity']; ?></td>
                            <td><?php echo number_format($detail['cost']); ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
    <a href="<?php echo BASE_URL; ?>admin/import" class="btn btn-secondary mt-3">Quay lại</a>
</div>
<?php require_once APP_ROOT . '/Views/layouts/footer.php'; ?>