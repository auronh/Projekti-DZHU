<?php
interface IMovieRepository {
    public function create(Movie $movie);
    public function findById($id);
    public function getAll();
    public function getByCategory($category);
    public function search($keyword);
    public function update(Movie $movie);
    public function delete($id);
    public function getLatest($limit = 10);
}
?>
