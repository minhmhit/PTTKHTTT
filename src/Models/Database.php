<?php
namespace Models;

class Database {
    private $host = DB_HOST;
    private $user = DB_USER;
    private $pass = DB_PASS;
    private $dbname = DB_NAME;
    
    private $conn;
    private $stmt;
    private $error;
    
    public function __construct() {
        // Tạo DSN
        $dsn = 'mysql:host=' . $this->host . ';dbname=' . $this->dbname . ';charset=utf8mb4';
        
        // Thiết lập PDO options
        $options = [
            \PDO::ATTR_PERSISTENT => true,
            \PDO::ATTR_ERRMODE => \PDO::ERRMODE_EXCEPTION,
            \PDO::ATTR_DEFAULT_FETCH_MODE => \PDO::FETCH_ASSOC,
            \PDO::ATTR_EMULATE_PREPARES => false
        ];
        
        // Tạo đối tượng PDO
        try {
            $this->conn = new \PDO($dsn, $this->user, $this->pass, $options);
        } catch(\PDOException $e) {
            $this->error = $e->getMessage();
            echo 'Lỗi kết nối: ' . $this->error;
        }
    }
    
    // Chuẩn bị statement với truy vấn
    public function query($sql) {
        $this->stmt = $this->conn->prepare($sql);
    }
    
    // Bind param
    public function bind($param, $value, $type = null) {
        if(is_null($type)) {
            switch(true) {
                case is_int($value):
                    $type = \PDO::PARAM_INT;
                    break;
                case is_bool($value):
                    $type = \PDO::PARAM_BOOL;
                    break;
                case is_null($value):
                    $type = \PDO::PARAM_NULL;
                    break;
                default:
                    $type = \PDO::PARAM_STR;
            }
        }
        
        $this->stmt->bindValue($param, $value, $type);
    }
    
    // Thực thi statement
    public function execute() {
        return $this->stmt->execute();
    }
    
    // Lấy nhiều bản ghi
    public function fetchAll() {
        $this->execute();
        return $this->stmt->fetchAll();
    }
    
    // Lấy một bản ghi
    public function fetch() {
        $this->execute();
        return $this->stmt->fetch();
    }
    
    // Lấy số bản ghi
    public function rowCount() {
        return $this->stmt->rowCount();
    }
    
    // Lấy last insert id
    public function lastInsertId() {
        return $this->conn->lastInsertId();
    }
    
    // Bắt đầu transaction
    public function beginTransaction() {
        return $this->conn->beginTransaction();
    }
    
    // Commit transaction
    public function commit() {
        return $this->conn->commit();
    }
    
    // Rollback transaction
    public function rollback() {
        return $this->conn->rollBack();
    }
}