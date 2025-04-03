<?php
namespace Controllers\Admin;

use Models\Import;
use Models\Supplier;
use Models\Product;

class ImportController {
    private $importModel;
    private $supplierModel;
    private $productModel;

    public function __construct() {
        $this->importModel = new Import();
        $this->supplierModel = new Supplier();
        $this->productModel = new Product();
    }

    public function index() {
        $imports = $this->importModel->getAllImports();
        $data = ['title' => 'Quản lý nhập hàng', 'imports' => $imports];
        require_once APP_ROOT . '/Views/admin/import/index.php';
    }

    public function add() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $data = [
                'user_id' => $_SESSION['user_id'],
                'supplier_id' => clean($_POST['supplier_id']),
                'total_cost' => clean($_POST['total_cost']),
                'note' => clean($_POST['note']),
                'status' => clean($_POST['status'])
            ];
            $details = [];
            foreach ($_POST['products'] as $index => $productId) {
                $details[] = [
                    'product_id' => $productId,
                    'quantity' => clean($_POST['quantities'][$index]),
                    'cost' => clean($_POST['costs'][$index])
                ];
            }
            if ($this->importModel->addImport($data, $details)) {
                setFlash('success', 'Thêm nhập hàng thành công');
                redirect('admin/import');
            } else {
                setFlash('error', 'Thêm nhập hàng thất bại');
            }
        }
        $suppliers = $this->supplierModel->getAllSuppliers();
        $products = $this->productModel->getAllProducts();
        $data = ['title' => 'Thêm nhập hàng', 'suppliers' => $suppliers, 'products' => $products];
        require_once APP_ROOT . '/Views/admin/import/add.php';
    }

    public function edit($id) {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $data = [
                'id' => $id,
                'supplier_id' => clean($_POST['supplier_id']),
                'total_cost' => clean($_POST['total_cost']),
                'note' => clean($_POST['note']),
                'status' => clean($_POST['status'])
            ];
            $details = [];
            foreach ($_POST['products'] as $index => $productId) {
                $details[] = [
                    'product_id' => $productId,
                    'quantity' => clean($_POST['quantities'][$index]),
                    'cost' => clean($_POST['costs'][$index])
                ];
            }
            if ($this->importModel->updateImport($data, $details)) {
                setFlash('success', 'Cập nhật nhập hàng thành công');
                redirect('admin/import');
            } else {
                setFlash('error', 'Cập nhật thất bại');
            }
        }
        $import = $this->importModel->getImportById($id);
        $details = $this->importModel->getImportDetails($id);
        $suppliers = $this->supplierModel->getAllSuppliers();
        $products = $this->productModel->getAllProducts();
        $data = ['title' => 'Sửa nhập hàng', 'import' => $import, 'details' => $details, 'suppliers' => $suppliers, 'products' => $products];
        require_once APP_ROOT . '/Views/admin/import/edit.php';
    }

    public function view($id) {
        $import = $this->importModel->getImportById($id);
        $details = $this->importModel->getImportDetails($id);
        $data = ['title' => 'Chi tiết nhập hàng', 'import' => $import, 'details' => $details];
        require_once APP_ROOT . '/Views/admin/import/view.php';
    }

    public function delete($id) {
        if ($this->importModel->deleteImport($id)) {
            setFlash('success', 'Xóa nhập hàng thành công');
        } else {
            setFlash('error', 'Xóa thất bại');
        }
        redirect('admin/import');
    }
}