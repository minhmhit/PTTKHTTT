<?php
namespace Controllers\Admin;

use Models\Role;

class RoleController {
    private $roleModel;

    public function __construct() {
        $this->roleModel = new Role();
    }

    public function index() {
        $roles = $this->roleModel->getAllRoles();
        $data = ['title' => 'Quản lý vai trò', 'roles' => $roles];
        require_once APP_ROOT . '/Views/admin/role/index.php';
    }

    public function add() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $data = [
                'name' => clean($_POST['name']),
                'description' => clean($_POST['description']),
                'permissions' => $_POST['permissions'] ?? []
            ];
            if ($this->roleModel->addRole($data)) {
                setFlash('success', 'Thêm vai trò thành công');
                redirect('admin/role');
            } else {
                setFlash('error', 'Thêm thất bại');
            }
        }
        $permissions = $this->roleModel->getAllPermissions();
        $data = ['title' => 'Thêm vai trò', 'permissions' => $permissions];
        require_once APP_ROOT . '/Views/admin/role/add.php';
    }

    public function edit($id) {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $data = [
                'id' => $id,
                'name' => clean($_POST['name']),
                'description' => clean($_POST['description']),
                'permissions' => $_POST['permissions'] ?? []
            ];
            if ($this->roleModel->updateRole($data)) {
                setFlash('success', 'Cập nhật vai trò thành công');
                redirect('admin/role');
            } else {
                setFlash('error', 'Cập nhật thất bại');
            }
        }
        $role = $this->roleModel->getRoleById($id);
        $permissions = $this->roleModel->getAllPermissions();
        $rolePermissions = array_column($this->roleModel->getPermissionsByRole($id), 'id');
        $data = ['title' => 'Sửa vai trò', 'role' => $role, 'permissions' => $permissions, 'rolePermissions' => $rolePermissions];
        require_once APP_ROOT . '/Views/admin/role/edit.php';
    }

    public function delete($id) {
        if ($this->roleModel->deleteRole($id)) {
            setFlash('success', 'Xóa vai trò thành công');
        } else {
            setFlash('error', 'Xóa thất bại');
        }
        redirect('admin/role');
    }
}