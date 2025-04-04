<?php
namespace Controllers;

class CartController {
    public function add($productId) {
        if (!isset($_SESSION['cart'])) {
            $_SESSION['cart'] = [];
        }
        $_SESSION['cart'][$productId] = ($_SESSION['cart'][$productId] ?? 0) + 1;
        setFlash('success', 'Đã thêm sản phẩm vào giỏ hàng!');
        redirect('cart');
    }

    public function index() {
        $data = [
            'title' => 'Giỏ hàng - ' . SITE_NAME,
            'cart' => $_SESSION['cart'] ?? []
        ];
        require_once APP_ROOT . '/Views/cart/index.php';
    }

    public function remove($productId) {
        if (isset($_SESSION['cart'][$productId])) {
            unset($_SESSION['cart'][$productId]);
            setFlash('success', 'Đã xóa sản phẩm khỏi giỏ hàng!');
        }
        redirect('cart');
    }
}