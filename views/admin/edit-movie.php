<?php
require_once '../../config/config.php';
$authController = new AuthController();
$authController->requireAdmin();
$movieController = new MovieController();
$movieId = isset($_GET['id']) ? (int)$_GET['id'] : 0;
$movie = $movieController->getMovieById($movieId);
if (!$movie) redirect('manage-movies.php');
$errors = [];
$success = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $_POST['id'] = $movieId;
    $result = $movieController->updateMovie($_POST, $_FILES);
    if ($result['success']) {
        $success = $result['message'];
        $movie = $movieController->getMovieById($movieId);
    } else {
        $errors = $result['errors'];
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Movie - <?php echo SITE_NAME; ?></title>
    <link rel="stylesheet" href="../../assets/css/style.css">
    <link rel="stylesheet" href="../../assets/css/admin.css">
</head>
<body>
    <header>
        <a href="dashboard.php" class="logo"><?php echo SITE_NAME; ?> Admin</a>
        <nav>
            <a href="manage-movies.php">Back to Movies</a>
            <a href="../public/logout.php">Logout</a>
        </nav>
    </header>
    <div class="admin-container">
        <h1>Edit Movie</h1>
        <?php if (!empty($errors)): ?><div class="alert alert-error"><ul><?php foreach ($errors as $error): ?><li><?php echo htmlspecialchars($error); ?></li><?php endforeach; ?></ul></div><?php endif; ?>
        <?php if ($success): ?><div class="alert alert-success"><?php echo htmlspecialchars($success); ?></div><?php endif; ?>
        <form method="POST" enctype="multipart/form-data" class="form-container">
            <div class="form-group">
                <label>Title *</label>
                <input type="text" name="title" required value="<?php echo htmlspecialchars($movie->getTitle()); ?>">
            </div>
            <div class="form-group">
                <label>Description *</label>
                <textarea name="description" required><?php echo htmlspecialchars($movie->getDescription()); ?></textarea>
            </div>
            <div class="form-group">
                <label>Year *</label>
                <input type="number" name="year" required value="<?php echo $movie->getYear(); ?>">
            </div>
            <div class="form-group">
                <label>Duration (minutes)</label>
                <input type="number" name="duration" value="<?php echo $movie->getDuration(); ?>">
            </div>
            <div class="form-group">
                <label>Rating (0-10)</label>
                <input type="number" step="0.1" min="0" max="10" name="rating" value="<?php echo $movie->getRating(); ?>">
            </div>
            <div class="form-group">
                <label>Genre *</label>
                <input type="text" name="genre" required value="<?php echo htmlspecialchars($movie->getGenre()); ?>">
            </div>
            <div class="form-group">
                <label>Category *</label>
                <select name="category" required>
                    <option value="trending" <?php echo $movie->getCategory() === 'trending' ? 'selected' : ''; ?>>Trending</option>
                    <option value="popular" <?php echo $movie->getCategory() === 'popular' ? 'selected' : ''; ?>>Popular</option>
                    <option value="top-rated" <?php echo $movie->getCategory() === 'top-rated' ? 'selected' : ''; ?>>Top Rated</option>
                    <option value="action" <?php echo $movie->getCategory() === 'action' ? 'selected' : ''; ?>>Action</option>
                    <option value="drama" <?php echo $movie->getCategory() === 'drama' ? 'selected' : ''; ?>>Drama</option>
                    <option value="sci-fi" <?php echo $movie->getCategory() === 'sci-fi' ? 'selected' : ''; ?>>Sci-Fi</option>
                </select>
            </div>
            <div class="form-group">
                <label>Current Image</label>
                <img src="<?php echo $movie->getImagePath(); ?>" style="max-width: 200px; margin-bottom: 10px;">
                <label>Change Image</label>
                <input type="file" name="image" accept="image/*">
            </div>
            <div class="form-group">
                <label>PDF File (Optional)</label>
                <?php if ($movie->getPdfPath()): ?>
                <p>Current: <a href="../../assets/uploads/pdfs/<?php echo $movie->getPdfPath(); ?>" target="_blank">View PDF</a></p>
                <?php endif; ?>
                <input type="file" name="pdf" accept=".pdf">
            </div>
            <div class="form-actions">
                <button type="submit" class="btn-primary">Update Movie</button>
                <a href="manage-movies.php" class="btn-secondary">Cancel</a>
            </div>
        </form>
    </div>
</body>
</html>
