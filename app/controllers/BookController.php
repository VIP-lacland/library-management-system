<?php

class BookController extends Controller
{
    private $bookModel;

    public function __construct()
    {
        $this->bookModel = $this->model('Book');
    }

    // Hiển thị trang chi tiết sách
    public function detail($id = null)
    {
        if ($id === null) {
            die('Book ID is required');
        }

        $book = $this->bookModel->getBookDetail($id);

        if (!$book) {
            die('Book not found');
        }

        $statuses = $this->bookModel->getBookItemsStatus($id);

        $this->view('books/detail', [
            'book' => $book,
            'statuses' => $statuses
        ]);
    }


}
