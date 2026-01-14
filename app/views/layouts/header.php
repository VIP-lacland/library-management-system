<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo APP_NAME; ?> - Hệ thống Quản lý Thư viện</title>
    <link rel="stylesheet" href="<?php echo URL_ROOT; ?>/css/style.css">
</head>
<body>

<header>
    <div class="container">
        <h1><?php echo APP_NAME; ?></h1>
        <p>Phiên bản <?php echo APP_VERSION; ?></p>
        
        <nav>
            <ul>
                <li><a href="<?php echo URL_ROOT; ?>/?url=book/index">Danh sách sách</a></li>
                <li><a href="<?php echo URL_ROOT; ?>/?url=book/create">Thêm sách</a></li>
                <li><a href="<?php echo URL_ROOT; ?>/">Trang chủ</a></li>
            </ul>
        </nav>
    </div>
</header>

<main class="container">
