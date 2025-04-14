<?php
require_once __DIR__ . '/../models/User.php';

class AuthController {
    private $userModel;

    public function __construct() {
        global $pdo;
        $this->userModel = new User($pdo);
    }

    public function login() {
        $title = 'Login';
        require_once __DIR__ . '/../views/auth/login.php';
    }

    public function authenticate() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $username = trim($_POST['username']);
            $password = $_POST['password'];
            
            $user = $this->userModel->verifyCredentials($username, $password);
            
            if ($user) {
                $_SESSION['user_id'] = $user['user_id'];
                $_SESSION['username'] = $user['username'];
                $_SESSION['role'] = $user['role'];
                $_SESSION['full_name'] = $user['full_name'];
                
                header('Location: ' . BASE_PATH . '/');
                exit;
            } else {
                $_SESSION['error'] = 'Invalid username or password';
                header('Location: ' . BASE_PATH . '/login');
                exit;
            }
        }
    }

    public function logout() {
        session_unset();
        session_destroy();
        header('Location: ' . BASE_PATH . '/login');
        exit;
    }
}
?>