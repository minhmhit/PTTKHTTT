<?php
namespace Controllers\Admin;

use Models\Report;

class ReportController {
    private $reportModel;

    public function __construct() {
        $this->reportModel = new Report();
    }

    public function sales() {
        $year = isset($_GET['year']) ? (int)$_GET['year'] : date('Y');
        $monthlySales = $this->reportModel->getMonthlySalesReport($year);
        $data = [
            'title' => 'Báo cáo doanh thu - ' . SITE_NAME,
            'monthlySales' => $monthlySales ?? [],
            'year' => $year
        ];
        require_once APP_ROOT . '/Views/admin/report/sales.php';
    }

    public function products() {
        $bestSellingProducts = $this->reportModel->getBestSellingProducts();
        $data = [
            'title' => 'Báo cáo sản phẩm bán chạy - ' . SITE_NAME,
            'bestSellingProducts' => $bestSellingProducts ?? []
        ];
        require_once APP_ROOT . '/Views/admin/report/products.php';
    }
}