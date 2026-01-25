<?php



class AdminBookController
{
    private $bookModel;
    private $categoryModel;

    public function __construct()
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        $this->bookModel     = new Book();
        $this->categoryModel = new Category();
    }

    // ==============================
    // LIST BOOKS
    // ==============================
    public function index()
{
    $books = $this->bookModel->getAllAdminBooks();
    $viewFile = APP_ROOT . '/views/admin/book/index.php';
    
    
    echo "Đường dẫn thực tế là: " . $viewFile;
    if (!file_exists($viewFile)) { echo " -> FILE KHÔNG TỒN TẠI TẠI ĐÂY!"; }
    
    require APP_ROOT . '/views/layouts/admin-layout.php'; 
}

    // ==============================
    // SHOW CREATE FORM
    // ==============================
    public function create()
{
    $categories = $this->categoryModel->getAllCategories();
    
    $viewFile = APP_ROOT . '/views/admin/book/create.php';
    require APP_ROOT . '/views/layouts/admin-layout.php';
}

    // ==============================
    // STORE NEW BOOK
    // ==============================
    public function store()
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header("Location: index.php?action=admin-books");
            exit;
        }

        $data = [
            'title'        => trim($_POST['title'] ?? ''),
            'author'       => trim($_POST['author'] ?? ''),
            'isbn'         => trim($_POST['isbn'] ?? ''),
            'category_id'  => $_POST['category_id'] ?? null,
            'publisher'    => trim($_POST['publisher'] ?? ''),
            'publish_year' => $_POST['publish_year'] ?? null,
            'description'  => trim($_POST['description'] ?? ''),
            'url'          => null
        ];

        // Validate
        if (!$data['title'] || !$data['author'] || !$data['isbn']) {
            $_SESSION['error'] = "Title, Author, ISBN are required!";
            header("Location: index.php?action=admin-book-create");
            exit;
        }

        // Check ISBN duplicate
        if ($this->bookModel->isIsbnExists($data['isbn'])) {
            $_SESSION['error'] = "ISBN already exists!";
            header("Location: index.php?action=admin-book-create");
            exit;
        }

        // Upload image nếu có
        $imagePath = $this->uploadImage();
        if ($imagePath) {
            $data['url'] = $imagePath;
        }

        $this->bookModel->createBook($data);

        $_SESSION['success'] = "Book added successfully!";
        header("Location: index.php?action=admin-books");
        exit;
    }

    // ==============================
    // SHOW EDIT FORM
    // ==============================
    public function edit()
{
    $id = $_GET['id'] ?? 0;
    $book = $this->bookModel->getById($id);
    $categories = $this->categoryModel->getAllCategories();

    if (!$book) {
        die("Book not found!");
    }

    $viewFile = APP_ROOT . '/views/admin/book/edit.php';
    require APP_ROOT . '/views/layouts/admin-layout.php';
}

    // ==============================
    // UPDATE BOOK
    // ==============================
    public function update()
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header("Location: index.php?action=admin-books");
            exit;
        }

        $id = $_POST['id'];

        $data = [
            'title'        => $_POST['title'],
            'author'       => $_POST['author'],
            'isbn'         => $_POST['isbn'],
            'category_id'  => $_POST['category_id'],
            'publisher'    => $_POST['publisher'],
            'publish_year' => $_POST['publish_year'],
            'description'  => $_POST['description'],
            'url'          => $_POST['old_url']
        ];

        // Nếu có ảnh mới thì upload
        $imagePath = $this->uploadImage();
        if ($imagePath) {
            $data['url'] = $imagePath;
        }

        $this->bookModel->updateBook($id, $data);

        $_SESSION['success'] = "Book updated successfully!";
        header("Location: index.php?action=admin-books");
        exit;
    }

    // ==============================
    // DELETE BOOK
    // ==============================
    public function delete()
    {
        $id = $_GET['id'];

        if ($this->bookModel->hasBorrowHistory($id)) {
            $_SESSION['error'] = "Cannot delete — book has borrowing history!";
        } else {
            $this->bookModel->deleteBook($id);
            $_SESSION['success'] = "Book deleted!";
        }

        header("Location: index.php?action=admin-books");
        exit;
    }

    // ==============================
    // IMAGE UPLOAD
    // ==============================
    private function uploadImage()
    {
        if (!isset($_FILES['image']) || $_FILES['image']['error'] !== 0) {
            return null;
        }

        $targetDir = APP_ROOT . "/public/images/";
        if (!file_exists($targetDir)) {
            mkdir($targetDir, 0777, true);
        }

        $fileName = time() . "_" . basename($_FILES["image"]["name"]);
        $targetFile = $targetDir . $fileName;

        move_uploaded_file($_FILES["image"]["tmp_name"], $targetFile);

        return "/library-management-system/public/images/" . $fileName;
    }
}
