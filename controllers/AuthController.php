<?php
class AuthController {
    private $userRepository;

    public function __construct() {
        $this->userRepository = new UserRepository();
    }

    public function register($data) {
        $errors = [];

        if (empty($data['username'])) {
            $errors[] = "Username is required";
        } elseif (strlen($data['username']) < 3) {
            $errors[] = "Username must be at least 3 characters";
        }

        if (empty($data['email'])) {
            $errors[] = "Email is required";
        } elseif (!isValidEmail($data['email'])) {
            $errors[] = "Invalid email format";
        }

        if (empty($data['password'])) {
            $errors[] = "Password is required";
        } elseif (strlen($data['password']) < 6) {
            $errors[] = "Password must be at least 6 characters";
        }

        if (empty($data['confirm_password'])) {
            $errors[] = "Please confirm your password";
        } elseif ($data['password'] !== $data['confirm_password']) {
            $errors[] = "Passwords do not match";
        }

        if (empty($errors) && $this->userRepository->findByUsername($data['username'])) {
            $errors[] = "Username already exists";
        }

        if (empty($errors) && $this->userRepository->findByEmail($data['email'])) {
            $errors[] = "Email already registered";
        }

        if (!empty($errors)) {
            return ['success' => false, 'errors' => $errors];
        }

        $user = new User();
        $user->setUsername(sanitize($data['username']));
        $user->setEmail(sanitize($data['email']));
        $user->hashPassword($data['password']);
        $user->setRole('user');

        if ($this->userRepository->create($user)) {
            return ['success' => true, 'message' => 'Registration successful! Please login.'];
        }

        return ['success' => false, 'errors' => ['Registration failed. Please try again.']];
    }

    public function login($data) {
        $errors = [];

        if (empty($data['email'])) {
            $errors[] = "Email is required";
        }

        if (empty($data['password'])) {
            $errors[] = "Password is required";
        }

        if (!empty($errors)) {
            return ['success' => false, 'errors' => $errors];
        }

        $user = $this->userRepository->findByEmail($data['email']);

        if (!$user) {
            return ['success' => false, 'errors' => ['Invalid email or password']];
        }

        if (!$user->verifyPassword($data['password'])) {
            return ['success' => false, 'errors' => ['Invalid email or password']];
        }

        $_SESSION['user_id'] = $user->getId();
        $_SESSION['username'] = $user->getUsername();
        $_SESSION['email'] = $user->getEmail();
        $_SESSION['role'] = $user->getRole();

        return ['success' => true, 'role' => $user->getRole()];
    }

    public function logout() {
        session_destroy();
        redirect('../public/index.php');
    }

    public function isAuthenticated() {
        return isset($_SESSION['user_id']);
    }

    public function requireAuth() {
        if (!$this->isAuthenticated()) {
            redirect('../views/public/login.php');
        }
    }

    public function requireAdmin() {
        $this->requireAuth();
        if (!isAdmin()) {
            redirect('../views/public/index.php');
        }
    }
}
?>
