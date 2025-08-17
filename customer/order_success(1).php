<?php

include 'connection.php';

if (!isset($_GET['order_id'])) {
    header('Location: viewmenu.php');
    exit;
}

$order_id = intval($_GET['order_id']);
$stall_id = isset($_GET['stall_id']) ? intval($_GET['stall_id']) : 0;

// Fetch order details
$sql = "SELECT o.*, s.name as stall_name 
        FROM orders o 
        JOIN stall s ON o.stall_id = s.id 
        WHERE o.id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $order_id);
$stmt->execute();
$order = $stmt->get_result()->fetch_assoc();

if (!$order) {
    header('Location: viewmenu.php');
    exit;
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Order Success - Project EAT</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="css/style.css" rel="stylesheet">
    <style>
        .loading-spinner {
            width: 3rem;
            height: 3rem;
        }
        .order-status {
            padding: 20px;
            border-radius: 8px;
            margin-bottom: 20px;
        }
        .status-pending {
            background-color: #fff3cd;
            border: 1px solid #ffeeba;
        }
        .status-completed {
            background-color: #d4edda;
            border: 1px solid #c3e6cb;
        }
    </style>
</head>
<body>
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header bg-primary text-white">
                        <h4 class="text-center mb-0">Order Status</h4>
                    </div>
                    <div class="card-body text-center">
                        <div id="statusContainer" class="order-status status-pending">
                            <h5 class="mb-3">Order #<?php echo htmlspecialchars($order['order_number']); ?></h5>
                            <div class="spinner-border loading-spinner text-warning mb-3" role="status">
                                <span class="visually-hidden">Loading...</span>
                            </div>
                            <h5 class="mb-3">Waiting for Confirmation</h5>
                            <p class="mb-0">Please wait while we process your order...</p>
                        </div>

                        <div class="order-details text-start">
                            <h5>Order Details:</h5>
                            <ul class="list-unstyled">
                                <li><strong>Stall:</strong> <?php echo htmlspecialchars($order['stall_name']); ?></li>
                                <li><strong>Amount:</strong> ₱<?php echo number_format($order['total_paid'], 2); ?></li>
                                <li><strong>Payment:</strong> <?php echo htmlspecialchars($order['payment_method']); ?></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Clear the specific stall's cart from localStorage after successful order
        function clearStallCart() {
            const stallId = '<?php echo $stall_id; ?>';
            if (stallId) {
                let stallCarts = {};
                const savedCarts = localStorage.getItem('stallCarts');
                if (savedCarts) {
                    stallCarts = JSON.parse(savedCarts);
                    if (stallCarts[stallId]) {
                        stallCarts[stallId] = {};
                        localStorage.setItem('stallCarts', JSON.stringify(stallCarts));
                    }
                }
            }
            if (typeof updateAllCartCounts === 'function') {
                updateAllCartCounts();
            }
        }

        function checkOrderStatus() {
            fetch('check_status.php?order_id=<?php echo $order_id; ?>')
                .then(response => response.json())
                .then(data => {
                    if (data.status === 'Completed') {
                        // Clear cart before redirecting
                        clearStallCart();
                        // Redirect to queue.php with order details
                        window.location.href = `queue.php?order_id=<?php echo $order_id; ?>`;
                    } else {
                        // Continue checking every 2 seconds
                        setTimeout(checkOrderStatus, 2000);
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    setTimeout(checkOrderStatus, 2000);
                });
        }

        // Clear cart immediately as the page loads
        clearStallCart();

        // Start checking order status
        checkOrderStatus();
    </script>
    <script src="https://kit.fontawesome.com/a076d05399.js"></script>
</body>
</html>