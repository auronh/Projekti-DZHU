<?php

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

define('BASE_PATH', dirname(__DIR__));
define('UPLOAD_PATH', BASE_PATH . '/assets/uploads/');
define('MOVIE_UPLOAD_PATH', UPLOAD_PATH . 'movies/');
define('PDF_UPLOAD_PATH', UPLOAD_PATH . 'pdfs/');

if (!file_exists(MOVIE_UPLOAD_PATH)) {
    mkdir(MOVIE_UPLOAD_PATH, 0755, true);
}
if (!file_exists(PDF_UPLOAD_PATH)) {
    mkdir(PDF_UPLOAD_PATH, 0755, true);
}

define('SITE_NAME', 'AlbFlix');
define('SITE_URL', 'http://localhost/movie-website');

define('MAX_FILE_SIZE', 5242880);
define('ALLOWED_IMAGE_TYPES', ['image/jpeg', 'image/png', 'image/jpg', 'image/gif', 'image/webp']);
define('ALLOWED_PDF_TYPES', ['application/pdf']);

define('ITEMS_PER_PAGE', 12);

define('ROLE_ADMIN', 'admin');
define('ROLE_USER', 'user');

error_reporting(E_ALL);
ini_set('display_errors', 1);

spl_autoload_register(function ($class) {
    $directories = [
        BASE_PATH . '/models/',
        BASE_PATH . '/repositories/',
        BASE_PATH . '/controllers/',
        BASE_PATH . '/interfaces/',
        BASE_PATH . '/config/'
    ];
    
    foreach ($directories as $directory) {
        $file = $directory . $class . '.php';
        if (file_exists($file)) {
            require_once $file;
            return;
        }
    }
});

function isLoggedIn() {
    return isset($_SESSION['user_id']);
}

function isAdmin() {
    return isset($_SESSION['role']) && $_SESSION['role'] === ROLE_ADMIN;
}

function redirect($url) {
    header("Location: " . $url);
    exit();
}

function sanitize($data) {
    return htmlspecialchars(strip_tags(trim($data)));
}

function isValidEmail($email) {
    return filter_var($email, FILTER_VALIDATE_EMAIL) !== false;
}
?>
