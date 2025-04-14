<?php
require_once __DIR__ . '/../../includes/header.php';
?>

<div class="container-fluid">
    <div class="row mb-4">
        <div class="col-md-12">
            <h2><i class="fas fa-boxes"></i> Inventory Report</h2>
        </div>
    </div>

    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <div class="row">
                <div class="col-md-6">
                    <h6 class="m-0 font-weight-bold text-primary">Current Stock Levels</h6>
                </div>
                <div class="col-md-6 text-right">
                    <a href="<?= BASE_PATH ?>/reports/generateInventoryPDF" class="btn btn-danger btn-sm">
                        <i class="fas fa-file-pdf"></i> Export PDF
                    </a>
                </div>
            </div>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>Product</th>
                            <th>Category</th>
                            <th>Price</th>
                            <th>In Stock</th>
                            <th>Times Sold</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (empty($stockData)): ?>
                            <tr>
                                <td colspan="5" class="text-center">No inventory data found</td>
                            </tr>
                        <?php else: ?>
                            <?php foreach ($stockData as $item): ?>
                                <tr class="<?= $item['total_stock'] <= 10 ? 'table-danger' : '' ?>">
                                    <td><?= htmlspecialchars($item['product_name']) ?></td>
                                    <td><?= htmlspecialchars($item['category_name']) ?></td>
                                    <td>LKR. <?= number_format($item['sell_price'], 2) ?></td>
                                    <td><?= htmlspecialchars($item['total_stock']) ?></td>
                                    <td><?= htmlspecialchars($item['times_sold']) ?></td>
                                </tr>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div class="card shadow mb-4">
        <div class="card-header py-3 bg-warning">
            <h6 class="m-0 font-weight-bold text-white">Low Stock Items (10 or less)</h6>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>Product</th>
                            <th>Category</th>
                            <th>Price</th>
                            <th>In Stock</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (empty($lowStockItems)): ?>
                            <tr>
                                <td colspan="4" class="text-center">No low stock items</td>
                            </tr>
                        <?php else: ?>
                            <?php foreach ($lowStockItems as $item): ?>
                                <tr>
                                    <td><?= htmlspecialchars($item['product_name']) ?></td>
                                    <td><?= htmlspecialchars($item['category_name']) ?></td>
                                    <td>LKR. <?= number_format($item['sell_price'], 2) ?></td>
                                    <td><?= htmlspecialchars($item['total_stock']) ?></td>
                                </tr>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<?php require_once __DIR__ . '/../../includes/footer.php'; ?>