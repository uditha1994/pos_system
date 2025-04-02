<?php require_once __DIR__ . '/../../includes/header.php'; ?>

<div class="card">
    <div class="card-body">
        <h4 class="card-title">Edit Product</h4>
        <form method="POST" action="<?= BASE_PATH ?>/products/update/<?= $product['product_id'] ?>">
            <div class="mb-3">
                <label for="product_name" class="form-label">Product Name</label>
                <input type="text" class="form-control" id="product_name" name="product_name"
                    value="<?= htmlspecialchars($product['product_name']) ?>" required>
            </div>
            <div class="mb-3">
                <label for="description" class="form-label">Description</label>
                <textarea class="form-control" id="description"
                    name="description"><?= htmlspecialchars($product['description']) ?></textarea>
            </div>
            <div class="mb-3">
                <label for="quantity" class="form-label">quantity</label>
                <input type="text" class="form-control" id="quantity" name="quantity"
                    value="<?= htmlspecialchars($product['quantity']) ?>" required>
            </div>
            <div class="mb-3">
                <label for="category_id" class=form-label>Category ID</label>
                <select name="category_id" id="category_id" class="form-select">
                    <option value="">--Select Category--</option>
                    <?php foreach ($categories as $category): ?>
                        <option value="<?= $category['category_id'] ?>">
                            <?= htmlspecialchars($category['category_name']) ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>
            <button type="submit" class="btn btn-primary">Update Customer</button>
            <a href="<?= BASE_PATH ?>/products" class="btn btn-secondary">Cancel</a>
        </form>
    </div>
</div>

<?php require_once __DIR__ . '/../../includes/footer.php'; ?>