<?php
namespace Models;

class User {
    private $db;
    
    public function __construct() {
        $this->db = new Database();
    }
    
    public function login($email, $password) {
        $this->db->query('SELECT u.*, r.name as role_name FROM users u JOIN roles r ON u.role_id = r.id WHERE u.email = :email');
        $this->db->bind(':email', $email);
        $user = $this->db->fetch();
        if ($user && password_verify($password, $user['password'])) {
            return $user;
        }
        return false;
    }

    public function register($data) {
        $this->db->query('INSERT INTO users (name, email, password, phone, address, role_id) VALUES (:name, :email, :password, :phone, :address, :role_id)');
        $this->db->bind(':name', $data['name']);
        $this->db->bind(':email', $data['email']);
        $this->db->bind(':password', password_hash($data['password'], PASSWORD_DEFAULT));
        $this->db->bind(':phone', $data['phone']);
        $this->db->bind(':address', $data['address']);
        $this->db->bind(':role_id', $data['role_id'] ?? 4); // Mặc định là customer (role_id = 4)
        return $this->db->execute();
    }

    public function getUserById($id) {
        $this->db->query('SELECT u.*, r.name as role_name FROM users u JOIN roles r ON u.role_id = r.id WHERE u.id = :id');
        $this->db->bind(':id', $id);
        return $this->db->fetch();
    }
    
    // Kiểm tra email đã tồn tại
    public function findUserByEmail($email) {
        $this->db->query('SELECT * FROM users WHERE email = :email');
        $this->db->bind(':email', $email);
        
        $row = $this->db->fetch();
        
        return ($this->db->rowCount() > 0);
    }
    public function getTotalUsers() {
        $this->db->query('SELECT COUNT(*) as total FROM users');
        $result = $this->db->fetch();
        return $result['total'] ?? 0;
    }
   
    
    // Cập nhật thông tin người dùng
    public function updateUser($data) {
        $this->db->query('UPDATE users SET name = :name, phone = :phone, address = :address, updated_at = NOW() 
                         WHERE id = :id');
        
        $this->db->bind(':name', $data['name']);
        $this->db->bind(':phone', $data['phone']);
        $this->db->bind(':address', $data['address']);
        $this->db->bind(':id', $data['id']);
        
        return $this->db->execute();
    }
    
    // Cập nhật mật khẩu
    public function updatePassword($id, $password) {
        $this->db->query('UPDATE users SET password = :password, updated_at = NOW() WHERE id = :id');
        
        $this->db->bind(':password', password_hash($password, PASSWORD_DEFAULT));
        $this->db->bind(':id', $id);
        
        return $this->db->execute();
    }
    
    // Lấy danh sách tất cả người dùng (cho admin)
    public function getAllUsers() {
        $this->db->query('SELECT * FROM users ORDER BY created_at DESC');
        return $this->db->fetchAll();
    }
    
    // Thêm người dùng (cho admin)
    public function addUser($data) {
        // Hash mật khẩu
        $data['password'] = password_hash($data['password'], PASSWORD_DEFAULT);
        
        // Chuẩn bị truy vấn
        $this->db->query('INSERT INTO users (name, email, password, phone, address, role, created_at) 
                         VALUES (:name, :email, :password, :phone, :address, :role, NOW())');
        
        // Bind values
        $this->db->bind(':name', $data['name']);
        $this->db->bind(':email', $data['email']);
        $this->db->bind(':password', $data['password']);
        $this->db->bind(':phone', $data['phone']);
        $this->db->bind(':address', $data['address']);
        $this->db->bind(':role', $data['role']);
        
        // Thực thi
        return $this->db->execute();
    }
    
    // Cập nhật người dùng (cho admin)
    public function updateUserByAdmin($data) {
        $this->db->query('UPDATE users SET name = :name, phone = :phone, address = :address, role = :role, updated_at = NOW() 
                         WHERE id = :id');
        
        $this->db->bind(':name', $data['name']);
        $this->db->bind(':phone', $data['phone']);
        $this->db->bind(':address', $data['address']);
        $this->db->bind(':role', $data['role']);
        $this->db->bind(':id', $data['id']);
        
        return $this->db->execute();
    }
    
    // Xóa người dùng
    public function deleteUser($id) {
        $this->db->query('DELETE FROM users WHERE id = :id');
        $this->db->bind(':id', $id);
        
        return $this->db->execute();
    }
}