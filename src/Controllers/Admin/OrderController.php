<?php
namespace Controllers\Admin;

use Models\Order;

class OrderController {
    private $orderModel;

    public function __construct() {
        $this->orderModel = new Order();
    }

    public function index() {
        $orders = $this->orderModel->getAllOrders();
        $data = [
            'title' => 'Quản lý đơn hàng - ' . SITE_NAME,
            'orders' => $orders
        ];
        require_once APP_ROOT . '/Views/admin/order/index.php';
    }

    public function view($id) {
        $order = $this->orderModel->getOrderById($id);
        $orderDetails = $this->orderModel->getOrderDetails($id);
        if (!$order) {
            setFlash('error', 'Đơn hàng không tồn tại');
            redirect('admin/order');
        }

        $data = [
            'title' => 'Chi tiết đơn hàng - ' . SITE_NAME,
            'order' => $order,
            'orderDetails' => $orderDetails
        ];
        require_once APP_ROOT . '/Views/admin/order/view.php';
    }

    public function updateStatus($id) {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $status = clean($_POST['status']);
            if ($this->orderModel->updateOrderStatus($id, $status)) {
                setFlash('success', 'Cập nhật trạng thái thành công');
            } else {
                setFlash('error', 'Cập nhật thất bại');
            }
            redirect('admin/order');
        }
    }
}