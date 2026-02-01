<?php 
require_once '../../config/config.php';
$movieController = new MovieController();
$totalMovies = count($movieController->getAllMovies());
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>About Us - <?php echo SITE_NAME; ?></title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="../../assets/css/style.css">
    <style>
        .about-hero {
            height: 60vh;
            background: linear-gradient(135deg, rgba(15, 23, 42, 0.95), rgba(30, 41, 59, 0.95)),
                        url('https://images.unsplash.com/photo-1489599849927-2ee91cede3ba?w=1920') center/cover;
            display: flex;
            align-items: center;
            justify-content: center;
            text-align: center;
            position: relative;
            overflow: hidden;
        }

        .about-hero::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: linear-gradient(45deg, var(--accent) 0%, transparent 50%, #f59e0b 100%);
            opacity: 0.1;
            animation: gradientMove 15s ease infinite;
        }

        @keyframes gradientMove {
            0%, 100% { transform: translateX(-50%) translateY(-50%) rotate(0deg); }
            50% { transform: translateX(50%) translateY(50%) rotate(180deg); }
        }

        .about-hero-content {
            position: relative;
            z-index: 2;
            max-width: 800px;
            padding: 20px;
        }

.about-hero h1 {
    font-size: 4rem;
    font-weight: 800;
    margin-bottom: 20px;
    color: #fff;  /* Changed from gradient */
    text-shadow: 0 0 30px rgba(239, 68, 68, 0.5);
    animation: fadeInUp 1s ease;
}



        .about-hero p {
            font-size: 1.3rem;
            color: var(--muted);
            animation: fadeInUp 1s ease 0.2s both;
        }

        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .stats-section {
            background: var(--card);
            padding: 80px 40px;
            position: relative;
        }

        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 40px;
            max-width: 1200px;
            margin: 0 auto;
        }

        .stat-item {
            text-align: center;
            padding: 40px 20px;
            background: rgba(15, 23, 42, 0.5);
            border-radius: 20px;
            border: 2px solid transparent;
            transition: all 0.4s ease;
            position: relative;
            overflow: hidden;
        }

        .stat-item::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(239, 68, 68, 0.1), transparent);
            transition: left 0.6s;
        }

        .stat-item:hover::before {
            left: 100%;
        }

        .stat-item:hover {
            border-color: var(--accent);
            transform: translateY(-10px);
            box-shadow: 0 20px 40px rgba(239, 68, 68, 0.2);
        }

        .stat-number {
            font-size: 3.5rem;
            font-weight: 800;
            color: var(--accent);
            margin-bottom: 10px;
            display: block;
        }

        .stat-label {
            font-size: 1.1rem;
            color: var(--text);
            text-transform: uppercase;
            letter-spacing: 1px;
        }

        .story-section {
            padding: 100px 40px;
            max-width: 1200px;
            margin: 0 auto;
        }

        .story-content {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 60px;
            align-items: center;
            margin-bottom: 80px;
        }

        .story-content.reverse {
            direction: rtl;
        }

        .story-content.reverse > * {
            direction: ltr;
        }

        .story-text h2 {
            font-size: 2.5rem;
            margin-bottom: 20px;
            color: var(--text);
        }

