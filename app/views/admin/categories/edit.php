<div class="container mt-4">
    <h2>Edit Category</h2>

    <?php if (isset($_SESSION['error'])): ?>
        <div class="alert alert-danger">
            <?= $_SESSION['error']; unset($_SESSION['error']); ?>
        </div>
    <?php endif; ?>

    <form action="admin.php?action=category-update" method="POST">
        
        <input type="hidden" name="id" value="<?= $category['category_id'] ?>">

        <div class="mb-3">
            <label class="form-label">Category Name *</label>
            <input type="text" name="name" class="form-control"
                   value="<?= htmlspecialchars($category['name']) ?>" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Description</label>
            <textarea name="description" class="form-control" rows="3"><?= htmlspecialchars($category['description']) ?></textarea>
        </div>

        <button type="submit" class="btn btn-success">Update</button>
        <a href="admin.php?action=categories" class="btn btn-secondary">Cancel</a>
    </form>
</div>