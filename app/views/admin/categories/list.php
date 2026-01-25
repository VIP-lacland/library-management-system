<div class="content-header" style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 25px;">
    <div>
        <h2 style="font-size: 24px; font-weight: 700; color: #1e293b; margin: 0;">📂 Category Management</h2>
        <p style="color: #64748b; margin: 5px 0 0 0; font-size: 14px;">Organize and manage your library book categories</p>
    </div>
    <a href="admin.php?action=category-create" class="btn btn-success" style="background: #10b981; border: none; padding: 10px 20px; border-radius: 6px; font-weight: 500; display: inline-flex; align-items: center; gap: 8px; text-decoration: none; color: white;">
        <i class="fas fa-plus"></i> Add New Category
    </a>
</div>

<?php if (isset($_SESSION['success'])): ?>
    <div class="alert alert-success" style="background: #f0fdf4; color: #166534; border: 1px solid #bbf7d0; padding: 12px; border-radius: 6px; margin-bottom: 20px;">
        <i class="fas fa-check-circle" style="margin-right: 8px;"></i> <?= $_SESSION['success']; unset($_SESSION['success']); ?>
    </div>
<?php endif; ?>

<div class="card shadow-sm" style="background: white; border-radius: 8px; box-shadow: 0 1px 3px rgba(0,0,0,0.1); border: 1px solid #e2e8f0; overflow: hidden;">
    <table class="table" style="width: 100%; border-collapse: collapse; text-align: left;">
        <thead>
            <tr style="background: #f8fafc; border-bottom: 1px solid #e2e8f0;">
                <th width="80px" style="padding: 14px 16px; font-size: 12px; font-weight: 600; color: #64748b; text-transform: uppercase; text-align: center;">ID</th>
                <th style="padding: 14px 16px; font-size: 12px; font-weight: 600; color: #64748b; text-transform: uppercase;">Category Name</th>
                <th style="padding: 14px 16px; font-size: 12px; font-weight: 600; color: #64748b; text-transform: uppercase;">Description</th>
                <th width="120px" style="padding: 14px 16px; font-size: 12px; font-weight: 600; color: #64748b; text-transform: uppercase; text-align: center;">Total Books</th>
                <th width="200px" style="padding: 14px 16px; font-size: 12px; font-weight: 600; color: #64748b; text-transform: uppercase; text-align: center;">Actions</th>
            </tr>
        </thead>
        <tbody style="font-size: 14px;">
            <?php if (!empty($categories)): ?>
                <?php foreach ($categories as $cat): ?>
                    <tr style="border-bottom: 1px solid #f1f5f9; transition: background 0.2s;" onmouseover="this.style.background='#f8fafc'" onmouseout="this.style.background='transparent'">
                        <td style="padding: 12px 16px; text-align: center; color: #64748b; font-weight: 500;">
                            #<?= $cat['category_id'] ?>
                        </td>
                        <td style="padding: 12px 16px;">
                            <strong style="color: #1e293b;"><?= htmlspecialchars($cat['name']) ?></strong>
                        </td>
                        <td style="padding: 12px 16px; color: #64748b; font-size: 13px; max-width: 300px; overflow: hidden; text-overflow: ellipsis; white-space: nowrap;">
                            <?= htmlspecialchars($cat['description']) ?>
                        </td>
                        <td style="padding: 12px 16px; text-align: center;">
                            <span style="background: #eff6ff; color: #2563eb; padding: 4px 12px; border-radius: 12px; font-weight: 600; font-size: 12px; border: 1px solid #dbeafe;">
                                <?= $cat['total_books'] ?? 0 ?>
                            </span>
                        </td>
                        <td style="padding: 12px 16px; text-align: center;">
                            <div style="display: flex; gap: 12px; justify-content: center;">
                                <a href="admin.php?action=category-edit&id=<?= $cat['category_id'] ?>" 
                                   title="Edit" style="color: #f59e0b; font-size: 18px; text-decoration: none;">
                                    <i class="fas fa-edit"></i>
                                </a>

                                <a href="admin.php?action=category-delete&id=<?= $cat['category_id'] ?>" 
                                   title="Delete" style="color: #ef4444; font-size: 18px; text-decoration: none;"
                                   onclick="return confirm('Are you sure you want to delete this category?');">
                                    <i class="fas fa-trash"></i>
                                </a>
                            </div>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr>
                    <td colspan="5" style="text-align: center; padding: 50px; color: #94a3b8;">
                        <i class="fas fa-folder-open" style="font-size: 32px; display: block; margin-bottom: 15px;"></i>
                        No categories found in database.
                    </td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>