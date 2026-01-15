<?php

class BookController extends Controller
{
    private $bookModel;

    public function __construct()
    {
        $this->bookModel = $this->model('Book');
    }

    // Hiển thị trang chủ - danh sách tất cả sách
    public function index()
    {
        $books = $this->bookModel->getAllBooks();
        $this->view('index', ['books' => $books]);
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
?>
