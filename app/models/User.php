<?php

use LDAP\ResultEntry;

class User extends Database
{
    private $db;

    private $username;
    private $password;
    private $email;
    private $phone;
    private $address;

    public function __construct()
    {
        $this->db = Database::getInstance()->getConnection();
    }

    public function emailExists($email)
    {
        try {
            $stmt = $this->db->prepare("SELECT user_id FROM Users WHERE email = :email LIMIT 1");
            $stmt->execute([':email' => $email]);
            return $stmt->rowCount() > 0;
        } catch (PDOException $e) {
            error_log("Error checking email exists: " . $e->getMessage());
            return false;
        }
    }


    public function create($username, $password, $email, $phone = null, $address = null)
    {
        try {

            $sql = "INSERT INTO Users (name, password, email, phone, address, role, status) 
                    VALUES (:name, :password, :email, :phone, :address, 'reader', 'active')";

            $stmt = $this->db->prepare($sql);

            // Mã hóa mật khẩu
            $hashed_password = password_hash($password, PASSWORD_DEFAULT);

            return $stmt->execute([
                ':name' => $username,
                ':password' => $hashed_password,
                ':email' => $email,
                ':phone' => $phone,
                ':address' => $address
            ]);
        } catch (PDOException $e) {
            error_log("Error creating user: " . $e->getMessage());
            return false;
        }
    }

    // select user by user_id
    public function getUserByEmail($email)
    {
        try {
            $stmt = $this->db->prepare("SELECT * FROM Users WHERE email = :email LIMIT 1");
            $stmt->execute([':email' => $email]);
            return $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log("Error getting user by email: " . $e->getMessage());
            return null;
        }
    }
}
