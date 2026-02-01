<?php
require_once '../../config/config.php';

$movieController = new MovieController();

$trendingMovies = $movieController->getMoviesByCategory('trending');
$popularMovies = $movieController->getMoviesByCategory('popular');
$topRatedMovies = $movieController->getMoviesByCategory('top-rated');
$actionMovies = $movieController->getMoviesByCategory('action');
$dramaMovies = $movieController->getMoviesByCategory('drama');
$sciFiMovies = $movieController->getMoviesByCategory('sci-fi');

$allMovies = $movieController->getAllMovies();
$sliderMovies = array_slice($allMovies, 0, 5); // Top 5 for slider
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo SITE_NAME; ?> - Unlimited Movies, Anytime</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="../../assets/css/style.css">
    <style>
        .slider-container {
            position: relative;
            height: 70vh;
            overflow: hidden;
        }

        .slide {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            opacity: 0;
            transition: opacity 1s ease-in-out;
            background-size: cover;
            background-position: center;
        }

        .slide.active {
            opacity: 1;
        }

        .slide::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: linear-gradient(rgba(0, 0, 0, 0.6), rgba(0, 0, 0, 0.9));
        }

        .slide-content {
            position: relative;
            z-index: 2;
            max-width: 800px;
            padding: 40px;
            height: 100%;
            display: flex;
            flex-direction: column;
            justify-content: center;
        }

        .slide-content h2 {
            font-size: 3.5rem;
            margin-bottom: 15px;
            color: white;
        }

        .slide-content .movie-meta {
            display: flex;
            gap: 20px;
            margin-bottom: 20px;
            color: var(--muted);
        }

        .slide-content p {
            font-size: 1.1rem;
            color: var(--muted);
            margin-bottom: 30px;
            line-height: 1.6;
        }

        .slider-dots {
            position: absolute;
            bottom: 30px;
            left: 50%;
            transform: translateX(-50%);
            display: flex;
            gap: 10px;
            z-index: 3;
        }

        .dot {
            width: 12px;
            height: 12px;
            border-radius: 50%;
            background: rgba(255, 255, 255, 0.5);
            cursor: pointer;
            transition: all 0.3s;
        }

        .dot.active {
            background: var(--accent);
            width: 30px;
            border-radius: 6px;
        }

        .slider-controls {
            position: absolute;
            top: 50%;
            transform: translateY(-50%);
            width: 100%;
            display: flex;
            justify-content: space-between;
            padding: 0 20px;
            z-index: 3;
        }

        .slider-btn {
            background: rgba(0, 0, 0, 0.5);
            border: none;
            color: white;
            padding: 15px 20px;
            cursor: pointer;
            border-radius: 6px;
            font-size: 1.2rem;
            transition: background 0.3s;
        }

        .slider-btn:hover {
            background: rgba(0, 0, 0, 0.8);
        }

        .rating {
            color: #fbbf24;
            font-weight: bold;
        }
        h4{
            color:white;
        }
    </style>
