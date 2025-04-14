<?php require_once __DIR__ . '/../includes/auth.php'; ?>
<?php authenticateUser(); ?>
<?php require_once __DIR__ . '/../includes/header.php'; ?>

<div class="container">
    <h1 class="my-4">POS System Dashboard</h1>

    <!-- Summary Cards -->
    <div class="row">
        <!-- Categories Card -->
        <div class="col-md-3 mb-4">
            <div class="card h-100">
                <div class="card-body d-flex flex-column justify-content-between">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h5 class="card-title">Categories</h5>
                            <h2 class="mb-0"><?= $categoryCount ?></h2>
                        </div>
                        <span class="badge bg-primary rounded-circle p-3">
                            <i class="fas fa-tags fa-2x"></i>
                        </span>
                    </div>
                    <a href="<?= BASE_PATH ?>/categories" class="btn btn-sm btn-primary mt-3">Manage Categories</a>
                </div>
            </div>
        </div>

        <!-- Products Card -->
        <div class="col-md-3 mb-4">
            <div class="card h-100">
                <div class="card-body d-flex flex-column justify-content-between">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h5 class="card-title">Products</h5>
                            <h2 class="mb-0"><?= $productCount ?></h2>
                        </div>
                        <span class="badge bg-success rounded-circle p-3">
                            <i class="fas fa-boxes fa-2x"></i>
                        </span>
                    </div>
                    <a href="<?= BASE_PATH ?>/products" class="btn btn-sm btn-success mt-3">Manage Products</a>
                </div>
            </div>
        </div>

        <!-- Customers Card -->
        <div class="col-md-3 mb-4">
            <div class="card h-100">
                <div class="card-body d-flex flex-column justify-content-between">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h5 class="card-title">Customers</h5>
                            <h2 class="mb-0"><?= $customerCount ?></h2>
                        </div>
                        <span class="badge bg-info rounded-circle p-3">
                            <i class="fas fa-users fa-2x"></i>
                        </span>
                    </div>
                    <a href="<?= BASE_PATH ?>/customers" class="btn btn-sm btn-info mt-3">Manage Customers</a>
                </div>
            </div>
        </div>

        <!-- Suppliers Card -->
        <div class="col-md-3 mb-4">
            <div class="card h-100">
                <div class="card-body d-flex flex-column justify-content-between">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h5 class="card-title">Suppliers</h5>
                            <h2 class="mb-0"><?= $supplierCount ?></h2>
                        </div>
                        <span class="badge bg-warning rounded-circle p-3">
                            <i class="fas fa-truck fa-2x"></i>
                        </span>
                    </div>
                    <a href="<?= BASE_PATH ?>/suppliers" class="btn btn-sm btn-warning mt-3">Manage Suppliers</a>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <!-- Users Card -->
        <div class="col-md-3 mb-4">
            <div class="card h-100">
                <div class="card-body d-flex flex-column justify-content-between">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h5 class="card-title">Users</h5>
                            <h2 class="mb-0"><?= $userCount ?></h2>
                        </div>
                        <span class="badge bg-purple rounded-circle p-3">
                            <i class="fas fa-user-shield fa-2x"></i>
                        </span>
                    </div>
                    <a href="<?= BASE_PATH ?>/users" class="btn btn-sm btn-purple mt-3">Manage Users</a>
                </div>
            </div>
        </div>

        <!-- Inventory Card -->
        <div class="col-md-3 mb-4">
            <div class="card h-100">
                <div class="card-body d-flex flex-column justify-content-between">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h5 class="card-title">Inventory</h5>
                            <h2 class="mb-0"><?= $inventoryCount ?></h2>
                            <small class="text-muted"><?= $lowStockCount ?> low stock</small>
                        </div>
                        <span class="badge bg-orange rounded-circle p-3">
                            <i class="fas fa-box-open fa-2x"></i>
                        </span>
                    </div>
                    <a href="<?= BASE_PATH ?>/inventory" class="btn btn-sm btn-orange mt-3">View Inventory</a>
                </div>
            </div>
        </div>

        <!-- Orders Card -->
        <div class="col-md-3 mb-4">
            <div class="card h-100 shadow-sm">
                <div class="card-body d-flex flex-column justify-content-between">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h5 class="card-title">Orders</h5>
                            <h2 class="mb-0"><?= $orderCount ?></h2>
                        </div>
                        <span class="badge bg-danger rounded-circle p-3">
                            <i class="fas fa-clipboard-list fa-2x"></i>
                        </span>
                    </div>
                    <a href="<?= BASE_PATH ?>/orders" class="btn btn-sm btn-danger mt-3">View Orders</a>
                </div>
            </div>
        </div>

    </div>

    <!-- Quick Actions Row -->
    <div class="row mb-4">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">Quick Actions</h5>
                </div>
                <div class="card-body">
                    <div class="d-flex flex-wrap gap-2">
                        <a href="<?= BASE_PATH ?>/products/create" class="btn btn-outline-primary">
                            <i class="fas fa-plus-circle me-2"></i> Add New Product
                        </a>
                        <a href="<?= BASE_PATH ?>/categories/create" class="btn btn-outline-secondary">
                            <i class="fas fa-plus-circle me-2"></i> Add New Category
                        </a>
                        <a href="<?= BASE_PATH ?>/customers/create" class="btn btn-outline-success">
                            <i class="fas fa-user-plus me-2"></i> Add New Customer
                        </a>
                        <a href="<?= BASE_PATH ?>/suppliers/create" class="btn btn-outline-info">
                            <i class="fas fa-truck-loading me-2"></i> Add New Supplier
                        </a>
                        <a href="<?= BASE_PATH ?>/orders/create" class="btn btn-outline-warning">
                            <i class="fas fa-clipboard-list me-2"></i> Add New Order
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Recent Activity Section -->
    <div class="row">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">Recent Products</h5>
                </div>
                <div class="card-body">
                    <?php if (!empty($recentProducts)): ?>
                        <div class="list-group">
                            <?php foreach ($recentProducts as $product): ?>
                                <a href="<?= BASE_PATH ?>/products/edit/<?= $product['product_id'] ?>"
                                    class="list-group-item list-group-item-action">
                                    <div class="d-flex w-100 justify-content-between">
                                        <h6 class="mb-1"><?= htmlspecialchars($product['product_name']) ?></h6>
                                    </div>
                                    <small class="text-muted">
                                        Stock: <?= $product['quantity'] ?>
                                    </small>
                                </a>
                            <?php endforeach; ?>
                        </div>
                    <?php else: ?>
                        <p class="text-muted">No recent products found</p>
                    <?php endif; ?>
                </div>
            </div>
        </div>

        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">Recent Customers</h5>
                </div>
                <div class="card-body">
                    <?php if (!empty($recentCustomers)): ?>
                        <div class="list-group">
                            <?php foreach ($recentCustomers as $customer): ?>
                                <a href="<?= BASE_PATH ?>/customers/edit/<?= $customer['customer_id'] ?>"
                                    class="list-group-item list-group-item-action">
                                    <div class="d-flex w-100 justify-content-between">
                                        <h6 class="mb-1"><?= htmlspecialchars($customer['full_name']) ?></h6>
                                    </div>
                                    <small class="text-muted">
                                        <?= htmlspecialchars($customer['contactno']) ?>
                                    </small>
                                </a>
                            <?php endforeach; ?>
                        </div>
                    <?php else: ?>
                        <p class="text-muted">No recent customers found</p>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>

<?php require_once __DIR__ . '/../includes/footer.php'; ?>