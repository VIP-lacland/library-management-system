<?php

class AdminBookController extends Controller
{
    // Hàm hiển thị danh sách sách (Nhớ đổi tên file view thành list.php)
    public function index()
    {
        $bookModel = $this->model('Book'); // Nhóm trưởng dùng $this->model('Tên')
        $books = $bookModel->getAllAdminBooks(); // Giả định hàm này trong Model của bạn

        $this->view('admin/book/list', ['books' => $books]);
    }

    // Hàm hiển thị form thêm sách
    public function create()
    {
        $categoryModel = $this->model('Category');
        $categories = $categoryModel->getAllCategories();

        $this->view('admin/book/create', ['categories' => $categories]);
    }

    // Hàm lưu sách mới
    public function store()
    {
        if (!$this->isPost()) {
            $this->redirect(url('admin.php?action=admin-book-create'));
            return;
        }

        $bookModel = $this->model('Book');
        
        // Lấy dữ liệu bằng $this->input() như nhóm trưởng
        $data = [
            'title' => $this->input('title'),
            'author' => $this->input('author'),
            'isbn' => $this->input('isbn'),
            'category_id' => $this->input('category_id'),
            'description' => $this->input('description'),
            'publisher' => $this->input('publisher'),
            'publish_year' => $this->input('publish_year')
        ];

        // Xử lý upload ảnh (nếu có)
        // ... (Logic upload của bạn)

        if ($bookModel->createBook($data)) {
            $this->setFlash('success', 'Book added successfully!');
            $this->redirect(url('admin.php?action=admin-books'));
        } else {
            $this->setFlash('error', 'Failed to add book.');
            $this->redirect(url('admin.php?action=admin-book-create'));
        }
    }

    // Hàm hiển thị form sửa
    public function edit()
    {
        $id = $this->input('id');
        $bookModel = $this->model('Book');
        $categoryModel = $this->model('Category');

        $book = $bookModel->getBookById($id);
        $categories = $categoryModel->getAllCategories();

        $this->view('admin/book/edit', [
            'book' => $book,
            'categories' => $categories
        ]);
    }

    // ===============================
    // UPDATE BOOK
    // ===============================
    public function update()
    {
        // Kiểm tra xem có phải dữ liệu gửi từ POST không
        if (!$this->isPost()) {
            $this->redirect(url('admin.php?action=admin-books'));
            return;
        }

        $bookModel = $this->model('Book');
        
        // Lấy ID và dữ liệu từ form
        $id = intval($this->input('id') ?? 0);
        $old_url = $this->input('old_url'); // URL ảnh cũ từ thẻ hidden

        $data = [
            'title'        => trim($this->input('title') ?? ''),
            'author'       => trim($this->input('author') ?? ''),
            'isbn'         => trim($this->input('isbn') ?? ''),
            'publisher'    => trim($this->input('publisher') ?? ''),
            'publish_year' => intval($this->input('publish_year') ?? 0),
            'category_id'  => intval($this->input('category_id') ?? 0),
            'description'  => trim($this->input('description') ?? ''),
            'url'          => $old_url // Mặc định dùng lại ảnh cũ
        ];

        // 1. Kiểm tra tiêu đề không được để trống
        if (empty($data['title'])) {
            $this->setFlash('error', "Book title is required!");
            $this->redirect(url("admin.php?action=admin-book-edit&id=$id"));
            exit;
        }

        // 2. Kiểm tra ISBN không được trùng (trừ chính nó)
        if ($bookModel->isIsbnExists($data['isbn'], $id)) {
            $this->setFlash('error', "ISBN already exists!");
            $this->redirect(url("admin.php?action=admin-book-edit&id=$id"));
            exit;
        }

        // 3. Xử lý Upload ảnh mới (nếu có)
        // Lưu ý: Nếu sếp yêu cầu upload file thật, bạn cần code upload ở đây. 
        // Nếu sếp chỉ yêu cầu dùng URL, bạn có thể bỏ qua phần file này.
        if (isset($_FILES['image']) && $_FILES['image']['error'] == 0) {
            // Đây là nơi xử lý upload file và gán lại $data['url']
            // Ví dụ: $data['url'] = $this->handleUpload($_FILES['image']);
        }

        // 4. Gọi Model để cập nhật
        if ($bookModel->updateBook($id, $data)) {
            $this->setFlash('success', "Book updated successfully!");
        } else {
            $this->setFlash('error', "Something went wrong. Could not update book.");
        }

        $this->redirect(url('admin.php?action=admin-books'));
        exit;
    }

    // Hàm xóa (Archive)
    public function delete()
    {
        $id = $this->input('id');
        $bookModel = $this->model('Book');

        if ($bookModel->deleteBook($id)) {
            $this->setFlash('success', 'Book archived successfully!');
        } else {
            $this->setFlash('error', 'Failed to delete book.');
        }
        
        $this->redirect(url('admin.php?action=admin-books'));
    }
}