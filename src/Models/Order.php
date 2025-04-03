<?php
namespace Models;

class Order {
    private $db;
    private $productModel;

    public function __construct() {
        $this->db = new Database();
        $this->productModel = new Product();
    }

    public function updateOrderStatus($id, $status) {
        $this->db->query('UPDATE orders SET status = :status WHERE id = :id');
        $this->db->bind(':status', $status);
        $this->db->bind(':id', $id);
        if ($this->db->execute() && $status === 'completed') {
            $details = $this->getOrderDetails($id);
            foreach ($details as $item) {
                $this->productModel->updateStock($item['product_id'], $item['quantity'], false);
            }
        }
        return true;
    }
    // Tạo đơn hàng mới
    public function createOrder($data) {
        try {
            $this->db->beginTransaction();
            
            // Thêm thông tin đơn hàng
            $this->db->query('INSERT INTO orders (user_id, total_amount, shipping_address, phone, note, status, created_at) 
                             VALUES (:user_id, :total_amount, :shipping_address, :phone, :note, :status, NOW())');
            
            $this->db->bind(':user_id', $data['user_id']);
            $this->db->bind(':total_amount', $data['total_amount']);
            $this->db->bind(':shipping_address', $data['shipping_address']);
            $this->db->bind(':phone', $data['phone']);
            $this->db->bind(':note', $data['note']);
            $this->db->bind(':status', 'pending'); // Trạng thái mặc định: đang chờ xử lý
            
            $this->db->execute();
            
            $orderId = $this->db->lastInsertId();
            
            // Thêm chi tiết đơn hàng
            foreach ($data['items'] as $item) {
                $this->db->query('INSERT INTO order_details (order_id, product_id, quantity, price) 
                                 VALUES (:order_id, :product_id, :quantity, :price)');
                
                $this->db->bind(':order_id', $orderId);
                $this->db->bind(':product_id', $item['product_id']);
                $this->db->bind(':quantity', $item['quantity']);
                $this->db->bind(':price', $item['price']);
                
                $this->db->execute();
                
                // Cập nhật số lượng sản phẩm trong kho
                $this->db->query('UPDATE products SET stock = stock - :quantity WHERE id = :product_id');
                $this->db->bind(':quantity', $item['quantity']);
                $this->db->bind(':product_id', $item['product_id']);
                
                $this->db->execute();
            }
            
            $this->db->commit();
            return $orderId;
            
        } catch (\Exception $e) {
            $this->db->rollback();
            return false;
        }
    }
    public function getTotalOrders() {
        $this->db->query('SELECT COUNT(*) as total FROM orders');
        $result = $this->db->fetch();
        return $result['total'] ?? 0;
    }
    
    // Lấy tất cả đơn hàng
    public function getAllOrders() {
        $this->db->query('SELECT o.*, u.name as user_name, u.email as user_email 
                         FROM orders o 
                         JOIN users u ON o.user_id = u.id 
                         ORDER BY o.created_at DESC');
        return $this->db->fetchAll();
    }
    
    // Lấy đơn hàng theo ID
    public function getOrderById($id) {
        $this->db->query('SELECT o.*, u.name as user_name, u.email as user_email 
                         FROM orders o 
                         JOIN users u ON o.user_id = u.id 
                         WHERE o.id = :id');
        $this->db->bind(':id', $id);
        
        return $this->db->fetch();
    }
    
    // Lấy đơn hàng của người dùng
    public function getOrdersByUser($userId) {
        $this->db->query('SELECT * FROM orders WHERE user_id = :user_id ORDER BY created_at DESC');
        $this->db->bind(':user_id', $userId);
        
        return $this->db->fetchAll();
    }
    
    // Lấy chi tiết đơn hàng
    public function getOrderDetails($orderId) {
        $this->db->query('SELECT od.*, p.name as product_name, p.image as product_image 
                         FROM order_details od 
                         JOIN products p ON od.product_id = p.id 
                         WHERE od.order_id = :order_id');
        $this->db->bind(':order_id', $orderId);
        
        return $this->db->fetchAll();
    }
   
    
    // Hủy đơn hàng và hoàn trả số lượng sản phẩm vào kho
    public function cancelOrder($id) {
        try {
            $this->db->beginTransaction();
            
            // Lấy chi tiết đơn hàng
            $this->db->query('SELECT * FROM order_details WHERE order_id = :order_id');
            $this->db->bind(':order_id', $id);
            $orderDetails = $this->db->fetchAll();
            
            // Hoàn trả số lượng sản phẩm vào kho
            foreach ($orderDetails as $item) {
                $this->db->query('UPDATE products SET stock = stock + :quantity WHERE id = :product_id');
                $this->db->bind(':quantity', $item['quantity']);
                $this->db->bind(':product_id', $item['product_id']);
                $this->db->execute();
            }
            
            // Cập nhật trạng thái đơn hàng
            $this->db->query('UPDATE orders SET status = "cancelled", updated_at = NOW() WHERE id = :id');
            $this->db->bind(':id', $id);
            $this->db->execute();
            
            $this->db->commit();
            return true;
        } catch (\Exception $e) {
            $this->db->rollback();
            return false;
        }
    }
    
    // Lấy thống kê đơn hàng theo trạng thái
    public function getOrderStatsByStatus() {
        $this->db->query('SELECT status, COUNT(*) as count FROM orders GROUP BY status');
        return $this->db->fetchAll();
    }
    
    // Lấy doanh thu theo thời gian
    public function getRevenueByDate($startDate, $endDate) {
        $this->db->query('SELECT DATE(created_at) as date, SUM(total_amount) as revenue 
                         FROM orders 
                         WHERE status = "completed" 
                         AND created_at BETWEEN :start_date AND :end_date 
                         GROUP BY DATE(created_at) 
                         ORDER BY date');
        
        $this->db->bind(':start_date', $startDate);
        $this->db->bind(':end_date', $endDate);
        
        return $this->db->fetchAll();
    }
    
    // Lấy tổng doanh thu
    public function getTotalRevenue() {
        $this->db->query('SELECT SUM(total_amount) as total_revenue FROM orders WHERE status = "completed"');
        $result = $this->db->fetch();
        return $result['total_revenue'] ?: 0;
    }
    
    // Lấy đơn hàng mới nhất
    public function getRecentOrders($limit = 5) {
        $this->db->query('SELECT o.*, u.name as user_name 
                         FROM orders o 
                         JOIN users u ON o.user_id = u.id 
                         ORDER BY o.created_at DESC LIMIT :limit');
        $this->db->bind(':limit', $limit);
        
        return $this->db->fetchAll();
    }
}