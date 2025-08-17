
<?php

include 'connection.php';

if (!isset($_GET['order_id'])) {
    header('Location: viewmenu.php');
    exit;
}

$order_id = intval($_GET['order_id']);

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
    <title>Queue Number - Project EAT</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="css/style.css" rel="stylesheet">
    <style>
        .queue-number {
            font-size: 4rem;
            font-weight: bold;
            color: #28a745;
        }
        .order-confirmed {
            background-color: #d4edda;
            border-radius: 8px;
            padding: 20px;
            margin-bottom: 20px;
        }
    </style>
</head>
<body>
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header bg-success text-white">
                        <h4 class="text-center mb-0">Order Confirmed!</h4>
                    </div>
                    <div class="card-body text-center">
                        <div class="order-confirmed">
                            <h5 class="mb-3"><?php echo htmlspecialchars($order['stall_name']); ?></h5>
                            <p class="mb-2">Order #<?php echo htmlspecialchars($order['order_number']); ?></p>
                            <div class="queue-number mb-3">
                                <?php echo substr($order['order_number'], -3); ?>
                            </div>
                            <p class="mb-0">Please keep this number and wait for your order.</p>
                        </div>

                        <div class="order-summary">
                            <h5>Order Summary</h5>
                            <p><strong>Total Amount:</strong> ₱<?php echo number_format($order['total_paid'], 2); ?></p>
                            <p><strong>Payment Method:</strong> <?php echo htmlspecialchars($order['payment_method']); ?></p>
                        </div>

                        

                        <!-- Feedback Form -->
                        <div class="mt-4" id="feedbackSection">
                            <h5>Share Your Experience</h5>
                            <form id="feedbackForm" onsubmit="submitFeedback(event)">
                                <input type="hidden" name="stall_id" value="<?php echo $order['stall_id']; ?>">
                                <div class="mb-3">
                                    <label for="customer_name" class="form-label">Your Name (Optional)</label>
                                    <input type="text" class="form-control" id="customer_name" name="customer_name" placeholder="Enter your name">
                                </div>
                                <div class="mb-3">
                                    <label for="response" class="form-label">Your Feedback</label>
                                    <textarea class="form-control" id="response" name="response" rows="3" required placeholder="Share your experience with us..."></textarea>
                                </div>
                                <button type="submit" class="btn btn-success">Submit Feedback</button>
                            </form>
                        </div>

                        <!-- Feedback Submitted Message (Hidden by default) -->
                        <div class="mt-4" id="feedbackSubmitted" style="display: none;">
                            <div class="alert alert-success text-center" role="alert">
                                <div class="d-flex flex-column align-items-center">
                                    <i class="fa fa-check-circle mb-2" style="font-size: 2rem;"></i>
                                    <h5 class="alert-heading mb-1">Feedback Submitted!</h5>
                                    <p class="mb-0">Thank you for sharing your experience with us.</p>
                                </div>
                            </div>
                        </div>

                        <div class="mt-4">
                            <a href="stalls.php" class="btn btn-primary">Order Again</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        // Clear the cart for this stall when queue page loads
        document.addEventListener('DOMContentLoaded', function() {
            const stallId = '<?php echo $order['stall_id']; ?>';
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
        });

        // Function to submit feedback via AJAX
        function submitFeedback(event) {
            event.preventDefault();
            
            const form = event.target;
            const formData = new FormData(form);
            
            // Disable submit button
            const submitBtn = form.querySelector('button[type="submit"]');
            submitBtn.disabled = true;
            
            fetch('feedback.php', {
                method: 'POST',
                body: formData
            })
            .then(response => response.text())
            .then(data => {
                // Show success message
                Swal.fire({
                    icon: 'success',
                    title: 'Thank You!',
                    text: 'Your feedback has been submitted successfully.',
                    confirmButtonColor: '#28a745'
                });
                
                // Hide feedback form and show submitted message
                document.getElementById('feedbackSection').style.display = 'none';
                document.getElementById('feedbackSubmitted').style.display = 'block';
            })
            .catch(error => {
                // Show error message
                Swal.fire({
                    icon: 'error',
                    title: 'Oops...',
                    text: 'Something went wrong. Please try again.',
                    confirmButtonColor: '#dc3545'
                });
                
                // Re-enable submit button
                submitBtn.disabled = false;
            });
        }
    </script>
</body>
</html>