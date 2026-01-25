<?php require_once __DIR__ . '/../../layouts/header.php'; ?>

<div class="container mt-4">
    <h2>Add New Book</h2>

    <form method="POST" action="index.php?action=admin-book-store">

        <div class="mb-3">
            <label>Title</label>
            <input type="text" name="title" class="form-control" required>
        </div>

        <div class="mb-3">
            <label>Author</label>
            <input type="text" name="author" class="form-control" required>
        </div>

        <div class="mb-3">
            <label>Publisher</label>
            <input type="text" name="publisher" class="form-control">
        </div>

        <div class="mb-3">
            <label>Publish Year</label>
            <input type="number" name="publish_year" class="form-control">
        </div>

        <div class="mb-3">
            <label>Description</label>
            <textarea name="description" class="form-control"></textarea>
        </div>

        <div class="mb-3">
            <label>Image URL</label>
            <input type="text" name="url" class="form-control">
        </div>

        <div class="mb-3">
            <label>Category</label>
            <select name="category_id" class="form-control">
                <?php foreach ($categories as $cat): ?>
                    <option value="<?= $cat['category_id'] ?>">
                        <?= $cat['name'] ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>

        <button type="submit" class="btn btn-success">Save Book</button>
        <a href="index.php?action=admin-books" class="btn btn-secondary">Cancel</a>
    </form>
</div>

<?php require_once __DIR__ . '/../../layouts/footer.php'; ?>