.story-text h2 span {
    color: var(--accent);
    text-shadow: 0 0 20px rgba(239, 68, 68, 0.3);
}

        .story-text p {
            font-size: 1.1rem;
            line-height: 1.8;
            color: var(--muted);
            margin-bottom: 15px;
        }

        .story-image {
            border-radius: 20px;
            overflow: hidden;
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.4);
            position: relative;
        }

        .story-image img {
            width: 100%;
            height: 400px;
            object-fit: cover;
            transition: transform 0.5s ease;
        }

        .story-image:hover img {
            transform: scale(1.1);
        }

        .story-image::after {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: linear-gradient(135deg, rgba(239, 68, 68, 0.3), transparent);
            opacity: 0;
            transition: opacity 0.5s;
        }

        .story-image:hover::after {
            opacity: 1;
        }

        .features-section {
            background: var(--card);
            padding: 80px 40px;
        }

        .features-section h2 {
            text-align: center;
            font-size: 3rem;
            margin-bottom: 60px;
            color: var(--text);
        }

        .features-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 30px;
            max-width: 1200px;
            margin: 0 auto;
        }

        .feature-card {
            background: rgba(15, 23, 42, 0.5);
            padding: 40px 30px;
            border-radius: 20px;
            text-align: center;
            transition: all 0.4s ease;
            border: 2px solid transparent;
            position: relative;
            overflow: hidden;
        }

        .feature-card::before {
            content: '';
            position: absolute;
            top: -50%;
            left: -50%;
            width: 200%;
            height: 200%;
            background: linear-gradient(45deg, transparent, rgba(239, 68, 68, 0.1), transparent);
            transform: rotate(45deg);
            transition: all 0.6s;
        }

        .feature-card:hover::before {
            left: 100%;
        }

        .feature-card:hover {
            border-color: var(--accent);
            transform: translateY(-10px);
            box-shadow: 0 15px 40px rgba(239, 68, 68, 0.3);
        }

        .feature-icon {
            font-size: 3.5rem;
            margin-bottom: 20px;
            display: inline-block;
            transition: transform 0.4s;
        }

        .feature-card:hover .feature-icon {
            transform: scale(1.2) rotate(5deg);
        }

        .feature-card h3 {
            font-size: 1.5rem;
            margin-bottom: 15px;
            color: var(--text);
        }

        .feature-card p {
            color: var(--muted);
            line-height: 1.6;
        }

        .team-section {
            padding: 100px 40px;
            max-width: 1200px;
            margin: 0 auto;
        }

        .team-section h2 {
            text-align: center;
            font-size: 3rem;
            margin-bottom: 20px;
            color: var(--text);
        }

        .team-section .subtitle {
            text-align: center;
            color: var(--muted);
            font-size: 1.2rem;
            margin-bottom: 60px;
        }

        .team-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 40px;
        }

        .team-member {
            text-align: center;
            transition: transform 0.3s;
        }

        .team-member:hover {
            transform: translateY(-10px);
        }

        .team-member-image {
            width: 200px;
            height: 200px;
            border-radius: 50%;
            margin: 0 auto 20px;
            overflow: hidden;
            border: 4px solid var(--accent);
            position: relative;
        }

        .team-member-image img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            filter: grayscale(100%);
            transition: filter 0.4s;
        }

        .team-member:hover .team-member-image img {
            filter: grayscale(0%);
        }

        .team-member h4 {
            font-size: 1.3rem;
            margin-bottom: 5px;
            color: var(--text);
        }

        .team-member .role {
            color: var(--accent);
            font-size: 0.95rem;
            margin-bottom: 10px;
        }

        .team-member p {
            color: var(--muted);
            font-size: 0.9rem;
        }

        .values-section {
            background: linear-gradient(135deg, var(--card), rgba(15, 23, 42, 0.8));
            padding: 80px 40px;
        }

        .values-section h2 {
            text-align: center;
            font-size: 3rem;
            margin-bottom: 60px;
            color: var(--text);
        }

        .values-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
            gap: 30px;
            max-width: 1200px;
            margin: 0 auto;
        }

        .value-card {
            background: rgba(15, 23, 42, 0.6);
            padding: 40px;
            border-radius: 20px;
            border-left: 4px solid var(--accent);
            transition: all 0.3s;
        }

        .value-card:hover {
            background: rgba(15, 23, 42, 0.9);
            transform: translateX(10px);
            box-shadow: -10px 0 30px rgba(239, 68, 68, 0.3);
        }

        .value-card h3 {
            font-size: 1.5rem;
            margin-bottom: 15px;
            color: var(--accent);
        }

        .value-card p {
            color: var(--muted);
            line-height: 1.7;
        }

        .cta-section {
            padding: 100px 40px;
            text-align: center;
            background: linear-gradient(135deg, rgba(239, 68, 68, 0.1), rgba(245, 158, 11, 0.1));
        }

        .cta-section h2 {
            font-size: 3rem;
            margin-bottom: 20px;
            color: var(--text);
        }

        .cta-section p {
            font-size: 1.2rem;
            color: var(--muted);
            margin-bottom: 40px;
            max-width: 600px;
            margin-left: auto;
            margin-right: auto;
        }

        .cta-buttons {
            display: flex;
            gap: 20px;
            justify-content: center;
            flex-wrap: wrap;
        }

        .cta-btn {
            padding: 18px 40px;
            border-radius: 12px;
            font-size: 1.1rem;
            font-weight: 600;
            text-decoration: none;
            transition: all 0.3s;
            text-transform: uppercase;
            letter-spacing: 1px;
        }

        .cta-btn-primary {
            background: linear-gradient(135deg, var(--accent), #dc2626);
            color: white;
            box-shadow: 0 10px 30px rgba(239, 68, 68, 0.3);
        }

        .cta-btn-primary:hover {
            transform: translateY(-5px);
            box-shadow: 0 15px 40px rgba(239, 68, 68, 0.5);
        }

        .cta-btn-secondary {
            background: transparent;
            color: var(--text);
            border: 2px solid var(--text);
        }

        .cta-btn-secondary:hover {
            background: var(--text);
            color: var(--bg);
        }

        @media (max-width: 768px) {
            .about-hero h1 {
                font-size: 2.5rem;
            }

            .about-hero p {
                font-size: 1rem;
            }

            .story-content {
                grid-template-columns: 1fr;
                gap: 40px;
            }

            .story-content.reverse {
                direction: ltr;
            }

            .stats-grid {
                grid-template-columns: 1fr;
            }

            .features-grid {
                grid-template-columns: 1fr;
            }

            .team-grid {
                grid-template-columns: 1fr;
            }

            .values-grid {
                grid-template-columns: 1fr;
            }

            .cta-section h2 {
                font-size: 2rem;
            }

            .cta-buttons {
                flex-direction: column;
                align-items: center;
            }

            .cta-btn {
                width: 100%;
                max-width: 300px;
            }
        }
    </style>
</head>
<body>
    <?php include 'includes/header.php'; ?>

    <section class="about-hero">
        <div class="about-hero-content">
            <h1>About AlbFlix</h1>
            <p>Your premier destination for discovering and enjoying the best movies from around the world.</p>
        </div>
    </section>

    <section class="stats-section">
        <div class="stats-grid">
            <div class="stat-item">
                <span class="stat-number"><?php echo $totalMovies; ?>+</span>
                <span class="stat-label">Movies Available</span>
            </div>
            <div class="stat-item">
                <span class="stat-number">50K+</span>
                <span class="stat-label">Active Users</span>
            </div>
            <div class="stat-item">
                <span class="stat-number">24/7</span>
                <span class="stat-label">Streaming Access</span>
            </div>
            <div class="stat-item">
                <span class="stat-number">4.8★</span>
                <span class="stat-label">User Rating</span>
            </div>
        </div>
    </section>

    <section class="story-section">
        <div class="story-content">
            <div class="story-text">
                <h2>Our <span>Story</span></h2>
                <p>AlbFlix was born from a simple idea: everyone deserves access to great entertainment. Founded in 2020, we started with a vision to create a platform that brings people together through the power of storytelling.</p>
                <p>What began as a small collection of classic films has grown into a comprehensive library spanning every genre imaginable. We believe that movies are more than just entertainment—they're a window into different cultures, perspectives, and experiences.</p>
                <p>Today, we're proud to serve thousands of movie enthusiasts who share our passion for cinema.</p>
            </div>
            <div class="story-image">
                <img src="https://images.unsplash.com/photo-1524985069026-dd778a71c7b4?w=800" alt="Our Story">
            </div>
        </div>

        <div class="story-content reverse">
            <div class="story-text">
                <h2>Our <span>Mission</span></h2>
                <p>To bring entertainment to everyone, everywhere. We believe in the power of storytelling and its ability to connect people across cultures, languages, and borders.</p>
                <p>We're committed to curating a diverse collection that represents voices from all corners of the globe. From Hollywood blockbusters to independent gems, from timeless classics to contemporary masterpieces—we celebrate all forms of cinematic expression.</p>
                <p>Our mission extends beyond just providing content. We aim to create a community where movie lovers can discover, discuss, and share their passion for film.</p>
            </div>
            <div class="story-image">
                <img src="https://images.unsplash.com/photo-1478720568477-152d9b164e26?w=800" alt="Our Mission">
            </div>
        </div>
    </section>

    <section class="features-section">
        <h2>Why Choose AlbFlix?</h2>
        <div class="features-grid">
            <div class="feature-card">
                <div class="feature-icon">🎬</div>
                <h3>Vast Library</h3>
                <p>Access thousands of movies across all genres. From action-packed thrillers to heartwarming dramas, we have something for everyone.</p>
            </div>
            <div class="feature-card">
                <div class="feature-icon">⚡</div>
                <h3>High Quality</h3>
                <p>Enjoy crystal-clear streaming in HD. Every frame, every detail, exactly as the filmmakers intended.</p>
            </div>
            <div class="feature-card">
                <div class="feature-icon">🔄</div>
                <h3>Regular Updates</h3>
                <p>New movies added weekly. Stay current with the latest releases and rediscover forgotten classics.</p>
            </div>
            <div class="feature-card">
                <div class="feature-icon">📱</div>
                <h3>Multi-Device</h3>
                <p>Watch on any device—phone, tablet, or desktop. Your entertainment goes wherever you go.</p>
            </div>
            <div class="feature-card">
                <div class="feature-icon">🌍</div>
                <h3>Global Content</h3>
                <p>Discover films from around the world. Experience different cultures through the universal language of cinema.</p>
            </div>
            <div class="feature-card">
                <div class="feature-icon">💬</div>
                <h3>Community</h3>
                <p>Join a community of passionate movie lovers. Share reviews, recommendations, and discussions.</p>
            </div>
        </div>
    </section>

    <section class="values-section">
        <h2>Our Core Values</h2>
        <div class="values-grid">
            <div class="value-card">
                <h3>Quality First</h3>
                <p>We never compromise on quality. Every movie in our library is carefully selected and presented in the best possible format.</p>
            </div>
            <div class="value-card">
                <h3>User-Centric</h3>
                <p>Your experience matters. We continuously improve our platform based on user feedback and needs.</p>
            </div>
            <div class="value-card">
                <h3>Diversity & Inclusion</h3>
                <p>We celebrate diverse voices and stories. Our collection represents cultures, perspectives, and experiences from around the globe.</p>
            </div>
            <div class="value-card">
                <h3>Innovation</h3>
                <p>We embrace new technologies to enhance your viewing experience. From smart recommendations to seamless streaming, we're always evolving.</p>
            </div>
        </div>
    </section>

    <section class="team-section">
        <h2>Meet Our Team</h2>
        <p class="subtitle">Passionate individuals dedicated to bringing you the best movie experience</p>
        <div class="team-grid">
            <div class="team-member">
                <div class="team-member-image">
                    <img src="https://i.pravatar.cc/200?img=33" alt="Team Member">
                </div>
                <h4>Sarah Johnson</h4>
                <p class="role">CEO & Founder</p>
                <p>Visionary leader with 15+ years in digital entertainment</p>
            </div>
            <div class="team-member">
                <div class="team-member-image">
                    <img src="https://i.pravatar.cc/200?img=12" alt="Team Member">
                </div>
                <h4>Michael Chen</h4>
                <p class="role">Chief Technology Officer</p>
                <p>Tech innovator ensuring seamless streaming experience</p>
            </div>
            <div class="team-member">
                <div class="team-member-image">
                    <img src="https://i.pravatar.cc/200?img=45" alt="Team Member">
                </div>
                <h4>Emily Rodriguez</h4>
                <p class="role">Content Director</p>
                <p>Curator of our diverse film collection</p>
            </div>
            <div class="team-member">
                <div class="team-member-image">
                    <img src="https://i.pravatar.cc/200?img=52" alt="Team Member">
                </div>
                <h4>David Kim</h4>
                <p class="role">Head of User Experience</p>
                <p>Designing intuitive and delightful interactions</p>
            </div>
        </div>
    </section>

    <section class="cta-section">
        <h2>Ready to Start Your Journey?</h2>
        <p>Join thousands of movie enthusiasts and discover your next favorite film today.</p>
        <div class="cta-buttons">
            <a href="movies.php" class="cta-btn cta-btn-primary">Browse Movies</a>
            <a href="contact.php" class="cta-btn cta-btn-secondary">Contact Us</a>
        </div>
    </section>

    <?php include 'includes/footer.php'; ?>
</body>
</html>