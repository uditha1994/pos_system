<?php require_once __DIR__ . '/../../includes/header.php'; ?>

<div class="card">
    <div class="card-body">
        <h4 class="card-title">Add Inventory Item</h4>

        <form method="POST" action="<?= BASE_PATH ?>/inventory/store">
            <div class="row">
                <div class="col-md-6">
                    <div class="mb-3">
                        <label for="product_id" class="form-label">Product *</label>
                        <select class="form-select" id="product_id" name="product_id" required>
                            <option value="">Select Product</option>
                            <?php foreach ($products as $product): ?>
                                <option value="<?= $product['product_id'] ?>">
                                    <?= htmlspecialchars($product['product_name']) ?> (<?= $product['product_id'] ?>)
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label for="quantity_added" class="form-label">Quantity Added *</label>
                        <input type="number" class="form-control" id="quantity_added" name="quantity_added" min="1"
                            required>
                    </div>

                    <div class="mb-3">
                        <label for="cost" class="form-label">Cost Price *</label>
                        <input type="number" step="0.01" class="form-control" id="cost" name="cost" min="0" required>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="mb-3">
                        <label for="supplier_id" class="form-label">Supplier *</label>
                        <select class="form-select" id="supplier_id" name="supplier_id" required>
                            <option value="">Select Supplier</option>
                            <?php foreach ($suppliers as $supplier): ?>
                                <option value="<?= $supplier['supplier_id'] ?>">
                                    <?= htmlspecialchars($supplier['supplier_name']) ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label for="sell_price" class="form-label">Sell Price *</label>
                        <input type="number" step="0.01" class="form-control" id="sell_price" name="sell_price" min="0"
                            required>
                    </div>
                </div>
            </div>

            <button type="submit" class="btn btn-primary">Save Inventory</button>
            <a href="<?= BASE_PATH ?>/inventory" class="btn btn-secondary">Cancel</a>
        </form>
    </div>
</div>

<?php require_once __DIR__ . '/../../includes/footer.php'; ?>