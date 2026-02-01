<?php
interface IUserRepository {
    public function create(User $user);
    public function findById($id);
    public function findByEmail($email);
    public function findByUsername($username);
    public function getAll();
    public function update(User $user);
    public function delete($id);
}
?>
