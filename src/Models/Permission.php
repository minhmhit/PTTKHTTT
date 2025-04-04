<?php
namespace Models;

class Permission {
    private $db;

    public function __construct() {
        $this->db = new Database(); // Giả sử bạn đã có class Database để kết nối cơ sở dữ liệu
    }

    // Lấy tất cả quyền
    public function getAllPermissions() {
        $this->db->query('SELECT * FROM permissions ORDER BY name ASC');
        return $this->db->fetchAll();
    }

    // Lấy quyền theo ID
    public function getPermissionById($id) {
        $this->db->query('SELECT * FROM permissions WHERE id = :id');
        $this->db->bind(':id', $id);
        return $this->db->fetch();
    }

    // Thêm quyền mới
    public function addPermission($data) {
        $this->db->query('INSERT INTO permissions (name, description) VALUES (:name, :description)');
        $this->db->bind(':name', $data['name']);
        $this->db->bind(':description', $data['description']);
        return $this->db->execute();
    }

    // Cập nhật quyền
    public function updatePermission($data) {
        $this->db->query('UPDATE permissions SET name = :name, description = :description WHERE id = :id');
        $this->db->bind(':name', $data['name']);
        $this->db->bind(':description', $data['description']);
        $this->db->bind(':id', $data['id']);
        return $this->db->execute();
    }

    // Xóa quyền
    public function deletePermission($id) {
        $this->db->query('DELETE FROM permissions WHERE id = :id');
        $this->db->bind(':id', $id);
        return $this->db->execute();
    }
}