<?php require_once __DIR__ . '/../../includes/header.php'; ?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <h2>Stock Report</h2>
    <div>
        <form method="GET" action="<?= BASE_PATH ?>/inventory/stock-report" class="d-flex">
            <input type="text" name="product_id" class="form-control me-2" placeholder="Search by Product ID"
                value="<?= htmlspecialchars($_GET['product_id'] ?? '') ?>">
            <button type="submit" class="btn btn-primary me-2">Search</button>
            <a href="<?= BASE_PATH ?>/inventory/stock-report" class="btn btn-secondary">Reset</a>
        </form>
    </div>
</div>

<div class="card">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>Product ID</th>
                        <th>Product Name</th>
                        <th>Available Quantity</th>
                        <th>Sell Price</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (empty($stockItems)): ?>
                        <tr>
                            <td colspan="4" class="text-center">No stock items found</td>
                        </tr>
                    <?php else: ?>
                        <?php foreach ($stockItems as $item): ?>
                            <tr>
                                <td><?= $item['product_id'] ?></td>
                                <td><?= htmlspecialchars($item['product_name']) ?></td>
                                <td><?= $item['total_quantity'] ?></td>
                                <td><?= $item['sell_price'] === null ? "0.00" : number_format($item['sell_price'], 2) ?></td>
                            </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<?php require_once __DIR__ . '/../../includes/footer.php'; ?>