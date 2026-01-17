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
            'password' => password_hash($password, PASSWORD_DEFAULT),
            'email'    => $email,
            'phone'    => $phone,
            'address'  => $address
        ]);
    }

    public function getUserByEmail(string $email): ?object
    {
        $stmt = $this->db->prepare(
            "SELECT * FROM Users WHERE email = :email LIMIT 1"
        );
        $stmt->execute(['email' => $email]);
        return $stmt->fetch(PDO::FETCH_OBJ) ?: null;
    }

    public function updatePassword(int $userId, string $hashedPassword): bool
    {
        $stmt = $this->db->prepare(
            "UPDATE Users SET password = :password WHERE user_id = :user_id"
        );

        return $stmt->execute([
            'password' => $hashedPassword,
            'user_id'  => $userId
        ]);
    }

    /* =========================
       PASSWORD RESET
    ========================== */

    public function createPasswordReset(
        int $userId,
        string $email,
        string $token,
        string $expiresAt
    ): bool {
        $sql = "INSERT INTO PasswordResets
                (user_id, email, reset_token, expires_at)
                VALUES
                (:user_id, :email, :token, :expires_at)";

        $stmt = $this->db->prepare($sql);

        return $stmt->execute([
            'user_id'    => $userId,
            'email'      => $email,
            'token'      => $token,
            'expires_at' => $expiresAt
        ]);
    }

    public function getPasswordResetByToken(string $token): ?object
    {
        $sql = "SELECT * FROM PasswordResets
                WHERE reset_token = :token
                  AND is_used = 0
                  AND expires_at > NOW()
                LIMIT 1";

        $stmt = $this->db->prepare($sql);
        $stmt->execute(['token' => $token]);

        return $stmt->fetch(PDO::FETCH_OBJ) ?: null;
    }

    public function markResetTokenUsed(int $resetId): bool
    {
        $stmt = $this->db->prepare(
            "UPDATE PasswordResets SET is_used = 1 WHERE reset_id = :id"
        );
        return $stmt->execute(['id' => $resetId]);
    }

    public function deleteExpiredResets(): bool
    {
        return $this->db
            ->prepare("DELETE FROM PasswordResets WHERE expires_at < NOW()")
            ->execute();
    }
}
