<?php
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <h1><?= $book['title'] ?></h1>
    <p>Author: <?= $book['author'] ?></p>
    <p><img src="<?= $book['image'] ?>" alt=""></p>
    <p>Genre: <?= $book['genre'] ?></p>
    <p>Publish: <?= $book['publish'] ?></p>
</body>
</html>