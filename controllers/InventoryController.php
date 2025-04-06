<?php
require_once __DIR__ . '/../models/Inventory.php';

class InventoryController
{
    private $inventoryModel;

    public function __construct()
    {
        global $pdo;
        $this->inventoryModel = new Inventory($pdo);
    }

    public function index()
    {
        $search = $_GET['search'] ?? '';
        $inventoryItems = $this->inventoryModel->getAll($search);
        require_once __DIR__ . '/../views/inventory/index.php';
    }

    public function create()
    {
        $products = $this->inventoryModel->getProducts();
        $suppliers = $this->inventoryModel->getSuppliers();
        require_once __DIR__ . '/../views/inventory/create.php';
    }

    public function store()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data = [
                'quantity_added' => (int) $_POST['quantity_added'],
                'cost' => (float) $_POST['cost'],
                'sell_price' => (float) $_POST['sell_price'],
                'product_id' => $_POST['product_id'],
                'supplier_id' => (int) $_POST['supplier_id'],
                'user_id' => $_SESSION['user_id']
            ];

            if ($this->inventoryModel->create($data)) {
                $_SESSION['success'] = 'Inventory item added successfully';
                header('Location: ' . BASE_PATH . '/inventory');
                exit;
            } else {
                $_SESSION['error'] = 'Failed to add inventory item';
                header('Location: ' . BASE_PATH . '/inventory/create');
                exit;
            }
        }
    }

    public function edit($inventoryId)
    {
        $inventoryItem = $this->inventoryModel->getById($inventoryId);
        if (!$inventoryItem) {
            $_SESSION['error'] = 'Inventory item not found';
            header('Location: ' . BASE_PATH . '/inventory');
            exit;
        }

        $products = $this->inventoryModel->getProducts();
        $suppliers = $this->inventoryModel->getSuppliers();

        require_once __DIR__ . '/../views/inventory/edit.php';
    }

    public function update($inventoryId)
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data = [
                'quantity_added' => (int) $_POST['quantity_added'],
                'cost' => (float) $_POST['cost'],
                'sell_price' => (float) $_POST['sell_price'],
                'product_id' => $_POST['product_id'],
                'supplier_id' => (int) $_POST['supplier_id']
            ];

            if ($this->inventoryModel->update($inventoryId, $data)) {
                $_SESSION['success'] = 'Inventory item updated successfully';
            } else {
                $_SESSION['error'] = 'Failed to update inventory item';
            }
            header('Location: ' . BASE_PATH . '/inventory');
            exit;
        }
    }

    public function delete($inventoryId)
    {
        if ($this->inventoryModel->delete($inventoryId)) {
            $_SESSION['success'] = 'Inventory item deleted successfully';
        } else {
            $_SESSION['error'] = 'Failed to delete inventory item';
        }
        header('Location: ' . BASE_PATH . '/inventory');
        exit;
    }

    public function stockReport()
    {
        $productId = $_GET['product_id'] ?? null;
        $stockItems = $this->inventoryModel->getAvailableStock($productId);
        require_once __DIR__ . '/../views/inventory/stock_report.php';
    }
}
?>