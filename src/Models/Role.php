<?php
namespace Models;

class Role {
    private $db;

    public function __construct() {
        $this->db = new Database();
    }

    public function getAllRoles() {
        $this->db->query('SELECT * FROM roles ORDER BY name ASC');
        return $this->db->fetchAll();
    }

    public function getRoleById($id) {
        $this->db->query('SELECT * FROM roles WHERE id = :id');
        $this->db->bind(':id', $id);
        return $this->db->fetch();
    }

    public function addRole($data) {
        $this->db->query('INSERT INTO roles (name, description) VALUES (:name, :description)');
        $this->db->bind(':name', $data['name']);
        $this->db->bind(':description', $data['description']);
        if ($this->db->execute()) {
            $roleId = $this->db->lastInsertId();
            foreach ($data['permissions'] as $permissionId) {
                $this->db->query('INSERT INTO role_permissions (role_id, permission_id) VALUES (:role_id, :permission_id)');
                $this->db->bind(':role_id', $roleId);
                $this->db->bind(':permission_id', $permissionId);
                $this->db->execute();
            }
            return true;
        }
        return false;
    }

    public function updateRole($data) {
        $this->db->query('UPDATE roles SET name = :name, description = :description WHERE id = :id');
        $this->db->bind(':name', $data['name']);
        $this->db->bind(':description', $data['description']);
        $this->db->bind(':id', $data['id']);
        if ($this->db->execute()) {
            $this->db->query('DELETE FROM role_permissions WHERE role_id = :role_id');
            $this->db->bind(':role_id', $data['id']);
            $this->db->execute();
            foreach ($data['permissions'] as $permissionId) {
                $this->db->query('INSERT INTO role_permissions (role_id, permission_id) VALUES (:role_id, :permission_id)');
                $this->db->bind(':role_id', $data['id']);
                $this->db->bind(':permission_id', $permissionId);
                $this->db->execute();
            }
            return true;
        }
        return false;
    }

    public function deleteRole($id) {
        $this->db->query('DELETE FROM roles WHERE id = :id');
        $this->db->bind(':id', $id);
        return $this->db->execute();
    }

    public function getPermissionsByRole($roleId) {
        $this->db->query('SELECT p.* FROM permissions p 
                         JOIN role_permissions rp ON p.id = rp.permission_id 
                         WHERE rp.role_id = :role_id');
        $this->db->bind(':role_id', $roleId);
        return $this->db->fetchAll();
    }

    public function getAllPermissions() {
        $this->db->query('SELECT * FROM permissions ORDER BY name ASC');
        return $this->db->fetchAll();
    }
}