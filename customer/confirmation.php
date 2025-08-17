<?php

include 'connection.php';

if (!isset($_GET['order_id'])) {
    header('Location: viewmenu.php');
    exit;
}

$order_id = intval($_GET['order_id']);

// Fetch order details
$order_query = "SELECT o.*, s.name as stall_name 
                FROM orders o 
                JOIN stall s ON o.stall_id = s.id 
                WHERE o.id = ?";
$stmt = $conn->prepare($order_query);
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
    <title>Order Confirmation - Project EAT</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="css/style.css" rel="stylesheet">
    <style>
        .loading-spinner {
            width: 4rem;
            height: 4rem;
        }
        .order-status {
            padding: 20px;
            border-radius: 10px;
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
                    <div class="card-header">
                        <h3 class="text-center mb-0">Order Status</h3>
                    </div>
                    <div class="card-body text-center">
                        <div class="order-status status-pending" id="statusContainer">
                            <h4 class="mb-3">Order #<?php echo $order['order_number']; ?></h4>
                            <div class="spinner-border loading-spinner text-warning mb-3" role="status">
                                <span class="visually-hidden">Loading...</span>
                            </div>
                            <h5 class="mb-3">Waiting for Confirmation</h5>
                            <p class="mb-0">Please wait while the staff confirms your order...</p>
                        </div>

                        <div class="order-details">
                            <h5>Order Details</h5>
                            <p>Stall: <?php echo htmlspecialchars($order['stall_name']); ?></p>
                            <p>Total Amount: ₱<?php echo number_format($order['total_paid'], 2); ?></p>
                            <p>Payment Method: <?php echo $order['payment_method']; ?></p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        function checkOrderStatus() {
            fetch('check_status.php?order_id=<?php echo $order_id; ?>')
                .then(response => response.json())
                .then(data => {
                    if (data.status === 'Completed') {
                        const statusContainer = document.getElementById('statusContainer');
                        statusContainer.className = 'order-status status-completed';
                        statusContainer.innerHTML = `
                            <h4 class="mb-3">Order #<?php echo $order['order_number']; ?></h4>
                            <i class="fas fa-check-circle text-success fa-3x mb-3"></i>
                            <h5 class="mb-3">Order Confirmed!</h5>
                            <p class="mb-3">Your order has been confirmed and is being prepared.</p>
                            <a href="viewmenu.php" class="btn btn-primary">Back to Menu</a>
                        `;
                    } else {
                        // Continue checking every 5 seconds
                        setTimeout(checkOrderStatus, 5000);
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    setTimeout(checkOrderStatus, 5000);
                });
        }

        // Start checking order status
        checkOrderStatus();
    </script>
    <script src="https://kit.fontawesome.com/your-kit-code.js"></script>
</body>
</html>