<?php
namespace Controllers\Admin;

use Models\Permission;

class PermissionController {
    private $permissionModel;

    public function __construct() {
        $this->permissionModel = new Permission();
    }

    public function index() {
        $permissions = $this->permissionModel->getAllPermissions();
        $data = ['title' => 'Quản lý quyền - ' . SITE_NAME, 'permissions' => $permissions];
        require_once APP_ROOT . '/Views/admin/permission/index.php';
    }

    public function add() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $data = [
                'name' => clean($_POST['name']),
                'description' => clean($_POST['description'])
            ];
            if ($this->permissionModel->addPermission($data)) {
                setFlash('success', 'Thêm quyền thành công');
                redirect('admin/permission');
            } else {
                setFlash('error', 'Thêm quyền thất bại');
            }
        }
        $data = ['title' => 'Thêm quyền - ' . SITE_NAME];
        require_once APP_ROOT . '/Views/admin/permission/add.php';
    }

    public function edit($id) {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $data = [
                'id' => $id,
                'name' => clean($_POST['name']),
                'description' => clean($_POST['description'])
            ];
            if ($this->permissionModel->updatePermission($data)) {
                setFlash('success', 'Cập nhật quyền thành công');
                redirect('admin/permission');
            } else {
                setFlash('error', 'Cập nhật quyền thất bại');
            }
        }
        $permission = $this->permissionModel->getPermissionById($id);
        $data = ['title' => 'Sửa quyền - ' . SITE_NAME, 'permission' => $permission];
        require_once APP_ROOT . '/Views/admin/permission/edit.php';
    }

    public function delete($id) {
        if ($this->permissionModel->deletePermission($id)) {
            setFlash('success', 'Xóa quyền thành công');
        } else {
            setFlash('error', 'Xóa quyền thất bại');
        }
        redirect('admin/permission');
    }
}