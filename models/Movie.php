<?php
class Movie {
    private $id;
    private $title;
    private $description;
    private $year;
    private $duration;
    private $rating;
    private $genre;
    private $category;
    private $imagePath;
    private $pdfPath;
    private $createdBy;
    private $updatedBy;
    private $createdAt;
    private $updatedAt;

    public function __construct(
        $id = null,
        $title = '',
        $description = '',
        $year = null,
        $duration = null,
        $rating = 0.0,
        $genre = '',
        $category = '',
        $imagePath = '',
        $pdfPath = ''
    ) {
        $this->id = $id;
        $this->title = $title;
        $this->description = $description;
        $this->year = $year;
        $this->duration = $duration;
        $this->rating = $rating;
        $this->genre = $genre;
        $this->category = $category;
        $this->imagePath = $imagePath;
        $this->pdfPath = $pdfPath;
    }

    public function getId() {
        return $this->id;
    }

    public function getTitle() {
        return $this->title;
    }

    public function getDescription() {
        return $this->description;
    }

    public function getYear() {
        return $this->year;
    }

    public function getDuration() {
        return $this->duration;
    }

    public function getRating() {
        return $this->rating;
    }

    public function getGenre() {
        return $this->genre;
    }

    public function getCategory() {
        return $this->category;
    }

    public function getImagePath() {
        return $this->imagePath;
    }

    public function getPdfPath() {
        return $this->pdfPath;
    }

    public function getCreatedBy() {
        return $this->createdBy;
    }

    public function getUpdatedBy() {
        return $this->updatedBy;
    }

    public function getCreatedAt() {
        return $this->createdAt;
    }

    public function getUpdatedAt() {
        return $this->updatedAt;
    }

    public function setId($id) {
        $this->id = $id;
    }

    public function setTitle($title) {
        $this->title = $title;
    }

    public function setDescription($description) {
        $this->description = $description;
    }

    public function setYear($year) {
        $this->year = $year;
    }

    public function setDuration($duration) {
        $this->duration = $duration;
    }

    public function setRating($rating) {
        $this->rating = $rating;
    }

    public function setGenre($genre) {
        $this->genre = $genre;
    }

    public function setCategory($category) {
        $this->category = $category;
    }

    public function setImagePath($imagePath) {
        $this->imagePath = $imagePath;
    }

    public function setPdfPath($pdfPath) {
        $this->pdfPath = $pdfPath;
    }

    public function setCreatedBy($createdBy) {
        $this->createdBy = $createdBy;
    }

    public function setUpdatedBy($updatedBy) {
        $this->updatedBy = $updatedBy;
    }

    public function setCreatedAt($createdAt) {
        $this->createdAt = $createdAt;
    }

    public function setUpdatedAt($updatedAt) {
        $this->updatedAt = $updatedAt;
    }

    public function getFormattedDuration() {
        if (!$this->duration) return '';
        $hours = floor($this->duration / 60);
        $minutes = $this->duration % 60;
        return $hours > 0 ? "{$hours}h {$minutes}m" : "{$minutes}m";
    }

    public function toArray() {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'description' => $this->description,
            'year' => $this->year,
            'duration' => $this->duration,
            'rating' => $this->rating,
            'genre' => $this->genre,
            'category' => $this->category,
            'image_path' => $this->imagePath,
            'pdf_path' => $this->pdfPath,
            'created_by' => $this->createdBy,
            'updated_by' => $this->updatedBy,
            'created_at' => $this->createdAt,
            'updated_at' => $this->updatedAt
        ];
    }
}
?>
