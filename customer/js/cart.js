// Multi-cart system - store carts in a structure where keys are stall IDs
let stallCarts = {}; 

// Get the current stall ID from the page (if we're on a stall menu page)
function getCurrentStallId() {
    // Try to get from checkout button first (we're on a menu page)
    const checkoutBtn = document.getElementById('checkout-btn');
    if (checkoutBtn) {
        return checkoutBtn.getAttribute('data-stall-id');
    }
    // Try to get from URL parameter
    const urlParams = new URLSearchParams(window.location.search);
    return urlParams.get('stall_id') || null;
}

// Initialize stallCarts from localStorage if available
function initializeStallCarts() {
    const savedCarts = localStorage.getItem('stallCarts');
    if (savedCarts) {
        stallCarts = JSON.parse(savedCarts);
    }
    updateAllCartCounts();
}

// Save stallCarts to localStorage
function saveStallCarts() {
    localStorage.setItem('stallCarts', JSON.stringify(stallCarts));
}

// Function to update cart count display
function updateCartCount() {
    const currentStallId = getCurrentStallId();
    if (!currentStallId) return;
    
    const cartCountElement = document.getElementById('cart-count');
    if (cartCountElement) {
        let count = 0;
        if (stallCarts[currentStallId]) {
            count = Object.values(stallCarts[currentStallId]).reduce((sum, item) => sum + item.qty, 0);
        }
        cartCountElement.textContent = count;
    }
}

// Function to update ALL cart counts (for My Carts button badge)
function updateAllCartCounts() {
    const totalCount = Object.values(stallCarts).reduce((total, cart) => {
        return total + Object.values(cart).reduce((sum, item) => sum + item.qty, 0);
    }, 0);
    
    // Update the My Carts badge if it exists
    const cartBadge = document.getElementById('all-carts-count');
    if (cartBadge) {
        cartBadge.textContent = totalCount;
        cartBadge.style.display = totalCount > 0 ? 'inline-block' : 'none';
    }
}

// Function to update cart table inside a stall's modal section
function updateCartTable() {
    const currentStallId = getCurrentStallId();
    if (!currentStallId || !stallCarts[currentStallId]) return;
    
    const tbody = document.querySelector('#cart-table tbody');
    if (!tbody) return;
    
    tbody.innerHTML = '';
    let grandTotal = 0;

    Object.values(stallCarts[currentStallId]).forEach(item => {
        const row = document.createElement('tr');
        row.innerHTML = `
            <td>${item.name}</td>
            <td>
                <button class="btn btn-sm btn-secondary decrease-qty" data-stall-id="${currentStallId}" data-name="${item.name}">-</button>
                <span class="mx-2">${item.qty}</span>
                <button class="btn btn-sm btn-secondary increase-qty" data-stall-id="${currentStallId}" data-name="${item.name}">+</button>
            </td>
            <td>₱${item.price}</td>
            <td>₱${(item.price * item.qty).toFixed(2)}</td>
            <td><button class="btn btn-danger btn-sm remove-item" data-stall-id="${currentStallId}" data-name="${item.name}">Remove</button></td>
        `;
        tbody.appendChild(row);
        grandTotal += item.price * item.qty;
    });

    const totalElement = document.getElementById('cart-grand-total');
    if (totalElement) {
        totalElement.textContent = grandTotal.toFixed(2);
    }
}

// Function to update UI for menu items based on cart contents
function updateMenuControls() {
    const currentStallId = getCurrentStallId();
    if (!currentStallId) return;
    
    document.querySelectorAll('.menu-item').forEach(menuItem => {
        const name = menuItem.getAttribute('data-name');
        const controls = menuItem.querySelector('.menu-controls');
        if (!controls) return;
        
        const addBtn = controls.querySelector('.add-to-cart');
        const removeBtn = controls.querySelector('.remove-from-cart');
        const qtySpan = controls.querySelector('.item-qty');
        
        if (!stallCarts[currentStallId]) {
            stallCarts[currentStallId] = {};
        }

        if (stallCarts[currentStallId][name]) {
            addBtn.textContent = '+';
            removeBtn.style.display = '';
            qtySpan.style.display = '';
            qtySpan.textContent = stallCarts[currentStallId][name].qty;
        } else {
            addBtn.textContent = 'Add';
            removeBtn.style.display = 'none';
            qtySpan.style.display = 'none';
            qtySpan.textContent = '0';
        }
    });
}

