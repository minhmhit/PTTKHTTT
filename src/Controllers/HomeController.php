<?php
namespace Controllers;

use Models\Product;
use Models\Category;

class HomeController {
    private $productModel;
    private $categoryModel;
    
    public function __construct() {
        $this->productModel = new Product();
        $this->categoryModel = new Category();
    }
    
    public function index() {
        // Lấy danh mục sản phẩm
        $categories = $this->categoryModel->getAllCategories();
        
        // Lấy sản phẩm bán chạy
        $bestSellers = $this->productModel->getBestSellingProducts(4);
        
        // Lấy sản phẩm mới nhất
        $newProducts = $this->productModel->getNewestProducts(8);
        
        $data = [
            'categories' => $categories,
            'bestSellers' => $bestSellers,
            'newProducts' => $newProducts,
            'title' => 'Trang chủ - ' . SITE_NAME
        ];
        
        // Load view
        require_once APP_ROOT . '/Views/layouts/header.php';
        require_once APP_ROOT . '/Views/home/index.php';
        require_once APP_ROOT . '/Views/layouts/footer.php';
    }
}