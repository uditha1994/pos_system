<?php
require_once __DIR__ . '/../../includes/header.php';
?>

<div class="container-fluid">
    <div class="row mb-4">
        <div class="col-md-12">
            <h2><i class="fas fa-users"></i> Customer Purchase Report</h2>
        </div>
    </div>

    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <div class="row">
                <div class="col-md-6">
                    <h6 class="m-0 font-weight-bold text-primary">Customer Purchase History</h6>
                </div>
                <?php if (!empty($customerId)): ?>
                    <div class="col-md-6 text-right">
                        <a href="<?= BASE_PATH ?>/reports/generateCustomerPDF/<?= $customerId ?>"
                            class="btn btn-danger btn-sm">
                            <i class="fas fa-file-pdf"></i> Export PDF
                        </a>
                    </div>
                <?php endif; ?>
            </div>
        </div>
        <div class="card-body">
            <form method="get" action="<?= BASE_PATH ?>/reports/customers">
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="customer_id">Select Customer</label>
                            <select class="form-control select2" id="customer_id" name="customer_id">
                                <option value="">All Customers</option>
                                <?php foreach ($customers as $cust): ?>
                                    <option value="<?= $cust['customer_id'] ?>" <?= ($customerId == $cust['customer_id']) ? 'selected' : '' ?>>
                                        <?= htmlspecialchars($cust['full_name']) ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
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

    <?php if (!empty($customerId)): ?>
        <div class="row">
            <div class="col-md-4">
                <div class="card shadow mb-4">
                    <div class="card-header py-3 bg-info text-white">
                        <h6 class="m-0 font-weight-bold">Customer Summary</h6>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-12">
                                <p><strong>Name:</strong> <?= htmlspecialchars($customers[0]['full_name']) ?></p>
                                <p><strong>Phone:</strong> <?= htmlspecialchars($customers[0]['contactno']) ?></p>
                                <hr>
                                <p><strong>Total Orders:</strong> <?= htmlspecialchars($customers[0]['total_orders']) ?></p>
                                <p><strong>Total Spent:</strong> LKR. <?= number_format($customers[0]['total_spent'], 2) ?></p>
                                <p><strong>Last Order:</strong> <?= htmlspecialchars($customers[0]['last_order_date']) ?>
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-8">
                <div class="card shadow mb-4">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-primary">Order History</h6>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-bordered" width="100%" cellspacing="0">
                                <thead>
                                    <tr>
                                        <th>Order ID</th>
                                        <th>Date</th>
                                        <th>Amount</th>
                                        <th>Products</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php if (empty($customerDetails)): ?>
                                        <tr>
                                            <td colspan="4" class="text-center">No orders found</td>
                                        </tr>
                                    <?php else: ?>
                                        <?php foreach ($customerDetails as $order): ?>
                                            <tr>
                                                <td><?= htmlspecialchars($order['order_id']) ?></td>
                                                <td><?= htmlspecialchars($order['order_date']) ?></td>
                                                <td>LKR. <?= number_format($order['total_amount'], 2) ?></td>
                                                <td><?= htmlspecialchars($order['products']) ?></td>
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
    <?php else: ?>
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Customer Spending</h6>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th>Customer</th>
                                <th>Phone</th>
                                <th>Orders</th>
                                <th>Total Spent</th>
                                <th>Last Order</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (empty($customers)): ?>
                                <tr>
                                    <td colspan="7" class="text-center">No customers found</td>
                                </tr>
                            <?php else: ?>
                                <?php foreach ($customers as $customer): ?>
                                    <tr>
                                        <td><?= htmlspecialchars($customer['full_name']) ?></td>
                                        <td><?= htmlspecialchars($customer['contactno']) ?></td>
                                        <td><?= htmlspecialchars($customer['total_orders']) ?></td>
                                        <td>LKR. <?= number_format($customer['total_spent'], 2) ?></td>
                                        <td><?= htmlspecialchars($customer['last_order_date']) ?></td>
                                        <td>
                                            <a href="<?= BASE_PATH ?>/reports/customers?customer_id=<?= $customer['customer_id'] ?>"
                                                class="btn btn-info btn-sm">
                                                <i class="fas fa-eye"></i> View
                                            </a>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    <?php endif; ?>
</div>

<?php require_once __DIR__ . '/../../includes/footer.php'; ?>