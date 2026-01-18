<?php

class Book
{
    private $db;

    public function __construct()
    {
        $this->db = Database::getInstance()->getConnection();
    }

    // Lấy tất cả sách
    public function getAllBooks()
    {
        $sql = "SELECT book_id, title, author, publisher, publish_year, description, url FROM Books";
        $stmt = $this->db->prepare($sql);
        $stmt->execute();

        return $stmt->fetchAll();
    }

    // Lấy thông tin chi tiết sách
    public function getBookDetail($bookId)
    {
        $bookId = (int)$bookId;

        $sql = "
            SELECT 
                b.book_id,
                b.title,
                b.author,
                b.publisher,
                b.publish_year,
                b.description,
                b.url,
                c.name AS category_name
            FROM Books b
            LEFT JOIN Categories c ON b.category_id = c.category_id
            WHERE b.book_id = :id
        ";

        $stmt = $this->db->prepare($sql);
        $stmt->execute(['id' => $bookId]);

        $book = $stmt->fetch();
        return $book ? $book : null;
    }

    // Lấy sách theo ID
    public function getById($id)
    {
        $stmt = $this->db->prepare("SELECT * FROM Books WHERE book_id = :id");
        $stmt->execute(['id' => $id]);
        return $stmt->fetch();
    }

    // Thống kê trạng thái sách
    public function getBookItemsStatus($bookId)
    {
        $bookId = (int)$bookId;

        $sql = "
            SELECT status, COUNT(*) as total
            FROM Book_Items
            WHERE book_id = :id
            GROUP BY status
        ";

        $stmt = $this->db->prepare($sql);
        $stmt->execute(['id' => $bookId]);

        return $stmt->fetchAll();
    }
}
