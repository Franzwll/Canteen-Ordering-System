<?php

include 'connection.php';

// Check if required parameters exist
if (!isset($_GET['total']) || !isset($_GET['stall_id']) || empty($_GET['total']) || empty($_GET['stall_id'])) {
    header('Location: viewmenu.php');
    exit;
}

$total = floatval($_GET['total']);
$stall_id = intval($_GET['stall_id']);

// Fetch stall name
$stall_query = "SELECT name FROM stall WHERE id = ?";
$stall_stmt = $conn->prepare($stall_query);
$stall_stmt->bind_param("i", $stall_id);
$stall_stmt->execute();
$stall_result = $stall_stmt->get_result();
$stall = $stall_result->fetch_assoc();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Payment - Project EAT</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="css/style.css" rel="stylesheet">
</head>

<body>
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header">
                        <h4 class="text-center mb-2"><?php echo htmlspecialchars($stall['name']); ?></h4>
                        <h3 class="text-center mb-2">Order Summary</h3>
                    </div>
                    <div class="card-body">
                        <!-- Order Items List -->
                        <div class="order-items mb-4">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>Item</th>
                                        <th class="text-center">Qty</th>
                                        <th class="text-end">Price</th>
                                        <th class="text-end">Total</th>
                                    </tr>
                                </thead>
                                <tbody id="order-items-body"></tbody>
                                <tfoot>
                                    <tr>
                                        <td colspan="3" class="text-end"><strong>Grand Total:</strong></td>
                                        <td class="text-end"><strong>₱<?php echo number_format($total, 2); ?></strong></td>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>

                        <!-- Payment Method Selection -->
                        <form id="payment-form" action="process_payment.php" method="POST">
                            <input type="hidden" name="stall_id" value="<?php echo $stall_id; ?>">
                            <input type="hidden" name="total_amount" value="<?php echo $total; ?>">
                            <input type="hidden" name="cart_items" id="cart-items">
                            <input type="hidden" name="status" value="Pending">
                            
                            <div class="mb-4">
                                <label class="form-label">Payment Method</label>
                                <select class="form-select" name="payment_method" required>
                                    <option value="">Select Payment Method</option>
                                    <option value="Cash">Cash</option>
                                    <option value="Gcash">GCash</option>
                                </select>
                            </div>
                            
                            <div class="text-center">
                                <button type="submit" class="btn btn-primary btn-lg">Proceed</button>
                                <a href="viewmenu.php?stall_id=<?php echo $stall_id; ?>" class="btn btn-secondary btn-lg">Cancel</a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Get cart items from sessionStorage
            const cartItems = JSON.parse(sessionStorage.getItem('cartItems') || '{}');
            const tbody = document.getElementById('order-items-body');
            
            // Populate order items table
            Object.values(cartItems).forEach(item => {
                const itemTotal = item.price * item.qty;
                const row = document.createElement('tr');
                row.innerHTML = `
                    <td>${item.name}</td>
                    <td class="text-center">${item.qty}</td>
                    <td class="text-end">₱${parseFloat(item.price).toFixed(2)}</td>
                    <td class="text-end">₱${itemTotal.toFixed(2)}</td>
                `;
                tbody.appendChild(row);
            });

            // Add cart items to form before submission
            document.getElementById('payment-form').addEventListener('submit', function(e) {
                document.getElementById('cart-items').value = JSON.stringify(cartItems);
            });
        });
    </script>
</body>

</html>