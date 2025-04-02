<?php
class DashboardController
{
    private $pdo;

    public function __construct()
    {
        global $pdo;
        $this->pdo = $pdo;
    }

    public function index()
    {
        // Get counts for dashboard cards
        $categoryCount = $this->pdo->query("SELECT COUNT(*) FROM category")->fetchColumn();
        $productCount = $this->pdo->query("SELECT COUNT(*) FROM product")->fetchColumn();
        $customerCount = $this->pdo->query("SELECT COUNT(*) FROM customer")->fetchColumn();
        $supplierCount = $this->pdo->query("SELECT COUNT(*) FROM supplier")->fetchColumn();

        // Get recent products (last 5 added)
        $recentProducts = $this->pdo->query("
            SELECT * FROM product 
            ORDER BY product_name DESC 
            LIMIT 5
        ")->fetchAll();

        // Get recent customers (last 5 added)
        $recentCustomers = $this->pdo->query("
            SELECT * FROM customer LIMIT 5
        ")->fetchAll();

        // Pass all variables to the view
        require_once __DIR__ . '/../views/dashboard.php';
    }
}
?>