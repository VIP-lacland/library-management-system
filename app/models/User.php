<?php
class User {
    private $db;

    public function __construct() {
        
        $this->db = Database::getInstance()->getConnection();
    }

    public function getUserByEmail($email) {
        $sql = "SELECT * FROM Users WHERE email = :email";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':email', $email);
        $stmt->execute();
        
        // Trả về dữ liệu kiểu Object
        return $stmt->fetch(PDO::FETCH_OBJ);
    }
}