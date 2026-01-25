<?php

class CategoryController extends Controller
{
    // ===============================
    // LIST
    // ===============================
    public function index()
    {
        // Sử dụng $this->model theo format nhóm trưởng
        $categoryModel = $this->model('Category');
        $categories = $categoryModel->getAllCategories();

        // Sử dụng $this->view thay vì require thủ công
        $this->view('admin/categories/list', ['categories' => $categories]);
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
        if (!$this->isPost()) {
            $this->redirect(url('admin.php?action=category-create'));
            return;
        }

        $categoryModel = $this->model('Category');
        
        // Sử dụng $this->input thay vì $_POST
        $name = trim($this->input('name') ?? '');
        $description = trim($this->input('description') ?? '');

        if (empty($name)) {
            $this->setFlash('error', "Category name is required!");
            $this->redirect(url('admin.php?action=category-create'));
            exit;
        }

        if ($categoryModel->isNameExists($name)) {
            $this->setFlash('error', "Category name already exists!");
            $this->redirect(url('admin.php?action=category-create'));
            exit;
        }

        $categoryModel->create($name, $description);

        $this->setFlash('success', "Category created successfully!");
        $this->redirect(url('admin.php?action=categories'));
        exit;
    }

    // ===============================
    // FORM EDIT
    // ===============================
    public function edit()
    {
        // Lấy ID từ input (GET)
        $id = $this->input('id');
        $categoryModel = $this->model('Category');
        $category = $categoryModel->getById($id);

        $this->view('admin/categories/edit', ['category' => $category]);
    }

    // ===============================
    // UPDATE
    // ===============================
    public function update()
    {
        if (!$this->isPost()) {
            $this->redirect(url('admin.php?action=categories'));
            return;
        }

        $categoryModel = $this->model('Category');
        $id = intval($this->input('id') ?? 0);
        $name = trim($this->input('name') ?? '');
        $description = trim($this->input('description') ?? '');

        if (empty($name)) {
            $this->setFlash('error', "Category name is required!");
            $this->redirect(url("admin.php?action=category-edit&id=$id"));
            exit;
        }

        if ($categoryModel->isNameExists($name, $id)) {
            $this->setFlash('error', "Category name already exists!");
            $this->redirect(url("admin.php?action=category-edit&id=$id"));
            exit;
        }

        $categoryModel->update($id, $name, $description);

        $this->setFlash('success', "Category updated successfully!");
        $this->redirect(url('admin.php?action=categories'));
        exit;
    }

    // ===============================
    // DELETE
    // ===============================
    public function delete()
    {
        $id = intval($this->input('id') ?? 0);
        $categoryModel = $this->model('Category');

        if ($categoryModel->hasBooks($id)) {
            $this->setFlash('error', "Cannot delete category that still has books!");
        } else {
            $categoryModel->delete($id);
            $this->setFlash('success', "Category deleted successfully!");
        }

        $this->redirect(url('admin.php?action=categories'));
        exit;
    }
}