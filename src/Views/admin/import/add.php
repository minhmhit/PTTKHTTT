<?php require_once APP_ROOT . '/Views/layouts/admin_header.php'; ?>
<div class="container">
    <h1><?php echo $data['title']; ?></h1>
    <?php flash('success'); ?>
    <?php flash('error'); ?>
    <form action="<?php echo BASE_URL; ?>admin/import/add" method="POST">
        <div class="mb-3">
            <label for="supplier_id" class="form-label">Nhà cung cấp</label>
            <select name="supplier_id" id="supplier_id" class="form-control" required>
                <?php foreach ($data['suppliers'] as $supplier): ?>
                    <option value="<?php echo $supplier['id']; ?>"><?php echo $supplier['name']; ?></option>
                <?php endforeach; ?>
            </select>
        </div>
        <div class="mb-3">
            <label for="total_cost" class="form-label">Tổng chi phí</label>
            <input type="number" name="total_cost" id="total_cost" class="form-control" required>
        </div>
        <div class="mb-3">
            <label for="note" class="form-label">Ghi chú</label>
            <textarea name="note" id="note" class="form-control"></textarea>
        </div>
        <div class="mb-3">
            <label for="status" class="form-label">Trạng thái</label>
            <select name="status" id="status" class="form-control" required>
                <option value="pending">Đang chờ</option>
                <option value="completed">Hoàn tất</option>
                <option value="cancelled">Đã hủy</option>
            </select>
        </div>
        <div class="mb-3">
            <label class="form-label">Sản phẩm nhập</label>
            <div id="product-list">
                <div class="row mb-2">
                    <div class="col-md-4">
                        <select name="products[]" class="form-control" required>
                            <?php foreach ($data['products'] as $product): ?>
                                <option value="<?php echo $product['id']; ?>"><?php echo $product['name']; ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="col-md-3">
                        <input type="number" name="quantities[]" class="form-control" placeholder="Số lượng" required>
                    </div>
                    <div class="col-md-3">
                        <input type="number" name="costs[]" class="form-control" placeholder="Chi phí" required>
                    </div>
                    <div class="col-md-2">
                        <button type="button" class="btn btn-danger remove-product">Xóa</button>
                    </div>
                </div>
            </div>
            <button type="button" class="btn btn-success" id="add-product">Thêm sản phẩm</button>
        </div>
        <button type="submit" class="btn btn-primary">Thêm</button>
        <a href="<?php echo BASE_URL; ?>admin/import" class="btn btn-secondary">Quay lại</a>
    </form>
</div>
<script>
document.getElementById('add-product').addEventListener('click', function() {
    let productList = document.getElementById('product-list');
    let newRow = productList.children[0].cloneNode(true);
    newRow.querySelector('select').value = '';
    newRow.querySelectorAll('input').forEach(input => input.value = '');
    productList.appendChild(newRow);
});
document.addEventListener('click', function(e) {
    if (e.target.classList.contains('remove-product')) {
        if (document.querySelectorAll('#product-list .row').length > 1) {
            e.target.closest('.row').remove();
        }
    }
});
</script>
<?php require_once APP_ROOT . '/Views/layouts/footer.php'; ?>