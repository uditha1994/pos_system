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
                header('Location: ' . BASE_PATH . '/product');
                exit;
            } else {
                $_SESSION['error'] = 'Failed to createProduct';
                header('Location: ' . BASE_PATH . '/product/create');
                exit;
            }
        }
    }

    public function edit($id)
    {
    }

    public function update($id)
    {
    }

    public function delete($id)
    {
    }
}