<?php
namespace Controllers;

use Models\Product;
use Models\Category;

class ProductController {
    private $productModel;
    private $categoryModel;
    
    public function __construct() {
        $this->productModel = new Product();
        $this->categoryModel = new Category();
    }
    
    // Hiển thị danh sách sản phẩm
    public function index() {
        // Lấy danh mục
        $categories = $this->categoryModel->getAllCategories();
        
        // Kiểm tra nếu có lọc theo danh mục
        if (isset($_GET['category'])) {
            $categoryId = (int)$_GET['category'];
            $products = $this->productModel->getProductsByCategory($categoryId);
            $category = $this->categoryModel->getCategoryById($categoryId);
            $pageTitle = 'Sản phẩm ' . $category['name'];
        } 
        // Kiểm tra nếu có tìm kiếm
        elseif (isset($_GET['search'])) {
            $keyword = clean($_GET['search']);
            $products = $this->productModel->searchProducts($keyword);
            $pageTitle = 'Kết quả tìm kiếm: ' . $keyword;
        } 
        // Hiển thị tất cả sản phẩm
        else {
            $products = $this->productModel->getAllProducts();
            $pageTitle = 'Tất cả sản phẩm';
        }
        
        $data = [
            'categories' => $categories,
            'products' => $products,
            'title' => $pageTitle . ' - ' . SITE_NAME
        ];
        
        // Load view
        require_once APP_ROOT . '/Views/layouts/header.php';
        require_once APP_ROOT . '/Views/product/index.php';
        require_once APP_ROOT . '/Views/layouts/footer.php';
    }
    
    // Hiển thị chi tiết sản phẩm
    public function view($id) {
        // Lấy thông tin sản phẩm
        $product = $this->productModel->getProductById($id);
        
        if (!$product) {
            // Sản phẩm không tồn tại
            setFlash('error', 'Sản phẩm không tồn tại!');
            redirect('product');
        }
        
        // Lấy sản phẩm cùng danh mục
        $relatedProducts = $this->productModel->getProductsByCategory($product['category_id']);
        
        $data = [
            'product' => $product,
            'relatedProducts' => $relatedProducts,
            'title' => $product['name'] . ' - ' . SITE_NAME
        ];
        
        // Load view
        require_once APP_ROOT . '/Views/layouts/header.php';
        require_once APP_ROOT . '/Views/product/view.php';
        require_once APP_ROOT . '/Views/layouts/footer.php';
    }
    
    // Hiển thị và quản lý giỏ hàng
    public function cart() {
        // Khởi tạo giỏ hàng nếu chưa có
        if (!isset($_SESSION['cart'])) {
            $_SESSION['cart'] = [];
        }
        
        // Xử lý các hành động giỏ hàng
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            // Thêm sản phẩm vào giỏ hàng
            if (isset($_POST['add_to_cart'])) {
                $productId = (int)$_POST['product_id'];
                $quantity = (int)$_POST['quantity'];
                
                // Lấy thông tin sản phẩm
                $product = $this->productModel->getProductById($productId);
                
                if ($product) {
                    // Kiểm tra số lượng trong kho
                    if ($quantity > $product['stock']) {
                        setFlash('error', 'Số lượng sản phẩm trong kho không đủ!');
                        redirect('product/view/' . $productId);
                    }
                    
                    // Kiểm tra sản phẩm đã có trong giỏ hàng chưa
                    if (isset($_SESSION['cart'][$productId])) {
                        $_SESSION['cart'][$productId]['quantity'] += $quantity;
                    } else {
                        $_SESSION['cart'][$productId] = [
                            'id' => $product['id'],
                            'name' => $product['name'],
                            'price' => $product['price'],
                            'image' => $product['image'],
                            'quantity' => $quantity
                        ];
                    }
                    
                    setFlash('success', 'Đã thêm sản phẩm vào giỏ hàng!');
                    redirect('product/cart');
                }
            }
            
            // Cập nhật số lượng sản phẩm
            if (isset($_POST['update_cart'])) {
                foreach ($_POST['quantity'] as $productId => $quantity) {
                    if ($quantity <= 0) {
                        unset($_SESSION['cart'][$productId]);
                    } else {
                        // Kiểm tra số lượng trong kho
                        $product = $this->productModel->getProductById($productId);
                        if ($quantity > $product['stock']) {
                            setFlash('error', 'Số lượng sản phẩm "' . $product['name'] . '" trong kho không đủ!');
                        } else {
                            $_SESSION['cart'][$productId]['quantity'] = $quantity;
                        }
                    }
                }
                
                setFlash('success', 'Giỏ hàng đã được cập nhật!');
                redirect('product/cart');
            }
            
            // Xóa sản phẩm khỏi giỏ hàng
            if (isset($_POST['remove_item'])) {
                $productId = (int)$_POST['product_id'];
                
                if (isset($_SESSION['cart'][$productId])) {
                    unset($_SESSION['cart'][$productId]);
                    setFlash('success', 'Đã xóa sản phẩm khỏi giỏ hàng!');
                }
                
                redirect('product/cart');
            }
            
            // Xóa toàn bộ giỏ hàng
            if (isset($_POST['clear_cart'])) {
                $_SESSION['cart'] = [];
                setFlash('success', 'Đã xóa toàn bộ giỏ hàng!');
                redirect('product/cart');
            }
        }
        
        // Tính tổng tiền giỏ hàng
        $total = 0;
        foreach ($_SESSION['cart'] as $item) {
            $total += $item['price'] * $item['quantity'];
        }
        
        $data = [
            'title' => 'Giỏ hàng - ' . SITE_NAME,
            'total' => $total
        ];
        
        // Load view
        require_once APP_ROOT . '/Views/layouts/header.php';
        require_once APP_ROOT . '/Views/product/cart.php';
        require_once APP_ROOT . '/Views/layouts/footer.php';
    }
}