<?php require_once APP_ROOT . '/Views/layouts/admin_header.php'; ?>
<h1>Báo cáo doanh thu</h1>
<form action="<?php echo BASE_URL; ?>admin/report/sales" method="get" class="mb-3">
    <div class="row">
        <div class="col-md-3">
            <label for="year" class="form-label">Chọn năm</label>
            <select class="form-select" id="year" name="year">
                <?php for ($i = date('Y'); $i >= date('Y') - 5; $i--): ?>
                    <option value="<?php echo $i; ?>" <?php echo $i == $data['year'] ? 'selected' : ''; ?>><?php echo $i; ?></option>
                <?php endfor; ?>
            </select>
        </div>
        <div class="col-md-2">
            <button type="submit" class="btn btn-primary mt-4">Xem</button>
        </div>
    </div>
</form>
<table class="table table-striped">
    <thead>
        <tr>
            <th>Tháng</th>
            <th>Doanh thu</th>
            <th>Số đơn hàng</th>
        </tr>
    </thead>
    <tbody>
        <?php for ($month = 1; $month <= 12; $month++): ?>
            <?php
            $found = false;
            foreach ($data['monthlySales'] as $sale) {
                if ($sale['month'] == $month) {
                    $found = true;
                    break;
                }
            }
            ?>
            <tr>
                <td><?php echo $month; ?></td>
                <td><?php echo $found ? number_format($sale['revenue'], 0, ',', '.') . ' VNĐ' : '0 VNĐ'; ?></td>
                <td><?php echo $found ? $sale['order_count'] : '0'; ?></td>
            </tr>
        <?php endfor; ?>
    </tbody>
</table>
<?php require_once APP_ROOT . '/Views/layouts/footer.php'; ?>