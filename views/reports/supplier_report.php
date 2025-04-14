<?php
require_once __DIR__ . '/../../includes/header.php';
?>

<div class="container-fluid">
    <div class="row mb-4">
        <div class="col-md-12">
            <h2><i class="fas fa-truck"></i> Supplier Performance Report</h2>
        </div>
    </div>

    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <div class="row">
                <div class="col-md-6">
                    <h6 class="m-0 font-weight-bold text-primary">Supplier Performance</h6>
                </div>
                <?php if (!empty($supplierId)): ?>
                    <div class="col-md-6 text-right">
                        <a href="<?= BASE_PATH ?>/reports/generateSupplierPDF/<?= $supplierId ?>"
                            class="btn btn-danger btn-sm">
                            <i class="fas fa-file-pdf"></i> Export PDF
                        </a>
                    </div>
                <?php endif; ?>
            </div>
        </div>
        <div class="card-body">
            <form method="get" action="<?= BASE_PATH ?>/reports/suppliers">
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="supplier_id">Select Supplier</label>
                            <select class="form-control select2" id="supplier_id" name="supplier_id">
                                <option value="">All Suppliers</option>
                                <?php foreach ($suppliers as $supp): ?>
                                    <option value="<?= $supp['supplier_id'] ?>" <?= ($supplierId == $supp['supplier_id']) ? 'selected' : '' ?>>
                                        <?= htmlspecialchars($supp['supplier_name']) ?>
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

    <?php if (!empty($supplierId)): ?>
        <div class="row">
            <div class="col-md-4">
                <div class="card shadow mb-4">
                    <div class="card-header py-3 bg-info text-white">
                        <h6 class="m-0 font-weight-bold">Supplier Summary</h6>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-12">
                                <?php
                                $supplier = null;
                                foreach ($suppliers as $s) {
                                    if ($s['supplier_id'] == $supplierId) {
                                        $supplier = $s;
                                        break;
                                    }
                                }
                                ?>
                                <?php if ($supplier): ?>
                                    <p><strong>Name:</strong> <?= htmlspecialchars($supplier['supplier_name']) ?></p>
                                    <p><strong>Email:</strong> <?= htmlspecialchars($supplier['address']) ?></p>
                                    <p><strong>Phone:</strong> <?= htmlspecialchars($supplier['contactno']) ?></p>
                                    <hr>
                                    <p><strong>Shipments:</strong> <?= htmlspecialchars($supplier['total_shipments']) ?></p>
                                    <p><strong>Total Items:</strong> <?= htmlspecialchars($supplier['total_items']) ?></p>
                                    <p><strong>Total Cost:</strong> $<?= number_format($supplier['total_cost'], 2) ?></p>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-8">
                <div class="card shadow mb-4">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-primary">Shipment History</h6>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-bordered" width="100%" cellspacing="0">
                                <thead>
                                    <tr>
                                        <th>Shipment ID</th>
                                        <th>Date</th>
                                        <th>Product</th>
                                        <th>Quantity</th>
                                        <th>Total Cost</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php if (empty($supplierDetails)): ?>
                                        <tr>
                                            <td colspan="5" class="text-center">No shipments found</td>
                                        </tr>
                                    <?php else: ?>
                                        <?php foreach ($supplierDetails as $shipment): ?>
                                            <tr>
                                                <td><?= htmlspecialchars($shipment['inventory_id']) ?></td>
                                                <td><?= htmlspecialchars($shipment['date_added']) ?></td>
                                                <td><?= htmlspecialchars($shipment['product_name']) ?></td>
                                                <td><?= htmlspecialchars($shipment['quantity_added']) ?></td>
                                                <td>$<?= number_format($shipment['total_cost'], 2) ?></td>
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
                <h6 class="m-0 font-weight-bold text-primary">Supplier Performance</h6>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th>Supplier</th>
                                <th>Contact</th>
                                <th>Address</th>
                                <th>Shipments</th>
                                <th>Total Items</th>
                                <th>Total Cost</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (empty($suppliers)): ?>
                                <tr>
                                    <td colspan="7" class="text-center">No suppliers found</td>
                                </tr>
                            <?php else: ?>
                                <?php foreach ($suppliers as $supplier): ?>
                                    <tr>
                                        <td><?= htmlspecialchars($supplier['supplier_name']) ?></td>
                                        <td><?= htmlspecialchars($supplier['contactno']) ?></td>
                                        <td><?= htmlspecialchars($supplier['address']) ?></td>
                                        <td><?= htmlspecialchars($supplier['total_shipments']) ?></td>
                                        <td><?= htmlspecialchars($supplier['total_items']) ?></td>
                                        <td>$<?= number_format($supplier['total_cost'], 2) ?></td>
                                        <td>
                                            <a href="<?= BASE_PATH ?>/reports/suppliers?supplier_id=<?= $supplier['supplier_id'] ?>"
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