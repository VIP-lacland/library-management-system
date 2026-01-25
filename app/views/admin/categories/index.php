<div class="page-header" style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
    <h2 class="page-title">📂 Category Management</h2>
    <a href="index.php?action=category-create" class="btn btn-success" style="display: inline-flex; align-items: center; gap: 8px;">
        <i class="fas fa-plus"></i> Add New Category
    </a>
</div>

<?php if (isset($_SESSION['success'])): ?>
    <div class="alert alert-success">
        <?= $_SESSION['success']; unset($_SESSION['success']); ?>
    </div>
<?php endif; ?>

<?php if (isset($_SESSION['error'])): ?>
    <div class="alert alert-error">
        <?= $_SESSION['error']; unset($_SESSION['error']); ?>
    </div>
<?php endif; ?>

<div class="card shadow-sm">
    <table class="table">
        <thead>
            <tr>
                <th width="80px" style="text-align: center;">ID</th>
                <th>Category Name</th>
                <th>Description</th>
                <th width="120px" style="text-align: center;">Books</th>
                <th width="220px" style="text-align: center;">Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php if (!empty($categories)): ?>
                <?php foreach ($categories as $cat): ?>
                    <tr>
                        <td style="text-align: center; color: #64748b; font-weight: 500;">
                            #<?= $cat['category_id'] ?>
                        </td>
                        <td>
                            <strong style="color: #1e293b;"><?= htmlspecialchars($cat['name']) ?></strong>
                        </td>
                        <td style="color: #64748b; font-size: 13px; max-width: 300px; overflow: hidden; text-overflow: ellipsis; white-space: nowrap;">
                            <?= htmlspecialchars($cat['description']) ?>
                        </td>
                        <td style="text-align: center;">
                            <span style="background: #eff6ff; color: #2563eb; padding: 4px 12px; border-radius: 12px; font-weight: 600; font-size: 12px; border: 1px solid #dbeafe;">
                                <?= $cat['book_count'] ?? 0 ?>
                            </span>
                        </td>
                        <td>
                            <div style="display: flex; gap: 10px; justify-content: center;">
                                <a href="index.php?action=category-edit&id=<?= $cat['category_id'] ?>" 
                                   class="btn btn-warning" 
                                   style="display: inline-flex; align-items: center; gap: 6px; padding: 6px 12px; min-width: 85px; justify-content: center; text-decoration: none;">
                                    <i class="fas fa-edit"></i> Edit
                                </a>

                                <a href="index.php?action=category-delete&id=<?= $cat['category_id'] ?>" 
                                   class="btn btn-danger" 
                                   style="display: inline-flex; align-items: center; gap: 6px; padding: 6px 12px; min-width: 85px; justify-content: center; text-decoration: none;"
                                   onclick="return confirm('Are you sure you want to delete this category?');">
                                    <i class="fas fa-trash"></i> Delete
                                </a>
                            </div>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr>
                    <td colspan="5" style="text-align: center; padding: 40px; color: #94a3b8;">
                        <i class="fas fa-folder-open" style="font-size: 24px; display: block; margin-bottom: 10px;"></i>
                        No categories found.
                    </td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>