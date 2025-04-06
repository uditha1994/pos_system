document.addEventListener('DOMContentLoaded', function() {
    // Cart functionality
    const cart = [];
    const orderItems = document.getElementById('order-items')?.getElementsByTagName('tbody')[0];
    const cartInput = document.getElementById('cart-items');
    const orderTotal = document.getElementById('order-total');
    
    if (orderItems) {
        // Add product to cart
        document.querySelectorAll('.add-to-cart').forEach(button => {
            button.addEventListener('click', function() {
                const card = this.closest('.product-card');
                const inventoryId = parseInt(card.dataset.inventoryId);
                const productId = parseInt(card.dataset.productId);
                const productName = card.dataset.name;
                const productPrice = parseFloat(card.dataset.price);
                const stock = parseInt(card.dataset.stock);
                
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
                input.addEventListener('change', function() {
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
                button.addEventListener('click', function() {
                    const inventoryId = parseInt(this.dataset.inventoryId);
                    const index = cart.findIndex(item => item.inventory_id === inventoryId);
                    
                    if (index !== -1) {
                        cart.splice(index, 1);
                        updateCartDisplay();
                    }
                });
            });
        }
    }
});