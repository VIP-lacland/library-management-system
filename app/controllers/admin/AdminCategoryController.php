<?php

class AdminCategoryController extends Controller
{
    private $categoryModel;

    public function __construct()
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        $this->categoryModel = $this->model('Category');
    }

    // ===============================
    // LIST
    // ===============================
    public function index()
    {
        $categories = $this->categoryModel->getAllCategories();
        
        $this->view('admin/categories/index', [
            'categories' => $categories
        ]);
    }

    // ===============================
    // FORM CREATE
    // ===============================
    public function create()
    {
        $this->view('admin/categories/create');
    }

    // ===============================
    // STORE
    // ===============================
    public function store()
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header("Location: index.php?action=categories");
            exit;
        }

        $name = trim($_POST['name'] ?? '');
        $description = trim($_POST['description'] ?? '');

        if (empty($name)) {
            $_SESSION['error'] = "Category name is required!";
            header("Location: index.php?action=category-create");
            exit;
        }

        if ($this->categoryModel->isNameExists($name)) {
            $_SESSION['error'] = "Category name already exists!";
            header("Location: index.php?action=category-create");
            exit;
        }

        $this->categoryModel->create($name, $description);

        $_SESSION['success'] = "Category created successfully!";
        header("Location: index.php?action=categories");
        exit;
    }

    // ===============================
    // FORM EDIT
    // ===============================
    public function edit($id = null)
    {
        if ($id === null) {
            $id = $_GET['id'] ?? 0;
        }

        $category = $this->categoryModel->getById($id);

        if (!$category) {
            die("Category not found!");
        }

        $this->view('admin/categories/edit', [
            'category' => $category
        ]);
    }

    // ===============================
    // UPDATE
    // ===============================
    public function update()
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header("Location: index.php?action=categories");
            exit;
        }

        $id = intval($_POST['id'] ?? 0);
        $name = trim($_POST['name'] ?? '');
        $description = trim($_POST['description'] ?? '');

        if (empty($name)) {
            $_SESSION['error'] = "Category name is required!";
            header("Location: index.php?action=category-edit&id=$id");
            exit;
        }

        // Check trùng tên nhưng bỏ qua chính nó
        if ($this->categoryModel->isNameExists($name, $id)) {
            $_SESSION['error'] = "Category name already exists!";
            header("Location: index.php?action=category-edit&id=$id");
            exit;
        }

        $this->categoryModel->update($id, $name, $description);

        $_SESSION['success'] = "Category updated successfully!";
        header("Location: index.php?action=categories");
        exit;
    }

    // ===============================
    // DELETE
    // ===============================
    public function delete($id = null)
    {
        if ($id === null) {
            $id = intval($_GET['id'] ?? 0);
        }

        if ($this->categoryModel->hasBooks($id)) {
            $_SESSION['error'] = "Cannot delete category that still has books!";
            header("Location: index.php?action=categories");
            exit;
        }

        $this->categoryModel->delete($id);

        $_SESSION['success'] = "Category deleted successfully!";
        header("Location: index.php?action=categories");
        exit;
    }
}