<?php require_once __DIR__ . '/../../includes/header.php'; ?>

<div class="card">
    <div class="card-body">
        <h4 class="card-title">Edit Customer</h4>
        <form method="POST" action="<?= BASE_PATH ?>/customers/update/<?= $customer['customer_id'] ?>">
            <div class="mb-3">
                <label for="name" class="form-label">Full Name *</label>
                <input type="text" class="form-control" id="name" name="name"
                    value="<?= htmlspecialchars($customer['full_name']) ?>" required>
            </div>

            <div class="mb-3">
                <label for="phone_number" class="form-label">Phone Number</label>
                <input type="text" class="form-control" id="phone_number" name="phone_number"
                    value="<?= htmlspecialchars($customer['contactno']) ?>">
            </div>
            <button type="submit" class="btn btn-primary">Update Customer</button>
            <a href="<?= BASE_PATH ?>/customers" class="btn btn-secondary">Cancel</a>
        </form>
    </div>
</div>

<?php require_once __DIR__ . '/../../includes/footer.php'; ?>