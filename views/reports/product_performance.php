<?php
require_once __DIR__ . '/../../includes/header.php';
?>

<div class="container-fluid">
    <div class="row mb-4">
        <div class="col-md-12">
            <h2><i class="fas fa-chart-pie"></i> Product Performance Report</h2>
        </div>
    </div>

    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <div class="row">
                <div class="col-md-6">
                    <h6 class="m-0 font-weight-bold text-primary">Filter Report</h6>
                </div>
                <div class="col-md-6 text-right">
                    <a href="<?= BASE_PATH ?>/reports/generateProductPerformancePDF?<?= http_build_query($_GET) ?>"
                        class="btn btn-danger btn-sm">
                        <i class="fas fa-file-pdf"></i> Export PDF
                    </a>
                </div>
            </div>
        </div>
        <div class="card-body">
            <form method="get" action="<?= BASE_PATH ?>/reports/products">
                <div class="row">
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="start_date">Start Date</label>
                            <input type="date" class="form-control" id="start_date" name="start_date"
                                value="<?= htmlspecialchars($startDate) ?>">
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="end_date">End Date</label>
                            <input type="date" class="form-control" id="end_date" name="end_date"
                                value="<?= htmlspecialchars($endDate) ?>">
                        </div>
                    </div>
                    <div class="col-md-2 d-flex align-items-end">
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-filter"></i> Filter
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Product Sales Performance</h6>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>Product</th>
                            <th>Category</th>
                            <th>Price</th>
                            <th>Qty Sold</th>
                            <th>Revenue</th>
                            <th>Current Stock</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (empty($products)): ?>
                            <tr>
                                <td colspan="6" class="text-center">No product sales data found</td>
                            </tr>
                        <?php else: ?>
                            <?php
                            $totalRevenue = 0;
                            $totalSold = 0;
                            ?>
                            <?php foreach ($products as $product): ?>
                                <tr>
                                    <td><?= htmlspecialchars($product['product_name']) ?></td>
                                    <td><?= htmlspecialchars($product['category_name']) ?></td>
                                    <td>LKR. <?= number_format($product['sell_price'], 2) ?></td>
                                    <td><?= htmlspecialchars($product['total_sold']) ?></td>
                                    <td>LKR. <?= number_format($product['total_revenue'], 2) ?></td>
                                    <td><?= htmlspecialchars($product['current_stock']) ?></td>
                                </tr>
                                <?php
                                $totalRevenue += $product['total_revenue'];
                                $totalSold += $product['total_sold'];
                                ?>
                            <?php endforeach; ?>
                            <tr class="font-weight-bold">
                                <td colspan="3">Total</td>
                                <td><?= $totalSold ?></td>
                                <td>$<?= number_format($totalRevenue, 2) ?></td>
                                <td></td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<?php require_once __DIR__ . '/../../includes/footer.php'; ?>