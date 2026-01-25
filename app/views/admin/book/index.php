<div class="container-fluid mt-4"> <div class="d-flex justify-content-between align-items-center mb-4">
        <h2>📚 Book Management</h2>
        <a href="index.php?action=admin-book-create" class="btn btn-success shadow-sm">+ Add New Book</a>
    </div>

    <?php if (!empty($_SESSION['success'])): ?>
        <div class="alert alert-success alert-dismissible fade show">
            <?= $_SESSION['success']; unset($_SESSION['success']); ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    <?php endif; ?>

    <div class="card shadow-sm">
        <div class="card-body p-0">
            <table class="table table-hover mb-0">
                <thead class="table-light">
                    <tr>
                        <th class="ps-3">Cover</th>
                        <th>Title</th>
                        <th>Author</th>
                        <th>Category</th>
                        <th>Status</th> <th class="text-center">Actions</th>
                    </tr>
                </thead>
                <tbody>
                <?php foreach ($books as $book): ?>
                    <tr>
                        <td class="ps-3">
                            <img src="<?= $book['url'] ?: '/library-management-system/public/images/no-image.png' ?>" 
                                 class="rounded border" width="45" height="60" style="object-fit: cover;">
                        </td>
                        <td class="fw-bold"><?= htmlspecialchars($book['title']) ?></td>
                        <td><?= htmlspecialchars($book['author']) ?></td>
                        <td><span class="badge bg-info text-dark"><?= htmlspecialchars($book['category_name']) ?></span></td>
                        <td>
                            <span class="badge <?= ($book['quantity'] > 0) ? 'bg-success' : 'bg-danger' ?>">
                                <?= ($book['quantity'] > 0) ? 'Available' : 'Out of Stock' ?>
                            </span>
                        </td>
                        <td class="text-center">
                            <a href="index.php?action=admin-book-edit&id=<?= $book['book_id'] ?>" class="btn btn-outline-warning btn-sm">Edit</a>
                            
                            <a href="index.php?action=admin-book-delete&id=<?= $book['book_id'] ?>" 
                               onclick="return confirm('Bạn có chắc chắn muốn xóa/lưu trữ sách này?')" 
                               class="btn btn-outline-danger btn-sm">Delete</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>