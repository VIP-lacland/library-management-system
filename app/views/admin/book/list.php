<div class="page-header" style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
    <h2 class="page-title">📚 Book Management</h2>
    <a href="admin.php?action=admin-book-create" class="btn btn-primary">+ Add New Book</a>
</div>

<?php if (!empty($_SESSION['success'])): ?>
    <div class="alert alert-success"><?= $_SESSION['success']; unset($_SESSION['success']); ?></div>
<?php endif; ?>

<?php if (!empty($_SESSION['error'])): ?>
    <div class="alert alert-error"><?= $_SESSION['error']; unset($_SESSION['error']); ?></div>
<?php endif; ?>

<div class="card">
    <table class="table">
        <thead>
            <tr>
                <th>Cover</th>
                <th>Title & Author</th>
                <th>ISBN</th>
                <th>Category</th>
                <th style="text-align: center;">Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php if (!empty($books)): ?>
                <?php foreach ($books as $book): ?>
                    <tr>
                        <td>
                            <img src="<?= $book['url'] ?: '/library-management-system/public/images/no-book.png' ?>" 
                                 style="width: 45px; height: 60px; object-fit: cover; border-radius: 4px; border: 1px solid #e2e8f0;">
                        </td>
                        <td>
                            <div style="font-weight: 600; color: #1e293b;"><?= htmlspecialchars($book['title']) ?></div>
                            <div style="font-size: 12px; color: #64748b;"><?= htmlspecialchars($book['author']) ?></div>
                        </td>
                        <td><code style="background: #f1f5f9; padding: 2px 5px; border-radius: 4px;"><?= htmlspecialchars($book['isbn']) ?></code></td>
                        <td>
                            <span style="background: #e0f2fe; color: #0369a1; padding: 3px 8px; border-radius: 12px; font-size: 12px;">
                                <?= htmlspecialchars($book['category_name'] ?? 'Uncategorized') ?>
                            </span>
                        </td>
                        <td style="text-align: center;">
                            <div style="display: flex; gap: 8px; justify-content: center;">
                                <a href="admin.php?action=admin-book-edit&id=<?= $book['book_id'] ?>" class="btn btn-warning">Edit</a>
                                
                                <a href="admin.php?action=admin-book-delete&id=<?= $book['book_id'] ?>" 
                                   class="btn btn-danger" 
                                   onclick="return confirm('Archive this book?')">Delete</a>
                            </div>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr>
                    <td colspan="5" style="text-align: center; color: #64748b; padding: 30px;">No books found in database.</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>