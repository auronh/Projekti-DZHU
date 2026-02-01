<?php
require_once '../../config/config.php';
$authController = new AuthController();
$authController->requireAdmin();
$movieController = new MovieController();
$movies = $movieController->getAllMovies();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Movies - <?php echo SITE_NAME; ?></title>
    <link rel="stylesheet" href="../../assets/css/style.css">
    <link rel="stylesheet" href="../../assets/css/admin.css">
</head>
<body>
    <header>
        <a href="dashboard.php" class="logo"><?php echo SITE_NAME; ?> Admin</a>
        <nav>
            <a href="dashboard.php">Dashboard</a>
            <a href="../public/logout.php">Logout</a>
        </nav>
    </header>
    <div class="admin-container">
        <div class="admin-header">
            <h1>Manage Movies</h1>
            <a href="add-movie.php" class="btn-primary">Add New Movie</a>
        </div>
        <div class="admin-table-container">
            <table class="admin-table">
                <thead>
                    <tr>
                        <th>Image</th>
                        <th>Title</th>
                        <th>Year</th>
                        <th>Genre</th>
                        <th>Category</th>
                        <th>Rating</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($movies as $movie): ?>
                    <tr>
                        <td><img src="<?php echo $movie->getImagePath(); ?>" alt="<?php echo htmlspecialchars($movie->getTitle()); ?>"></td>
                        <td><?php echo htmlspecialchars($movie->getTitle()); ?></td>
                        <td><?php echo $movie->getYear(); ?></td>
                        <td><?php echo htmlspecialchars($movie->getGenre()); ?></td>
                        <td><?php echo htmlspecialchars($movie->getCategory()); ?></td>
                        <td>★ <?php echo $movie->getRating(); ?></td>
                        <td class="action-buttons">
                            <a href="edit-movie.php?id=<?php echo $movie->getId(); ?>" class="btn-small btn-edit">Edit</a>
                            <a href="delete-movie.php?id=<?php echo $movie->getId(); ?>" class="btn-small btn-delete" onclick="return confirm('Delete this movie?')">Delete</a>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</body>
</html>
