<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>POS System - <?= $title ?? 'Dashboard' ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <link href="/assets/css/style.css" rel="stylesheet">
</head>

<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-primary">
        <div class="container">
            <a class="navbar-brand" href="/">
                <i class="fas fa-cash-register me-2"></i>POS System
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav me-auto">
                    <li class="nav-item">
                        <a class="nav-link <?= strpos($_SERVER['REQUEST_URI'], '/products') !== false ? 'active' : '' ?>"
                            href="<?php echo BASE_PATH; ?>/products">
                            <i class="fas fa-boxes me-1"></i> Products
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link <?= strpos($_SERVER['REQUEST_URI'], '/customers') !== false ? 'active' : '' ?>"
                            href="<?= BASE_PATH ?>/customers">
                            <i class="fas fa-users me-1"></i> Customers
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link <?= strpos($_SERVER['REQUEST_URI'], '/suppliers') !== false ? 'active' : '' ?>"
                            href="<?= BASE_PATH ?>/suppliers">
                            <i class="fas fa-truck me-1"></i> Suppliers
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link <?= strpos($_SERVER['REQUEST_URI'], '/inventory') !== false ? 'active' : '' ?>"
                            href="<?= BASE_PATH ?>/inventory">
                            <i class="fas fa-boxes me-1"></i> Inventory
                        </a>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle <?= strpos($_SERVER['REQUEST_URI'], '/reports') !== false ? 'active' : '' ?>"
                            href="#" id="reportsDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="fas fa-chart-bar me-1"></i> Reports
                        </a>
                        <ul class="dropdown-menu" aria-labelledby="reportsDropdown">
                            <li>
                                <a class="dropdown-item <?= strpos($_SERVER['REQUEST_URI'], '/reports/sales') !== false ? 'active' : '' ?>"
                                    href="<?= BASE_PATH ?>/reports/sales">
                                    <i class="fas fa-shopping-cart me-1"></i> Sales Reports
                                </a>
                            </li>
                            <li>
                                <a class="dropdown-item <?= strpos($_SERVER['REQUEST_URI'], '/reports/inventory') !== false ? 'active' : '' ?>"
                                    href="<?= BASE_PATH ?>/reports/inventory">
                                    <i class="fas fa-box-open me-1"></i> Inventory Reports
                                </a>
                            </li>
                            <li>
                                <a class="dropdown-item <?= strpos($_SERVER['REQUEST_URI'], '/reports/customers') !== false ? 'active' : '' ?>"
                                    href="<?= BASE_PATH ?>/reports/customers">
                                    <i class="fas fa-users me-1"></i> Customer Reports
                                </a>
                            </li>
                            <li>
                                <a class="dropdown-item <?= strpos($_SERVER['REQUEST_URI'], '/reports/products') !== false ? 'active' : '' ?>"
                                    href="<?= BASE_PATH ?>/reports/products">
                                    <i class="fas fa-box me-1"></i> Product Performance
                                </a>
                            </li>
                            <li>
                                <a class="dropdown-item <?= strpos($_SERVER['REQUEST_URI'], '/reports/suppliers') !== false ? 'active' : '' ?>"
                                    href="<?= BASE_PATH ?>/reports/suppliers">
                                    <i class="fas fa-money-bill-wave me-1"></i> Supplier Reports
                                </a>
                            </li>
                        </ul>
                    </li>

                </ul>
                <ul class="navbar-nav ms-auto">
                    <?php if (isset($_SESSION['user_id'])): ?>
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button"
                                data-bs-toggle="dropdown">
                                <i class="fas fa-user-circle me-1"></i>
                                <?= htmlspecialchars($_SESSION['full_name']) ?> (<?= $_SESSION['role'] ?>)
                            </a>
                            <ul class="dropdown-menu dropdown-menu-end">
                                <li><a class="dropdown-item"
                                        href="<?= BASE_PATH ?>/users/edit/<?= $_SESSION['user_id'] ?>">My
                                        Profile</a></li>
                                <li>
                                    <hr class="dropdown-divider">
                                </li>
                                <li><a class="dropdown-item" href="<?= BASE_PATH ?>/logout">Logout</a></li>
                            </ul>
                        </li>
                    <?php else: ?>
                        <li class="nav-item">
                            <a class="nav-link" href="<?= BASE_PATH ?>/login">Login</a>
                        </li>
                    <?php endif; ?>
                </ul>
            </div>
        </div>
        </div>
    </nav>

    <div class="container mt-4">