<?php
namespace Controllers;

use Models\Order;

class OrderController {
    private $orderModel;

    public function __construct() {
        $this->orderModel = new Order();
    }

    public function create() {
        if (!isset($_SESSION['user_id'])) {
            redirect('user/login');
        }

        if (empty($_SESSION['cart'])) {
            setFlash('error', 'Giỏ hàng trống');
            redirect('product/cart');
        }

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $data = [
                'shipping_address' => clean($_POST['shipping_address']),
                'phone' => clean($_POST['phone']),
                'note' => clean($_POST['note']),
                'total' => 0
            ];

            foreach ($_SESSION['cart'] as $item) {
                $data['total'] += $item['price'] * $item['quantity'];
            }

            if ($this->orderModel->createOrder($_SESSION['user_id'], $data, $_SESSION['cart'])) {
                unset($_SESSION['cart']);
                setFlash('success', 'Đặt hàng thành công');
                redirect('order/history');
            } else {
                setFlash('error', 'Đặt hàng thất bại');
            }
        }

        $data = ['title' => 'Tạo đơn hàng - Coffee Shop'];
        require_once APP_ROOT . '/Views/order/create.php';
    }

    public function history() {
        if (!isset($_SESSION['user_id'])) {
            redirect('user/login');
        }

        $orders = $this->orderModel->getOrdersByUser($_SESSION['user_id']);
        $data = [
            'title' => 'Lịch sử đơn hàng - Coffee Shop',
            'orders' => $orders ?? []
        ];
        require_once APP_ROOT . '/Views/order/history.php';
    }
}