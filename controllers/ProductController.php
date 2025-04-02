<?php
require_once __DIR__ . "/../models/Product.php";

class ProductController
{
    private $productModel;

    public function __construct()
    {
        global $pdo;
        $this->productModel = new Product($pdo);
    }

    public function index()
    {
        $products = $this->productModel->getAll();
        require_once __DIR__ . "/../views/products/index.php";
    }

    public function create()
    {
        $categories = $this->productModel->getCategories();
        require_once __DIR__ . "/../views/products/create.php";
    }

    public function store()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data = [
                'product_id' => $_POST['id'],
                'product_name' => $_POST['name'],
                'description' => $_POST['description'],
                'quantity' => $_POST['quantity'],
                'category_id' => $_POST['category_id'],
            ];

            if ($this->productModel->create($data)) {
                $_SESSION['success'] = 'Product Create Successfully';
                header('Location: ' . BASE_PATH . '/products');
                exit;
            } else {
                $_SESSION['error'] = 'Failed to createProduct';
                header('Location: ' . BASE_PATH . '/products/create');
                exit;
            }
        }
    }

    public function edit($id)
    {
        $product = $this->productModel->getById($id);
        $categories = $this->productModel->getCategories();

        if (!$product) {
            $_SESSION['error'] = 'Product not found';
            header('Location: ' . BASE_PATH . '/products');
            exit;
        }

        require_once __DIR__ . "/../views/products/edit.php";
    }

    public function update($id)
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data = [
                'product_name' => $_POST['product_name'],
                'description' => $_POST['description'],
                'quantity' => $_POST['quantity'],
                'category_id' => $_POST['category_id'],
            ];

            if ($this->productModel->update($id, $data)) {
                $_SESSION['success'] = 'Product updated Successfully';
                header('Location: ' . BASE_PATH . '/products');
                exit;
            } else {
                $_SESSION['error'] = 'Failed to update Product';
                header('Location: ' . BASE_PATH . '/products');
                exit;
            }
        }
    }

    public function delete($id)
    {
        if ($this->productModel->delete($id)) {
            $_SESSION['success'] = 'Product deleted Successfully';
        } else {
            $_SESSION['error'] = 'Failed to delete Product';
        }
        header('Location: ' . BASE_PATH . '/products');
        exit;
    }
}