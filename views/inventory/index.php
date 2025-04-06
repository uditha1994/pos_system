<?php require_once __DIR__ . '/../../includes/header.php'; ?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <h2>Inventory Management</h2>
    <div>
        <a href="<?= BASE_PATH ?>/inventory/create" class="btn btn-primary me-2">
            <i class="fas fa-plus"></i> Add Inventory
        </a>
        <a href="<?= BASE_PATH ?>/inventory/stock-report" class="btn btn-info">
            <i class="fas fa-chart-bar"></i> Stock Report
        </a>
    </div>
</div>

<?php if (isset($_SESSION['success'])): ?>
    <div class="alert alert-success"><?= $_SESSION['success'] ?></div>
    <?php unset($_SESSION['success']); ?>
<?php endif; ?>

<?php if (isset($_SESSION['error'])): ?>
    <div class="alert alert-danger"><?= $_SESSION['error'] ?></div>
    <?php unset($_SESSION['error']); ?>
<?php endif; ?>

<div class="card mb-4">
    <div class="card-body">
        <form method="GET" action="<?= BASE_PATH ?>/inventory" class="row g-3">
            <div class="col-md-8">
                <input type="text" name="search" class="form-control" placeholder="Search by product name or ID"
                    value="<?= htmlspecialchars($_GET['search'] ?? '') ?>">
            </div>
            <div class="col-md-2">
                <button type="submit" class="btn btn-primary w-100">Search</button>
            </div>
            <div class="col-md-2">
                <a href="<?= BASE_PATH ?>/inventory" class="btn btn-secondary w-100">Reset</a>
            </div>
        </form>
    </div>
</div>

<div class="card">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Product</th>
                        <th>Quantity</th>
                        <th>Cost</th>
                        <th>Sell Price</th>
                        <th>Supplier</th>
                        <th>Added By</th>
                        <th>Date Added</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (empty($inventoryItems)): ?>
                        <tr>
                            <td colspan="9" class="text-center">No inventory items found</td>
                        </tr>
                    <?php else: ?>
                        <?php foreach ($inventoryItems as $item): ?>
                            <tr>
                                <td><?= $item['inventory_id'] ?></td>
                                <td><?= htmlspecialchars($item['product_name']) ?> (<?= $item['product_id'] ?>)</td>
                                <td><?= $item['quantity_added'] ?></td>
                                <td><?= number_format($item['cost'], 2) ?></td>
                                <td><?= number_format($item['sell_price'], 2) ?></td>
                                <td><?= htmlspecialchars($item['supplier_name']) ?></td>
                                <td><?= htmlspecialchars($item['username']) ?></td>
                                <td><?= $item['date_added'] ?></td>
                                <td>
                                    <a href="<?= BASE_PATH ?>/inventory/edit/<?= $item['inventory_id'] ?>"
                                        class="btn btn-sm btn-warning me-1">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <form action="<?= BASE_PATH ?>/inventory/delete/<?= $item['inventory_id'] ?>" method="POST"
                                        style="display: inline;">
                                        <button type="submit" class="btn btn-sm btn-danger"
                                            onclick="return confirm('Are you sure you want to delete this item?')">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<?php require_once __DIR__ . '/../../includes/footer.php'; ?>