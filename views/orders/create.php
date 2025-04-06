<?php require_once __DIR__ . '/../../includes/header.php'; ?>

<div class="card">
    <div class="card-body">
        <h4 class="card-title">Create New Order</h4>

        <div class="row">
            <div class="col-md-8">
                <div class="card mb-4">
                    <div class="card-header">
                        <h5>Available Products</h5>
                    </div>
                    <div class="card-body">
                        <div class="row" id="product-list">
                            <?php foreach ($inventoryItems as $item): ?>
                                <div class="col-md-4 mb-3">
                                    <div class="card product-card" data-inventory-id="<?= $item['inventory_id'] ?>"
                                        data-product-id="<?= $item['product_id'] ?>"
                                        data-name="<?= htmlspecialchars($item['product_name']) ?>"
                                        data-price="<?= $item['sell_price'] ?>" data-stock="<?= $item['quantity_added'] ?>">
                                        <div class="card-body">
                                            <h6><?= htmlspecialchars($item['product_name']) ?></h6>
                                            <p>Price: <?= number_format($item['sell_price'], 2) ?></p>
                                            <p>Stock: <?= $item['quantity_added'] ?></p>
                                            <button class="btn btn-sm btn-primary add-to-cart">Add to Order</button>
                                        </div>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="card">
                    <div class="card-header">
                        <h5>Order Details</h5>
                    </div>
                    <div class="card-body">
                        <form id="order-form" method="POST" action="<?= BASE_PATH ?>/orders/store">
                            <div class="mb-3">
                                <label for="customer_id" class="form-label">Customer *</label>
                                <select class="form-select" id="customer_id" name="customer_id" required>
                                    <option value="">Select Customer</option>
                                    <?php foreach ($customers as $customer): ?>
                                        <option value="<?= $customer['customer_id'] ?>">
                                            <?= htmlspecialchars($customer['full_name']) ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                            </div>

                            <div class="mb-3">
                                <label for="payment_method" class="form-label">Payment Method *</label>
                                <select class="form-select" id="payment_method" name="payment_method" required>
                                    <option value="Cash">Cash</option>
                                    <option value="Credit Card">Credit Card</option>
                                    <option value="Mobile Payment">Mobile Payment</option>
                                </select>
                            </div>

                            <input type="hidden" name="cart_items" id="cart-items">

                            <table class="table" id="order-items">
                                <thead>
                                    <tr>
                                        <th>Product</th>
                                        <th>Qty</th>
                                        <th>Price</th>
                                        <th>Subtotal</th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <!-- Items will be added here via JavaScript -->
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <th colspan="3">Total</th>
                                        <th id="order-total">0.00</th>
                                        <th></th>
                                    </tr>
                                </tfoot>
                            </table>

                            <div class="d-grid gap-2 mt-3">
                                <button type="submit" class="btn btn-success">Complete Order</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const cart = [];
        const orderItems = document.getElementById('order-items').getElementsByTagName('tbody')[0];
        const cartInput = document.getElementById('cart-items');
        const orderTotal = document.getElementById('order-total');

        // Add product to cart
        document.querySelectorAll('.add-to-cart').forEach(button => {
            button.addEventListener('click', function () {
                const card = this.closest('.product-card');
                const inventoryId = parseInt(card.dataset.inventoryId);
                const productId = parseInt(card.dataset.productId);
                const productName = card.dataset.name;
                const productPrice = parseFloat(card.dataset.price);
                const stock = parseInt(card.dataset.stock);

                // Check if product already in cart
                const existingItem = cart.find(item => item.inventory_id === inventoryId);

                if (existingItem) {
                    if (existingItem.quantity < stock) {
                        existingItem.quantity++;
                        existingItem.sub_total = existingItem.quantity * productPrice;
                    } else {
                        alert('Cannot add more than available stock');
                        return;
                    }
                } else {
                    cart.push({
                        inventory_id: inventoryId,
                        product_id: productId,
                        name: productName,
                        price: productPrice,
                        quantity: 1,
                        sub_total: productPrice
                    });
                }

                updateCartDisplay();
            });
        });

        // Update cart display
        function updateCartDisplay() {
            orderItems.innerHTML = '';
            let total = 0;

            cart.forEach(item => {
                total += item.sub_total;

                const row = document.createElement('tr');
                row.innerHTML = `
                <td>${item.name}</td>
                <td>
                    <input type="number" min="1" max="${item.stock}" 
                           value="${item.quantity}" 
                           class="form-control quantity-input"
                           data-inventory-id="${item.inventory_id}">
                </td>
                <td>${item.price.toFixed(2)}</td>
                <td>${item.sub_total.toFixed(2)}</td>
                <td>
                    <button class="btn btn-sm btn-danger remove-item" 
                            data-inventory-id="${item.inventory_id}">
                        <i class="fas fa-trash"></i>
                    </button>
                </td>
            `;
                orderItems.appendChild(row);
            });

            orderTotal.textContent = total.toFixed(2);
            cartInput.value = JSON.stringify(cart);

            // Add event listeners to new elements
            document.querySelectorAll('.quantity-input').forEach(input => {
                input.addEventListener('change', function () {
                    const inventoryId = parseInt(this.dataset.inventoryId);
                    const newQuantity = parseInt(this.value);
                    const item = cart.find(item => item.inventory_id === inventoryId);

                    if (item) {
                        item.quantity = newQuantity;
                        item.sub_total = item.quantity * item.price;
                        updateCartDisplay();
                    }
                });
            });

            document.querySelectorAll('.remove-item').forEach(button => {
                button.addEventListener('click', function () {
                    const inventoryId = parseInt(this.dataset.inventoryId);
                    const index = cart.findIndex(item => item.inventory_id === inventoryId);

                    if (index !== -1) {
                        cart.splice(index, 1);
                        updateCartDisplay();
                    }
                });
            });
        }
    });
</script>

<?php require_once __DIR__ . '/../../includes/footer.php'; ?>