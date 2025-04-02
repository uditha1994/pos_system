<?php require_once __DIR__ . '/../../includes/header.php'; ?>

<?php if (isset($_SESSION['error'])): ?>
    <div class="alert alert-danger"><?= htmlspecialchars($_SESSION['error']) ?></div>
    <?php unset($_SESSION['error']); ?>
<?php endif; ?>

<div class="card">
    <div class="card-body">
        <h4 class="card-title">Edit Category</h4>
        <form method="POST" action="<?= BASE_PATH ?>/categories/update/<?= $category['category_id'] ?>">
            <div class="mb-3">
                <label for="name" class="form-label">Name *</label>
                <input type="text" class="form-control" id="name" name="name"
                    value="<?= htmlspecialchars($category['category_name']) ?>" required>
            </div>
            <div class="mb-3">
                <label for="description" class="form-label">Description</label>
                <textarea class="form-control" id="description" name="description"
                    rows="3"><?= htmlspecialchars($category['description']) ?></textarea>
            </div>
            <button type="submit" class="btn btn-primary">Update Category</button>
            <a href="/categories" class="btn btn-secondary">Cancel</a>
        </form>
    </div>
</div>

<?php require_once __DIR__ . '/../../includes/footer.php'; ?>