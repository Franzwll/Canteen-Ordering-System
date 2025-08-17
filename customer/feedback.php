<?php
include 'connection.php';

// Initialize response array
$response = [
    'success' => false,
    'message' => ''
];

// Check if it's a POST request
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get and sanitize input
    $stall_id = isset($_POST['stall_id']) ? intval($_POST['stall_id']) : 0;
    $customer_name = isset($_POST['customer_name']) ? trim($_POST['customer_name']) : '';
    $feedback = isset($_POST['response']) ? trim($_POST['response']) : '';

    // Validate required fields
    if (empty($feedback)) {
        $response['message'] = 'Please provide your feedback.';
    } else {
        try {
            // Prepare the SQL statement
            $sql = "INSERT INTO feedback (stall_id, customer_name, feedback_text, created_at) VALUES (?, ?, ?, NOW())";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("iss", $stall_id, $customer_name, $feedback);
            
            // Execute the statement
            if ($stmt->execute()) {
                $response['success'] = true;
                $response['message'] = 'Thank you for your feedback!';
            } else {
                $response['message'] = 'Failed to submit feedback. Please try again.';
            }
        } catch (Exception $e) {
            $response['message'] = 'An error occurred. Please try again later.';
        }
    }
} else {
    $response['message'] = 'Invalid request method.';
}

// Set header to return JSON
header('Content-Type: application/json');
echo json_encode($response);
?>
