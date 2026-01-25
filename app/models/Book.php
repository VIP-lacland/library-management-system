﻿<?php

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

    // Lấy sách theo phân trang
    public function getBooksPaginated($limit, $offset)
    {
        $sql = "SELECT book_id, title, author, publisher, publish_year, description, url 
                FROM Books 
                ORDER BY book_id DESC
                LIMIT :limit OFFSET :offset";
        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(':limit', (int)$limit, PDO::PARAM_INT);
        $stmt->bindValue(':offset', (int)$offset, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    // Đếm tổng số sách
    public function countTotalBooks()
    {
        $stmt = $this->db->query("SELECT COUNT(*) as total FROM Books");
        $row = $stmt->fetch();
        return $row ? $row['total'] : 0;
    }

    // Tìm kiếm sách
    public function searchBooks($keyword)
    {
        $keyword = "%$keyword%";
        $sql = "SELECT book_id, title, author, publisher, publish_year, description, url 
                FROM Books 
                WHERE title LIKE :keyword OR author LIKE :keyword OR publisher LIKE :keyword";
        $stmt = $this->db->prepare($sql);
        $stmt->execute(['keyword' => $keyword]);
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
