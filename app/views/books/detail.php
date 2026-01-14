<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Chi tiết sách</title>
    <link rel="stylesheet" href="<?php echo URL_ROOT; ?>/css/style.css">
    <style>
        .container {
            max-width: 900px;
            margin: 0 auto;
            padding: 20px;
        }

        .book-detail {
            background: white;
            border-radius: 8px;
            padding: 30px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }

        .book-header {
            border-bottom: 2px solid #007bff;
            padding-bottom: 20px;
            margin-bottom: 30px;
        }

        .book-header h1 {
            margin: 0 0 10px 0;
            color: #2c3e50;
        }

        .author {
            color: #666;
            font-size: 16px;
        }

        .info {
            display: flex;
            margin: 15px 0;
            padding: 10px 0;
        }

        .info strong {
            min-width: 150px;
            color: #333;
        }

        .info span {
            color: #666;
        }

        .description {
            line-height: 1.6;
            color: #555;
            margin: 20px 0;
        }

        .status {
            margin-top: 30px;
            padding-top: 30px;
            border-top: 2px solid #eee;
        }

        .status h3 {
            color: #2c3e50;
            margin-bottom: 15px;
        }

        .status-list {
            list-style: none;
            padding: 0;
        }

        .status-list li {
            padding: 10px;
            margin: 5px 0;
            background: #f5f5f5;
            border-left: 4px solid #007bff;
            border-radius: 4px;
        }

        .btn-group {
            margin-top: 30px;
            padding-top: 20px;
            border-top: 1px solid #eee;
        }

        .btn {
            display: inline-block;
            padding: 10px 20px;
            margin-right: 10px;
            border: none;
            border-radius: 4px;
            text-decoration: none;
            cursor: pointer;
            font-size: 14px;
            transition: background-color 0.3s;
        }

        .btn-primary {
            background-color: #007bff;
            color: white;
        }

        .btn-primary:hover {
            background-color: #0056b3;
        }

        .btn-secondary {
            background-color: #6c757d;
            color: white;
        }

        .btn-secondary:hover {
            background-color: #5a6268;
        }

        .alert {
            padding: 15px;
            border-radius: 4px;
            margin: 20px 0;
        }

        .alert-error {
            background-color: #f8d7da;
            color: #721c24;
            border: 1px solid #f5c6cb;
        }

        .alert-success {
            background-color: #d4edda;
            color: #155724;
            border: 1px solid #c3e6cb;
        }
    </style>
</head>
<body>

<div class="container">
    <div class="book-detail">
        <?php if ($book): ?>
            <div class="book-header">
                <h1><?php echo htmlspecialchars($book['title']); ?></h1>
                <p class="author">
                    <strong>Tác giả:</strong> <?php echo htmlspecialchars($book['author']); ?>
                </p>
            </div>

            <div class="book-info">
                <div class="info">
                    <strong>Thể loại:</strong>
                    <span><?php echo htmlspecialchars($book['category_name'] ?? 'N/A'); ?></span>
                </div>

                <div class="info">
                    <strong>NXB:</strong>
                    <span><?php echo htmlspecialchars($book['publisher'] ?? 'N/A'); ?></span>
                </div>

                <div class="info">
                    <strong>Năm xuất bản:</strong>
                    <span><?php echo htmlspecialchars($book['publish_year'] ?? 'N/A'); ?></span>
                </div>

                <p class="description">
                    <strong>Mô tả:</strong><br>
                    <?php echo nl2br(htmlspecialchars($book['description'] ?? '')); ?>
                </p>

                <?php if (!empty($book['url'])): ?>
                    <div class="info">
                        <strong>Link tham khảo:</strong>
                        <span>
                            <a href="<?php echo htmlspecialchars($book['url']); ?>" 
                               target="_blank" rel="noopener noreferrer">
                                <?php echo htmlspecialchars($book['url']); ?>
                            </a>
                        </span>
                    </div>
                <?php endif; ?>
            </div>

            <?php if (!empty($statuses)): ?>
                <div class="status">
                    <h3>Tình trạng sách</h3>
                    <ul class="status-list">
                        <?php foreach ($statuses as $item): ?>
                            <li>
                                <?php echo ucfirst(htmlspecialchars($item['status'])); ?>: 
                                <strong><?php echo htmlspecialchars($item['total']); ?></strong> cuốn
                            </li>
                        <?php endforeach; ?>
                    </ul>
                </div>
            <?php endif; ?>

            <div class="btn-group">
                <a href="<?php echo URL_ROOT; ?>/?url=book/index" class="btn btn-secondary">
                    ← Quay lại danh sách
                </a>
            </div>

        <?php else: ?>
            <div class="alert alert-error">
                <p>Không tìm thấy sách.</p>
            </div>
            <div class="btn-group">
                <a href="<?php echo URL_ROOT; ?>/?url=book/index" class="btn btn-secondary">
                    ← Quay lại danh sách
                </a>
            </div>
        <?php endif; ?>
    </div>
</div>

</body>
</html>
