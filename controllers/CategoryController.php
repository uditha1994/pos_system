<?php
require_once __DIR__ . '/../models/Category.php';
require_once __DIR__ . '/../includes/db.php';

class CategoryController
{

    private $categoryModel;

    public function __construct()
    {
        global $pdo;
        $this->categoryModel = new Category($pdo);

        if (!$pdo) {
            throw new RuntimeException("Database Connection 
            not found");
        }
    }

    public function index()
    {
        $title = 'Categories';
        $categories = $this->categoryModel->getAll();
        require_once __DIR__ . '/../views/categories/index.php';
    }

    public function create()
    {
        $title = 'New Category';
        require_once __DIR__ . '/../views/categories/create.php';
    }

    public function store()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $name = $_POST['category_name'];
            $description = $_POST['description'];
        }

        if (empty($name)) {
            $_SESSION['error'] = 'Categery name is required';
            header('Location: /categories');
        }

        if ($this->categoryModel->create($name, $description)) {
            $_SESSION['success'] = 'Category created successfully';
            header('Location: /categories');
            exit;
        } else {
            $_SESSION['error'] = 'Failed to create Categery';
            header('Location: /categories');
        }
    }

    public function edit($id)
    {
        $title = 'Edit Category';
        $category = $this->categoryModel->getById($id);
        if (!$category) {
            header('Location: /categories');
        }
        require_once __DIR__ . '/../views/categories/edit.php';
    }

    public function update($id)
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $name = $_POST['name'];
            $description = $_POST['description'];

            if (empty($name)) {
                $_SESSION['error'] = "Category name is required";
                header("Location: /categories/edit/$id");
                exit;
            }

            if (
                $this->categoryModel->update(
                    $id,
                    $name,
                    $description
                )
            ) {
                $_SESSION["success"] = "Category updated successfully";
                header('Location: /categories');
                exit;
            } else {
                $_SESSION['error'] = "Failed to update Category";
                header("Location: /categories/edit/$id");
                exit;
            }
        } else {
            header('Location: /categories');
        }
    }

    public function delete($id)
    {
        if ($this->categoryModel->delete($id)) {
            $_SESSION["success"] = "Category deleted successfully";
        } else {
            $_SESSION['error'] = "Failed to delete Category";
        }
        header('Location: /categories');
        exit;
    }

}