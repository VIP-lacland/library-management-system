<?php

class Category
{
    private $db;

    public function __construct()
    {
        // Kết nối qua Database singleton theo chuẩn dự án của bạn
        $this->db = Database::getInstance()->getConnection();
    }

    // ==========================================
    // TRANG ADMIN & USER
    // ==========================================

    /**
     * Lấy tất cả danh mục và đếm số lượng sách thuộc danh mục đó
     */
    public function getAllCategories()
    {
        $sql = "
            SELECT 
                c.category_id,
                c.name,
                c.description,
                COUNT(b.book_id) AS total_books
            FROM Categories c
            LEFT JOIN Books b ON c.category_id = b.category_id
            GROUP BY c.category_id, c.name, c.description
            ORDER BY c.name ASC
        ";

        $stmt = $this->db->prepare($sql);
        $stmt->execute();
        // Trả về FETCH_ASSOC để thống nhất format dữ liệu
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Lấy thông tin 1 danh mục theo ID
     */
    public function getById($id)
    {
        $stmt = $this->db->prepare("SELECT * FROM Categories WHERE category_id = :id");
        $stmt->execute(['id' => $id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    /**
     * Kiểm tra tên danh mục đã tồn tại chưa (Dùng cho cả Create và Update)
     */
    public function isNameExists($name, $excludeId = null)
    {
        if ($excludeId) {
            $sql = "SELECT COUNT(*) FROM Categories WHERE name = :name AND category_id != :id";
            $stmt = $this->db->prepare($sql);
            $stmt->execute(['name' => $name, 'id' => $excludeId]);
        } else {
            $sql = "SELECT COUNT(*) FROM Categories WHERE name = :name";
            $stmt = $this->db->prepare($sql);
            $stmt->execute(['name' => $name]);
        }

        return $stmt->fetchColumn() > 0;
    }

    /**
     * Thêm mới danh mục
     */
    public function create($name, $description)
    {
        $sql = "INSERT INTO Categories (name, description) VALUES (:name, :description)";
        $stmt = $this->db->prepare($sql);

        return $stmt->execute([
            'name' => $name,
            'description' => $description
        ]);
    }

    /**
     * Cập nhật danh mục
     */
    public function update($id, $name, $description)
    {
        $sql = "
            UPDATE Categories 
            SET name = :name,
                description = :description
            WHERE category_id = :id
        ";

        $stmt = $this->db->prepare($sql);

        return $stmt->execute([
            'id' => $id,
            'name' => $name,
            'description' => $description
        ]);
    }

    /**
     * Kiểm tra xem danh mục có đang chứa sách nào không
     */
    public function hasBooks($categoryId)
    {
        $stmt = $this->db->prepare("SELECT COUNT(*) FROM Books WHERE category_id = :id");
        $stmt->execute(['id' => $categoryId]);
        return $stmt->fetchColumn() > 0;
    }

    /**
     * Xóa danh mục
     */
    public function delete($id)
    {
        // Chú ý: Luôn kiểm tra hasBooks ở Controller trước khi gọi hàm này
        $stmt = $this->db->prepare("DELETE FROM Categories WHERE category_id = :id");
        return $stmt->execute(['id' => $id]);
    }
}