<?php
namespace Models;

class Category {
    private $db;
    
    public function __construct() {
        $this->db = new Database();
    }
    
    // Lấy tất cả danh mục
    public function getAllCategories() {
        $this->db->query('SELECT * FROM categories ORDER BY name');
        return $this->db->fetchAll();
    }
    
    // Lấy danh mục theo ID
    public function getCategoryById($id) {
        $this->db->query('SELECT * FROM categories WHERE id = :id');
        $this->db->bind(':id', $id);
        
        return $this->db->fetch();
    }
    
    // Thêm danh mục mới
    public function addCategory($data) {
        $this->db->query('INSERT INTO categories (name, description, created_at) 
                         VALUES (:name, :description, NOW())');
        
        $this->db->bind(':name', $data['name']);
        $this->db->bind(':description', $data['description']);
        
        return $this->db->execute();
    }
    
    // Cập nhật danh mục
    public function updateCategory($data) {
        $this->db->query('UPDATE categories SET name = :name, description = :description, updated_at = NOW() 
                         WHERE id = :id');
        
        $this->db->bind(':name', $data['name']);
        $this->db->bind(':description', $data['description']);
        $this->db->bind(':id', $data['id']);
        
        return $this->db->execute();
    }
    
    // Xóa danh mục
    public function deleteCategory($id) {
        $this->db->query('DELETE FROM categories WHERE id = :id');
        $this->db->bind(':id', $id);
        
        return $this->db->execute();
    }
    
    // Đếm số sản phẩm trong danh mục
    public function countProductsInCategory($id) {
        $this->db->query('SELECT COUNT(*) as count FROM products WHERE category_id = :id');
        $this->db->bind(':id', $id);
        
        $result = $this->db->fetch();
        return $result['count'];
    }
}