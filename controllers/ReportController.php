<?php
// controllers/ReportController.php
require_once __DIR__ . '/../models/Report.php';

class ReportController
{
    private $reportModel;

    public function __construct()
    {
        global $pdo;
        $this->reportModel = new Report($pdo);
    }

    public function salesReport()
    {
        $title = 'Sales Report';
        $startDate = $_GET['start_date'] ?? date('Y-m-01');
        $endDate = $_GET['end_date'] ?? date('Y-m-t');

        $salesData = $this->reportModel->getSalesReport($startDate, $endDate);
        $topProducts = $this->reportModel->getTopProducts($startDate, $endDate);

        require_once __DIR__ . '/../views/reports/sales_report.php';
    }

    public function generateSalesPDF()
    {
        $startDate = $_GET['start_date'] ?? date('Y-m-01');
        $endDate = $_GET['end_date'] ?? date('Y-m-t');

        $salesData = $this->reportModel->getSalesReport($startDate, $endDate);
        $topProducts = $this->reportModel->getTopProducts($startDate, $endDate);

        require_once __DIR__ . '/../includes/fpdf/fpdf.php';

        $pdf = new FPDF();
        $pdf->AddPage();
        $pdf->SetFont('Arial', 'B', 16);
        $pdf->Cell(0, 10, 'Sales Report (' . $startDate . ' to ' . $endDate . ')', 0, 1, 'C');

        // Sales Summary
        $pdf->SetFont('Arial', 'B', 12);
        $pdf->Cell(0, 10, 'Sales Summary', 0, 1);
        $pdf->SetFont('Arial', '', 10);

        $pdf->Cell(40, 10, 'Date', 1);
        $pdf->Cell(40, 10, 'Orders', 1);
        $pdf->Cell(50, 10, 'Total Sales', 1);
        $pdf->Cell(50, 10, 'Items Sold', 1);
        $pdf->Ln();

        $totalSales = 0;
        $totalItems = 0;
        $totalOrders = 0;

        foreach ($salesData as $row) {
            $pdf->Cell(40, 10, $row['order_day'], 1);
            $pdf->Cell(40, 10, $row['total_orders'], 1);
            $pdf->Cell(50, 10, number_format($row['total_sales'], 2), 1);
            $pdf->Cell(50, 10, $row['total_items_sold'], 1);
            $pdf->Ln();

            $totalSales += $row['total_sales'];
            $totalItems += $row['total_items_sold'];
            $totalOrders += $row['total_orders'];
        }

        $pdf->SetFont('Arial', 'B', 10);
        $pdf->Cell(80, 10, 'Total', 1);
        $pdf->Cell(50, 10, number_format($totalSales, 2), 1);
        $pdf->Cell(50, 10, $totalItems, 1);
        $pdf->Ln();

        // Top Products
        $pdf->SetFont('Arial', 'B', 12);
        $pdf->Cell(0, 10, 'Top Selling Products', 0, 1);
        $pdf->SetFont('Arial', '', 10);

        $pdf->Cell(80, 10, 'Product Name', 1);
        $pdf->Cell(40, 10, 'Quantity Sold', 1);
        $pdf->Cell(60, 10, 'Revenue', 1);
        $pdf->Ln();

        foreach ($topProducts as $product) {
            $pdf->Cell(80, 10, $product['product_name'], 1);
            $pdf->Cell(40, 10, $product['total_quantity'], 1);
            $pdf->Cell(60, 10, number_format($product['total_revenue'], 2), 1);
            $pdf->Ln();
        }

        $pdf->Output('I', 'sales_report_' . $startDate . '_' . $endDate . '.pdf');
    }

    public function inventoryReport()
    {
        $title = 'Inventory Report';
        $stockData = $this->reportModel->getInventoryStock();
        $lowStockItems = $this->reportModel->getLowStockItems();

        require_once __DIR__ . '/../views/reports/inventory_report.php';
    }

