<?php
class Report
{
    private $pdo;

    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    public function getSalesReport($startDate, $endDate)
    {
        $stmt = $this->pdo->prepare("SELECT DATE(o.order_date) as order_day,COUNT(o.order_id) as total_orders,
        SUM(o.total_amount) as total_sales,SUM(oi.qty) as total_items_sold FROM `order` o JOIN order_item oi 
        ON o.order_id = oi.order_id WHERE o.order_date BETWEEN ? AND ? GROUP BY DATE(o.order_date) 
        ORDER BY order_day ASC");
        $stmt->execute([$startDate, $endDate]);
        return $stmt->fetchAll();
    }

    public function getTopProducts($startDate, $endDate, $limit = 5)
    {
        $stmt = $this->pdo->prepare("
    SELECT 
        p.product_id,
        p.product_name,
        SUM(oi.qty) as total_quantity,
        SUM(oi.sub_total) as total_revenue 
    FROM 
        order_item oi 
    JOIN 
        inventory i ON oi.inventory_id = i.inventory_id
    JOIN 
        product p ON i.product_id = p.product_id 
    JOIN 
        `order` o ON oi.order_id = o.order_id 
    WHERE 
        o.order_date BETWEEN ? AND ? 
    GROUP BY 
        p.product_id, p.product_name 
    ORDER BY 
        total_quantity DESC 
    LIMIT ?
");
        $stmt->execute([$startDate, $endDate, $limit]);
        return $stmt->fetchAll();
    }

    public function getInventoryStock()
    {
        $stmt = $this->pdo->query("
        SELECT 
    p.product_id,
    p.product_name,
    i.sell_price,
    c.category_name,
    COALESCE(SUM(i.quantity_added), 0) as total_stock,
    (SELECT COUNT(*) FROM order_item oi 
     JOIN `order` o ON oi.order_id = o.order_id 
     WHERE oi.inventory_id = i.inventory_id) as times_sold
FROM 
    product p
LEFT JOIN 
    inventory i ON p.product_id = i.product_id
LEFT JOIN 
    category c ON p.category_id = c.category_id
GROUP BY 
    p.product_id, p.product_name, i.sell_price, c.category_name, i.inventory_id
ORDER BY 
    total_stock ASC
    ");
        return $stmt->fetchAll();
    }

    public function getLowStockItems($threshold = 10)
    {
        $stmt = $this->pdo->prepare("
        SELECT 
            p.product_id,
            p.product_name,
            i.sell_price,
            c.category_name,
            COALESCE(SUM(i.quantity_added), 0) as total_stock
        FROM 
            product p
        LEFT JOIN 
            inventory i ON p.product_id = i.product_id
        LEFT JOIN 
            category c ON p.category_id = c.category_id
        GROUP BY 
            p.product_id, p.product_name, i.sell_price, c.category_name
        HAVING 
            total_stock <= ?
        ORDER BY 
            total_stock ASC
    ");
        $stmt->execute([$threshold]);
        return $stmt->fetchAll();
    }

    public function getCustomerPurchases($customerId = null)
    {
        $sql = "
        SELECT 
            c.customer_id,
            c.full_name,
            c.contactno,
            COUNT(o.order_id) as total_orders,
            SUM(o.total_amount) as total_spent,
            MAX(o.order_date) as last_order_date
        FROM 
            customer c
        LEFT JOIN 
            `order` o ON c.customer_id = o.customer_id
    ";

        $params = [];

        if ($customerId) {
            $sql .= " AND c.customer_id = ?";
            $params[] = $customerId;
        }

        $sql .= " GROUP BY c.customer_id, c.full_name, c.contactno
              ORDER BY total_spent DESC";

        $stmt = $this->pdo->prepare($sql);
        $stmt->execute($params);
        return $stmt->fetchAll();
    }

    public function getCustomerOrderDetails($customerId)
    {
        $stmt = $this->pdo->prepare("
        SELECT 
            o.order_id,
            o.order_date,
            o.total_amount,
            GROUP_CONCAT(p.product_name SEPARATOR ', ') as products
        FROM 
            `order` o
        JOIN 
            order_item oi ON o.order_id = oi.order_id
        JOIN 
            inventory i ON i.inventory_id = oi.inventory_id
        JOIN 
            product p ON i.product_id = p.product_id
        WHERE 
            o.customer_id = ?
        GROUP BY 
            o.order_id, o.order_date, o.total_amount
        
    ");
        $stmt->execute([$customerId]);
        return $stmt->fetchAll();
    }

    public function getProductPerformance($startDate = null, $endDate = null)
    {
        $sql = "
    SELECT 
        p.product_id,
        p.product_name,
        c.category_name,
        (SELECT i.sell_price 
         FROM inventory i 
         WHERE i.product_id = p.product_id 
         LIMIT 1) as sell_price,
        COALESCE(SUM(oi.qty), 0) as total_sold,
        COALESCE(SUM(oi.sub_total), 0) as total_revenue,
        (SELECT COALESCE(SUM(i.quantity_added), 0) 
         FROM inventory i 
         WHERE i.product_id = p.product_id) as current_stock
    FROM 
        product p
    LEFT JOIN 
        category c ON p.category_id = c.category_id
    LEFT JOIN 
        order_item oi ON p.product_id = (
            SELECT i2.product_id 
            FROM inventory i2 
            WHERE i2.inventory_id = oi.inventory_id
        )
    LEFT JOIN 
        `order` o ON oi.order_id = o.order_id
";

        $params = [];

        if ($startDate && $endDate) {
            $sql .= " WHERE o.order_date BETWEEN ? AND ? ";
            $params[] = $startDate;
            $params[] = $endDate;
        }

        $sql .= " GROUP BY p.product_id, p.product_name, c.category_name
      ORDER BY total_sold DESC";

        $stmt = $this->pdo->prepare($sql);
        $stmt->execute($params);
        return $stmt->fetchAll();
    }

    public function getSupplierPerformance($supplierId = null)
    {
        $stmt = $this->pdo->query("
        SELECT 
            s.*,
            COUNT(i.inventory_id) as total_shipments,
            SUM(i.quantity_added) as total_items,
            SUM(i.quantity_added * i.cost) as total_cost
        FROM 
            supplier s
        LEFT JOIN 
            inventory i ON s.supplier_id = i.supplier_id
        GROUP BY 
            s.supplier_id, s.supplier_name, s.address, s.contactno
        ORDER BY 
            total_items DESC
    ");
        return $stmt->fetchAll();
    }

    public function getSupplierShipments($supplierId)
    {
        $stmt = $this->pdo->prepare("
        SELECT 
            i.inventory_id,
            i.date_added,
            p.product_name,
            i.quantity_added,
            i.cost,
            (i.quantity_added * i.cost) as total_cost
        FROM 
            inventory i
        JOIN 
            product p ON i.product_id = p.product_id
        WHERE 
            i.supplier_id = ?
        ORDER BY 
            i.date_added DESC
    ");
        $stmt->execute([$supplierId]);
        return $stmt->fetchAll();
    }
}