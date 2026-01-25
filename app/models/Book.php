<?php

class Book
{
    private $db;

    public function __construct()
    {
        $this->db = Database::getInstance()->getConnection();
    }

    // ================= USER SIDE =================

    public function getAllBooks()
    {
        $sql = "SELECT book_id, title, author, publisher, publish_year, description, url FROM Books";
        return $this->db->query($sql)->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getBookDetail($bookId)
    {
        $sql = "SELECT b.*, c.name AS category_name
                FROM Books b
                LEFT JOIN Categories c ON b.category_id = c.category_id
                WHERE b.book_id = :id";
        $stmt = $this->db->prepare($sql);
        $stmt->execute(['id' => $bookId]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function getById($id)
    {
        $stmt = $this->db->prepare("SELECT * FROM Books WHERE book_id = :id");
        $stmt->execute(['id' => $id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function getBookItemsStatus($bookId)
    {
        $stmt = $this->db->prepare("SELECT status, COUNT(*) as total 
                                   FROM Book_Items 
                                   WHERE book_id = :id 
                                   GROUP BY status");
        $stmt->execute(['id' => $bookId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // ================= ADMIN SIDE =================

    public function getAllAdminBooks()
    {
        $sql = "SELECT b.*, c.name AS category_name
                FROM Books b
                LEFT JOIN Categories c ON b.category_id = c.category_id
                ORDER BY b.book_id DESC";
        return $this->db->query($sql)->fetchAll(PDO::FETCH_ASSOC);
    }

    public function isIsbnExists($isbn)
    {
        $stmt = $this->db->prepare("SELECT COUNT(*) FROM Books WHERE isbn = :isbn");
        $stmt->execute(['isbn' => $isbn]);
        return $stmt->fetchColumn() > 0;
    }

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

    public function updateBook($id, $data)
    {
        $sql = "UPDATE Books SET
                title=:title, author=:author, isbn=:isbn, category_id=:category_id,
                publisher=:publisher, publish_year=:publish_year,
                description=:description, url=:url
                WHERE book_id=:id";

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

    // Nếu có lịch sử mượn → không cho delete
    public function hasBorrowHistory($bookId)
    {
        $stmt = $this->db->prepare("SELECT COUNT(*) FROM Book_Items WHERE book_id = :id");
        $stmt->execute(['id' => $bookId]);
        return $stmt->fetchColumn() > 0;
    }

    public function deleteBook($id)
    {
        $stmt = $this->db->prepare("DELETE FROM Books WHERE book_id = :id");
        return $stmt->execute(['id' => $id]);
    }
}
