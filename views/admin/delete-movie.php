<?php
require_once '../../config/config.php';
$authController = new AuthController();
$authController->requireAdmin();
$movieController = new MovieController();
$movieId = isset($_GET['id']) ? (int)$_GET['id'] : 0;
if ($movieId) {
    $movieController->deleteMovie($movieId);
}
redirect('manage-movies.php');
