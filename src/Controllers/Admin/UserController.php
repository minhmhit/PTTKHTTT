<?php
namespace Controllers\Admin;

use Models\User;
use Models\Role;

class UserController {
    private $userModel;
    private $roleModel;

    public function __construct() {
        $this->userModel = new User();
        $this->roleModel = new Role();
    }

    public function index() {
        $users = $this->userModel->getAllUsers();
        $data = [
            'title' => 'Quản lý người dùng - ' . SITE_NAME,
            'users' => $users ?? []
        ];
        require_once APP_ROOT . '/Views/admin/user/index.php';
    }

    public function add() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $data = [
                'name' => clean($_POST['name']),
                'email' => clean($_POST['email']),
                'password' => password_hash($_POST['password'], PASSWORD_DEFAULT),
                'phone' => clean($_POST['phone']),
                'address' => clean($_POST['address']),
                'role_id' => clean($_POST['role_id']) // Sửa 'role' thành 'role_id'
            ];

            $errors = [];
            if (empty($data['name'])) $errors['name'] = 'Vui lòng nhập tên';
            if (empty($data['email']) || !filter_var($data['email'], FILTER_VALIDATE_EMAIL)) $errors['email'] = 'Email không hợp lệ';
            if (empty($_POST['password']) || strlen($_POST['password']) < 6) $errors['password'] = 'Mật khẩu phải có ít nhất 6 ký tự';
            if (empty($data['phone'])) $errors['phone'] = 'Vui lòng nhập số điện thoại';
            if (empty($data['address'])) $errors['address'] = 'Vui lòng nhập địa chỉ';
            if (empty($data['role_id'])) $errors['role_id'] = 'Vui lòng chọn vai trò'; // Sửa 'role' thành 'role_id'

            if (empty($errors)) {
                if ($this->userModel->register($data)) { // Sử dụng register() thay vì addUser()
                    setFlash('success', 'Thêm người dùng thành công');
                    redirect('admin/user');
                } else {
                    setFlash('error', 'Thêm người dùng thất bại');
                }
            } else {
                $roles = $this->roleModel->getAllRoles();
                $data['errors'] = $errors;
                $data['title'] = 'Thêm người dùng - ' . SITE_NAME;
                $data['roles'] = $roles;
                require_once APP_ROOT . '/Views/admin/user/add.php';
            }
        } else {
            $roles = $this->roleModel->getAllRoles();
            $data = ['title' => 'Thêm người dùng - ' . SITE_NAME, 'roles' => $roles];
            require_once APP_ROOT . '/Views/admin/user/add.php';
        }
    }

    public function edit($id) {
        $user = $this->userModel->getUserById($id);
        if (!$user) {
            setFlash('error', 'Người dùng không tồn tại');
            redirect('admin/user');
        }

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $data = [
                'id' => $id,
                'name' => clean($_POST['name']),
                'phone' => clean($_POST['phone']),
                'address' => clean($_POST['address']),
                'role_id' => clean($_POST['role_id']) // Sửa 'role' thành 'role_id'
            ];

            $errors = [];
            if (empty($data['name'])) $errors['name'] = 'Vui lòng nhập tên';
            if (empty($data['phone'])) $errors['phone'] = 'Vui lòng nhập số điện thoại';
            if (empty($data['address'])) $errors['address'] = 'Vui lòng nhập địa chỉ';
            if (empty($data['role_id'])) $errors['role_id'] = 'Vui lòng chọn vai trò'; // Sửa 'role' thành 'role_id'

            if (empty($errors)) {
                if ($this->userModel->updateUser($data)) { // Sử dụng updateUser() thay vì updateUserByAdmin()
                    setFlash('success', 'Cập nhật người dùng thành công');
                    redirect('admin/user');
                } else {
                    setFlash('error', 'Cập nhật người dùng thất bại');
                }
            } else {
                $roles = $this->roleModel->getAllRoles();
                $data['errors'] = $errors;
                $data['user'] = $user;
                $data['title'] = 'Sửa người dùng - ' . SITE_NAME;
                $data['roles'] = $roles;
                require_once APP_ROOT . '/Views/admin/user/edit.php';
            }
        } else {
            $roles = $this->roleModel->getAllRoles();
            $data = [
                'title' => 'Sửa người dùng - ' . SITE_NAME,
                'user' => $user,
                'roles' => $roles
            ];
            require_once APP_ROOT . '/Views/admin/user/edit.php';
        }
    }

    public function delete($id) {
        if ($this->userModel->deleteUser($id)) {
            setFlash('success', 'Xóa người dùng thành công');
        } else {
            setFlash('error', 'Xóa người dùng thất bại');
        }
        redirect('admin/user');
    }
}