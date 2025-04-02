
<?php require_once __DIR__ . '/../../includes/header.php'; ?>

<div class="card">
    <div class="card-body">
        <h4 class="card-title">Edit Supplier</h4>
        <form method="POST" action="<?= BASE_PATH ?>/suppliers/update/<?= $supplier['supplier_id'] ?>">
            <div class="mb-3">
                <label for="name" class="form-label">Name *</label>
                <input type="text" class="form-control" id="name" name="name"
                    value="<?= htmlspecialchars($supplier['supplier_name']) ?>" required>
            </div>

            <div class="mb-3">
                <label for="phone_number" class="form-label">Phone Number</label>
                <input type="text" class="form-control" id="phone_number" name="phone_number"
                    value="<?= htmlspecialchars($supplier['contactno']) ?>">
            </div>

            <div class="mb-3">
                <label for="address" class="form-label">Address</label>
                <textarea class="form-control" id="address" name="address" rows="3"><?=
                    htmlspecialchars($supplier['address']) ?></textarea>
            </div>

            <button type="submit" class="btn btn-primary">Update Supplier</button>
            <a href="<?= BASE_PATH ?>/suppliers" class="btn btn-secondary">Cancel</a>
        </form>
    </div>
</div>

<?php require_once __DIR__ . '/../../includes/footer.php'; ?>