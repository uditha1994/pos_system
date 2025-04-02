<?php
require_once __DIR__ . '/../models/Customer.php';

class CustomerController
{
    private $customerModel;

    public function __construct()
    {
        global $pdo;
        $this->customerModel = new Customer($pdo);
    }

    public function index()
    {
        $customers = $this->customerModel->getAll();
        require_once __DIR__ . '/../views/customers/index.php';
    }

    public function create()
    {
        require_once __DIR__ . '/../views/customers/create.php';
    }

    public function store()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data = [
                'full_name' => trim($_POST['name']),
                'contactno' => trim($_POST['phone_number'])
            ];

            if ($this->customerModel->create($data)) {
                $_SESSION['success'] = 'Customer created successfully';
                header('Location: ' . BASE_PATH . '/customers');
                exit;
            } else {
                $_SESSION['error'] = 'Failed to create customer';
                header('Location: ' . BASE_PATH . '/customers/create');
                exit;
            }
        }
    }

    public function edit($id)
    {
        $customer = $this->customerModel->getById($id);
        if (!$customer) {
            $_SESSION['error'] = 'Customer not found';
            header('Location: ' . BASE_PATH . '/customers');
            exit;
        }
        require_once __DIR__ . '/../views/customers/edit.php';
    }

    public function update($id)
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data = [
                'full_name' => trim($_POST['name']),
                'contactno' => trim($_POST['phone_number'])
            ];

            if ($this->customerModel->update($id, $data)) {
                $_SESSION['success'] = 'Customer updated successfully';
            } else {
                $_SESSION['error'] = 'Failed to update customer';
            }
            header('Location: ' . BASE_PATH . '/customers');
            exit;
        }
    }

    public function delete($id)
    {
        if ($this->customerModel->delete($id)) {
            $_SESSION['success'] = 'Customer deleted successfully';
        } else {
            $_SESSION['error'] = 'Failed to delete customer';
        }
        header('Location: ' . BASE_PATH . '/customers');
        exit;
    }
}
?>