// Function to update the All Carts modal
function updateAllCartsModal() {
    const stallCartsContainer = document.getElementById('stallCarts');
    if (!stallCartsContainer) return;
    
    // Clear current content
    stallCartsContainer.innerHTML = '';
    
    // If no carts exist
    if (Object.keys(stallCarts).length === 0) {
        stallCartsContainer.innerHTML = '<div class="text-center p-4"><p>No items in any cart.</p></div>';
        return;
    }
    
    // For each stall that has a cart
    for (const stallId in stallCarts) {
        const cart = stallCarts[stallId];
        
        // Skip empty carts
        if (Object.keys(cart).length === 0) continue;
        
        // Get stall name (this is async but we'll use a placeholder initially)
        let stallName = `Stall #${stallId}`;
        
        // Create stall cart container
        const stallCartDiv = document.createElement('div');
        stallCartDiv.className = 'card mb-4';
        stallCartDiv.id = `stall-cart-${stallId}`;
        
        // Create card header with stall name
        const cardHeader = document.createElement('div');
        cardHeader.className = 'card-header d-flex justify-content-between align-items-center';
        cardHeader.innerHTML = `
            <h5 class="mb-0">${stallName}</h5>
            <button class="btn btn-sm btn-outline-danger remove-stall-cart" data-stall-id="${stallId}">
                Remove Cart
            </button>
        `;
        stallCartDiv.appendChild(cardHeader);
        
        // Create card body with items table
        const cardBody = document.createElement('div');
        cardBody.className = 'card-body';
        
        // Calculate total for this stall
        let stallTotal = 0;
        Object.values(cart).forEach(item => {
            stallTotal += item.price * item.qty;
        });
        
        // Create table
        let tableHtml = `
            <table class="table">
                <thead>
                    <tr>
                        <th>Item</th>
                        <th>Quantity</th>
                        <th>Price</th>
                        <th>Total</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
        `;
        
        // Add rows for each item
        Object.values(cart).forEach(item => {
            const itemTotal = item.price * item.qty;
            tableHtml += `
                <tr>
                    <td>${item.name}</td>
                    <td>
                        <button class="btn btn-sm btn-secondary decrease-qty" data-stall-id="${stallId}" data-name="${item.name}">-</button>
                        <span class="mx-2">${item.qty}</span>
                        <button class="btn btn-sm btn-secondary increase-qty" data-stall-id="${stallId}" data-name="${item.name}">+</button>
                    </td>
                    <td>₱${item.price.toFixed(2)}</td>
                    <td>₱${itemTotal.toFixed(2)}</td>
                    <td>
                        <button class="btn btn-danger btn-sm remove-item" data-stall-id="${stallId}" data-name="${item.name}">
                            Remove
                        </button>
                    </td>
                </tr>
            `;
        });
        
        // Close table and add total
        tableHtml += `
                </tbody>
                <tfoot>
                    <tr>
                        <td colspan="3" class="text-end"><strong>Total:</strong></td>
                        <td>₱${stallTotal.toFixed(2)}</td>
                        <td></td>
                    </tr>
                </tfoot>
            </table>
        `;
        
        cardBody.innerHTML = tableHtml;
        stallCartDiv.appendChild(cardBody);
        
        // Add card footer with checkout button
        const cardFooter = document.createElement('div');
        cardFooter.className = 'card-footer text-end';
        cardFooter.innerHTML = `
            <button class="btn btn-primary checkout-stall-btn" data-stall-id="${stallId}" data-total="${stallTotal.toFixed(2)}">
                Checkout
            </button>
        `;
        stallCartDiv.appendChild(cardFooter);
        
        // Add this stall's cart to the container
        stallCartsContainer.appendChild(stallCartDiv);
        
        // Fetch stall name asynchronously and update the header
        fetchStallName(stallId).then(name => {
            const headerElement = document.querySelector(`#stall-cart-${stallId} .card-header h5`);
            if (headerElement && name) {
                headerElement.textContent = name;
            }
        });
    }
}

