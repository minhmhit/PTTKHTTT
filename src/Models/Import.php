<?php
namespace Models;

class Import {
    private $db;
    private $productModel;

    public function __construct() {
        $this->db = new Database();
        $this->productModel = new Product();
    }

    public function getAllImports() {
        $this->db->query('SELECT i.*, s.name as supplier_name, u.name as user_name 
                         FROM imports i 
                         JOIN suppliers s ON i.supplier_id = s.id 
                         JOIN users u ON i.user_id = u.id 
                         ORDER BY i.created_at DESC');
        return $this->db->fetchAll();
    }

    public function getImportById($id) {
        $this->db->query('SELECT i.*, s.name as supplier_name, u.name as user_name 
                         FROM imports i 
                         JOIN suppliers s ON i.supplier_id = s.id 
                         JOIN users u ON i.user_id = u.id 
                         WHERE i.id = :id');
        $this->db->bind(':id', $id);
        return $this->db->fetch();
    }

    public function getImportDetails($importId) {
        $this->db->query('SELECT id.*, p.name as product_name 
                         FROM import_details id 
                         JOIN products p ON id.product_id = p.id 
                         WHERE id.import_id = :import_id');
        $this->db->bind(':import_id', $importId);
        return $this->db->fetchAll();
    }

    public function addImport($data, $details) {
        $this->db->query('INSERT INTO imports (user_id, supplier_id, total_cost, note, status) 
                         VALUES (:user_id, :supplier_id, :total_cost, :note, :status)');
        $this->db->bind(':user_id', $data['user_id']);
        $this->db->bind(':supplier_id', $data['supplier_id']);
        $this->db->bind(':total_cost', $data['total_cost']);
        $this->db->bind(':note', $data['note']);
        $this->db->bind(':status', $data['status']);
        if ($this->db->execute()) {
            $importId = $this->db->lastInsertId();
            foreach ($details as $detail) {
                $this->db->query('INSERT INTO import_details (import_id, product_id, quantity, cost) 
                                 VALUES (:import_id, :product_id, :quantity, :cost)');
                $this->db->bind(':import_id', $importId);
                $this->db->bind(':product_id', $detail['product_id']);
                $this->db->bind(':quantity', $detail['quantity']);
                $this->db->bind(':cost', $detail['cost']);
                $this->db->execute();
                if ($data['status'] === 'completed') {
                    $this->productModel->updateStock($detail['product_id'], $detail['quantity'], true);
                }
            }
            return true;
        }
        return false;
    }

    public function updateImport($data, $details) {
        $this->db->query('UPDATE imports SET supplier_id = :supplier_id, total_cost = :total_cost, note = :note, status = :status 
                         WHERE id = :id');
        $this->db->bind(':supplier_id', $data['supplier_id']);
        $this->db->bind(':total_cost', $data['total_cost']);
        $this->db->bind(':note', $data['note']);
        $this->db->bind(':status', $data['status']);
        $this->db->bind(':id', $data['id']);
        if ($this->db->execute()) {
            // Xóa chi tiết cũ và thêm mới
            $this->db->query('DELETE FROM import_details WHERE import_id = :import_id');
            $this->db->bind(':import_id', $data['id']);
            $this->db->execute();
            foreach ($details as $detail) {
                $this->db->query('INSERT INTO import_details (import_id, product_id, quantity, cost) 
                                 VALUES (:import_id, :product_id, :quantity, :cost)');
                $this->db->bind(':import_id', $data['id']);
                $this->db->bind(':product_id', $detail['product_id']);
                $this->db->bind(':quantity', $detail['quantity']);
                $this->db->bind(':cost', $detail['cost']);
                $this->db->execute();
                if ($data['status'] === 'completed') {
                    $this->productModel->updateStock($detail['product_id'], $detail['quantity'], true);
                }
            }
            return true;
        }
        return false;
    }

    public function deleteImport($id) {
        $this->db->query('DELETE FROM imports WHERE id = :id');
        $this->db->bind(':id', $id);
        return $this->db->execute();
    }

    public function getRecentImports($limit) {
        $this->db->query('SELECT i.*, s.name as supplier_name 
                         FROM imports i 
                         JOIN suppliers s ON i.supplier_id = s.id 
                         ORDER BY i.created_at DESC LIMIT :limit');
        $this->db->bind(':limit', $limit);
        return $this->db->fetchAll();
    }
}