<?php require_once __DIR__ . '/../../includes/header.php'; ?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <h2>Customers</h2>
    <a href="<?= BASE_PATH ?>/customers/create" class="btn btn-primary">Add New Customer</a>
</div>

<?php if (isset($_SESSION['success'])): ?>
    <div class="alert alert-success"><?= $_SESSION['success'] ?></div>
    <?php unset($_SESSION['success']); ?>
<?php endif; ?>

<?php if (isset($_SESSION['error'])): ?>
    <div class="alert alert-danger"><?= $_SESSION['error'] ?></div>
    <?php unset($_SESSION['error']); ?>
<?php endif; ?>

<div class="card">
    <div class="card-body">
        <?php if (empty($customers)): ?>
            <div class="alert alert-warning">No customers found.</div>
        <?php else: ?>
            <div class="table-responsive">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Full Name</th>
                            <th>Phone</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($customers as $customer): ?>
                            <tr>
                                <td><?= htmlspecialchars($customer['customer_id']) ?></td>
                                <td><?= htmlspecialchars($customer['full_name']) ?></td>
                                <td><?= htmlspecialchars($customer['contactno']) ?></td>
                                <td>
                                    <a href="<?= BASE_PATH ?>/customers/edit/<?= $customer['customer_id'] ?>"
                                        class="btn btn-sm btn-warning">Edit</a>
                                    <form action="<?= BASE_PATH ?>/customers/delete/<?= $customer['customer_id'] ?>"
                                        method="POST" style="display:inline">
                                        <button type="submit" class="btn btn-sm btn-danger"
                                            onclick="return confirm('Are you sure?')">Delete</button>
                                    </form>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        <?php endif; ?>
    </div>
</div>

<?php require_once __DIR__ . '/../../includes/footer.php'; ?>