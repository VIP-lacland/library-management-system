<div class="content-header" style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 25px;">
    <div>
        <h2 style="font-size: 24px; font-weight: 700; color: #1e293b; margin: 0;">Book Management</h2>
        <p style="color: #64748b; margin: 5px 0 0 0; font-size: 14px;">View and manage your library book collection</p>
    </div>
    <a href="admin.php?action=admin-book-create" class="btn btn-primary" style="background: #2563eb; border: none; padding: 10px 20px; border-radius: 6px; font-weight: 500; display: inline-flex; align-items: center; gap: 8px; text-decoration: none; color: white;">
        <i class="fas fa-plus"></i> Add New Book
    </a>
</div>

<?php if (!empty($_SESSION['success'])): ?>
    <div class="alert alert-success" style="background: #f0fdf4; color: #166534; border: 1px solid #bbf7d0; padding: 12px; border-radius: 6px; margin-bottom: 20px;">
        <?= $_SESSION['success']; unset($_SESSION['success']); ?>
    </div>
<?php endif; ?>

<div class="toolbar" style="background: white; padding: 16px; border-radius: 8px; margin-bottom: 20px; display: flex; gap: 12px; box-shadow: 0 1px 2px rgba(0,0,0,0.05);">
    <div style="flex: 1; position: relative;">
        <input type="text" placeholder="Search by title, author or ISBN..." 
               style="width: 100%; padding: 10px 12px; border: 1px solid #e2e8f0; border-radius: 6px; outline: none;">
    </div>
    <button style="background: #2563eb; color: white; border: none; padding: 10px 20px; border-radius: 6px; cursor: pointer; display: flex; align-items: center; gap: 8px;">
        <i class="fas fa-search"></i> Search
    </button>
</div>

<div class="card" style="background: white; border-radius: 8px; box-shadow: 0 1px 3px rgba(0,0,0,0.1); border: 1px solid #e2e8f0; overflow: hidden;">
    <table class="table" style="width: 100%; border-collapse: collapse; text-align: left;">
        <thead>
            <tr style="background: #f8fafc; border-bottom: 1px solid #e2e8f0;">
                <th style="padding: 14px 16px; font-size: 12px; font-weight: 600; color: #64748b; text-transform: uppercase;">Cover</th>
                <th style="padding: 14px 16px; font-size: 12px; font-weight: 600; color: #64748b; text-transform: uppercase;">Title & Author</th>
                <th style="padding: 14px 16px; font-size: 12px; font-weight: 600; color: #64748b; text-transform: uppercase;">ISBN</th>
                <th style="padding: 14px 16px; font-size: 12px; font-weight: 600; color: #64748b; text-transform: uppercase;">Category</th>
                <th style="padding: 14px 16px; font-size: 12px; font-weight: 600; color: #64748b; text-transform: uppercase; text-align: center;">Actions</th>
            </tr>
        </thead>
        <tbody style="font-size: 14px;">
            <?php if (!empty($books)): ?>
                <?php foreach ($books as $book): ?>
                    <tr style="border-bottom: 1px solid #f1f5f9; transition: background 0.2s;" onmouseover="this.style.background='#f8fafc'" onmouseout="this.style.background='transparent'">
                        <td style="padding: 12px 16px;">
                            <img src="<?= $book['url'] ?: '/library-management-system/public/images/no-book.png' ?>" 
                                 style="width: 40px; height: 55px; object-fit: cover; border-radius: 4px; border: 1px solid #e2e8f0;">
                        </td>
                        <td style="padding: 12px 16px;">
                            <div style="font-weight: 600; color: #1e293b;"><?= htmlspecialchars($book['title']) ?></div>
                            <div style="font-size: 12px; color: #64748b;"><?= htmlspecialchars($book['author']) ?></div>
                        </td>
                        <td style="padding: 12px 16px;">
                            <code style="background: #f1f5f9; padding: 2px 6px; border-radius: 4px; font-family: monospace; font-size: 13px; color: #475569;">
                                <?= htmlspecialchars($book['isbn']) ?>
                            </code>
                        </td>
                        <td style="padding: 12px 16px;">
                            <span style="background: #e0f2fe; color: #0369a1; padding: 4px 10px; border-radius: 20px; font-size: 12px; font-weight: 500;">
                                <?= htmlspecialchars($book['category_name'] ?? 'Uncategorized') ?>
                            </span>
                        </td>
                        <td style="padding: 12px 16px; text-align: center;">
                            <div style="display: flex; gap: 10px; justify-content: center;">
                                <a href="admin.php?action=admin-book-edit&id=<?= $book['book_id'] ?>" 
                                   title="Edit" style="color: #f59e0b; font-size: 18px;"><i class="fas fa-edit"></i></a>
                                
                                <a href="admin.php?action=admin-book-delete&id=<?= $book['book_id'] ?>" 
                                   title="Delete" style="color: #ef4444; font-size: 18px;"
                                   onclick="return confirm('Archive this book?')"><i class="fas fa-trash-alt"></i></a>
                            </div>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr>
                    <td colspan="5" style="text-align: center; color: #94a3b8; padding: 40px;">
                        <i class="fas fa-box-open" style="font-size: 32px; display: block; margin-bottom: 10px;"></i>
                        No books found in database.
                    </td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>