<?php require_once APP_ROOT . '/Views/layouts/admin_header.php'; ?>
<h1>Thêm sản phẩm</h1>
<?php if (isset($data['errors'])): ?>
    <div class="alert alert-danger">
        <ul>
            <?php foreach ($data['errors'] as $error): ?>
                <li><?php echo $error; ?></li>
            <?php endforeach; ?>
        </ul>
    </div>
<?php endif; ?>
<form action="<?php echo BASE_URL; ?>admin/product/add" method="post" enctype="multipart/form-data">
    <div class="mb-3">
        <label for="name" class="form-label">Tên sản phẩm</label>
        <input type="text" class="form-control" id="name" name="name" required>
    </div>
    <div class="mb-3">
        <label for="description" class="form-label">Mô tả</label>
        <textarea class="form-control" id="description" name="description" rows="3"></textarea>
    </div>
    <div class="mb-3">
        <label for="price" class="form-label">Giá</label>
        <input type="number" class="form-control" id="price" name="price" required>
    </div>
    <div class="mb-3">
        <label for="category_id" class="form-label">Danh mục</label>
        <select class="form-select" id="category_id" name="category_id" required>
            <?php foreach ($data['categories'] as $category): ?>
                <option value="<?php echo $category['id']; ?>"><?php echo $category['name']; ?></option>
            <?php endforeach; ?>
        </select>
    </div>
    <div class="mb-3">
        <label for="stock" class="form-label">Số lượng</label>
        <input type="number" class="form-control" id="stock" name="stock" required>
    </div>
    <div class="mb-3">
        <label for="image" class="form-label">Hình ảnh</label>
        <input type="file" class="form-control" id="image" name="image">
    </div>
    <button type="submit" class="btn btn-primary">Thêm</button>
</form>
<?php require_once APP_ROOT . '/Views/layouts/footer.php'; ?>