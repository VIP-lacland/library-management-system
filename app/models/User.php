<?php

class User
{
    private PDO $db;

    public function __construct()
    {
        $this->db = Database::getInstance()->getConnection();
    }

    /* =========================
       USER BASIC
    ========================== */

    public function emailExists(string $email): bool
    {
        $stmt = $this->db->prepare(
            "SELECT user_id FROM Users WHERE email = :email LIMIT 1"
        );
        $stmt->execute(['email' => $email]);
        return $stmt->fetch() !== false;
    }

    public function create(
        string $username,
        string $password,
        string $email,
        ?string $phone = null,
        ?string $address = null
    ): bool {
        $sql = "INSERT INTO Users 
                (name, password, email, phone, address, role, status)
                VALUES 
                (:name, :password, :email, :phone, :address, 'reader', 'active')";

        $stmt = $this->db->prepare($sql);

        return $stmt->execute([
            'name'     => $username,
            'password' => $password,
            'email'    => $email,
            'phone'    => $phone,
            'address'  => $address
        ]);
    }

    public function findByEmail($email) {
        $stmt = $this->db->prepare("SELECT * FROM Users WHERE email = :email");
        $stmt->execute(['email' => $email]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function findById($user_id) {
        $stmt = $this->db->prepare("SELECT * FROM Users WHERE user_id = :user_id");
        $stmt->execute(['user_id' => $user_id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function getUserByEmail(string $email): ?object
    {
        $stmt = $this->db->prepare(
            "SELECT * FROM Users WHERE email = :email LIMIT 1"
        );
        $stmt->execute(['email' => $email]);
        return $stmt->fetch(PDO::FETCH_OBJ) ?: null;
    }

    public function updatePassword(int $userId, string $password): bool
    {
        $stmt = $this->db->prepare(
            "UPDATE Users SET password = :password WHERE user_id = :user_id"
        );

        return $stmt->execute([
            'password' => $password,
            'user_id'  => $userId
        ]);
    }

    /* =========================
       PASSWORD RESET
    ========================== */

    public function createPasswordReset(
        int $userId,
        string $email,
    ): bool {
        $sql = "INSERT INTO PasswordResets
                (user_id, email, reset_token, expires_at)
                VALUES
                (:user_id, :email, :expires_at)";

        $stmt = $this->db->prepare($sql);

        return $stmt->execute([
            'user_id'    => $userId,
            'email'      => $email,
        ]);
    }


//  ADMIN - USER MANAGEMENT
    public function getAllUser() {
        $stmt = $this->db->prepare("SELECT * FROM Users");
        $stmt->execute();
        return $stmt->fetchAll();
    }

    public function updateStatus(int $userId, string $status): bool
    {
        $stmt = $this->db->prepare(
            "UPDATE Users SET status = :status WHERE user_id = :user_id"
        );

        return $stmt->execute([
            'status'  => $status,
            'user_id' => $userId
        ]);
    }


    public function blockUser(int $userId): bool
    {
        return $this->updateStatus($userId, 'block');
    }


    public function unblockUser(int $userId): bool
    {
        return $this->updateStatus($userId, 'active');
    }
    
}







    
