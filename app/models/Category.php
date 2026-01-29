<?php

class Category {
    private $db;

    public function __construct() {
        $this->db = Database::getInstance()->getConnection();
    }

    function getAllCategory() {
        $sql = "SELECT * FROM Categories";
        $stmt = $this->db->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    function addCategory($name) {
        $sql = "INSERT INTO Categories (name) VALUES (:name)";
        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(':name', $name, PDO::PARAM_STR);
        return $stmt->execute();
    }


    function deleteCategory($category_id) {
        // First, check if any books are associated with this category
        $checkSql = "SELECT COUNT(*) as book_count FROM Books WHERE category_id = :category_id";
        $checkStmt = $this->db->prepare($checkSql);
        $checkStmt->bindValue(':category_id', $category_id, PDO::PARAM_INT);
        $checkStmt->execute();
        $result = $checkStmt->fetch(PDO::FETCH_ASSOC);

        // If books are found, prevent deletion
        if ($result && $result['book_count'] > 0) {
            return false;
        }

        // If no books are associated, proceed with deletion
        $sql = "DELETE FROM Categories WHERE category_id = :category_id";
        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(':category_id', $category_id, PDO::PARAM_INT);
        return $stmt->execute();
    }


    function getCategoryById($category_id) {
        $sql = "SELECT * FROM Categories WHERE category_id = :category_id";
        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(':category_id', $category_id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    function updateCategory($category_id, $name) {
        $sql = "UPDATE Categories SET name = :name WHERE category_id = :category_id";
        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(':name', $name, PDO::PARAM_STR);
        $stmt->bindValue(':category_id', $category_id, PDO::PARAM_INT);
        return $stmt->execute();
    }
}

?>