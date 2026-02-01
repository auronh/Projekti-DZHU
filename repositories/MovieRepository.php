<?php
class MovieRepository implements IMovieRepository {
    private $connection;

    public function __construct() {
        $db = DatabaseConnection::getInstance();
        $this->connection = $db->getConnection();
    }

    public function create(Movie $movie) {
        try {
            $sql = "INSERT INTO movies (title, description, year, duration, rating, genre, category, 
                    image_path, pdf_path, created_by) 
                    VALUES (:title, :description, :year, :duration, :rating, :genre, :category, 
                    :image_path, :pdf_path, :created_by)";
            
            $stmt = $this->connection->prepare($sql);
            $result = $stmt->execute([
                ':title' => $movie->getTitle(),
                ':description' => $movie->getDescription(),
                ':year' => $movie->getYear(),
                ':duration' => $movie->getDuration(),
                ':rating' => $movie->getRating(),
                ':genre' => $movie->getGenre(),
                ':category' => $movie->getCategory(),
                ':image_path' => $movie->getImagePath(),
                ':pdf_path' => $movie->getPdfPath(),
                ':created_by' => $movie->getCreatedBy()
            ]);

            if ($result) {
                $movie->setId($this->connection->lastInsertId());
            }

            return $result;
        } catch (PDOException $e) {
            error_log("Error creating movie: " . $e->getMessage());
            return false;
        }
    }

    public function findById($id) {
        try {
            $sql = "SELECT m.*, u1.username as created_by_name, u2.username as updated_by_name
                    FROM movies m
                    LEFT JOIN users u1 ON m.created_by = u1.id
                    LEFT JOIN users u2 ON m.updated_by = u2.id
                    WHERE m.id = :id";
            
            $stmt = $this->connection->prepare($sql);
            $stmt->execute([':id' => $id]);
            
            $data = $stmt->fetch();
            return $data ? $this->mapToMovie($data) : null;
        } catch (PDOException $e) {
            error_log("Error finding movie by ID: " . $e->getMessage());
            return null;
        }
    }

    public function getAll() {
        try {
            $sql = "SELECT m.*, u1.username as created_by_name, u2.username as updated_by_name
                    FROM movies m
                    LEFT JOIN users u1 ON m.created_by = u1.id
                    LEFT JOIN users u2 ON m.updated_by = u2.id
                    ORDER BY m.created_at DESC";
            
            $stmt = $this->connection->query($sql);
            
            $movies = [];
            while ($data = $stmt->fetch()) {
                $movies[] = $this->mapToMovie($data);
            }
            return $movies;
        } catch (PDOException $e) {
            error_log("Error getting all movies: " . $e->getMessage());
            return [];
        }
    }

    public function getByCategory($category) {
        try {
            $sql = "SELECT m.*, u1.username as created_by_name, u2.username as updated_by_name
                    FROM movies m
                    LEFT JOIN users u1 ON m.created_by = u1.id
                    LEFT JOIN users u2 ON m.updated_by = u2.id
                    WHERE m.category = :category
                    ORDER BY m.rating DESC, m.created_at DESC";
            
            $stmt = $this->connection->prepare($sql);
            $stmt->execute([':category' => $category]);
            
            $movies = [];
            while ($data = $stmt->fetch()) {
                $movies[] = $this->mapToMovie($data);
            }
            return $movies;
        } catch (PDOException $e) {
            error_log("Error getting movies by category: " . $e->getMessage());
            return [];
        }
    }

    public function search($keyword) {
        try {
            $searchTerm = "%{$keyword}%";
            
            $sql = "SELECT m.*, u1.username as created_by_name, u2.username as updated_by_name
                    FROM movies m
                    LEFT JOIN users u1 ON m.created_by = u1.id
                    LEFT JOIN users u2 ON m.updated_by = u2.id
                    WHERE m.title LIKE ? OR m.description LIKE ? OR m.genre LIKE ?
                    ORDER BY m.rating DESC";
            
            $stmt = $this->connection->prepare($sql);
            $stmt->execute([$searchTerm, $searchTerm, $searchTerm]);
            
            $movies = [];
            while ($data = $stmt->fetch()) {
                $movies[] = $this->mapToMovie($data);
            }
            return $movies;
        } catch (PDOException $e) {
            error_log("Error searching movies: " . $e->getMessage());
            return [];
        }
    }

    public function update(Movie $movie) {
        try {
            $sql = "UPDATE movies 
                    SET title = :title, description = :description, year = :year, 
                        duration = :duration, rating = :rating, genre = :genre, 
                        category = :category, image_path = :image_path, pdf_path = :pdf_path,
                        updated_by = :updated_by
                    WHERE id = :id";
            
            $stmt = $this->connection->prepare($sql);
            return $stmt->execute([
                ':title' => $movie->getTitle(),
                ':description' => $movie->getDescription(),
                ':year' => $movie->getYear(),
                ':duration' => $movie->getDuration(),
                ':rating' => $movie->getRating(),
                ':genre' => $movie->getGenre(),
                ':category' => $movie->getCategory(),
                ':image_path' => $movie->getImagePath(),
                ':pdf_path' => $movie->getPdfPath(),
                ':updated_by' => $movie->getUpdatedBy(),
                ':id' => $movie->getId()
            ]);
        } catch (PDOException $e) {
            error_log("Error updating movie: " . $e->getMessage());
            return false;
        }
    }

    public function delete($id) {
        try {
            $movie = $this->findById($id);
            if ($movie) {
                if ($movie->getImagePath() && file_exists(MOVIE_UPLOAD_PATH . $movie->getImagePath())) {
                    unlink(MOVIE_UPLOAD_PATH . $movie->getImagePath());
                }
                if ($movie->getPdfPath() && file_exists(PDF_UPLOAD_PATH . $movie->getPdfPath())) {
                    unlink(PDF_UPLOAD_PATH . $movie->getPdfPath());
                }
            }

            $sql = "DELETE FROM movies WHERE id = :id";
            $stmt = $this->connection->prepare($sql);
            return $stmt->execute([':id' => $id]);
        } catch (PDOException $e) {
            error_log("Error deleting movie: " . $e->getMessage());
            return false;
        }
    }
    public function getLatest($limit = 10) {
        try {
            $sql = "SELECT m.*, u1.username as created_by_name, u2.username as updated_by_name
                    FROM movies m
                    LEFT JOIN users u1 ON m.created_by = u1.id
                    LEFT JOIN users u2 ON m.updated_by = u2.id
                    ORDER BY m.created_at DESC
                    LIMIT :limit";
            
            $stmt = $this->connection->prepare($sql);
            $stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
            $stmt->execute();
            
            $movies = [];
            while ($data = $stmt->fetch()) {
                $movies[] = $this->mapToMovie($data);
            }
            return $movies;
        } catch (PDOException $e) {
            error_log("Error getting latest movies: " . $e->getMessage());
            return [];
        }
    }

    private function mapToMovie($data) {
        $movie = new Movie(
            $data['id'],
            $data['title'],
            $data['description'],
            $data['year'],
            $data['duration'],
            $data['rating'],
            $data['genre'],
            $data['category'],
            $data['image_path'],
            $data['pdf_path']
        );
        $movie->setCreatedBy($data['created_by']);
        $movie->setUpdatedBy($data['updated_by']);
        $movie->setCreatedAt($data['created_at']);
        $movie->setUpdatedAt($data['updated_at']);
        return $movie;
    }
}
?>
