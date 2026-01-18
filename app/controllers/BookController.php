<?php

class BookController extends Controller
{
    private $bookModel;

    public function __construct()
    {
        $this->bookModel = $this->model('Book');
    }

    public function index()
    {
        $booklist = $this->model('Book');
        $books = $booklist->getAllBooks();
    
        $this->view('index', ['books' => $books]);
    }

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
