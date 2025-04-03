<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

function clean($data) {
    return htmlspecialchars(trim($data), ENT_QUOTES, 'UTF-8');
}

function redirect($url) {
    header("Location: " . BASE_URL . $url);
    exit();
}

function setFlash($key, $message) {
    $_SESSION['flash'][$key] = $message;
}

function flash($key) {
    if (isset($_SESSION['flash'][$key])) {
        $message = $_SESSION['flash'][$key];
        unset($_SESSION['flash'][$key]);
        echo '<div class="alert alert-' . ($key === 'success' ? 'success' : 'danger') . ' alert-dismissible fade show" role="alert">' .
             $message .
             '<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>' .
             '</div>';
    }
}