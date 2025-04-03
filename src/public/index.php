<?php

require_once '../config/app.php';
require_once '../config/database.php';




// Thiết lập autoloader
spl_autoload_register(function ($class) {
    $file = APP_ROOT . '/' . str_replace('\\', '/', $class) . '.php';
    if (file_exists($file)) {
        require_once $file;
    }
});


// Xử lý routing
$url = isset($_GET['url']) ? rtrim($_GET['url'], '/') : '';
$url = filter_var($url, FILTER_SANITIZE_URL);
$url = explode('/', $url);

// Xác định controller
$controllerName = !empty($url[0]) ? ucfirst($url[0]) : 'Home';
$controllerMethod = !empty($url[1]) ? $url[1] : 'index';

// Kiểm tra nếu là Admin route
if ($controllerName == 'Admin') {
    $controllerName = !empty($url[1]) ? ucfirst($url[1]) : 'Dashboard';
    $controllerMethod = !empty($url[2]) ? $url[2] : 'index';
    $controllerFile = '../Controllers/Admin/' . $controllerName . 'Controller.php';
    $controllerClass = 'Controllers\\Admin\\' . $controllerName . 'Controller';
    
    // Kiểm tra quyền admin trước khi gọi controller
    require_once '../middleware/AdminMiddleware.php';
    $adminMiddleware = new \Middleware\AdminMiddleware(); // Thêm namespace
    $adminMiddleware->handle();
    
    // Lấy các tham số (nếu có)
    $params = array_slice($url, 3);
} else {
    $controllerFile = '../Controllers/' . $controllerName . 'Controller.php';
    $controllerClass = 'Controllers\\' . $controllerName . 'Controller';
    
    // Lấy các tham số (nếu có)
    $params = array_slice($url, 2);
}

// Kiểm tra file controller tồn tại
if (file_exists($controllerFile)) {
    require_once $controllerFile;
    
    // Khởi tạo controller
    if (class_exists($controllerClass)) {
        $controller = new $controllerClass();
        
        // Kiểm tra phương thức tồn tại
        if (method_exists($controller, $controllerMethod)) {
            call_user_func_array([$controller, $controllerMethod], $params);
        } else {
            // Phương thức không tồn tại
            require_once '../Views/layouts/header.php';
            echo '<div class="container mt-5"><div class="alert alert-danger">Phương thức không tồn tại!</div></div>';
            require_once '../Views/layouts/footer.php';
        }
    } else {
        // Class không tồn tại
        require_once '../Views/layouts/header.php';
        echo '<div class="container mt-5"><div class="alert alert-danger">Controller không tồn tại!</div></div>';
        require_once '../Views/layouts/footer.php';
    }
} else {
    // File không tồn tại
    require_once '../Views/layouts/header.php';
    echo '<div class="container mt-5"><div class="alert alert-danger">Trang không tồn tại!</div></div>';
    require_once '../Views/layouts/footer.php';
}