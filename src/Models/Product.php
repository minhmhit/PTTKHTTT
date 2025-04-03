<?php
namespace Models;

class Product {
    private $db;
    
    public function __construct() {
        $this->db = new Database();
    }
    
    // Lấy tất cả sản phẩm
    public function getAllProducts() {
        $this->db->query('SELECT p.*, c.name as category_name FROM products p 
                         JOIN categories c ON p.category_id = c.id 
                         ORDER BY p.created_at DESC');
        return $this->db->fetchAll();
    }
    public function getTotalProducts() {
        $this->db->query('SELECT COUNT(*) as total FROM products');
        $result = $this->db->fetch();
        return $result['total'] ?? 0;
    }
    // Lấy sản phẩm theo ID
    public function getProductById($id) {
        $this->db->query('SELECT p.*, c.name as category_name FROM products p 
                         JOIN categories c ON p.category_id = c.id 
                         WHERE p.id = :id');
        $this->db->bind(':id', $id);
        
        return $this->db->fetch();
    }

    public function updateStock($productId, $quantity, $increase = true) {
        $operator = $increase ? '+' : '-';
        $this->db->query("UPDATE products SET stock = stock $operator :quantity WHERE id = :id");
        $this->db->bind(':quantity', $quantity);
        $this->db->bind(':id', $productId);
        return $this->db->execute();
    }
    
    // Thêm sản phẩm mới
    public function addProduct($data) {
        $this->db->query('INSERT INTO products (name, description, price, image, category_id, stock, created_at) 
                         VALUES (:name, :description, :price, :image, :category_id, :stock, NOW())');
        
        $this->db->bind(':name', $data['name']);
        $this->db->bind(':description', $data['description']);
        $this->db->bind(':price', $data['price']);
        $this->db->bind(':image', $data['image']);
        $this->db->bind(':category_id', $data['category_id']);
        $this->db->bind(':stock', $data['stock']);
        
        return $this->db->execute();
    }
    
    // Cập nhật sản phẩm
    public function updateProduct($data) {
        // Kiểm tra xem có cần cập nhật hình ảnh không
        if (!empty($data['image'])) {
            $this->db->query('UPDATE products SET name = :name, description = :description, price = :price, 
                             image = :image, category_id = :category_id, stock = :stock, updated_at = NOW() 
                             WHERE id = :id');
            $this->db->bind(':image', $data['image']);
        } else {
            $this->db->query('UPDATE products SET name = :name, description = :description, price = :price, 
                             category_id = :category_id, stock = :stock, updated_at = NOW() 
                             WHERE id = :id');
        }
        
        $this->db->bind(':name', $data['name']);
        $this->db->bind(':description', $data['description']);
        $this->db->bind(':price', $data['price']);
        $this->db->bind(':category_id', $data['category_id']);
        $this->db->bind(':stock', $data['stock']);
        $this->db->bind(':id', $data['id']);
        
        return $this->db->execute();
    }
    
    // Xóa sản phẩm
    public function deleteProduct($id) {
        $this->db->query('DELETE FROM products WHERE id = :id');
        $this->db->bind(':id', $id);
        
        return $this->db->execute();
    }
    
    // Lấy sản phẩm theo danh mục
    public function getProductsByCategory($categoryId) {
        $this->db->query('SELECT p.*, c.name as category_name FROM products p 
                         JOIN categories c ON p.category_id = c.id 
                         WHERE p.category_id = :category_id
                         ORDER BY p.created_at DESC');
        $this->db->bind(':category_id', $categoryId);
        
        return $this->db->fetchAll();
    }
    
    // Tìm kiếm sản phẩm
    public function searchProducts($keyword) {
        $this->db->query('SELECT p.*, c.name as category_name FROM products p 
                         JOIN categories c ON p.category_id = c.id 
                         WHERE p.name LIKE :keyword OR p.description LIKE :keyword
                         ORDER BY p.created_at DESC');
        $this->db->bind(':keyword', '%' . $keyword . '%');
        
        return $this->db->fetchAll();
    }
    
    
    
    // Lấy sản phẩm bán chạy nhất
    public function getBestSellingProducts($limit = 8) {
        $this->db->query('SELECT p.*, c.name as category_name, SUM(od.quantity) as total_quantity 
                         FROM products p 
                         JOIN categories c ON p.category_id = c.id 
                         JOIN order_details od ON p.id = od.product_id
                         JOIN orders o ON od.order_id = o.id
                         WHERE o.status = "completed"
                         GROUP BY p.id
                         ORDER BY total_quantity DESC
                         LIMIT :limit');
        $this->db->bind(':limit', $limit);
        
        return $this->db->fetchAll();
    }
    
    // Lấy sản phẩm mới nhất
    public function getNewestProducts($limit = 8) {
        $this->db->query('SELECT p.*, c.name as category_name FROM products p 
                         JOIN categories c ON p.category_id = c.id 
                         ORDER BY p.created_at DESC
                         LIMIT :limit');
        $this->db->bind(':limit', $limit);
        
        return $this->db->fetchAll();
    }
}