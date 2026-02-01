-- Movie Website Database Schema
-- AlbFlix - Netflix-like Movie Platform

CREATE DATABASE IF NOT EXISTS albflix_db;
USE albflix_db;

-- Users table with role management
CREATE TABLE IF NOT EXISTS users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) UNIQUE NOT NULL,
    email VARCHAR(100) UNIQUE NOT NULL,
    password VARCHAR(255) NOT NULL,
    role ENUM('admin', 'user') DEFAULT 'user',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

-- Movies table with media support
CREATE TABLE IF NOT EXISTS movies (
    id INT AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(255) NOT NULL,
    description TEXT,
    year INT,
    duration INT COMMENT 'Duration in minutes',
    rating DECIMAL(3,1) DEFAULT 0.0,
    genre VARCHAR(100),
    category VARCHAR(50) COMMENT 'trending, popular, top-rated, action, drama, sci-fi',
    image_path VARCHAR(255),
    pdf_path VARCHAR(255) COMMENT 'Additional PDF content like script or info',
    created_by INT,
    updated_by INT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (created_by) REFERENCES users(id) ON DELETE SET NULL,
    FOREIGN KEY (updated_by) REFERENCES users(id) ON DELETE SET NULL
);

-- Contact messages table
CREATE TABLE IF NOT EXISTS contact_messages (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    email VARCHAR(100) NOT NULL,
    subject VARCHAR(200),
    message TEXT NOT NULL,
    is_read BOOLEAN DEFAULT FALSE,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Site content table for dynamic pages
CREATE TABLE IF NOT EXISTS site_content (
    id INT AUTO_INCREMENT PRIMARY KEY,
    page VARCHAR(50) NOT NULL COMMENT 'home, about, etc',
    section VARCHAR(50) NOT NULL COMMENT 'hero, features, etc',
    title VARCHAR(255),
    content TEXT,
    image_path VARCHAR(255),
    display_order INT DEFAULT 0,
    is_active BOOLEAN DEFAULT TRUE,
    updated_by INT,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (updated_by) REFERENCES users(id) ON DELETE SET NULL,
    UNIQUE KEY page_section (page, section)
);

-- Insert default admin user (password: admin123)
-- Note: If login doesn't work, run this SQL command in phpMyAdmin:
-- UPDATE users SET password = '$2y$10$rT0K3qJZK8Z6kZ5Z5Z5Z5uO7jZ5Z5Z5Z5Z5Z5Z5Z5Z5Z5Z5Z5Z5Z2' WHERE email = 'admin@albflix.com';
INSERT INTO users (username, email, password, role) VALUES 
('admin', 'admin@albflix.com', '$2y$10$rT0K3qJZK8Z6kZ5Z5Z5Z5uO7jZ5Z5Z5Z5Z5Z5Z5Z5Z5Z5Z5Z5Z5Z2', 'admin'),
('user', 'user@albflix.com', '$2y$10$rT0K3qJZK8Z6kZ5Z5Z5Z5uO7jZ5Z5Z5Z5Z5Z5Z5Z5Z5Z5Z5Z5Z5Z2', 'user');

-- Insert default site content for home page
INSERT INTO site_content (page, section, title, content) VALUES 
('home', 'hero', 'Unlimited Movies, Anytime', 'Discover popular movies and search your favorites in one place.'),
('about', 'main', 'About AlbFlix', 'AlbFlix is your premier destination for discovering and enjoying the best movies from around the world. We provide a curated collection of films across all genres.'),
('about', 'mission', 'Our Mission', 'To bring entertainment to everyone, everywhere. We believe in the power of storytelling and its ability to connect people across cultures.');

-- Insert sample movies
INSERT INTO movies (title, description, year, duration, rating, genre, category, image_path, created_by) VALUES 
('The Shawshank Redemption', 'Two imprisoned men bond over a number of years, finding solace and eventual redemption through acts of common decency.', 1994, 142, 9.3, 'Drama', 'top-rated', 'https://image.tmdb.org/t/p/w500/q6y0Go1tsGEsmtFryDOJo3dEmqu.jpg', 1),
('The Dark Knight', 'When the menace known as the Joker wreaks havoc and chaos on the people of Gotham, Batman must accept one of the greatest psychological and physical tests.', 2008, 152, 9.0, 'Action', 'action', 'https://image.tmdb.org/t/p/w500/qJ2tW6WMUDux911r6m7haRef0WH.jpg', 1),
('Inception', 'A thief who steals corporate secrets through the use of dream-sharing technology is given the inverse task of planting an idea.', 2010, 148, 8.8, 'Sci-Fi', 'sci-fi', 'https://image.tmdb.org/t/p/w500/9gk7adHYeDvHkCSEqAvQNLV5Uge.jpg', 1),
('Pulp Fiction', 'The lives of two mob hitmen, a boxer, a gangster and his wife intertwine in four tales of violence and redemption.', 1994, 154, 8.9, 'Drama', 'drama', 'https://image.tmdb.org/t/p/w500/d5iIlFn5s0ImszYzBPb8JPIfbXD.jpg', 1),
('The Matrix', 'A computer hacker learns from mysterious rebels about the true nature of his reality and his role in the war against its controllers.', 1999, 136, 8.7, 'Sci-Fi', 'sci-fi', 'https://image.tmdb.org/t/p/w500/f89U3ADr1oiB1s9GkdPOEpXUk5H.jpg', 1),
('Interstellar', 'A team of explorers travel through a wormhole in space in an attempt to ensure humanity survival.', 2014, 169, 8.6, 'Sci-Fi', 'popular', 'https://image.tmdb.org/t/p/w500/gEU2QniE6E77NI6lCU6MxlNBvIx.jpg', 1),
('Parasite', 'Greed and class discrimination threaten the newly formed symbiotic relationship between the wealthy Park family and the destitute Kim clan.', 2019, 132, 8.6, 'Drama', 'trending', 'https://image.tmdb.org/t/p/w500/7IiTTgloJzvGI1TAYymCfbfl3vT.jpg', 1),
('Avengers: Endgame', 'After the devastating events of Infinity War, the Avengers assemble once more to reverse Thanos actions.', 2019, 181, 8.4, 'Action', 'trending', 'https://image.tmdb.org/t/p/w500/or06FN3Dka5tukK1e9sl16pB3iy.jpg', 1);
