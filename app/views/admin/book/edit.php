<div class="container mt-4">
    <h2>Edit Book</h2>

    <?php if (!empty($_SESSION['error'])): ?>
        <div class="alert alert-danger">
            <?= $_SESSION['error']; unset($_SESSION['error']); ?>
        </div>
    <?php endif; ?>

    <form action="index.php?action=admin-book-update" method="POST" enctype="multipart/form-data">

        <input type="hidden" name="id" value="<?= $book['book_id'] ?>">
        <input type="hidden" name="old_url" value="<?= $book['url'] ?>">

        <div class="mb-3">
            <label class="form-label">Title</label>
            <input type="text" name="title" class="form-control" value="<?= $book['title'] ?>" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Author</label>
            <input type="text" name="author" class="form-control" value="<?= $book['author'] ?>" required>
        </div>

        <div class="mb-3">
            <label class="form-label">ISBN</label>
            <input type="text" name="isbn" class="form-control" value="<?= $book['isbn'] ?>" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Publisher</label>
            <input type="text" name="publisher" class="form-control" value="<?= $book['publisher'] ?>">
        </div>

        <div class="mb-3">
            <label class="form-label">Publish Year</label>
            <input type="number" name="publish_year" class="form-control" value="<?= $book['publish_year'] ?>">
        </div>

        <div class="mb-3">
            <label class="form-label">Category</label>
            <select name="category_id" class="form-control">
                <?php foreach ($categories as $category): ?>
                    <option value="<?= $category['category_id'] ?>"
                        <?= $category['category_id'] == $book['category_id'] ? 'selected' : '' ?>>
                        <?= $category['name'] ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>

        <div class="mb-3">
            <label class="form-label">Description</label>
            <textarea name="description" class="form-control" rows="4"><?= $book['description'] ?></textarea>
        </div>

        <div class="mb-3">
            <label class="form-label">Current Cover</label><br>
            <img src="<?= $book['url'] ?>" width="100" class="mb-2">
        </div>

        <div class="mb-3">
            <label class="form-label">Change Cover Image</label>
            <input type="file" name="image" class="form-control">
        </div>

        <button type="submit" class="btn btn-primary">Update Book</button>
        <a href="index.php?action=admin-books" class="btn btn-secondary">Cancel</a>
    </form>
</div>
