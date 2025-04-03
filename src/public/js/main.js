document.addEventListener('DOMContentLoaded', function () {
    // Xử lý xác nhận xóa
    const deleteButtons = document.querySelectorAll('.btn-danger');
    deleteButtons.forEach(button => {
        button.addEventListener('click', function (e) {
            if (!confirm('Bạn có chắc muốn xóa?')) {
                e.preventDefault();
            }
        });
    });

    // Xử lý cập nhật số lượng trong giỏ hàng
    const quantityInputs = document.querySelectorAll('input[name="quantity"]');
    quantityInputs.forEach(input => {
        input.addEventListener('change', function () {
            if (this.value < 1) this.value = 1;
            if (this.value > parseInt(this.max)) this.value = this.max;
        });
    });
});