    public function generateInventoryPDF()
    {
        $stockData = $this->reportModel->getInventoryStock();
        $lowStockItems = $this->reportModel->getLowStockItems();

        require_once __DIR__ . '/../includes/fpdf/fpdf.php';

        $pdf = new FPDF();
        $pdf->AddPage();
        $pdf->SetFont('Arial', 'B', 16);
        $pdf->Cell(0, 10, 'Inventory Stock Report', 0, 1, 'C');

        // Current Stock
        $pdf->SetFont('Arial', 'B', 12);
        $pdf->Cell(0, 10, 'Current Stock Levels', 0, 1);
        $pdf->SetFont('Arial', '', 10);

        $pdf->Cell(60, 10, 'Product', 1);
        $pdf->Cell(40, 10, 'Category', 1);
        $pdf->Cell(30, 10, 'Price', 1);
        $pdf->Cell(30, 10, 'In Stock', 1);
        $pdf->Cell(30, 10, 'Times Sold', 1);
        $pdf->Ln();

        foreach ($stockData as $item) {
            $pdf->Cell(60, 10, $item['product_name'], 1);
            $pdf->Cell(40, 10, $item['category_name'], 1);
            $pdf->Cell(30, 10, number_format($item['sell_price'], 2), 1);
            $pdf->Cell(30, 10, $item['total_stock'], 1);
            $pdf->Cell(30, 10, $item['times_sold'], 1);
            $pdf->Ln();
        }

        // Low Stock Items
        $pdf->AddPage();
        $pdf->SetFont('Arial', 'B', 12);
        $pdf->Cell(0, 10, 'Low Stock Items (10 or less)', 0, 1);
        $pdf->SetFont('Arial', '', 10);

        $pdf->Cell(60, 10, 'Product', 1);
        $pdf->Cell(40, 10, 'Category', 1);
        $pdf->Cell(30, 10, 'Price', 1);
        $pdf->Cell(30, 10, 'In Stock', 1);
        $pdf->Ln();

        foreach ($lowStockItems as $item) {
            $pdf->Cell(60, 10, $item['product_name'], 1);
            $pdf->Cell(40, 10, $item['category_name'], 1);
            $pdf->Cell(30, 10, number_format($item['sell_price'], 2), 1);
            $pdf->Cell(30, 10, $item['total_stock'], 1);
            $pdf->Ln();
        }

        $pdf->Output('I', 'inventory_report_' . date('Y-m-d') . '.pdf');
    }

    public function customerReport()
    {
        $title = 'Customer Report';
        $customerId = $_GET['customer_id'] ?? null;
        $customers = $this->reportModel->getCustomerPurchases($customerId);

        $customerDetails = null;
        if ($customerId) {
            $customerDetails = $this->reportModel->getCustomerOrderDetails($customerId);
        }

        require_once __DIR__ . '/../views/reports/customer_report.php';
    }