</head>
<body>

    <?php include 'includes/header.php'; ?>

    <div class="slider-container">
        <?php foreach ($sliderMovies as $index => $movie): ?>
        <div class="slide <?php echo $index === 0 ? 'active' : ''; ?>" 
             style="background-image: url('<?php echo $movie->getImagePath(); ?>');">
            <div class="slide-content">
                <h2><?php echo htmlspecialchars($movie->getTitle()); ?></h2>
                <div class="movie-meta">
                    <span><?php echo $movie->getYear(); ?></span>
                    <span><?php echo $movie->getFormattedDuration(); ?></span>
                    <span class="rating">★ <?php echo $movie->getRating(); ?></span>
                    <span><?php echo htmlspecialchars($movie->getGenre()); ?></span>
                </div>
                <p><?php echo htmlspecialchars(substr($movie->getDescription(), 0, 200)); ?>...</p>
                <div>
                    <a class="btn" href="movie-detail.php?id=<?php echo $movie->getId(); ?>">Watch Now</a>
                </div>
            </div>
        </div>
        <?php endforeach; ?>

        <div class="slider-controls">
            <button class="slider-btn" onclick="changeSlide(-1)">&#10094;</button>
            <button class="slider-btn" onclick="changeSlide(1)">&#10095;</button>
        </div>

        <div class="slider-dots">
            <?php foreach ($sliderMovies as $index => $movie): ?>
            <span class="dot <?php echo $index === 0 ? 'active' : ''; ?>" onclick="currentSlide(<?php echo $index; ?>)"></span>
            <?php endforeach; ?>
        </div>
    </div>

    <?php if (!empty($trendingMovies)): ?>
    <section class="section" id="trending">
        <h3>Trending Movies</h3>
        <div class="movies">
            <?php foreach ($trendingMovies as $movie): ?>
            <a href="movie-detail.php?id=<?php echo $movie->getId(); ?>" class="movie-card">
                <img src="<?php echo $movie->getImagePath(); ?>" alt="<?php echo htmlspecialchars($movie->getTitle()); ?>">
                <div class="movie-info">
                    <h4><?php echo htmlspecialchars($movie->getTitle()); ?></h4>
                    <span><?php echo $movie->getYear(); ?> • ★ <?php echo $movie->getRating(); ?></span>
                </div>
            </a>
            <?php endforeach; ?>
        </div>
    </section>
    <?php endif; ?>

    <?php if (!empty($popularMovies)): ?>
    <section class="section" id="popular">
        <h3>Popular Movies</h3>
        <div class="movies">
            <?php foreach ($popularMovies as $movie): ?>
            <a href="movie-detail.php?id=<?php echo $movie->getId(); ?>" class="movie-card">
                <img src="<?php echo $movie->getImagePath(); ?>" alt="<?php echo htmlspecialchars($movie->getTitle()); ?>">
                <div class="movie-info">
                    <h4><?php echo htmlspecialchars($movie->getTitle()); ?></h4>
                    <span><?php echo $movie->getYear(); ?> • ★ <?php echo $movie->getRating(); ?></span>
                </div>
            </a>
            <?php endforeach; ?>
        </div>
    </section>
    <?php endif; ?>

    <?php if (!empty($topRatedMovies)): ?>
    <section class="section" id="top-rated">
        <h3>Top Rated</h3>
        <div class="movies">
            <?php foreach ($topRatedMovies as $movie): ?>
            <a href="movie-detail.php?id=<?php echo $movie->getId(); ?>" class="movie-card">
                <img src="<?php echo $movie->getImagePath(); ?>" alt="<?php echo htmlspecialchars($movie->getTitle()); ?>">
                <div class="movie-info">
                    <h4><?php echo htmlspecialchars($movie->getTitle()); ?></h4>
                    <span><?php echo $movie->getYear(); ?> • ★ <?php echo $movie->getRating(); ?></span>
                </div>
            </a>
            <?php endforeach; ?>
        </div>
    </section>
    <?php endif; ?>

    <?php if (!empty($actionMovies)): ?>
    <section class="section" id="action">
        <h3>Action</h3>
        <div class="movies">
            <?php foreach ($actionMovies as $movie): ?>
            <a href="movie-detail.php?id=<?php echo $movie->getId(); ?>" class="movie-card">
                <img src="<?php echo $movie->getImagePath(); ?>" alt="<?php echo htmlspecialchars($movie->getTitle()); ?>">
                <div class="movie-info">
                    <h4><?php echo htmlspecialchars($movie->getTitle()); ?></h4>
                    <span><?php echo $movie->getYear(); ?> • ★ <?php echo $movie->getRating(); ?></span>
                </div>
            </a>
            <?php endforeach; ?>
        </div>
    </section>
    <?php endif; ?>

    <?php if (!empty($dramaMovies)): ?>
    <section class="section" id="drama">
        <h3>Drama</h3>
        <div class="movies">
            <?php foreach ($dramaMovies as $movie): ?>
            <a href="movie-detail.php?id=<?php echo $movie->getId(); ?>" class="movie-card">
                <img src="<?php echo $movie->getImagePath(); ?>" alt="<?php echo htmlspecialchars($movie->getTitle()); ?>">
                <div class="movie-info">
                    <h4><?php echo htmlspecialchars($movie->getTitle()); ?></h4>
                    <span><?php echo $movie->getYear(); ?> • ★ <?php echo $movie->getRating(); ?></span>
                </div>
            </a>
            <?php endforeach; ?>
        </div>
    </section>
    <?php endif; ?>

    <?php if (!empty($sciFiMovies)): ?>
    <section class="section" id="sci-fi">
        <h3>Sci-Fi</h3>
        <div class="movies">
            <?php foreach ($sciFiMovies as $movie): ?>
            <a href="movie-detail.php?id=<?php echo $movie->getId(); ?>" class="movie-card">
                <img src="<?php echo $movie->getImagePath(); ?>" alt="<?php echo htmlspecialchars($movie->getTitle()); ?>">
                <div class="movie-info">
                    <h4><?php echo htmlspecialchars($movie->getTitle()); ?></h4>
                    <span><?php echo $movie->getYear(); ?> • ★ <?php echo $movie->getRating(); ?></span>
                </div>
            </a>
            <?php endforeach; ?>
        </div>
    </section>
    <?php endif; ?>

    <?php include 'includes/footer.php'; ?>

    <script>
        let currentSlideIndex = 0;
        const slides = document.querySelectorAll('.slide');
        const dots = document.querySelectorAll('.dot');
        const totalSlides = slides.length;

        function showSlide(index) {
            if (index >= totalSlides) currentSlideIndex = 0;
            else if (index < 0) currentSlideIndex = totalSlides - 1;
            else currentSlideIndex = index;

            slides.forEach(slide => slide.classList.remove('active'));
            dots.forEach(dot => dot.classList.remove('active'));

            slides[currentSlideIndex].classList.add('active');
            dots[currentSlideIndex].classList.add('active');
        }

        function changeSlide(direction) {
            showSlide(currentSlideIndex + direction);
        }

        function currentSlide(index) {
            showSlide(index);
        }

        setInterval(() => {
            changeSlide(1);
        }, 5000);
    </script>
</body>
</html>
