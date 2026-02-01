<?php
require_once '../../config/config.php';
$authController = new AuthController();
$authController->requireAdmin();
$movieController = new MovieController();
$contactController = new ContactController();
$movies = $movieController->getAllMovies();
$messages = $contactController->getAllMessages();
$unreadCount = $contactController->getUnreadCount();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - <?php echo SITE_NAME; ?></title>
    <link rel="stylesheet" href="../../assets/css/style.css">
    <link rel="stylesheet" href="../../assets/css/admin.css">
</head>
<body>
    <header>
        <a href="../public/index.php" class="logo"><?php echo SITE_NAME; ?> Admin</a>
        <nav>
            <a href="../public/index.php">View Site</a>
            <a href="../public/logout.php">Logout</a>
        </nav>
    </header>
    <div class="admin-container">
        <div class="admin-header">
            <h1>Admin Dashboard</h1>
            <div class="admin-nav">
                <a href="manage-movies.php">Manage Movies</a>
                <a href="messages.php">Messages (<?php echo $unreadCount; ?>)</a>
            </div>
        </div>
        <div class="stats-grid">
            <div class="stat-card">
                <h3>Total Movies</h3>
                <div class="number"><?php echo count($movies); ?></div>
            </div>
            <div class="stat-card">
                <h3>Total Messages</h3>
                <div class="number"><?php echo count($messages); ?></div>
            </div>
            <div class="stat-card">
                <h3>Unread Messages</h3>
                <div class="number"><?php echo $unreadCount; ?></div>
            </div>
        </div>
        <h2>Recent Movies</h2>
        <div class="admin-table-container">
            <table class="admin-table">
                <thead>
                    <tr>
                        <th>Image</th>
                        <th>Title</th>
                        <th>Year</th>
                        <th>Genre</th>
                        <th>Rating</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach (array_slice($movies, 0, 10) as $movie): ?>
                    <tr>
                        <td><img src="<?php echo $movie->getImagePath(); ?>" alt="<?php echo htmlspecialchars($movie->getTitle()); ?>"></td>
                        <td><?php echo htmlspecialchars($movie->getTitle()); ?></td>
                        <td><?php echo $movie->getYear(); ?></td>
                        <td><?php echo htmlspecialchars($movie->getGenre()); ?></td>
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
