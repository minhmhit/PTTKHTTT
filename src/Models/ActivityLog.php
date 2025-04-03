<?php
namespace Models;

class ActivityLog {
    private $db;

    public function __construct() {
        $this->db = new Database();
    }

    public function getAllLogs($limit = null) {
        $query = 'SELECT al.*, u.name as user_name FROM activity_logs al 
                  JOIN users u ON al.user_id = u.id 
                  ORDER BY al.created_at DESC';
        if ($limit) {
            $query .= ' LIMIT :limit';
        }
        $this->db->query($query);
        if ($limit) {
            $this->db->bind(':limit', $limit);
        }
        return $this->db->fetchAll();
    }

    public function addLog($userId, $action, $description) {
        $this->db->query('INSERT INTO activity_logs (user_id, action, description) 
                         VALUES (:user_id, :action, :description)');
        $this->db->bind(':user_id', $userId);
        $this->db->bind(':action', $action);
        $this->db->bind(':description', $description);
        return $this->db->execute();
    }
}