    public function generateCustomerPDF($customerId)
    {
        $customers = $this->reportModel->getCustomerPurchases($customerId);
        $customerDetails = $this->reportModel->getCustomerOrderDetails($customerId);

        if (empty($customers)) {
            die("Customer not found");
        }

        $customer = $customers[0];

        require_once __DIR__ . '/../includes/fpdf/fpdf.php';

        $pdf = new FPDF();
        $pdf->AddPage();
        $pdf->SetFont('Arial', 'B', 16);
        $pdf->Cell(0, 10, 'Customer Purchase History', 0, 1, 'C');

        // Customer Info
        $pdf->SetFont('Arial', 'B', 12);
        $pdf->Cell(0, 10, 'Customer Information', 0, 1);
        $pdf->SetFont('Arial', '', 10);

        $pdf->Cell(40, 10, 'Customer ID:', 0);
        $pdf->Cell(0, 10, $customer['customer_id'], 0);
        $pdf->Ln();

        $pdf->Cell(40, 10, 'Name:', 0);
        $pdf->Cell(0, 10, $customer['full_name'], 0);
        $pdf->Ln();

        $pdf->Cell(40, 10, 'Phone:', 0);
        $pdf->Cell(0, 10, $customer['contactno'], 0);
        $pdf->Ln();

        $pdf->Cell(40, 10, 'Total Orders:', 0);
        $pdf->Cell(0, 10, $customer['total_orders'], 0);
        $pdf->Ln();

        $pdf->Cell(40, 10, 'Total Spent:', 0);
        $pdf->Cell(0, 10, number_format($customer['total_spent'], 2), 0);
        $pdf->Ln();

        $pdf->Cell(40, 10, 'Last Order:', 0);
        $pdf->Cell(0, 10, $customer['last_order_date'], 0);
        $pdf->Ln(15);

        // Order History
        $pdf->SetFont('Arial', 'B', 12);
        $pdf->Cell(0, 10, 'Order History', 0, 1);
        $pdf->SetFont('Arial', '', 10);

        $pdf->Cell(30, 10, 'Order ID', 1);
        $pdf->Cell(40, 10, 'Date', 1);
        $pdf->Cell(30, 10, 'Amount', 1);
        $pdf->Cell(90, 10, 'Products', 1);
        $pdf->Ln();

        foreach ($customerDetails as $order) {
            $pdf->Cell(30, 10, $order['order_id'], 1);
            $pdf->Cell(40, 10, $order['order_date'], 1);
            $pdf->Cell(30, 10, number_format($order['total_amount'], 2), 1);
            $pdf->Cell(90, 10, $order['products'], 1);
            $pdf->Ln();
        }

        $pdf->Output('I', 'customer_report_' . $customerId . '.pdf');
    }

    public function productPerformance()
    {
        $title = 'Product Performance Report';
        $startDate = $_GET['start_date'] ?? date('Y-m-01');
        $endDate = $_GET['end_date'] ?? date('Y-m-t');

        $products = $this->reportModel->getProductPerformance($startDate, $endDate);

        require_once __DIR__ . '/../views/reports/product_performance.php';
    }

    public function generateProductPerformancePDF()
    {
        $startDate = $_GET['start_date'] ?? date('Y-m-01');
        $endDate = $_GET['end_date'] ?? date('Y-m-t');

        $products = $this->reportModel->getProductPerformance($startDate, $endDate);

        require_once __DIR__ . '/../includes/fpdf/fpdf.php';

        $pdf = new FPDF();
        $pdf->AddPage();
        $pdf->SetFont('Arial', 'B', 16);
        $pdf->Cell(0, 10, 'Product Performance Report (' . $startDate . ' to ' . $endDate . ')', 0, 1, 'C');

        $pdf->SetFont('Arial', 'B', 12);
        $pdf->Cell(0, 10, 'Product Sales Summary', 0, 1);
        $pdf->SetFont('Arial', '', 10);

        $pdf->Cell(50, 10, 'Product', 1);
        $pdf->Cell(40, 10, 'Category', 1);
        $pdf->Cell(30, 10, 'Price', 1);
        $pdf->Cell(30, 10, 'Qty Sold', 1);
        $pdf->Cell(40, 10, 'Revenue', 1);
        $pdf->Ln();

        $totalRevenue = 0;
        $totalSold = 0;

        foreach ($products as $product) {
            $pdf->Cell(50, 10, $product['product_name'], 1);
            $pdf->Cell(40, 10, $product['category_name'], 1);
            $pdf->Cell(30, 10, number_format($product['sell_price'], 2), 1);
            $pdf->Cell(30, 10, $product['total_sold'], 1);
            $pdf->Cell(40, 10, number_format($product['total_revenue'], 2), 1);
            $pdf->Ln();

            $totalRevenue += $product['total_revenue'];
            $totalSold += $product['total_sold'];
        }

        $pdf->SetFont('Arial', 'B', 10);
        $pdf->Cell(120, 10, 'Total', 1);
        $pdf->Cell(30, 10, $totalSold, 1);
        $pdf->Cell(40, 10, number_format($totalRevenue, 2), 1);
        $pdf->Ln();

        $pdf->Output('I', 'product_performance_' . $startDate . '_' . $endDate . '.pdf');
    }

