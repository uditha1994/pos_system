<?php
function authenticateUser($requiredRole = null)
{
    if (!isset($_SESSION['user_id'])) {
        header('Location: ' . BASE_PATH . '/login');
        exit;
    }

    if ($requiredRole && $_SESSION['role'] !== $requiredRole) {
        $_SESSION['error'] = 'You do not have permission to access this page';
        header('Location: ' . BASE_PATH . '/');
        exit;
    }
}
?>