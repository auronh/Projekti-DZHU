<?php
require_once '../../config/config.php';
$authController = new AuthController();
$authController->requireAdmin();
$movieController = new MovieController();
$errors = [];
$success = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $result = $movieController->createMovie($_POST, $_FILES);
    if ($result['success']) {
        $success = $result['message'];
        $_POST = [];
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
    <title>Add Movie - <?php echo SITE_NAME; ?></title>
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
        <h1>Add New Movie</h1>
        <?php if (!empty($errors)): ?><div class="alert alert-error"><ul><?php foreach ($errors as $error): ?><li><?php echo htmlspecialchars($error); ?></li><?php endforeach; ?></ul></div><?php endif; ?>
        <?php if ($success): ?><div class="alert alert-success"><?php echo htmlspecialchars($success); ?> <a href="manage-movies.php">View all movies</a></div><?php endif; ?>
        <form method="POST" enctype="multipart/form-data" class="form-container">
            <div class="form-group">
                <label>Title *</label>
                <input type="text" name="title" required value="<?php echo isset($_POST['title']) ? htmlspecialchars($_POST['title']) : ''; ?>">
            </div>
            <div class="form-group">
                <label>Description *</label>
                <textarea name="description" required><?php echo isset($_POST['description']) ? htmlspecialchars($_POST['description']) : ''; ?></textarea>
            </div>
            <div class="form-group">
                <label>Year *</label>
                <input type="number" name="year" required value="<?php echo isset($_POST['year']) ? htmlspecialchars($_POST['year']) : date('Y'); ?>">
            </div>
            <div class="form-group">
                <label>Duration (minutes)</label>
                <input type="number" name="duration" value="<?php echo isset($_POST['duration']) ? htmlspecialchars($_POST['duration']) : ''; ?>">
            </div>
            <div class="form-group">
                <label>Rating (0-10)</label>
                <input type="number" step="0.1" min="0" max="10" name="rating" value="<?php echo isset($_POST['rating']) ? htmlspecialchars($_POST['rating']) : '0'; ?>">
            </div>
            <div class="form-group">
                <label>Genre *</label>
                <input type="text" name="genre" required value="<?php echo isset($_POST['genre']) ? htmlspecialchars($_POST['genre']) : ''; ?>">
            </div>
            <div class="form-group">
                <label>Category *</label>
                <select name="category" required>
                    <option value="">Select Category</option>
                    <option value="trending">Trending</option>
                    <option value="popular">Popular</option>
                    <option value="top-rated">Top Rated</option>
                    <option value="action">Action</option>
                    <option value="drama">Drama</option>
                    <option value="sci-fi">Sci-Fi</option>
                </select>
            </div>
            <div class="form-group">
                <label>Movie Image</label>
                <input type="file" name="image" accept="image/*">
            </div>
            <div class="form-group">
                <label>PDF File (Optional)</label>
                <input type="file" name="pdf" accept=".pdf">
            </div>
            <div class="form-actions">
                <button type="submit" class="btn-primary">Add Movie</button>
                <a href="manage-movies.php" class="btn-secondary">Cancel</a>
            </div>
        </form>
    </div>
</body>
</html>
