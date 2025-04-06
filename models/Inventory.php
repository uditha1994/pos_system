<?php
class Inventory
{
    private $pdo;

    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    public function create($data)
    {
        $stmt = $this->pdo->prepare("
            INSERT INTO inventory 
            (date_added, quantity_added, cost, sell_price, product_id, supplier_id, user_id)
            VALUES (NOW(), ?, ?, ?, ?, ?, ?)
        ");
        return $stmt->execute([
            $data['quantity_added'],
            $data['cost'],
            $data['sell_price'],
            $data['product_id'],
            $data['supplier_id'],
            $data['user_id']
        ]);
    }

    public function update($inventoryId, $data)
    {
        $stmt = $this->pdo->prepare("
            UPDATE inventory SET
                quantity_added = ?,
                cost = ?,
                sell_price = ?,
                product_id = ?,
                supplier_id = ?
            WHERE inventory_id = ?
        ");
        return $stmt->execute([
            $data['quantity_added'],
            $data['cost'],
            $data['sell_price'],
            $data['product_id'],
            $data['supplier_id'],
            $inventoryId
        ]);
    }

    public function delete($inventoryId)
    {
        $stmt = $this->pdo->prepare("DELETE FROM inventory WHERE inventory_id = ?");
        return $stmt->execute([$inventoryId]);
    }

    public function getById($inventoryId)
    {
        $stmt = $this->pdo->prepare("
            SELECT i.*, p.product_name, s.supplier_name, u.username
            FROM inventory i
            JOIN product p ON i.product_id = p.product_id
            JOIN supplier s ON i.supplier_id = s.supplier_id
            JOIN user u ON i.user_id = u.user_id
            WHERE i.inventory_id = ?
        ");
        $stmt->execute([$inventoryId]);
        return $stmt->fetch();
    }

    public function getAll($search = '')
    {
        $sql = "
            SELECT i.*, p.product_name, s.supplier_name, u.username
            FROM inventory i
            JOIN product p ON i.product_id = p.product_id
            JOIN supplier s ON i.supplier_id = s.supplier_id
            JOIN user u ON i.user_id = u.user_id
        ";

        $params = [];

        if (!empty($search)) {
            $sql .= " WHERE p.product_name LIKE ? OR p.product_id LIKE ?";
            $params = ["%$search%", "%$search%"];
        }

        $sql .= " ORDER BY i.date_added DESC";

        $stmt = $this->pdo->prepare($sql);
        $stmt->execute($params);
        return $stmt->fetchAll();
    }

    public function getAvailableStock($productId = null)
    {
        $sql = "
            SELECT 
                p.product_id,
                p.product_name,
                COALESCE(SUM(i.quantity_added), 0) as total_quantity,
                i.sell_price
            FROM product p
            LEFT JOIN inventory i ON p.product_id = i.product_id
        ";

        $params = [];

        if ($productId) {
            $sql .= " WHERE p.product_id = ?";
            $params = [$productId];
        }

        $sql .= " GROUP BY p.product_id, p.product_name, i.sell_price";

        $stmt = $this->pdo->prepare($sql);
        $stmt->execute($params);
        return $stmt->fetchAll();
    }

    public function getProducts()
    {
        $stmt = $this->pdo->query("SELECT product_id, product_name FROM product ORDER BY product_name");
        return $stmt->fetchAll();
    }

    public function getSuppliers()
    {
        $stmt = $this->pdo->query("SELECT supplier_id, supplier_name FROM supplier ORDER BY supplier_name");
        return $stmt->fetchAll();
    }
}
?>