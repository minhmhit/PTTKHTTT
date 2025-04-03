<?php
namespace Controllers\Admin;

use Models\Order;
use Models\Product;
use Models\User;
use Models\Report; // Giữ lại nhưng không dùng trong index()
use Models\Import;
use Models\ActivityLog;

class DashboardController {
    private $userModel;
    private $productModel;
    private $orderModel;
    private $importModel;
    private $activityLogModel;

    public function __construct() {
        $this->userModel = new User();
        $this->productModel = new Product();
        $this->orderModel = new Order();
        $this->importModel = new Import();
        $this->activityLogModel = new ActivityLog();
    }

    public function index() {
        $totalOrders = $this->orderModel->getTotalOrders();
        $totalRevenue = $this->orderModel->getTotalRevenue();
        $totalProducts = $this->productModel->getTotalProducts();
        $totalUsers = $this->userModel->getTotalUsers();
        $recentOrders = $this->orderModel->getRecentOrders(5);
        $bestSellingProducts = $this->productModel->getBestSellingProducts(5);
        $recentImports = $this->importModel->getRecentImports(5); // Thêm nhập hàng gần đây
        $recentLogs = $this->activityLogModel->getAllLogs(5); // Thêm log hoạt động gần đây

        $data = [
            'title' => 'Trang tổng quan - ' . SITE_NAME,
            'totalOrders' => $totalOrders ?? 0,
            'totalRevenue' => $totalRevenue ?? 0,
            'totalProducts' => $totalProducts ?? 0,
            'totalUsers' => $totalUsers ?? 0,
            'recentOrders' => $recentOrders ?? [],
            'bestSellingProducts' => $bestSellingProducts ?? [],
            'recentImports' => $recentImports ?? [], // Thêm vào $data
            'recentLogs' => $recentLogs ?? [] // Thêm vào $data
        ];

        require_once APP_ROOT . '/Views/admin/dashboard/index.php';
    }
}