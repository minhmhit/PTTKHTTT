<?php
namespace Controllers\Admin;

use Models\Supplier;

class SupplierController {
    private $supplierModel;

    public function __construct() {
        $this->supplierModel = new Supplier();
    }

    public function index() {
        $suppliers = $this->supplierModel->getAllSuppliers();
        $data = ['title' => 'Quản lý nhà cung cấp', 'suppliers' => $suppliers];
        require_once APP_ROOT . '/Views/admin/supplier/index.php';
    }

    public function add() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $data = [
                'name' => clean($_POST['name']),
                'contact_name' => clean($_POST['contact_name']),
                'phone' => clean($_POST['phone']),
                'email' => clean($_POST['email']),
                'address' => clean($_POST['address'])
            ];
            if ($this->supplierModel->addSupplier($data)) {
                setFlash('success', 'Thêm nhà cung cấp thành công');
                redirect('admin/supplier');
            } else {
                setFlash('error', 'Thêm thất bại');
            }
        }
        $data = ['title' => 'Thêm nhà cung cấp'];
        require_once APP_ROOT . '/Views/admin/supplier/add.php';
    }

    public function edit($id) {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $data = [
                'id' => $id,
                'name' => clean($_POST['name']),
                'contact_name' => clean($_POST['contact_name']),
                'phone' => clean($_POST['phone']),
                'email' => clean($_POST['email']),
                'address' => clean($_POST['address'])
            ];
            if ($this->supplierModel->updateSupplier($data)) {
                setFlash('success', 'Cập nhật nhà cung cấp thành công');
                redirect('admin/supplier');
            } else {
                setFlash('error', 'Cập nhật thất bại');
            }
        }
        $supplier = $this->supplierModel->getSupplierById($id);
        $data = ['title' => 'Sửa nhà cung cấp', 'supplier' => $supplier];
        require_once APP_ROOT . '/Views/admin/supplier/edit.php';
    }

    public function delete($id) {
        if ($this->supplierModel->deleteSupplier($id)) {
            setFlash('success', 'Xóa nhà cung cấp thành công');
        } else {
            setFlash('error', 'Xóa thất bại');
        }
        redirect('admin/supplier');
    }
}