<?php
class BookController {
    public function detail($id) {
        $book = Book::getBookById($id);
        require_once '../app/views/book/detail.php';
    }
}
