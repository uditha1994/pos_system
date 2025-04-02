<?php
session_start();
error_reporting(E_ALL);
ini_set('display_errors', 1);

//Automatically detect base path
$basepath = str_replace(
    '/index.php',
    '',
    $_SERVER['SCRIPT_NAME']
);
define('BASE_PATH', $basepath);

require_once __DIR__ . '/includes/db.php';
require_once __DIR__ . '/controllers/CategoryController.php';
require_once __DIR__ . '/controllers/ProductController.php';
require_once __DIR__ . '/controllers/CustomerController.php';
require_once __DIR__ . '/controllers/SupplierController.php';
require_once __DIR__ . '/controllers/DashboardController.php';
require_once __DIR__ . '/controllers/AuthController.php';
require_once __DIR__ . '/controllers/UserController.php';

try {

    $requestUri = parse_url(
        $_SERVER['REQUEST_URI'],
        PHP_URL_PATH
    );
    $request = str_replace(
        $basepath,
        '',
        $requestUri
    );

    switch ($request) {
        case '/':
        case '/dashboard':
            $dashboardController = new DashboardController();
            $dashboardController->index();
            break;
        case '/categories':
            $controller = new CategoryController();
            $controller->index();
            break;
        case '/categories/create':
            $controller = new CategoryController();
            $controller->create();
            break;
        case '/categories/store':
            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                $controller = new CategoryController();
                $controller->store();
            } else {
                header('Location: ' . BASE_PATH . '/categories');
            }
            break;
        case (preg_match(
        '/^\/categories\/edit\/(\d+)$/',
        $request,
        $matches
        ) ? true : false):
            $controller = new CategoryController();
            $controller->edit($matches[1]);
            break;
        case (preg_match(
        '/^\/categories\/update\/(\d+)$/',
        $request,
        $matches
        ) ? true : false):
            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                $controller = new CategoryController();
                $controller->update($matches[1]);
            } else {
                header('Location: ' . BASE_PATH . '/categories');
            }
            break;
        case '/categories/delete':
            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                $controller = new CategoryController();
                $controller->delete($_POST['category_id']);
            } else {
                header('Location: ' . BASE_PATH . '/categories');
            }
        case '/products':
            $productController = new ProductController();
            $productController->index();
            break;

        case '/products/create':
            $productController = new ProductController();
            $productController->create();
            break;

        case '/products/store':
            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                $productController = new ProductController();
                $productController->store();
            }
            break;

        case (preg_match('/^\/products\/edit\/(\d+)$/', $request, $matches) ? true : false):
            $productController = new ProductController();
            $productController->edit($matches[1]);
            break;

        case (preg_match('/^\/products\/update\/(\d+)$/', $request, $matches) ? true : false):
            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                $productController = new ProductController();
                $productController->update($matches[1]);
            }
            break;

        case (preg_match('/^\/products\/delete\/(\d+)$/', $request, $matches) ? true : false):
            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                $productController = new ProductController();
                $productController->delete($matches[1]);
            }
            break;
        // Customer routes
        case '/customers':
            $customerController = new CustomerController();
            $customerController->index();
            break;

        case '/customers/create':
            $customerController = new CustomerController();
            $customerController->create();
            break;

        case '/customers/store':
            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                $customerController = new CustomerController();
                $customerController->store();
            }
            break;

        case (preg_match('/^\/customers\/edit\/(\d+)$/', $request, $matches) ? true : false):
            $customerController = new CustomerController();
            $customerController->edit($matches[1]);
            break;

        case (preg_match('/^\/customers\/update\/(\d+)$/', $request, $matches) ? true : false):
            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                $customerController = new CustomerController();
                $customerController->update($matches[1]);
            }
            break;

        case (preg_match('/^\/customers\/delete\/(\d+)$/', $request, $matches) ? true : false):
            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                $customerController = new CustomerController();
                $customerController->delete($matches[1]);
            }
            break;

        // Supplier routes
        case '/suppliers':
            $supplierController = new SupplierController();
            $supplierController->index();
            break;

        case '/suppliers/create':
            $supplierController = new SupplierController();
            $supplierController->create();
            break;

        case '/suppliers/store':
            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                $supplierController = new SupplierController();
                $supplierController->store();
            }
            break;

        case (preg_match('/^\/suppliers\/edit\/(\d+)$/', $request, $matches) ? true : false):
            $supplierController = new SupplierController();
            $supplierController->edit($matches[1]);
            break;

        case (preg_match('/^\/suppliers\/update\/(\d+)$/', $request, $matches) ? true : false):
            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                $supplierController = new SupplierController();
                $supplierController->update($matches[1]);
            }
            break;

        case (preg_match('/^\/suppliers\/delete\/(\d+)$/', $request, $matches) ? true : false):
            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                $supplierController = new SupplierController();
                $supplierController->delete($matches[1]);
            }
            break;

        // Auth routes
        case '/login':
            $authController = new AuthController();
            $authController->login();
            break;

        case '/authenticate':
            $authController = new AuthController();
            $authController->authenticate();
            break;

        case '/logout':
            $authController = new AuthController();
            $authController->logout();
            break;

        // User routes
        case '/users':
            $userController = new UserController();
            $userController->index();
            break;

        case '/users/create':
            $userController = new UserController();
            $userController->create();
            break;

        case '/users/store':
            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                $userController = new UserController();
                $userController->store();
            }
            break;

        case (preg_match('/^\/users\/edit\/(\d+)$/', $request, $matches) ? true : false):
            $userController = new UserController();
            $userController->edit($matches[1]);
            break;

        case (preg_match('/^\/users\/update\/(\d+)$/', $request, $matches) ? true : false):
            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                $userController = new UserController();
                $userController->update($matches[1]);
            }
            break;

        case (preg_match('/^\/users\/delete\/(\d+)$/', $request, $matches) ? true : false):
            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                $userController = new UserController();
                $userController->delete($matches[1]);
            }
            break;

        default:
            http_response_code(404);
            require_once __DIR__ . '/views/404.php';
            break;

    }

} catch (PDOException $e) {
    die("Database Error:" . $e->getMessage());
} catch (Exception $e) {
    die("Application Error: " . $e->getMessage());
}