<?php require_once __DIR__ . '/../../includes/header.php'; ?>

<div class="card">
    <div class="card-body">
        <h4 class="card-title">Create New User</h4>
        
        <?php if (isset($_SESSION['form_errors'])): ?>
            <div class="alert alert-danger">
                <ul class="mb-0">
                    <?php foreach ($_SESSION['form_errors'] as $error): ?>
                        <li><?= $error ?></li>
                    <?php endforeach; ?>
                </ul>
            </div>
            <?php unset($_SESSION['form_errors']); ?>
        <?php endif; ?>
        
        <form method="POST" action="<?= BASE_PATH ?>/users/store">
            <div class="row">
                <div class="col-md-6">
                    <div class="mb-3">
                        <label for="username" class="form-label">Username *</label>
                        <input type="text" class="form-control" id="username" name="username" 
                               value="<?= htmlspecialchars($_SESSION['form_data']['username'] ?? '') ?>" required>
                    </div>
                    
                    <div class="mb-3">
                        <label for="password" class="form-label">Password *</label>
                        <input type="password" class="form-control" id="password" name="password" required>
                    </div>
                    
                    <div class="mb-3">
                        <label for="role" class="form-label">Role *</label>
                        <select class="form-select" id="role" name="role" required>
                            <option value="Cashier" <?= ($_SESSION['form_data']['role'] ?? '') === 'Cashier' ? 'selected' : '' ?>>Cashier</option>
                            <option value="Manager" <?= ($_SESSION['form_data']['role'] ?? '') === 'Manager' ? 'selected' : '' ?>>Manager</option>
                            <option value="Admin" <?= ($_SESSION['form_data']['role'] ?? '') === 'Admin' ? 'selected' : '' ?>>Admin</option>
                        </select>
                    </div>
                </div>
                
                <div class="col-md-6">
                    <div class="mb-3">
                        <label for="full_name" class="form-label">Full Name *</label>
                        <input type="text" class="form-control" id="full_name" name="full_name" 
                               value="<?= htmlspecialchars($_SESSION['form_data']['full_name'] ?? '') ?>" required>
                    </div>
                    
                    <div class="mb-3">
                        <label for="email" class="form-label">Email *</label>
                        <input type="email" class="form-control" id="email" name="email" 
                               value="<?= htmlspecialchars($_SESSION['form_data']['email'] ?? '') ?>" required>
                    </div>
                </div>
            </div>
            
            <button type="submit" class="btn btn-primary">Save User</button>
            <a href="<?= BASE_PATH ?>/users" class="btn btn-secondary">Cancel</a>
            
            <?php unset($_SESSION['form_data']); ?>
        </form>
    </div>
</div>

<?php require_once __DIR__ . '/../../includes/footer.php'; ?>