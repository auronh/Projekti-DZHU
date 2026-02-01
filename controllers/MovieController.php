<?php
class MovieController {
    private $movieRepository;

    public function __construct() {
        $this->movieRepository = new MovieRepository();
    }

    public function getAllMovies() {
        return $this->movieRepository->getAll();
    }

    public function getMoviesByCategory($category) {
        return $this->movieRepository->getByCategory($category);
    }

    public function searchMovies($keyword) {
        return $this->movieRepository->search($keyword);
    }

    public function getMovieById($id) {
        return $this->movieRepository->findById($id);
    }

    public function createMovie($data, $files) {
        $errors = [];

        if (empty($data['title'])) {
            $errors[] = "Title is required";
        }

        if (empty($data['description'])) {
            $errors[] = "Description is required";
        }

        if (empty($data['year']) || !is_numeric($data['year'])) {
            $errors[] = "Valid year is required";
        }

        if (empty($data['genre'])) {
            $errors[] = "Genre is required";
        }

        if (empty($data['category'])) {
            $errors[] = "Category is required";
        }

        $imagePath = '';
        if (isset($files['image']) && $files['image']['error'] === 0) {
            $uploadResult = $this->uploadImage($files['image']);
            if ($uploadResult['success']) {
                $imagePath = $uploadResult['filename'];
            } else {
                $errors[] = $uploadResult['error'];
            }
        }

        $pdfPath = '';
        if (isset($files['pdf']) && $files['pdf']['error'] === 0) {
            $uploadResult = $this->uploadPDF($files['pdf']);
            if ($uploadResult['success']) {
                $pdfPath = $uploadResult['filename'];
            } else {
                $errors[] = $uploadResult['error'];
            }
        }

        if (!empty($errors)) {
            return ['success' => false, 'errors' => $errors];
        }

        $movie = new Movie();
        $movie->setTitle(sanitize($data['title']));
        $movie->setDescription(sanitize($data['description']));
        $movie->setYear((int)$data['year']);
        $movie->setDuration(isset($data['duration']) ? (int)$data['duration'] : null);
        $movie->setRating(isset($data['rating']) ? (float)$data['rating'] : 0.0);
        $movie->setGenre(sanitize($data['genre']));
        $movie->setCategory(sanitize($data['category']));
        $movie->setImagePath($imagePath);
        $movie->setPdfPath($pdfPath);
        $movie->setCreatedBy($_SESSION['user_id']);

        if ($this->movieRepository->create($movie)) {
            return ['success' => true, 'message' => 'Movie created successfully!'];
        }

        return ['success' => false, 'errors' => ['Failed to create movie']];
    }

    public function updateMovie($data, $files) {
        $errors = [];

        if (empty($data['id'])) {
            return ['success' => false, 'errors' => ['Movie ID is required']];
        }

        $movie = $this->movieRepository->findById($data['id']);
        if (!$movie) {
            return ['success' => false, 'errors' => ['Movie not found']];
        }

        if (empty($data['title'])) {
            $errors[] = "Title is required";
        }

        if (!empty($errors)) {
            return ['success' => false, 'errors' => $errors];
        }

        $movie->setTitle(sanitize($data['title']));
        $movie->setDescription(sanitize($data['description']));
        $movie->setYear((int)$data['year']);
        $movie->setDuration(isset($data['duration']) ? (int)$data['duration'] : null);
        $movie->setRating(isset($data['rating']) ? (float)$data['rating'] : 0.0);
        $movie->setGenre(sanitize($data['genre']));
        $movie->setCategory(sanitize($data['category']));
        $movie->setUpdatedBy($_SESSION['user_id']);

        if (isset($files['image']) && $files['image']['error'] === 0) {
            $uploadResult = $this->uploadImage($files['image']);
            if ($uploadResult['success']) {
                if ($movie->getImagePath() && file_exists(MOVIE_UPLOAD_PATH . $movie->getImagePath())) {
                    unlink(MOVIE_UPLOAD_PATH . $movie->getImagePath());
                }
                $movie->setImagePath($uploadResult['filename']);
            }
        }

        if (isset($files['pdf']) && $files['pdf']['error'] === 0) {
            $uploadResult = $this->uploadPDF($files['pdf']);
            if ($uploadResult['success']) {
                if ($movie->getPdfPath() && file_exists(PDF_UPLOAD_PATH . $movie->getPdfPath())) {
                    unlink(PDF_UPLOAD_PATH . $movie->getPdfPath());
                }
                $movie->setPdfPath($uploadResult['filename']);
            }
        }

        if ($this->movieRepository->update($movie)) {
            return ['success' => true, 'message' => 'Movie updated successfully!'];
        }

        return ['success' => false, 'errors' => ['Failed to update movie']];
    }

    public function deleteMovie($id) {
        if ($this->movieRepository->delete($id)) {
            return ['success' => true, 'message' => 'Movie deleted successfully!'];
        }
        return ['success' => false, 'errors' => ['Failed to delete movie']];
    }

    private function uploadImage($file) {
        if (!in_array($file['type'], ALLOWED_IMAGE_TYPES)) {
            return ['success' => false, 'error' => 'Invalid image type. Allowed: JPG, PNG, GIF, WEBP'];
        }

        if ($file['size'] > MAX_FILE_SIZE) {
            return ['success' => false, 'error' => 'Image size exceeds 5MB limit'];
        }

        $extension = pathinfo($file['name'], PATHINFO_EXTENSION);
        $filename = uniqid('movie_') . '.' . $extension;
        $targetPath = MOVIE_UPLOAD_PATH . $filename;

        if (move_uploaded_file($file['tmp_name'], $targetPath)) {
            return ['success' => true, 'filename' => $filename];
        }

        return ['success' => false, 'error' => 'Failed to upload image'];
    }

    private function uploadPDF($file) {
        if (!in_array($file['type'], ALLOWED_PDF_TYPES)) {
            return ['success' => false, 'error' => 'Invalid file type. Only PDF allowed'];
        }

        if ($file['size'] > MAX_FILE_SIZE) {
            return ['success' => false, 'error' => 'PDF size exceeds 5MB limit'];
        }

        $filename = uniqid('pdf_') . '.pdf';
        $targetPath = PDF_UPLOAD_PATH . $filename;

        if (move_uploaded_file($file['tmp_name'], $targetPath)) {
            return ['success' => true, 'filename' => $filename];
        }

        return ['success' => false, 'error' => 'Failed to upload PDF'];
    }
}
?>
