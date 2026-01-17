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

    public function createPasswordReset($user_id, $email, $token, $expiresAt) {
        $sql = "INSERT INTO PasswordResets (user_id, email, reset_token, expires_at) 
                VALUES (:user_id, :email, :reset_token, :expires_at)";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':user_id', $user_id);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':reset_token', $token);
        $stmt->bindParam(':expires_at', $expiresAt);
        
        return $stmt->execute();
    }

    public function getPasswordResetByToken($token) {
        $sql = "SELECT * FROM PasswordResets 
                WHERE reset_token = :token 
                AND is_used = FALSE 
                AND expires_at > NOW()";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':token', $token);
        $stmt->execute();
        
        return $stmt->fetch(PDO::FETCH_OBJ);
    }

    public function updatePassword($user_id, $hashedPassword) {
        $sql = "UPDATE Users SET password = :password WHERE user_id = :user_id";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':password', $hashedPassword);
        $stmt->bindParam(':user_id', $user_id);
        
        return $stmt->execute();
    }

    public function markResetTokenUsed($reset_id) {
        $sql = "UPDATE PasswordResets SET is_used = TRUE WHERE reset_id = :reset_id";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':reset_id', $reset_id);
        
        return $stmt->execute();
    }

    public function deleteExpiredResets() {
        $sql = "DELETE FROM PasswordResets WHERE expires_at < NOW()";
        $stmt = $this->db->prepare($sql);
        
        return $stmt->execute();
    }
}