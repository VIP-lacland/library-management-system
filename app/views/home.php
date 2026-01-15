<?php
require_once __DIR__ . '/../config/config.php';
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../../public/css/home.css">
    <title>Home Page</title>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.10.2/dist/umd/popper.min.js" integrity="sha384-7+zCNj/IqJ95wo16oMtfsKbZ9ccEh31eOz1HGyDuCQ6wgnyJNSYdrPa03rtR1zdB" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.min.js" integrity="sha384-QJHtvGhmr9XOIpI6YVutG+2QOK9T+ZnN4kzFN1RtK3zEFEIsxhlmWl5/YESvpZ13" crossorigin="anonymous"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">

</head>
<?php require_once  __DIR__ . '/../views/layouts/header.php'; ?>

<body>
    <div class="container">
        <div class="row g-4">
            <?php foreach ($books as $book): ?>
                <div class="col-md-3">
                    <div class="card h-100" style="width: 18rem;">
                        <img src="<?= $book["url"] ?>" class="card-img-top" alt="...">
                        <div class="card-body d-flex flex-column">
                            <h5 class="card-title"><?= $book["title"] ?></h5>
                            <p class="card-text"><?= $book["description"] ?></p>
                            <h5 class="card-tittle"><i class="fa-regular fa-user me-3"></i><?= $book["author"] ?></h5>
                            <a href="#" class="btn btn-primary mt-auto w-100">View Details</a>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</body>
<?php require_once  __DIR__ . '/../views/layouts/footer.php'; ?>

</html>