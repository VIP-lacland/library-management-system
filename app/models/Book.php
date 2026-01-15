<?php

use LDAP\Result;

class Book extends Database {
  private $db;
  
  private $title;
  private $publisher;
  private $publish_year;
  private $author;
  private $description;
  private $image;
  
  public function __construct() {
    // Lấy kết nối database
    $this->db = Database::getInstance()->getConnection();
  }

  public function getAll() {
    $result = $this->db->query("SELECT * FROM Books");

    $books = [];
      while ($row = $result->fetch()) {
        $books[] = $row;
      }
    
    return $books;
  }

  public function getById($id) {
    $stmt = $this->db->prepare("SELECT * FROM books WHERE book_id = :id");
    $stmt->execute(['id' => $id]);
    return $stmt->fetch();
  }
}

