<?php
class Book {
    // Lấy thông tin sách theo ID
    public static function getBookById($id) {
        $db = Database::getConnection();
        $stmt = $db->prepare("SELECT * FROM books WHERE id = :id");
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Lấy danh sách tất cả sách
    public static function getAllBooks() {
        $db = Database::getConnection();
        $stmt = $db->query("SELECT * FROM books");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Thêm sách mới
    public static function addBook($data) {
        $db = Database::getConnection();
        $stmt = $db->prepare("INSERT INTO books (title, author, year, isbn) VALUES (:title, :author, :year, :isbn)");
        $stmt->execute($data);
        return $db->lastInsertId();
    }

    // Cập nhật sách
    public static function updateBook($id, $data) {
        $db = Database::getConnection();
        $stmt = $db->prepare("UPDATE books SET title=:title, author=:author, year=:year, isbn=:isbn WHERE id=:id");
        $data['id'] = $id;
        return $stmt->execute($data);
    }

    // Xóa sách
    public static function deleteBook($id) {
        $db = Database::getConnection();
        $stmt = $db->prepare("DELETE FROM books WHERE id=:id");
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        return $stmt->execute();
    }
}
?>