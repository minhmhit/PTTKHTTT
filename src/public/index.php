<?php

// Định nghĩa APP_ROOT
define('APP_ROOT', dirname(__DIR__));

// Nạp cấu hình
require_once APP_ROOT . '/config/app.php';
require_once APP_ROOT . '/config/database.php';

// Khởi động session
// session_start();

// Thiết lập autoloader
spl_autoload_register(function ($class) {
    $file = APP_ROOT . '/' . str_replace('\\', '/', $class) . '.php';
    if (file_exists($file)) {
        require_once $file;
    }
});

// Xử lý routing
$url = isset($_GET['url']) ? rtrim($_GET['url'], '/') : 'home';
$url = filter_var($url, FILTER_SANITIZE_URL);
$segments = explode('/', $url);

// Xác định controller và method
$controllerName = !empty($segments[0]) ? ucfirst($segments[0]) : 'Home';
$method = !empty($segments[1]) ? $segments[1] : 'index';
$params = array_slice($segments, 2);

// Kiểm tra nếu là Admin route
if ($controllerName === 'Admin') {
    require_once APP_ROOT . '/middleware/AdminMiddleware.php';
    $adminMiddleware = new \Middleware\AdminMiddleware();
    $adminMiddleware->handle();

    $controllerName = !empty($segments[1]) ? ucfirst($segments[1]) : 'Dashboard';
    $method = !empty($segments[2]) ? $segments[2] : 'index';
    $params = array_slice($segments, 3);
    $controllerFile = APP_ROOT . '/Controllers/Admin/' . $controllerName . 'Controller.php';
    $controllerClass = 'Controllers\\Admin\\' . $controllerName . 'Controller';
} else {
    $controllerFile = APP_ROOT . '/Controllers/' . $controllerName . 'Controller.php';
    $controllerClass = 'Controllers\\' . $controllerName . 'Controller';
}

// Kiểm tra và gọi controller
if (file_exists($controllerFile)) {
    require_once $controllerFile;

    if (class_exists($controllerClass)) {
        $controller = new $controllerClass();

        if (method_exists($controller, $method)) {
            call_user_func_array([$controller, $method], $params);
        } else {
            header('HTTP/1.0 404 Not Found');
            require_once APP_ROOT . '/Views/layouts/header.php';
            echo '<div class="container mt-5"><div class="alert alert-danger">Phương thức không tồn tại!</div></div>';
            require_once APP_ROOT . '/Views/layouts/footer.php';
        }
    } else {
        header('HTTP/1.0 404 Not Found');
        require_once APP_ROOT . '/Views/layouts/header.php';
        echo '<div class="container mt-5"><div class="alert alert-danger">Controller không tồn tại!</div></div>';
        require_once APP_ROOT . '/Views/layouts/footer.php';
    }
} else {
    header('HTTP/1.0 404 Not Found');
    require_once APP_ROOT . '/Views/layouts/header.php';
    echo '<div class="container mt-5"><div class="alert alert-danger">Trang không tồn tại!</div></div>';
    require_once APP_ROOT . '/Views/layouts/footer.php';
}