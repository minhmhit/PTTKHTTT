<?php
include 'includes/header.php';
if (isset($_SESSION['user_id'])) {
    header("Location: index.php");
    exit();
}
?>

<main>
    <h1>Đăng nhập</h1>
    <form id="login-form">
        <label>Username: <input type="text" name="username" required></label>
        <label>Password: <input type="password" name="password" required></label>
        <button type="submit">Đăng nhập</button>
    </form>
    <div id="login-message"></div>
</main>

<script>
$(document).ready(function() {
    $('#login-form').on('submit', function(e) {
        e.preventDefault();
        $.ajax({
            url: 'ajax/login.php',
            method: 'POST',
            data: $(this).serialize(),
            success: function(response) {
                if (response === 'success') {
                    Swal.fire('Thành công', 'Đăng nhập thành công!', 'success').then(() => window.location.href = 'index.php');
                } else {
                    Swal.fire('Lỗi', response, 'error');
                }
            },
            error: function() {
                Swal.fire('Lỗi', 'Không thể đăng nhập.', 'error');
            }
        });
    });
});
</script>

<?php include 'includes/footer.php'; ?>