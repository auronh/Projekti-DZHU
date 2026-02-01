<?php
class UserRepository implements IUserRepository {
    private $connection;

    public function __construct() {
        $db = DatabaseConnection::getInstance();
        $this->connection = $db->getConnection();
    }

    public function create(User $user) {
        try {
            $sql = "INSERT INTO users (username, email, password, role) 
                    VALUES (:username, :email, :password, :role)";
            
            $stmt = $this->connection->prepare($sql);
            $result = $stmt->execute([
                ':username' => $user->getUsername(),
                ':email' => $user->getEmail(),
                ':password' => $user->getPassword(),
                ':role' => $user->getRole()
            ]);

            if ($result) {
                $user->setId($this->connection->lastInsertId());
            }

            return $result;
        } catch (PDOException $e) {
            error_log("Error creating user: " . $e->getMessage());
            return false;
        }
    }

    public function findById($id) {
        try {
            $sql = "SELECT * FROM users WHERE id = :id";
            $stmt = $this->connection->prepare($sql);
            $stmt->execute([':id' => $id]);
            
            $data = $stmt->fetch();
            return $data ? $this->mapToUser($data) : null;
        } catch (PDOException $e) {
            error_log("Error finding user by ID: " . $e->getMessage());
            return null;
        }
    }

    public function findByEmail($email) {
        try {
            $sql = "SELECT * FROM users WHERE email = :email";
            $stmt = $this->connection->prepare($sql);
            $stmt->execute([':email' => $email]);
            
            $data = $stmt->fetch();
            return $data ? $this->mapToUser($data) : null;
        } catch (PDOException $e) {
            error_log("Error finding user by email: " . $e->getMessage());
            return null;
        }
    }

    public function findByUsername($username) {
        try {
            $sql = "SELECT * FROM users WHERE username = :username";
            $stmt = $this->connection->prepare($sql);
            $stmt->execute([':username' => $username]);
            
            $data = $stmt->fetch();
            return $data ? $this->mapToUser($data) : null;
        } catch (PDOException $e) {
            error_log("Error finding user by username: " . $e->getMessage());
            return null;
        }
    }

    public function getAll() {
        try {
            $sql = "SELECT * FROM users ORDER BY created_at DESC";
            $stmt = $this->connection->query($sql);
            
            $users = [];
            while ($data = $stmt->fetch()) {
                $users[] = $this->mapToUser($data);
            }
            return $users;
        } catch (PDOException $e) {
            error_log("Error getting all users: " . $e->getMessage());
            return [];
        }
    }
    public function update(User $user) {
        try {
            $sql = "UPDATE users 
                    SET username = :username, email = :email, role = :role
                    WHERE id = :id";
            
            $stmt = $this->connection->prepare($sql);
            return $stmt->execute([
                ':username' => $user->getUsername(),
                ':email' => $user->getEmail(),
                ':role' => $user->getRole(),
                ':id' => $user->getId()
            ]);
        } catch (PDOException $e) {
            error_log("Error updating user: " . $e->getMessage());
            return false;
        }
    }

    public function delete($id) {
        try {
            $sql = "DELETE FROM users WHERE id = :id";
            $stmt = $this->connection->prepare($sql);
            return $stmt->execute([':id' => $id]);
        } catch (PDOException $e) {
            error_log("Error deleting user: " . $e->getMessage());
            return false;
        }
    }

    private function mapToUser($data) {
        $user = new User(
            $data['id'],
            $data['username'],
            $data['email'],
            $data['password'],
            $data['role']
        );
        $user->setCreatedAt($data['created_at']);
        $user->setUpdatedAt($data['updated_at']);
        return $user;
    }
}
?>
