<?php
namespace Controllers\Admin;

use Models\Category;

class CategoryController {
    private $categoryModel;

    public function __construct() {
        $this->categoryModel = new Category();
    }

    public function index() {
        $categories = $this->categoryModel->getAllCategories();
        $data = [
            'title' => 'Quản lý danh mục - ' . SITE_NAME,
            'categories' => $categories ?? []
        ];
        require_once APP_ROOT . '/Views/admin/category/index.php';
    }

    public function add() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $data = [
                'name' => clean($_POST['name']),
                'description' => clean($_POST['description'])
            ];

            $errors = [];
            if (empty($data['name'])) $errors['name'] = 'Vui lòng nhập tên danh mục';

            if (empty($errors)) {
                if ($this->categoryModel->addCategory($data)) {
                    setFlash('success', 'Thêm danh mục thành công');
                    redirect('admin/category');
                } else {
                    setFlash('error', 'Thêm danh mục thất bại');
                }
            } else {
                $data['errors'] = $errors;
                require_once APP_ROOT . '/Views/admin/category/add.php';
            }
        } else {
            $data = ['title' => 'Thêm danh mục - ' . SITE_NAME];
            require_once APP_ROOT . '/Views/admin/category/add.php';
        }
    }

    public function edit($id) {
        $category = $this->categoryModel->getCategoryById($id);
        if (!$category) {
            setFlash('error', 'Danh mục không tồn tại');
            redirect('admin/category');
        }

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $data = [
                'id' => $id,
                'name' => clean($_POST['name']),
                'description' => clean($_POST['description'])
            ];

            $errors = [];
            if (empty($data['name'])) $errors['name'] = 'Vui lòng nhập tên danh mục';

            if (empty($errors)) {
                if ($this->categoryModel->updateCategory($data)) {
                    setFlash('success', 'Cập nhật danh mục thành công');
                    redirect('admin/category');
                } else {
                    setFlash('error', 'Cập nhật danh mục thất bại');
                }
            } else {
                $data['errors'] = $errors;
                $data['category'] = $category;
                require_once APP_ROOT . '/Views/admin/category/edit.php';
            }
        } else {
            $data = [
                'title' => 'Sửa danh mục - ' . SITE_NAME,
                'category' => $category
            ];
            require_once APP_ROOT . '/Views/admin/category/edit.php';
        }
    }

    public function delete($id) {
        if ($this->categoryModel->deleteCategory($id)) {
            setFlash('success', 'Xóa danh mục thành công');
        } else {
            setFlash('error', 'Xóa danh mục thất bại');
        }
        redirect('admin/category');
    }
}