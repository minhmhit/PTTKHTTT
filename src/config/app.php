<?php
// Cấu hình ứng dụng
define('BASE_URL', 'http://localhost/PTTKHTTT/PTTKHTTT/src/');
define('SITE_NAME', 'Coffee Shop');
define('APP_ROOT', dirname(dirname(__FILE__)));

// Cấu hình session
session_start();

// Tự động tải các file
spl_autoload_register(function($className) {
    $file = APP_ROOT . '/' . str_replace('\\', '/', $className) . '.php';
    if (file_exists($file)) {
        require_once $file;
    }
});

// Tải helper functions
require_once APP_ROOT . '/helpers/common.php';
require_once APP_ROOT . '/helpers/validation.php';