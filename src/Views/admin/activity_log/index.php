<?php require_once APP_ROOT . '/Views/layouts/admin_header.php'; ?>
<div class="container">
    <h1><?php echo $data['title']; ?></h1>
    <?php flash('success'); ?>
    <?php flash('error'); ?>
    <table class="table table-striped">
        <thead>
            <tr>
                <th>ID</th>
                <th>Nhân viên</th>
                <th>Hành động</th>
                <th>Mô tả</th>
                <th>Thời gian</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($data['logs'] as $log): ?>
                <tr>
                    <td><?php echo $log['id']; ?></td>
                    <td><?php echo $log['user_name']; ?></td>
                    <td><?php echo $log['action']; ?></td>
                    <td><?php echo $log['description'] ?: 'Không có'; ?></td>
                    <td><?php echo $log['created_at']; ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>
<?php require_once APP_ROOT . '/Views/layouts/footer.php'; ?>