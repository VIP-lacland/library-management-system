<?php

class DashboardController {
    public function index() {
        if (!isset($_SESSION['user'])) {
            header("Location: " . URL_ROOT . "/auth");
            exit;
        }

        echo "Welcome " . $_SESSION['user'];
        echo "<br><a href='" . URL_ROOT . "/logout'>Logout</a>";
    }
}
