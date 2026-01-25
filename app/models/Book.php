<?php

class Book
{
    private $db;

    public function __construct()
    {
        // Kết nối Database theo Pattern 
        $this->db = Database::getInstance()->getConnection();
    }

    // ================================================= coding 
    // ADMIN SIDE LOGIC
    // =================================================

    /**
     * Lấy toàn bộ sách kèm tên danh mục cho trang quản trị
     */
    public function getAllAdminBooks()
    {
        $sql = "SELECT b.*, c.name AS category_name
                FROM Books b
                LEFT JOIN Categories c ON b.category_id = c.category_id
                ORDER BY b.book_id DESC";
        return $this->db->query($sql)->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Lấy chi tiết một cuốn sách theo ID
     */
    public function getById($id)
    {
        $sql = "SELECT * FROM Books WHERE book_id = :id";
        $stmt = $this->db->prepare($sql);
        $stmt->execute(['id' => $id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    /**
     * Thêm sách mới
     */
    public function createBook($data)
    {
        $sql = "INSERT INTO Books(title, author, isbn, category_id, publisher, publish_year, description, url)
                VALUES(:title, :author, :isbn, :category_id, :publisher, :publish_year, :description, :url)";
        
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([
            'title'        => $data['title'],
            'author'       => $data['author'],
            'isbn'         => $data['isbn'],
            'category_id'  => $data['category_id'],
            'publisher'    => $data['publisher'],
            'publish_year' => $data['publish_year'],
            'description'  => $data['description'],
            'url'          => $data['url']
        ]);
    }

    /**
     * Cập nhật thông tin sách
     */
    public function updateBook($id, $data)
    {
        $sql = "UPDATE Books SET
                title = :title, 
                author = :author, 
                isbn = :isbn, 
                category_id = :category_id,
                publisher = :publisher, 
                publish_year = :publish_year,
                description = :description, 
                url = :url
                WHERE book_id = :id";

        $stmt = $this->db->prepare($sql);
        return $stmt->execute([
            'id'           => $id,
            'title'        => $data['title'],
            'author'       => $data['author'],
            'isbn'         => $data['isbn'],
            'category_id'  => $data['category_id'],
            'publisher'    => $data['publisher'],
            'publish_year' => $data['publish_year'],
            'description'  => $data['description'],
            'url'          => $data['url']
        ]);
    }

    /**
     * Kiểm tra ISBN đã tồn tại chưa (trừ cuốn đang sửa)
     */
    public function isIsbnExists($isbn, $excludeId = null)
    {
        $sql = "SELECT COUNT(*) FROM Books WHERE isbn = :isbn";
        $params = ['isbn' => $isbn];

        if ($excludeId) {
            $sql .= " AND book_id != :id";
            $params['id'] = $excludeId;
        }

        $stmt = $this->db->prepare($sql);
        $stmt->execute($params);
        return $stmt->fetchColumn() > 0;
    }

    /**
     * Xóa sách (Chỉ xóa nếu không có dữ liệu liên quan ở bảng khác)
     */
    public function deleteBook($id)
    {
        // Kiểm tra xem sách có đang được mượn không trước khi xóa
        if ($this->hasBorrowHistory($id)) {
            return false;
        }

        $stmt = $this->db->prepare("DELETE FROM Books WHERE book_id = :id");
        return $stmt->execute(['id' => $id]);
    }

    /**
     * Kiểm tra lịch sử mượn/bản ghi con
     */
    public function hasBorrowHistory($bookId)
    {
        $stmt = $this->db->prepare("SELECT COUNT(*) FROM Book_Items WHERE book_id = :id");
        $stmt->execute(['id' => $bookId]);
        return $stmt->fetchColumn() > 0;
    }
}