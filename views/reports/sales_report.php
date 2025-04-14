<?php
require_once __DIR__ . '/../../includes/header.php';
?>

<div class="container-fluid">
    <div class="row mb-4">
        <div class="col-md-12">
            <h2><i class="fas fa-chart-line"></i> Sales Report</h2>
        </div>
    </div>

    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <div class="row">
                <div class="col-md-6">
                    <h6 class="m-0 font-weight-bold text-primary">Filter Report</h6>
                </div>
                <div class="col-md-6 text-right">
                    <a href="<?= BASE_PATH ?>/reports/generateSalesPDF?<?= http_build_query($_GET) ?>"
                        class="btn btn-danger btn-sm">
                        <i class="fas fa-file-pdf"></i> Export PDF
                    </a>
                </div>
            </div>
        </div>
        <div class="card-body">
            <form method="get" action="<?= BASE_PATH ?>/reports/sales">
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

    <div class="row">
        <div class="col-lg-8">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Sales Summary</h6>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered" width="100%" cellspacing="0">
                            <thead>
                                <tr>
                                    <th>Date</th>
                                    <th>Orders</th>
                                    <th>Total Sales</th>
                                    <th>Items Sold</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if (empty($salesData)): ?>
                                    <tr>
                                        <td colspan="4" class="text-center">No sales data found</td>
                                    </tr>
                                <?php else: ?>
                                    <?php
                                    $totalSales = 0;
                                    $totalItems = 0;
                                    $totalOrders = 0;
                                    ?>
                                    <?php foreach ($salesData as $sale): ?>
                                        <tr>
                                            <td><?= htmlspecialchars($sale['order_day']) ?></td>
                                            <td><?= htmlspecialchars($sale['total_orders']) ?></td>
                                            <td>LKR. <?= number_format($sale['total_sales'], 2) ?></td>
                                            <td><?= htmlspecialchars($sale['total_items_sold']) ?></td>
                                        </tr>
                                        <?php
                                        $totalSales += $sale['total_sales'];
                                        $totalItems += $sale['total_items_sold'];
                                        $totalOrders += $sale['total_orders'];
                                        ?>
                                    <?php endforeach; ?>
                                    <tr class="font-weight-bold">
                                        <td>Total</td>
                                        <td><?= $totalOrders ?></td>
                                        <td>LKR. <?= number_format($totalSales, 2) ?></td>
                                        <td><?= $totalItems ?></td>
                                    </tr>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-4">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Top Selling Products</h6>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered" width="100%" cellspacing="0">
                            <thead>
                                <tr>
                                    <th>Product</th>
                                    <th>Qty Sold</th>
                                    <th>Revenue</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if (empty($topProducts)): ?>
                                    <tr>
                                        <td colspan="3" class="text-center">No products sold</td>
                                    </tr>
                                <?php else: ?>
                                    <?php foreach ($topProducts as $product): ?>
                                        <tr>
                                            <td><?= htmlspecialchars($product['product_name']) ?></td>
                                            <td><?= htmlspecialchars($product['total_quantity']) ?></td>
                                            <td>LKR. <?= number_format($product['total_revenue'], 2) ?></td>
                                        </tr>
                                    <?php endforeach; ?>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php require_once __DIR__ . '/../../includes/footer.php'; ?>