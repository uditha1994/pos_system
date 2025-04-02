<?php
require_once __DIR__ . '/../models/Supplier.php';

class SupplierController
{
    private $supplierModel;

    public function __construct()
    {
        global $pdo;
        $this->supplierModel = new Supplier($pdo);
    }

    public function index()
    {
        $suppliers = $this->supplierModel->getAll();
        require_once __DIR__ . '/../views/suppliers/index.php';
    }

    public function create()
    {
        require_once __DIR__ . '/../views/suppliers/create.php';
    }

    public function store()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data = [
                'supplier_name' => trim($_POST['name']),
                'contactno' => trim($_POST['phone_number']),
                'address' => trim($_POST['address'])
            ];

            if ($this->supplierModel->create($data)) {
                $_SESSION['success'] = 'Supplier created successfully';
                header('Location: ' . BASE_PATH . '/suppliers');
                exit;
            } else {
                $_SESSION['error'] = 'Failed to create supplier';
                header('Location: ' . BASE_PATH . '/suppliers/create');
                exit;
            }
        }
    }

    public function edit($id)
    {
        $supplier = $this->supplierModel->getById($id);
        if (!$supplier) {
            $_SESSION['error'] = 'Supplier not found';
            header('Location: ' . BASE_PATH . '/suppliers');
            exit;
        }
        require_once __DIR__ . '/../views/suppliers/edit.php';
    }

    public function update($id)
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data = [
                'supplier_name' => trim($_POST['name']),
                'contactno' => trim($_POST['phone_number']),
                'address' => trim($_POST['address'])
            ];

            if ($this->supplierModel->update($id, $data)) {
                $_SESSION['success'] = 'Supplier updated successfully';
            } else {
                $_SESSION['error'] = 'Failed to update supplier';
            }
            header('Location: ' . BASE_PATH . '/suppliers');
            exit;
        }
    }

    public function delete($id)
    {
        if ($this->supplierModel->delete($id)) {
            $_SESSION['success'] = 'Supplier deleted successfully';
        } else {
            $_SESSION['error'] = 'Failed to delete supplier';
        }
        header('Location: ' . BASE_PATH . '/suppliers');
        exit;
    }
}
?>