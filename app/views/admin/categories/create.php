<div class="container mt-4">
    <h2>Add New Category</h2>

    <?php if (isset($_SESSION['error'])): ?>
        <div class="alert alert-danger">
            <?= $_SESSION['error']; unset($_SESSION['error']); ?>
        </div>
    <?php endif; ?>

    <form action="admin.php?action=category-store" method="POST">
        <div class="mb-3">
            <label class="form-label">Category Name *</label>
            <input type="text" name="name" class="form-control" placeholder="Enter category name" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Description</label>
            <textarea name="description" class="form-control" rows="3" placeholder="Enter description (optional)"></textarea>
        </div>

        <button type="submit" class="btn btn-primary">Save</button>
        <a href="admin.php?action=categories" class="btn btn-secondary">Cancel</a>
    </form>
</div>