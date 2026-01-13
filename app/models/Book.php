<?php
class Book extends Database {
  private $db;
  
  public function __construct() {
    // Lấy kết nối database
    $this->db = Database::getInstance()->getConnection();
  }
  
  public function getAll() {
    $stmt = $this->db->query("SELECT * FROM books");
    return $stmt->fetchAll();
  }
  
  public function getById($id) {
    $stmt = $this->db->prepare("SELECT * FROM books WHERE book_id = :id");
    $stmt->execute(['id' => $id]);
    return $stmt->fetch();
  }
}