<?php
require_once __DIR__ . '/../models/Order.php';
require_once __DIR__ . '/../models/Customer.php';
require_once __DIR__ . '/../includes/pdf.php';

class OrderController
{
    private $orderModel;
    private $customerModel;

    public function __construct()
    {
        global $pdo;
        $this->orderModel = new Order($pdo);
        $this->customerModel = new Customer($pdo);
    }

    public function index()
    {
        $orders = $this->orderModel->getAll();
        require_once __DIR__ . '/../views/orders/index.php';
    }

    public function create()
    {
        $customers = $this->customerModel->getAll();
        $inventoryItems = $this->orderModel->getAvailableInventory();
        require_once __DIR__ . '/../views/orders/create.php';
    }

    public function store()
    {
        global $pdo;
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            try {
                $pdo->beginTransaction();

                $customerId = (int) $_POST['customer_id'];
                $userId = $_SESSION['user_id'];
                $paymentMethod = $_POST['payment_method'];
                $cartItems = json_decode($_POST['cart_items'], true);

                // Calculate total amount
                $totalAmount = 0;
                foreach ($cartItems as $item) {
                    $totalAmount += $item['sub_total'];
                }

                // Create order
                $orderId = $this->orderModel->create($customerId, $userId, $totalAmount, $paymentMethod);

                // Add order items
                foreach ($cartItems as $item) {
                    $this->orderModel->addItem(
                        $orderId,
                        $item['inventory_id'],
                        $item['quantity'],
                        $item['sub_total']
                    );

                    // Update inventory
                    if (!$this->orderModel->updateInventory($item['inventory_id'], $item['quantity'])) {
                        throw new Exception("Failed to update inventory for item ID: {$item['inventory_id']}");
                    }
                }

                $pdo->commit();
                $_SESSION['success'] = 'Order created successfully';
                header("Location: " . BASE_PATH . "/orders/view/$orderId");
                exit;
            } catch (Exception $e) {
                $pdo->rollBack();
                $_SESSION['error'] = 'Order failed: ' . $e->getMessage();
                header("Location: " . BASE_PATH . "/orders/create");
                exit;
            }
        }
    }

    public function view($orderId)
    {
        $order = $this->orderModel->getById($orderId);
        $items = $this->orderModel->getItems($orderId);

        if (!$order) {
            $_SESSION['error'] = 'Order not found';
            header("Location: " . BASE_PATH . "/orders");
            exit;
        }

        require_once __DIR__ . '/../views/orders/view.php';
    }

    public function generatePdf($orderId)
    {
        $order = $this->orderModel->getById($orderId);
        $items = $this->orderModel->getItems($orderId);

        if (!$order) {
            $_SESSION['error'] = 'Order not found';
            header("Location: " . BASE_PATH . "/orders");
            exit;
        }

        $pdf = generateOrderPdf($order, $items);
        $pdf->Output('order_' . $orderId . '.pdf', 'D');
        exit;
    }
}
?>