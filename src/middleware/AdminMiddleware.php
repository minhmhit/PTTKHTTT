<?php
namespace Middleware;

use Models\User;

class AdminMiddleware {
    private $userModel;

    public function __construct() {
        $this->userModel = new User();
    }

    public function handle() {
        if (!isset($_SESSION['user_id']) || !$this->isAdmin()) {
            redirect('user/login');
        }
    }

    private function isAdmin() {
        $user = $this->userModel->getUserById($_SESSION['user_id']);
        return $user['role_id'] == 1; // Role_id = 1 là admin
    }
}