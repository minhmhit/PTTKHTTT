<?php
namespace Controllers;

use Models\User;

class UserController {
    private $userModel;
    
    public function __construct() {
        $this->userModel = new User();
    }
    
    // Hiển thị form đăng nhập
    public function login() {
        // Kiểm tra nếu đã đăng nhập
        if (isset($_SESSION['user_id'])) {
            redirect('');
        }
        
        // Kiểm tra form submit
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            // Xử lý form
            $email = clean($_POST['email']);
            $password = $_POST['password'];
            
            // Validate input
            $errors = [];
            
            if (empty($email)) {
                $errors['email'] = 'Vui lòng nhập email';
            } elseif (!isValidEmail($email)) {
                $errors['email'] = 'Email không hợp lệ';
            }
            
            if (empty($password)) {
                $errors['password'] = 'Vui lòng nhập mật khẩu';
            }
            
            // Nếu không có lỗi, tiến hành đăng nhập
            if (empty($errors)) {
                $user = $this->userModel->login($email, $password);
                
                if ($user) {
                    // Tạo session
                    $_SESSION['user_id'] = $user['id'];
                    $_SESSION['user_name'] = $user['name'];
                    $_SESSION['user_email'] = $user['email'];
                    $_SESSION['user_role'] = $user['role'];
                    
                    // Chuyển hướng dựa vào quyền
                    if ($user['role'] == 'admin') {
                        redirect('admin/dashboard');
                    } else {
                        redirect('');
                    }
                } else {
                    $errors['login'] = 'Email hoặc mật khẩu không đúng';
                }
            }
            
            $data = [
                'email' => $email,
                'errors' => $errors,
                'title' => 'Đăng nhập - ' . SITE_NAME
            ];
        } else {
            $data = [
                'email' => '',
                'errors' => [],
                'title' => 'Đăng nhập - ' . SITE_NAME
            ];
        }
        
        // Load view
        require_once APP_ROOT . '/Views/layouts/header.php';
        require_once APP_ROOT . '/Views/user/login.php';
        require_once APP_ROOT . '/Views/layouts/footer.php';
    }
    
    // Hiển thị form đăng ký
    public function register() {
        // Kiểm tra nếu đã đăng nhập
        if (isset($_SESSION['user_id'])) {
            redirect('');
        }
        
        // Kiểm tra form submit
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            // Xử lý form
            $name = clean($_POST['name']);
            $email = clean($_POST['email']);
            $password = $_POST['password'];
            $confirm_password = $_POST['confirm_password'];
            $phone = clean($_POST['phone']);
            $address = clean($_POST['address']);
            
            // Validate input
            $errors = [];
            
            if (empty($name)) {
                $errors['name'] = 'Vui lòng nhập họ tên';
            }
            
            if (empty($email)) {
                $errors['email'] = 'Vui lòng nhập email';
            } elseif (!isValidEmail($email)) {
                $errors['email'] = 'Email không hợp lệ';
            } elseif ($this->userModel->findUserByEmail($email)) {
                $errors['email'] = 'Email đã được sử dụng';
            }
            
            if (empty($password)) {
                $errors['password'] = 'Vui lòng nhập mật khẩu';
            } elseif (strlen($password) < 6) {
                $errors['password'] = 'Mật khẩu phải có ít nhất 6 ký tự';
            }
            
            if ($password != $confirm_password) {
                $errors['confirm_password'] = 'Mật khẩu không khớp';
            }
            
            if (empty($phone)) {
                $errors['phone'] = 'Vui lòng nhập số điện thoại';
            } elseif (!isValidPhone($phone)) {
                $errors['phone'] = 'Số điện thoại không hợp lệ';
            }
            
            if (empty($address)) {
                $errors['address'] = 'Vui lòng nhập địa chỉ';
            }
            
            // Nếu không có lỗi, tiến hành đăng ký
            if (empty($errors)) {
                $data = [
                    'name' => $name,
                    'email' => $email,
                    'password' => $password,
                    'phone' => $phone,
                    'address' => $address
                ];
                
                $user_id = $this->userModel->register($data);
                
                if ($user_id) {
                    // Tạo session
                    $_SESSION['user_id'] = $user_id;
                    $_SESSION['user_name'] = $name;
                    $_SESSION['user_email'] = $email;
                    $_SESSION['user_role'] = 'customer';
                    
                    setFlash('success', 'Đăng ký thành công!');
                    redirect('');
                } else {
                    $errors['register'] = 'Đăng ký thất bại, vui lòng thử lại';
                }
            }
            
            $data = [
                'name' => $name,
                'email' => $email,
                'phone' => $phone,
                'address' => $address,
                'errors' => $errors,
                'title' => 'Đăng ký - ' . SITE_NAME
            ];
        } else {
            $data = [
                'name' => '',
                'email' => '',
                'phone' => '',
                'address' => '',
                'errors' => [],
                'title' => 'Đăng ký - ' . SITE_NAME
            ];
        }
        
        // Load view
        require_once APP_ROOT . '/Views/layouts/header.php';
        require_once APP_ROOT . '/Views/user/register.php';
        require_once APP_ROOT . '/Views/layouts/footer.php';
    }
    
    // Đăng xuất
    public function logout() {
        // Xóa session người dùng
        unset($_SESSION['user_id']);
        unset($_SESSION['user_name']);
        unset($_SESSION['user_email']);
        unset($_SESSION['user_role']);
        
        session_destroy();
        setFlash('success', 'Đăng xuất thành công');
        // Chuyển hướng đến trang đăng nhập
        redirect('user/login');
    }
   
    // Hiển thị và cập nhật hồ sơ người dùng
    public function profile() {
        // Kiểm tra đăng nhập
        if (!isset($_SESSION['user_id'])) {
            redirect('user/login');
        }
        
        // Lấy thông tin người dùng
        $user = $this->userModel->getUserById($_SESSION['user_id']);
        
        // Kiểm tra form submit
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            // Xử lý form
            $name = clean($_POST['name']);
            $phone = clean($_POST['phone']);
            $address = clean($_POST['address']);
            
            // Validate input
            $errors = [];
            
            if (empty($name)) {
                $errors['name'] = 'Vui lòng nhập họ tên';
            }
            
            if (empty($phone)) {
                $errors['phone'] = 'Vui lòng nhập số điện thoại';
            } elseif (!isValidPhone($phone)) {
                $errors['phone'] = 'Số điện thoại không hợp lệ';
            }
            
            if (empty($address)) {
                $errors['address'] = 'Vui lòng nhập địa chỉ';
            }
            
            // Nếu không có lỗi, tiến hành cập nhật
            if (empty($errors)) {
                $data = [
                    'id' => $_SESSION['user_id'],
                    'name' => $name,
                    'phone' => $phone,
                    'address' => $address
                ];
                
                if ($this->userModel->updateUser($data)) {
                    $_SESSION['user_name'] = $name;
                    setFlash('success', 'Cập nhật thông tin thành công!');
                    redirect('user/profile');
                } else {
                    $errors['update'] = 'Cập nhật thất bại, vui lòng thử lại';
                }
            }
            
            $data = [
                'user' => $user,
                'errors' => $errors,
                'title' => 'Hồ sơ người dùng - ' . SITE_NAME
            ];
        } else {
            $data = [
                'user' => $user,
                'errors' => [],
                'title' => 'Hồ sơ người dùng - ' . SITE_NAME
            ];
        }
        
        
        // Load view
        require_once APP_ROOT . '/Views/layouts/header.php';
        require_once APP_ROOT . '/Views/user/profile.php';
        require_once APP_ROOT . '/Views/layouts/footer.php';
    }
}