// Function to fetch stall name from the server
async function fetchStallName(stallId) {
    try {
        const response = await fetch(`get_stall_name.php?stall_id=${stallId}`);
        if (!response.ok) return null;
        
        const data = await response.json();
        return data.name || null;
    } catch (error) {
        console.error('Error fetching stall name:', error);
        return null;
    }
}

// Event listeners for cart actions
document.addEventListener('click', function(e) {
    const stallId = e.target.getAttribute('data-stall-id') || getCurrentStallId();
    const name = e.target.getAttribute('data-name');
    
    if (!stallId) return;
    
    // Initialize stall cart if it doesn't exist
    if (!stallCarts[stallId]) {
        stallCarts[stallId] = {};
    }
    
    // Add item to cart
    if (e.target.classList.contains('add-to-cart')) {
        const price = parseFloat(e.target.getAttribute('data-price'));
        
        stallCarts[stallId][name] = stallCarts[stallId][name] 
            ? { ...stallCarts[stallId][name], qty: stallCarts[stallId][name].qty + 1 } 
            : { name, price, qty: 1 };
            
        saveStallCarts();
        updateCartCount();
        updateAllCartCounts();
        updateMenuControls();
    }

    // Remove item from cart (menu view)
    if (e.target.classList.contains('remove-from-cart')) {
        if (stallCarts[stallId][name]) {
            stallCarts[stallId][name].qty -= 1;
            if (stallCarts[stallId][name].qty <= 0) {
                delete stallCarts[stallId][name];
            }
            saveStallCarts();
            updateCartCount();
            updateAllCartCounts();
            updateMenuControls();
        }
    }

    // Remove item from cart modal
    if (e.target.classList.contains('remove-item')) {
        if (stallCarts[stallId] && stallCarts[stallId][name]) {
            delete stallCarts[stallId][name];
            saveStallCarts();
            updateCartTable();
            updateCartCount();
            updateAllCartCounts();
            updateMenuControls();
            updateAllCartsModal();
        }
    }

    // Increase qty in cart modal
    if (e.target.classList.contains('increase-qty')) {
        if (stallCarts[stallId] && stallCarts[stallId][name]) {
            stallCarts[stallId][name].qty += 1;
            saveStallCarts();
            updateCartTable();
            updateCartCount();
            updateAllCartCounts();
            updateMenuControls();
            updateAllCartsModal();
        }
    }

    // Decrease qty in cart modal
    if (e.target.classList.contains('decrease-qty')) {
        if (stallCarts[stallId] && stallCarts[stallId][name]) {
            if (stallCarts[stallId][name].qty > 1) {
                stallCarts[stallId][name].qty -= 1;
            } else {
                delete stallCarts[stallId][name];
            }
            saveStallCarts();
            updateCartTable();
            updateCartCount();
            updateAllCartCounts();
            updateMenuControls();
            updateAllCartsModal();
        }
    }
    
    // Remove entire stall cart
    if (e.target.classList.contains('remove-stall-cart')) {
        delete stallCarts[stallId];
        saveStallCarts();
        updateCartCount();
        updateAllCartCounts();
        updateMenuControls();
        updateAllCartsModal();
    }
    
    // Checkout specific stall
    if (e.target.classList.contains('checkout-stall-btn')) {
        const total = parseFloat(e.target.getAttribute('data-total'));
        handleStallCheckout(stallId, total);
    }
});

