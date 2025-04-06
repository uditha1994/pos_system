<?php
class Order
{
    private $pdo;

    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    public function create($customerId, $userId, $totalAmount, $paymentMethod)
    {
        $stmt = $this->pdo->prepare("
            INSERT INTO `order` (order_date, total_amount, payment_method, customer_id, user_id)
            VALUES (NOW(), ?, ?, ?, ?)
        ");
        $stmt->execute([$totalAmount, $paymentMethod, $customerId, $userId]);
        return $this->pdo->lastInsertId();
    }

    public function addItem($orderId, $inventoryId, $quantity, $subTotal)
    {
        $stmt = $this->pdo->prepare("
            INSERT INTO order_item (order_id, inventory_id, qty, sub_total)
            VALUES (?, ?, ?, ?)
        ");
        return $stmt->execute([$orderId, $inventoryId, $quantity, $subTotal]);
    }

    public function getById($orderId)
    {
        $stmt = $this->pdo->prepare("
            SELECT o.*, c.full_name as customer_name, u.username as cashier_name
            FROM `order` o
            JOIN customer c ON o.customer_id = c.customer_id
            JOIN user u ON o.user_id = u.user_id
            WHERE o.order_id = ?
        ");
        $stmt->execute([$orderId]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function getItems($orderId)
    {
        $stmt = $this->pdo->prepare("
            SELECT oi.*, p.product_name, i.sell_price
            FROM order_item oi
            JOIN inventory i ON oi.inventory_id = i.inventory_id
            JOIN product p ON i.product_id = p.product_id
            WHERE oi.order_id = ?
        ");
        $stmt->execute([$orderId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getAll()
    {
        $stmt = $this->pdo->query("
            SELECT o.*, c.full_name as customer_name, u.username as cashier_name
            FROM `order` o
            JOIN customer c ON o.customer_id = c.customer_id
            JOIN user u ON o.user_id = u.user_id
            ORDER BY o.order_date DESC
        ");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getAvailableInventory()
    {
        $stmt = $this->pdo->query("
            SELECT i.*, p.product_name, i.sell_price
            FROM inventory i
            JOIN product p ON i.product_id = p.product_id
            WHERE i.quantity_added > 0
            ORDER BY p.product_name
        ");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function updateInventory($inventoryId, $quantity)
    {
        $stmt = $this->pdo->prepare("
            UPDATE inventory 
            SET quantity_added = quantity_added - ? 
            WHERE inventory_id = ? AND quantity_added >= ?
        ");
        return $stmt->execute([$quantity, $inventoryId, $quantity]);
    }
}
?>