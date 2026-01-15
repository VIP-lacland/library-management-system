<?php

require_once '../app/config/config.php';
require_once '../app/core/Database.php';
require_once '../app/core/Controller.php';


require_once('../app/controllers/BookController.php');


$bookController = new BookController();
$bookController->index();

?>
