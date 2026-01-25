<

<div class="container mt-4">
    <h2>📚 Book Management</h2>

    <?php if (!empty($_SESSION['success'])): ?>
        <div class="alert alert-success"><?= $_SESSION['success']; unset($_SESSION['success']); ?></div>
    <?php endif; ?>

    <?php if (!empty($_SESSION['error'])): ?>
        <div class="alert alert-danger"><?= $_SESSION['error']; unset($_SESSION['error']); ?></div>
    <?php endif; ?>

    <a href="index.php?action=admin-book-create" class="btn btn-success mb-3">+ Add Book</a>

    <table class="table table-bordered table-hover">
        <thead class="table-dark">
        <tr>
            <th>Cover</th>
            <th>Title</th>
            <th>Author</th>
            <th>Category</th>
            <th width="150">Actions</th>
        </tr>
        </thead>
        <tbody>
        <?php foreach ($books as $book): ?>
            <tr>
                <td>
                    <img src="<?= $book['url'] ?: '/library-management-system/public/images/no-image.png' ?>" width="50">
                </td>
                <td><?= htmlspecialchars($book['title']) ?></td>
                <td><?= htmlspecialchars($book['author']) ?></td>
                <td><?= htmlspecialchars($book['category_name']) ?></td>
                <td>
                    <a href="index.php?action=admin-book-edit&id=<?= $book['book_id'] ?>" class="btn btn-warning btn-sm">Edit</a>
                    <a href="index.php?action=admin-book-delete&id=<?= $book['book_id'] ?>" 
                       onclick="return confirm('Delete this book?')" 
                       class="btn btn-danger btn-sm">Delete</a>
                </td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
</div>
