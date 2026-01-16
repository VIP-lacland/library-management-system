<?php
class BookController extends Controller
{
  public function index() {
    $booklist = $this->model('Book');
    $books = $booklist->getAllBooks();
    
    $this->view('index', ['books' => $books]);
  }


}
?>