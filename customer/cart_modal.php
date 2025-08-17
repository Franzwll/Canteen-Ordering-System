<div class="modal fade" id="cartModal" tabindex="-1" aria-labelledby="cartModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="cartModalLabel">Your Cart</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <table class="table table-bordered" id="cart-table">
                    <thead>
                        <tr>
                            <th>Item</th>
                            <th>Qty</th>
                            <th>Price</th>
                            <th>Total</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <!-- Cart items will be injected here dynamically -->
                    </tbody>
                </table>
                <div class="text-end">
                    <strong>Grand Total: ₱<span id="cart-grand-total">0</span></strong>
                </div>
            </div>
            <div class="modal-footer">
                <button class="btn btn-danger" id="clear-cart">Clear Cart</button>
                <button class="btn btn-primary" id="checkout-btn">Checkout</button>
            </div>
        </div>
    </div>
</div>