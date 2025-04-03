<?php
namespace Models;

class Report {
    private $db;
    
    public function __construct() {
        $this->db = new Database();
    }
    
    // Báo cáo doanh thu theo tháng
    public function getMonthlySalesReport($year) {
        $this->db->query('SELECT MONTH(created_at) as month, 
                         SUM(total_amount) as revenue,
                         COUNT(*) as order_count
                         FROM orders 
                         WHERE YEAR(created_at) = :year AND status = "completed"
                         GROUP BY MONTH(created_at)
                         ORDER BY month');
        
        $this->db->bind(':year', $year);
        
        return $this->db->fetchAll();
    }
    
    // Báo cáo doanh thu theo danh mục
    public function getSalesByCategory() {
        $this->db->query('SELECT c.name as category_name, SUM(od.quantity * od.price) as revenue
                         FROM categories c
                         JOIN products p ON c.id = p.category_id
                         JOIN order_details od ON p.id = od.product_id
                         JOIN orders o ON od.order_id = o.id
                         WHERE o.status = "completed"
                         GROUP BY c.id
                         ORDER BY revenue DESC');
        
        return $this->db->fetchAll();
    }
    
    // Báo cáo sản phẩm bán chạy
    public function getBestSellingProducts($limit = 10) {
        $this->db->query('SELECT p.name as product_name, p.price, SUM(od.quantity) as total_quantity,
                         SUM(od.quantity * od.price) as total_revenue
                         FROM products p
                         JOIN order_details od ON p.id = od.product_id
                         JOIN orders o ON od.order_id = o.id
                         WHERE o.status = "completed"
                         GROUP BY p.id
                         ORDER BY total_quantity DESC
                         LIMIT :limit');
        
        $this->db->bind(':limit', $limit);
        
        return $this->db->fetchAll();
    }
    
    // Báo cáo khách hàng mua nhiều nhất
    public function getTopCustomers($limit = 10) {
        $this->db->query('SELECT u.name as customer_name, u.email, COUNT(o.id) as order_count,
                         SUM(o.total_amount) as total_spent
                         FROM users u
                         JOIN orders o ON u.id = o.user_id
                         WHERE o.status = "completed"
                         GROUP BY u.id
                         ORDER BY total_spent DESC
                         LIMIT :limit');
        
        $this->db->bind(':limit', $limit);
        
        return $this->db->fetchAll();
    }
}