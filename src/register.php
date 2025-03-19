<?php
include 'includes/header.php';
if (isset($_SESSION['user_id'])) {
    header("Location: index.php");
    exit();
}
?>

<main>
    <h1>Đăng ký</h1>
    <form id="register-form">
        <label>Username: <input type="text" name="username" required></label>
        <label>Password: <input type="password" name="password" required></label>
        <label>Email: <input type="email" name="email" required></label>
        <button type="submit">Đăng ký</button>
    </form>
    <div id="register-message"></div>
</main>

<script>
$(document).ready(function() {
    $('#register-form').on('submit', function(e) {
        e.preventDefault();
        const username = $('input[name="username"]').val();
        const password = $('input[name="password"]').val();
        if (username.length < 3 || password.length < 6) {
            Swal.fire('Lỗi', 'Username phải từ 3 ký tự và password từ 6 ký tự.', 'error');
            return;
        }
        $.ajax({
            url: 'ajax/register.php',
            method: 'POST',
            data: $(this).serialize(),
            success: function(response) {
                Swal.fire('Thành công', response, 'success').then(() => window.location.href = 'login.php');
            },
            error: function() {
                Swal.fire('Lỗi', 'Không thể đăng ký.', 'error');
            }
        });
    });
});
</script>

<?php include 'includes/footer.php'; ?>