    public function supplierReport()
    {
        $title = 'Supplier Report';
        $supplierId = $_GET['supplier_id'] ?? null;
        $suppliers = $this->reportModel->getSupplierPerformance();

        $supplierDetails = null;
        if ($supplierId) {
            $supplierDetails = $this->reportModel->getSupplierShipments($supplierId);
        }

        require_once __DIR__ . '/../views/reports/supplier_report.php';
    }

    public function generateSupplierPDF($supplierId)
    {
        $suppliers = $this->reportModel->getSupplierPerformance();
        $supplierDetails = $this->reportModel->getSupplierShipments($supplierId);

        if (empty($suppliers)) {
            die("Supplier not found");
        }

        $supplier = null;
        foreach ($suppliers as $s) {
            if ($s['supplier_id'] == $supplierId) {
                $supplier = $s;
                break;
            }
        }

        if (!$supplier) {
            die("Supplier not found");
        }

        require_once __DIR__ . '/../includes/fpdf/fpdf.php';

        $pdf = new FPDF();
        $pdf->AddPage();
        $pdf->SetFont('Arial', 'B', 16);
        $pdf->Cell(0, 10, 'Supplier Performance Report', 0, 1, 'C');

        // Supplier Info
        $pdf->SetFont('Arial', 'B', 12);
        $pdf->Cell(0, 10, 'Supplier Information', 0, 1);
        $pdf->SetFont('Arial', '', 10);

        $pdf->Cell(40, 10, 'Supplier ID:', 0);
        $pdf->Cell(0, 10, $supplier['supplier_id'], 0);
        $pdf->Ln();

        $pdf->Cell(40, 10, 'Name:', 0);
        $pdf->Cell(0, 10, $supplier['supplier_name'], 0);
        $pdf->Ln();

        $pdf->Cell(40, 10, 'Contact:', 0);
        $pdf->Cell(0, 10, $supplier['contactno'], 0);
        $pdf->Ln();

        $pdf->Cell(40, 10, 'Address:', 0);
        $pdf->Cell(0, 10, $supplier['address'], 0);
        $pdf->Ln();

        $pdf->Cell(40, 10, 'Total Shipments:', 0);
        $pdf->Cell(0, 10, $supplier['total_shipments'], 0);
        $pdf->Ln();

        $pdf->Cell(40, 10, 'Total Items:', 0);
        $pdf->Cell(0, 10, $supplier['total_items'], 0);
        $pdf->Ln();

        $pdf->Cell(40, 10, 'Total Cost:', 0);
        $pdf->Cell(0, 10, number_format($supplier['total_cost'], 2), 0);
        $pdf->Ln(15);

        // Shipment History
        $pdf->SetFont('Arial', 'B', 12);
        $pdf->Cell(0, 10, 'Shipment History', 0, 1);
        $pdf->SetFont('Arial', '', 10);

        $pdf->Cell(30, 10, 'Shipment ID', 1);
        $pdf->Cell(40, 10, 'Date', 1);
        $pdf->Cell(60, 10, 'Product', 1);
        $pdf->Cell(30, 10, 'Quantity', 1);
        $pdf->Cell(30, 10, 'Total Cost', 1);
        $pdf->Ln();

        foreach ($supplierDetails as $shipment) {
            $pdf->Cell(30, 10, $shipment['inventory_id'], 1);
            $pdf->Cell(40, 10, $shipment['date_added'], 1);
            $pdf->Cell(60, 10, $shipment['product_name'], 1);
            $pdf->Cell(30, 10, $shipment['quantity_added'], 1);
            $pdf->Cell(30, 10, number_format($shipment['total_cost'], 2), 1);
            $pdf->Ln();
        }

        $pdf->Output('I', 'supplier_report_' . $supplierId . '.pdf');
    }

}