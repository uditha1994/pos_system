<?php
require_once __DIR__ . '/../models/User.php';

class UserController
{
    private $userModel;

    public function __construct()
    {
        global $pdo;
        $this->userModel = new User($pdo);
    }

    public function index()
    {
        $title = 'Users';
        $users = $this->userModel->getAll();
        require_once __DIR__ . '/../views/users/index.php';
    }

    public function create()
    {
        $title = 'New Users';
        require_once __DIR__ . '/../views/users/create.php';
    }

    public function store()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data = [
                'username' => trim($_POST['username']),
                'password' => $_POST['password'],
                'full_name' => trim($_POST['full_name']),
                'email' => trim($_POST['email']),
                'role' => $_POST['role']
            ];

            // Validate input
            $errors = $this->validateUserData($data);

            if (empty($errors)) {
                if ($this->userModel->create($data)) {
                    $_SESSION['success'] = 'User created successfully';
                    header('Location: ' . BASE_PATH . '/users');
                    exit;
                } else {
                    $_SESSION['error'] = 'Failed to create user';
                }
            } else {
                $_SESSION['form_errors'] = $errors;
                $_SESSION['form_data'] = $data;
            }

            header('Location: ' . BASE_PATH . '/users/create');
            exit;
        }
    }

    public function edit($id)
    {
        $title = 'Edit Users';
        $user = $this->userModel->getById($id);
        if (!$user) {
            $_SESSION['error'] = 'User not found';
            header('Location: ' . BASE_PATH . '/users');
            exit;
        }
        require_once __DIR__ . '/../views/users/edit.php';
    }

    public function update($id)
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data = [
                'username' => trim($_POST['username']),
                'full_name' => trim($_POST['full_name']),
                'email' => trim($_POST['email']),
                'role' => $_POST['role']
            ];

            // Only add password if provided
            if (!empty($_POST['password'])) {
                $data['password'] = $_POST['password'];
            }

            // Validate input
            $errors = $this->validateUserData($data, $id);

            if (empty($errors)) {
                if ($this->userModel->update($id, $data)) {
                    $_SESSION['success'] = 'User updated successfully';
                } else {
                    $_SESSION['error'] = 'Failed to update user';
                }
            } else {
                $_SESSION['form_errors'] = $errors;
                $_SESSION['form_data'] = $data;
                header('Location: ' . BASE_PATH . '/users/edit/' . $id);
                exit;
            }

            header('Location: ' . BASE_PATH . '/users');
            exit;
        }
    }

    public function delete($id)
    {
        if ($this->userModel->delete($id)) {
            $_SESSION['success'] = 'User deleted successfully';
        } else {
            $_SESSION['error'] = 'Failed to delete user';
        }
        header('Location: ' . BASE_PATH . '/users');
        exit;
    }

    private function validateUserData($data, $userId = null)
    {
        $errors = [];

        if (empty($data['username'])) {
            $errors['username'] = 'Username is required';
        }

        if (empty($data['full_name'])) {
            $errors['full_name'] = 'Full name is required';
        }

        if (empty($data['email'])) {
            $errors['email'] = 'Email is required';
        } elseif (!filter_var($data['email'], FILTER_VALIDATE_EMAIL)) {
            $errors['email'] = 'Invalid email format';
        }

        if (!isset($data['role']) || !in_array($data['role'], ['Admin', 'Cashier', 'Manager'])) {
            $errors['role'] = 'Invalid role selected';
        }

        // For new users or when password is being changed
        if ((!$userId || isset($data['password'])) && empty($data['password'])) {
            $errors['password'] = 'Password is required';
        } elseif (isset($data['password']) && strlen($data['password']) < 6) {
            $errors['password'] = 'Password must be at least 6 characters';
        }

        return $errors;
    }
}
?>