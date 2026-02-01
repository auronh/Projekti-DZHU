<?php
require_once '../../config/config.php';
$movieController = new MovieController();
$movieId = isset($_GET['id']) ? (int)$_GET['id'] : 0;
$movie = $movieController->getMovieById($movieId);
if (!$movie) {
    redirect('movies.php');
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($movie->getTitle()); ?> - <?php echo SITE_NAME; ?></title>
    <link rel="stylesheet" href="../../assets/css/style.css">
    <style>
        .movie-detail {
            display: grid;
            grid-template-columns: 1fr 2fr;
            gap: 40px;
            padding: 40px;
            max-width: 1200px;
            margin: 0 auto;
        }
        .movie-poster img {
            width: 100%;
            border-radius: 10px;
        }
        .movie-info-detail h1 {
            font-size: 2.5rem;
            margin-bottom: 20px;
        }
        .movie-meta {
            display: flex;
            gap: 20px;
            margin-bottom: 20px;
            color: var(--muted);
        }
        .rating {
            color: #fbbf24;
        }
        @media (max-width: 768px) {
            .movie-detail {
                grid-template-columns: 1fr;
            }
        }
    </style>
</head>
<body>
    <?php include 'includes/header.php'; ?>
    <div class="movie-detail">
        <div class="movie-poster">
            <img src="<?php echo $movie->getImagePath(); ?>" alt="<?php echo htmlspecialchars($movie->getTitle()); ?>">
            <?php if ($movie->getPdfPath()): ?>
            <a href="../../assets/uploads/pdfs/<?php echo $movie->getPdfPath(); ?>" target="_blank" class="btn" style="display: block; margin-top: 20px; text-align: center;">View PDF</a>
            <?php endif; ?>
        </div>
        <div class="movie-info-detail">
            <h1><?php echo htmlspecialchars($movie->getTitle()); ?></h1>
            <div class="movie-meta">
                <span><?php echo $movie->getYear(); ?></span>
                <span><?php echo $movie->getFormattedDuration(); ?></span>
                <span class="rating">★ <?php echo $movie->getRating(); ?></span>
                <span><?php echo htmlspecialchars($movie->getGenre()); ?></span>
            </div>
            <h3>Description</h3>
            <p><?php echo nl2br(htmlspecialchars($movie->getDescription())); ?></p>
        </div>
    </div>
    <?php include 'includes/footer.php'; ?>
</body>
</html>
