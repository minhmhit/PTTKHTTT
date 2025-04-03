<?php
namespace Models;

class Supplier {
    private $db;

    public function __construct() {
        $this->db = new Database();
    }

    public function getAllSuppliers() {
        $this->db->query('SELECT * FROM suppliers ORDER BY name ASC');
        return $this->db->fetchAll();
    }

    public function getSupplierById($id) {
        $this->db->query('SELECT * FROM suppliers WHERE id = :id');
        $this->db->bind(':id', $id);
        return $this->db->fetch();
    }

    public function addSupplier($data) {
        $this->db->query('INSERT INTO suppliers (name, contact_name, phone, email, address) 
                         VALUES (:name, :contact_name, :phone, :email, :address)');
        $this->db->bind(':name', $data['name']);
        $this->db->bind(':contact_name', $data['contact_name']);
        $this->db->bind(':phone', $data['phone']);
        $this->db->bind(':email', $data['email']);
        $this->db->bind(':address', $data['address']);
        return $this->db->execute();
    }

    public function updateSupplier($data) {
        $this->db->query('UPDATE suppliers SET name = :name, contact_name = :contact_name, phone = :phone, email = :email, address = :address 
                         WHERE id = :id');
        $this->db->bind(':name', $data['name']);
        $this->db->bind(':contact_name', $data['contact_name']);
        $this->db->bind(':phone', $data['phone']);
        $this->db->bind(':email', $data['email']);
        $this->db->bind(':address', $data['address']);
        $this->db->bind(':id', $data['id']);
        return $this->db->execute();
    }

    public function deleteSupplier($id) {
        $this->db->query('DELETE FROM suppliers WHERE id = :id');
        $this->db->bind(':id', $id);
        return $this->db->execute();
    }
}