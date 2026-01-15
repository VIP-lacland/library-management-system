<?php
class BookController extends Controller
{
  public function index() {
    $booklist = $this->model('Book');
    $books = $booklist->getAll();
    
    $this->view('home', ['books' => $books]);
  }


}
?>