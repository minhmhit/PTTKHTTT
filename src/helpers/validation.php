<?php
/**
 * Kiểm tra email hợp lệ
 */
function isValidEmail($email) {
    return filter_var($email, FILTER_VALIDATE_EMAIL);
}

/**
 * Kiểm tra mật khẩu hợp lệ
 * Ít nhất 8 ký tự, bao gồm chữ hoa, chữ thường và số
 */
function isValidPassword($password) {
    return strlen($password) >= 8 && 
           preg_match('/[A-Z]/', $password) && 
           preg_match('/[a-z]/', $password) && 
           preg_match('/[0-9]/', $password);
}

/**
 * Kiểm tra số điện thoại hợp lệ
 */
function isValidPhone($phone) {
    return preg_match('/^(0|\+84)[0-9]{9,10}$/', $phone);
}

/**
 * Kiểm tra chuỗi không rỗng
 */
function isNotEmpty($input) {
    return !empty(trim($input));
}