// Handle stall checkout
function handleStallCheckout(stallId, total) {
    // Check if cart is empty
    if (!stallCarts[stallId] || Object.keys(stallCarts[stallId]).length === 0) {
        Swal.fire({
            icon: 'warning',
            title: 'Cart is Empty',
            text: 'Please add items to your cart before checking out.',
            confirmButtonColor: '#ffc107',
            confirmButtonText: 'Continue Shopping'
        });
        return;
    }

    // Generate order summary HTML
    let orderSummaryHtml = '<div class="text-left">';
    
    Object.values(stallCarts[stallId]).forEach(item => {
        const itemTotal = item.price * item.qty;
        orderSummaryHtml += `
            <div class="d-flex justify-content-between mb-2">
                <span>${item.name} x ${item.qty}</span>
                <span>₱${itemTotal.toFixed(2)}</span>
            </div>
        `;
    });

    orderSummaryHtml += `
        <hr>
        <div class="d-flex justify-content-between">
            <strong>Total Amount:</strong>
            <strong>₱${total.toFixed(2)}</strong>
        </div>
    </div>`;

    // Show confirmation dialog with order summary
    Swal.fire({
        icon: 'question',
        title: 'Confirm Checkout',
        html: `
            <h4>Order Summary:</h4>
            ${orderSummaryHtml}
        `,
        showCancelButton: true,
        confirmButtonColor: '#28a745',
        cancelButtonColor: '#dc3545',
        confirmButtonText: 'Proceed to Payment',
        cancelButtonText: 'Cancel'
    }).then((result) => {
        if (result.isConfirmed) {
            // Store cart data and stall_id in sessionStorage
            sessionStorage.setItem('cartItems', JSON.stringify(stallCarts[stallId]));
            sessionStorage.setItem('stallId', stallId);
            
            // Redirect to payment with both total and stall_id
            window.location.href = `payment.php?total=${total.toFixed(2)}&stall_id=${stallId}`;
        }
    });
}

// Show cart modal: refresh items each time
if (document.getElementById('cartModal')) {
    document.getElementById('cartModal').addEventListener('show.bs.modal', function () {
        updateCartTable();
    });
}

// Show all carts modal: refresh items each time
if (document.getElementById('allCartsModal')) {
    document.getElementById('allCartsModal').addEventListener('show.bs.modal', function () {
        updateAllCartsModal();
    });
}

// Clear current stall's cart
if (document.getElementById('clear-cart')) {
    document.getElementById('clear-cart').addEventListener('click', function () {
        const currentStallId = getCurrentStallId();
        if (currentStallId) {
            stallCarts[currentStallId] = {};
            saveStallCarts();
            updateCartTable();
            updateCartCount();
            updateAllCartCounts();
            updateMenuControls();
        }
    });
}

// Checkout current stall's cart
if (document.getElementById('checkout-btn')) {
    document.getElementById('checkout-btn').addEventListener('click', function() {
        const stallId = this.getAttribute('data-stall-id');
        const total = parseFloat(document.getElementById('cart-grand-total').textContent);
        handleStallCheckout(stallId, total);
    });
}

// Load previous cart state from localStorage
document.addEventListener('DOMContentLoaded', function() {
    initializeStallCarts();
    updateCartCount();
    updateMenuControls();
});

// ✅ Category Filtering Fix & "No Items" Message
const categoryList = document.getElementById('category-list');
if (categoryList) {
    categoryList.addEventListener('click', function (e) {
        if (e.target.matches('.list-group-item')) {
            document.querySelectorAll('#category-list .list-group-item').forEach(btn => btn.classList.remove('active'));
            e.target.classList.add('active');

            const selectedCategory = e.target.getAttribute('data-category').trim().toLowerCase();
            let itemsFound = false;

            document.querySelectorAll('.menu-item').forEach(item => {
                const itemCategory = item.getAttribute('data-category').trim().toLowerCase();
                
                // Show items that match category or all
                if (selectedCategory === 'all' || itemCategory === selectedCategory) {
                    item.style.display = '';
                    itemsFound = true;
                } else {
                    item.style.display = 'none';
                }
            });

            // Display message if no items are found
            const menuContainer = document.getElementById('menu-items');
            let noItemsMessage = document.getElementById('no-items-message');

            if (!itemsFound && menuContainer) {
                if (!noItemsMessage) {
                    noItemsMessage = document.createElement('p');
                    noItemsMessage.id = 'no-items-message';
                    noItemsMessage.className = 'text-center mt-3';
                    noItemsMessage.textContent = 'No items available in this category.';
                    menuContainer.appendChild(noItemsMessage);
                }
            } else {
                if (noItemsMessage) {
                    noItemsMessage.remove();
                }
            }
        }
    });
}