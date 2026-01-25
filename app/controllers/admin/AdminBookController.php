<?php

class AdminBookController extends Controller
{
    public function index()
    {
        $bookModel = $this->model('Book');

        // Lấy tham số tìm kiếm và phân trang từ URL
        $keyword = isset($_GET['keyword']) ? trim($_GET['keyword']) : '';
        $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
        $limit = 10; // Số sách mỗi trang
        $offset = ($page - 1) * $limit;

        if (!empty($keyword)) {
            // Nếu có từ khóa tìm kiếm
            $books = $bookModel->searchBooks($keyword);
            $totalPages = 1; // Tạm thời chưa hỗ trợ phân trang khi tìm kiếm
        } else {
            // Lấy danh sách mặc định có phân trang
            $books = $bookModel->getBooksPaginated($limit, $offset);
            $totalBooks = $bookModel->countTotalBooks();
            $totalPages = ceil($totalBooks / $limit);
        }

        $this->view('admin/books/index', [
            'books' => $books,
            'keyword' => $keyword,
            'currentPage' => $page,
            'totalPages' => $totalPages,
            'title' => 'Book Management'
        ]);
    }
}