<?php
require_once '../../config/config.php';
$movieController = new MovieController();
$search = isset($_GET['search']) ? sanitize($_GET['search']) : '';

if ($search) {
    $movies = $movieController->searchMovies($search);
} else {
    $movies = $movieController->getAllMovies();
}

$totalMovies = count($movies);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Movies - <?php echo SITE_NAME; ?></title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="../../assets/css/style.css">
    <style>
        .movies-header {
            background: linear-gradient(135deg, rgba(15, 23, 42, 0.95), rgba(30, 41, 59, 0.95));
            padding: 60px 40px 40px;
            text-align: center;
            position: relative;
            overflow: hidden;
        }

        .movies-header::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: radial-gradient(circle at 30% 50%, rgba(239, 68, 68, 0.1), transparent 50%);
            pointer-events: none;
        }

        .movies-header h2 {
            font-size: 3rem;
            margin-bottom: 15px;
            color: #fff;
            position: relative;
            z-index: 1;
        }

        .movies-header p {
            color: var(--muted);
            font-size: 1.1rem;
            margin-bottom: 30px;
            position: relative;
            z-index: 1;
        }

        .search-box {
            max-width: 600px;
            margin: 0 auto 30px;
            position: relative;
            z-index: 1;
        }

        .search-box form {
            position: relative;
        }

        .search-box input {
            width: 100%;
            padding: 18px 60px 18px 25px;
            border: 2px solid rgba(255, 255, 255, 0.2);
            border-radius: 50px;
            background: rgba(15, 23, 42, 0.6);
            backdrop-filter: blur(10px);
            color: var(--text);
            font-size: 1.05rem;
            transition: all 0.3s ease;
        }

        .search-box input:focus {
            outline: none;
            border-color: var(--accent);
            background: rgba(15, 23, 42, 0.9);
            box-shadow: 0 0 0 4px rgba(239, 68, 68, 0.1),
                        0 10px 30px rgba(0, 0, 0, 0.3);
            transform: translateY(-2px);
        }

        .search-box input::placeholder {
            color: var(--muted);
        }

        .search-icon {
            position: absolute;
            right: 25px;
            top: 50%;
            transform: translateY(-50%);
            font-size: 1.3rem;
            color: var(--muted);
            pointer-events: none;
        }

        .search-clear {
            position: absolute;
            right: 60px;
            top: 50%;
            transform: translateY(-50%);
            background: rgba(239, 68, 68, 0.2);
            border: none;
            color: var(--accent);
            width: 30px;
            height: 30px;
            border-radius: 50%;
            cursor: pointer;
            font-size: 1.1rem;
            display: none;
            align-items: center;
            justify-content: center;
            transition: all 0.3s;
        }

        .search-clear.visible {
            display: flex;
        }

        .search-clear:hover {
            background: var(--accent);
            color: white;
        }

        .results-info {
            text-align: center;
            color: var(--muted);
            margin-bottom: 30px;
            font-size: 1.05rem;
        }

        .results-info strong {
            color: var(--accent);
            font-size: 1.2rem;
        }

        .results-info a {
            color: var(--accent);
            text-decoration: none;
            font-weight: 600;
            margin-left: 15px;
            transition: opacity 0.3s;
        }

        .results-info a:hover {
            opacity: 0.7;
        }

        .section {
            padding: 40px;
            max-width: 1400px;
            margin: 0 auto;
        }

        .movies {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(220px, 1fr));
            gap: 30px;
        }

        .movie-card {
            background: var(--card);
            border-radius: 15px;
            overflow: hidden;
            transition: all 0.3s ease;
            text-decoration: none;
            display: block;
            position: relative;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.2);
        }

        .movie-card:hover {
            transform: translateY(-10px);
            box-shadow: 0 15px 40px rgba(239, 68, 68, 0.3);
        }

        .movie-card img {
            width: 100%;
            height: 330px;
            object-fit: cover;
            transition: transform 0.4s ease;
        }

        .movie-card:hover img {
            transform: scale(1.1);
        }

        .movie-info {
            padding: 18px;
            background: var(--card);
        }

        .movie-info h4 {
            margin-bottom: 8px;
            font-size: 1.1rem;
            color: var(--text);
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
            line-height: 1.4;
        }

        .movie-info span {
            color: var(--muted);
            font-size: 0.95rem;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .movie-rating {
            position: absolute;
            top: 12px;
            right: 12px;
            background: linear-gradient(135deg, var(--accent), #dc2626);
            color: white;
            padding: 6px 12px;
            border-radius: 20px;
            font-size: 0.85rem;
            font-weight: 700;
            box-shadow: 0 4px 12px rgba(239, 68, 68, 0.4);
            z-index: 2;
        }

        .play-overlay {
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: rgba(0, 0, 0, 0.7);
            display: flex;
            align-items: center;
            justify-content: center;
            opacity: 0;
            transition: opacity 0.3s;
            pointer-events: none;
        }

        .movie-card:hover .play-overlay {
            opacity: 1;
        }

        .play-icon {
            width: 60px;
            height: 60px;
            background: var(--accent);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.8rem;
            color: white;
            transform: scale(0.8);
            transition: transform 0.3s;
        }

        .movie-card:hover .play-icon {
            transform: scale(1);
        }

        .no-results {
            text-align: center;
            padding: 80px 20px;
            color: var(--muted);
        }

        .no-results-icon {
            font-size: 5rem;
            margin-bottom: 20px;
            opacity: 0.3;
        }

        .no-results h3 {
            font-size: 2rem;
            color: var(--text);
            margin-bottom: 15px;
        }

        .no-results p {
            font-size: 1.1rem;
            margin-bottom: 25px;
        }

        .no-results a {
            display: inline-block;
            padding: 14px 30px;
            background: var(--accent);
            color: white;
            text-decoration: none;
            border-radius: 25px;
            font-weight: 600;
            transition: all 0.3s;
        }

        .no-results a:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 25px rgba(239, 68, 68, 0.4);
        }

        .searching {
            opacity: 0.6;
            pointer-events: none;
        }

        @media (max-width: 768px) {
            .movies-header {
                padding: 40px 20px 30px;
            }

            .movies-header h2 {
                font-size: 2.2rem;
            }

            .movies {
                grid-template-columns: repeat(auto-fill, minmax(160px, 1fr));
                gap: 20px;
            }

            .section {
                padding: 30px 20px;
            }

            .search-box {
                margin-bottom: 20px;
            }

            .search-box input {
                padding: 16px 55px 16px 20px;
                font-size: 1rem;
            }
        }
    </style>
</head>
<body>
    <?php include 'includes/header.php'; ?>
    
    <div class="movies-header">
        <h2>Browse Movies</h2>
        <p>Discover your next favorite film</p>
        
        <div class="search-box">
            <form method="GET" action="movies.php" id="searchForm">
                <input 
                    type="text" 
                    name="search" 
                    id="searchInput"
                    placeholder="Search by title, genre, or description..." 
                    value="<?php echo htmlspecialchars($search); ?>"
                    autocomplete="off"
                >
                <button type="button" class="search-clear" id="clearBtn" onclick="clearSearch()">✕</button>
                <span class="search-icon">🔍</span>
            </form>
        </div>

        <?php if ($search): ?>
        <div class="results-info">
            Found <strong><?php echo $totalMovies; ?></strong> <?php echo $totalMovies === 1 ? 'movie' : 'movies'; ?> for "<strong><?php echo htmlspecialchars($search); ?></strong>"
            <a href="movies.php">Clear search</a>
        </div>
        <?php else: ?>
        <div class="results-info">
            Showing <strong><?php echo $totalMovies; ?></strong> movies
        </div>
        <?php endif; ?>
    </div>

    <section class="section">
        <?php if (empty($movies)): ?>
            <div class="no-results">
                <div class="no-results-icon">🎬</div>
                <h3>No Movies Found</h3>
                <p>Try a different search term or browse all movies</p>
                <a href="movies.php">View All Movies</a>
            </div>
        <?php else: ?>
            <div class="movies" id="moviesGrid">
                <?php foreach ($movies as $movie): ?>
                <a href="movie-detail.php?id=<?php echo $movie->getId(); ?>" class="movie-card">
                    <div style="position: relative; overflow: hidden;">
                        <img src="<?php echo $movie->getImagePath(); ?>" alt="<?php echo htmlspecialchars($movie->getTitle()); ?>" loading="lazy">
                        <div class="movie-rating">★ <?php echo $movie->getRating(); ?></div>
                        <div class="play-overlay">
                            <div class="play-icon">▶</div>
                        </div>
                    </div>
                    <div class="movie-info">
                        <h4><?php echo htmlspecialchars($movie->getTitle()); ?></h4>
                        <span><?php echo $movie->getYear(); ?> • <?php echo htmlspecialchars($movie->getGenre()); ?></span>
                    </div>
                </a>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
    </section>

    <?php include 'includes/footer.php'; ?>

    <script>
        const searchInput = document.getElementById('searchInput');
        const clearBtn = document.getElementById('clearBtn');
        const searchForm = document.getElementById('searchForm');
        const moviesGrid = document.getElementById('moviesGrid');
        let searchTimeout;

        function updateClearButton() {
            if (searchInput.value.length > 0) {
                clearBtn.classList.add('visible');
            } else {
                clearBtn.classList.remove('visible');
            }
        }

        function clearSearch() {
            searchInput.value = '';
            updateClearButton();
            window.location.href = 'movies.php';
        }

        searchInput.addEventListener('input', function() {
            updateClearButton();
            
            clearTimeout(searchTimeout);
            
            if (this.value.length === 0) {
                window.location.href = 'movies.php';
            } else if (this.value.length >= 2) {
                if (moviesGrid) {
                    moviesGrid.classList.add('searching');
                }
                
                searchTimeout = setTimeout(() => {
                    searchForm.submit();
                }, 600);
            }
        });

        searchInput.addEventListener('keypress', function(e) {
            if (e.key === 'Enter') {
                e.preventDefault();
                if (this.value.length >= 2) {
                    searchForm.submit();
                } else if (this.value.length === 0) {
                    window.location.href = 'movies.php';
                }
            }
        });

        updateClearButton();

        <?php if ($search): ?>
        const searchTerm = "<?php echo addslashes(htmlspecialchars($search)); ?>";
        if (searchTerm.length >= 2) {
            const titles = document.querySelectorAll('.movie-info h4');
            titles.forEach(title => {
                const regex = new RegExp(`(${searchTerm})`, 'gi');
                const text = title.textContent;
                const highlighted = text.replace(regex, '<mark style="background: var(--accent); color: white; padding: 2px 5px; border-radius: 3px;">$1</mark>');
                if (highlighted !== text) {
                    title.innerHTML = highlighted;
                }
            });
        }
        <?php endif; ?>
    </script>
</body>
</html>