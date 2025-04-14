<?php require_once __DIR__ . '/../../includes/header.php'; ?>

<div class="card">
    <div class="card-body">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2>Order #<?= $order['order_id'] ?></h2>
            <div>
                <a href="<?= BASE_PATH ?>/orders/generate-pdf/<?= $order['order_id'] ?>" class="btn btn-primary me-2">
                    <i class="fas fa-file-pdf"></i> Generate Invoice
                </a>
                <a href="<?= BASE_PATH ?>/orders" class="btn btn-secondary">
                    Back to Orders
                </a>
            </div>
        </div>

        <div class="row mb-4">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Order Details</h5>
                        <p><strong>Order Date:</strong> <?= $order['order_date'] ?></p>
                        <p><strong>Customer:</strong> <?= htmlspecialchars($order['customer_name']) ?></p>
                        <p><strong>Cashier:</strong> <?= htmlspecialchars($order['cashier_name']) ?></p>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Payment Summary</h5>
                        <p><strong>Payment Method:</strong> <?= $order['payment_method'] ?></p>
                        <p><strong>Total Amount:</strong> <?= number_format($order['total_amount'], 2) ?></p>
                    </div>
                </div>
            </div>
        </div>

        <div class="card">
            <div class="card-header">
                <h5>Order Items</h5>
            </div>
            <div class="card-body">
                <table class="table">
                    <thead>
                        <tr>
                            <th>Product</th>
                            <th>Price</th>
                            <th>Quantity</th>
                            <th>Subtotal</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($items as $item): ?>
                            <tr>
                                <td><?= htmlspecialchars($item['product_name']) ?></td>
                                <td><?= number_format($item['sell_price'], 2) ?></td>
                                <td><?= $item['qty'] ?></td>
                                <td><?= number_format($item['sub_total'], 2) ?></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                    <tfoot>
                        <tr>
                            <th colspan="3">Total</th>
                            <th><?= number_format($order['total_amount'], 2) ?></th>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
    </div>
</div>

<?php require_once __DIR__ . '/../../includes/footer.php'; ?>