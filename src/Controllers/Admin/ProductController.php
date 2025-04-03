<?php
namespace Controllers\Admin;

use Models\Product;
use Models\Category;

class ProductController {
    private $productModel;
    private $categoryModel;

    public function __construct() {
        $this->productModel = new Product();
        $this->categoryModel = new Category();
    }

    public function index() {
        $products = $this->productModel->getAllProducts();
        $data = [
            'title' => 'Quản lý sản phẩm - ' . SITE_NAME,
            'products' => $products ?? []
        ];
        require_once APP_ROOT . '/Views/admin/product/index.php';
    }

    public function add() {
        $categories = $this->categoryModel->getAllCategories();
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $data = [
                'name' => clean($_POST['name']),
                'description' => clean($_POST['description']),
                'price' => clean($_POST['price']),
                'category_id' => clean($_POST['category_id']),
                'stock' => clean($_POST['stock']),
                'image' => ''
            ];

            if (isset($_FILES['image']) && $_FILES['image']['error'] == 0) {
                $uploadDir = APP_ROOT . '/public/uploads/';
                $uploadFile = $uploadDir . basename($_FILES['image']['name']);
                if (move_uploaded_file($_FILES['image']['tmp_name'], $uploadFile)) {
                    $data['image'] = 'uploads/' . basename($_FILES['image']['name']);
                }
            }

            $errors = [];
            if (empty($data['name'])) $errors['name'] = 'Vui lòng nhập tên sản phẩm';
            if (empty($data['price']) || !is_numeric($data['price'])) $errors['price'] = 'Giá sản phẩm không hợp lệ';
            if (empty($data['category_id'])) $errors['category_id'] = 'Vui lòng chọn danh mục';
            if (empty($data['stock']) || !is_numeric($data['stock'])) $errors['stock'] = 'Số lượng không hợp lệ';

            if (empty($errors)) {
                if ($this->productModel->addProduct($data)) {
                    setFlash('success', 'Thêm sản phẩm thành công');
                    redirect('admin/product');
                } else {
                    setFlash('error', 'Thêm sản phẩm thất bại');
                }
            } else {
                $data['errors'] = $errors;
                $data['categories'] = $categories;
                require_once APP_ROOT . '/Views/admin/product/add.php';
            }
        } else {
            $data = [
                'title' => 'Thêm sản phẩm - ' . SITE_NAME,
                'categories' => $categories ?? []
            ];
            require_once APP_ROOT . '/Views/admin/product/add.php';
        }
    }

    public function edit($id) {
        $product = $this->productModel->getProductById($id);
        $categories = $this->categoryModel->getAllCategories();
        if (!$product) {
            setFlash('error', 'Sản phẩm không tồn tại');
            redirect('admin/product');
        }

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $data = [
                'id' => $id,
                'name' => clean($_POST['name']),
                'description' => clean($_POST['description']),
                'price' => clean($_POST['price']),
                'category_id' => clean($_POST['category_id']),
                'stock' => clean($_POST['stock']),
                'image' => $product['image']
            ];

            if (isset($_FILES['image']) && $_FILES['image']['error'] == 0) {
                $uploadDir = APP_ROOT . '/public/uploads/';
                $uploadFile = $uploadDir . basename($_FILES['image']['name']);
                if (move_uploaded_file($_FILES['image']['tmp_name'], $uploadFile)) {
                    $data['image'] = 'uploads/' . basename($_FILES['image']['name']);
                }
            }

            $errors = [];
            if (empty($data['name'])) $errors['name'] = 'Vui lòng nhập tên sản phẩm';
            if (empty($data['price']) || !is_numeric($data['price'])) $errors['price'] = 'Giá sản phẩm không hợp lệ';
            if (empty($data['category_id'])) $errors['category_id'] = 'Vui lòng chọn danh mục';
            if (empty($data['stock']) || !is_numeric($data['stock'])) $errors['stock'] = 'Số lượng không hợp lệ';

            if (empty($errors)) {
                if ($this->productModel->updateProduct($data)) {
                    setFlash('success', 'Cập nhật sản phẩm thành công');
                    redirect('admin/product');
                } else {
                    setFlash('error', 'Cập nhật sản phẩm thất bại');
                }
            } else {
                $data['errors'] = $errors;
                $data['product'] = $product;
                $data['categories'] = $categories;
                require_once APP_ROOT . '/Views/admin/product/edit.php';
            }
        } else {
            $data = [
                'title' => 'Sửa sản phẩm - ' . SITE_NAME,
                'product' => $product,
                'categories' => $categories ?? []
            ];
            require_once APP_ROOT . '/Views/admin/product/edit.php';
        }
    }

    public function delete($id) {
        if ($this->productModel->deleteProduct($id)) {
            setFlash('success', 'Xóa sản phẩm thành công');
        } else {
            setFlash('error', 'Xóa sản phẩm thất bại');
        }
        redirect('admin/product');
    }
}