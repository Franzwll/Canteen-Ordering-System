<?php
// Include database connection
include 'connection.php';

// Get order ID from request
$order_id = isset($_GET['order_id']) ? intval($_GET['order_id']) : 0;

if ($order_id <= 0) {
    // Invalid order ID
    echo json_encode(['error' => 'Invalid order ID']);
    exit;
}

// Query to get order status
$query = "SELECT status FROM orders WHERE id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $order_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $order = $result->fetch_assoc();
    echo json_encode(['status' => $order['status']]);
} else {
    echo json_encode(['error' => 'Order not found']);
}

// Close connection
$stmt->close();
$conn->close();