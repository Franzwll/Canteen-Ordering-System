<?php
// Database connection
$host = "localhost"; // Your hosting database host
$username = "root"; // Your hosting database username
$password = ""; // Your hosting database password
$database = "canteen_ordering_system"; // Your database name

// Create connection
$conn = new mysqli($host, $username, $password, $database);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Set charset to ensure proper encoding
$conn->set_charset("utf8mb4");
?> 