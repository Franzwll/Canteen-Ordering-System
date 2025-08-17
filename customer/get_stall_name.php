<?php
include 'connection.php';

header('Content-Type: application/json');

// Get stall ID from request
$stall_id = isset($_GET['stall_id']) ? (int) $_GET['stall_id'] : 0;

if ($stall_id <= 0) {
    echo json_encode(['error' => 'Invalid stall ID']);
    exit;
}

// Fetch stall name
$query = "SELECT name FROM stall WHERE id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $stall_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $stall = $result->fetch_assoc();
    echo json_encode(['name' => $stall['name']]);
} else {
    echo json_encode(['error' => 'Stall not found']);
}

$stmt->close();
$conn->close();
?>