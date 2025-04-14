<?php
// Include the FPDF library (download from http://www.fpdf.org/)
require_once __DIR__ . '/fpdf/fpdf.php';

function generateOrderPdf($order, $items) {
    $pdf = new FPDF();
    $pdf->AddPage();
    $pdf->SetFont('Arial', 'B', 16);
    
    // Header
    $pdf->Cell(0, 10, 'INVOICE', 0, 1, 'C');
    $pdf->SetFont('Arial', '', 12);
    $pdf->Cell(0, 10, 'Order #' . $order['order_id'], 0, 1, 'C');
    $pdf->Ln(10);
    
    // Order Details
    $pdf->SetFont('Arial', 'B', 12);
    $pdf->Cell(0, 10, 'Order Details', 0, 1);
    $pdf->SetFont('Arial', '', 12);
    
    $pdf->Cell(50, 10, 'Date:', 0, 0);
    $pdf->Cell(0, 10, $order['order_date'], 0, 1);
    
    $pdf->Cell(50, 10, 'Customer:', 0, 0);
    $pdf->Cell(0, 10, $order['customer_name'], 0, 1);
    
    $pdf->Cell(50, 10, 'Cashier:', 0, 0);
    $pdf->Cell(0, 10, $order['cashier_name'], 0, 1);
    
    $pdf->Cell(50, 10, 'Payment Method:', 0, 0);
    $pdf->Cell(0, 10, $order['payment_method'], 0, 1);
    $pdf->Ln(10);
    
    // Items Table
    $pdf->SetFont('Arial', 'B', 12);
    $pdf->Cell(80, 10, 'Product', 1, 0);
    $pdf->Cell(30, 10, 'Price', 1, 0, 'R');
    $pdf->Cell(30, 10, 'Qty', 1, 0, 'R');
    $pdf->Cell(50, 10, 'Subtotal', 1, 1, 'R');
    $pdf->SetFont('Arial', '', 12);
    
    foreach ($items as $item) {
        $pdf->Cell(80, 10, $item['product_name'], 1, 0);
        $pdf->Cell(30, 10, number_format($item['sell_price'], 2), 1, 0, 'R');
        $pdf->Cell(30, 10, $item['qty'], 1, 0, 'R');
        $pdf->Cell(50, 10, number_format($item['sub_total'], 2), 1, 1, 'R');
    }
    
    // Total
    $pdf->SetFont('Arial', 'B', 12);
    $pdf->Cell(140, 10, 'Total', 1, 0, 'R');
    $pdf->Cell(50, 10, number_format($order['total_amount'], 2), 1, 1, 'R');
    
    // Footer
    $pdf->Ln(20);
    $pdf->SetFont('Arial', 'I', 10);
    $pdf->Cell(0, 10, 'Thank you come again!!', 0, 1, 'C');
    
    return $pdf;
}
?>