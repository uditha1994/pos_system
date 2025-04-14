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

        require_once __DIR__ . '/../includes/fpdf/fpdf.php';

        $pdf = new FPDF();
        $pdf->AddPage();
        $pdf->SetFont('Arial', 'B', 16);
        $pdf->Cell(0, 10, 'Stock Report', 0, 1, 'C');

        // Add filter info if searching by product
        if ($productId) {
            $pdf->SetFont('Arial', '', 10);
            $pdf->Cell(0, 10, 'Filtered by Product ID: ' . $productId, 0, 1);
            $pdf->Ln(5);
        }

        // Table header
        $pdf->SetFont('Arial', 'B', 10);
        $pdf->Cell(30, 10, 'Product ID', 1);
        $pdf->Cell(70, 10, 'Product Name', 1);
        $pdf->Cell(40, 10, 'Available Qty', 1);
        $pdf->Cell(40, 10, 'Sell Price', 1);
        $pdf->Ln();

        // Table data
        $pdf->SetFont('Arial', '', 10);
        if (empty($stockItems)) {
            $pdf->Cell(0, 10, 'No stock items found', 1, 1, 'C');
        } else {
            foreach ($stockItems as $item) {
                $pdf->Cell(30, 10, $item['product_id'], 1);
                $pdf->Cell(70, 10, $item['product_name'], 1);
                $pdf->Cell(40, 10, $item['total_quantity'], 1);
                $pdf->Cell(40, 10, number_format($item['sell_price'] ?? 0, 2), 1);
                $pdf->Ln();
            }
        }

        // Footer with date
        $pdf->SetY(-15);
        $pdf->SetFont('Arial', 'I', 8);
        $pdf->Cell(0, 10, 'Generated on: ' . date('Y-m-d H:i:s'), 0, 0, 'R');

        $pdf->Output('I', 'stock_report_' . date('Y-m-d') . '.pdf');
    }
}
?>