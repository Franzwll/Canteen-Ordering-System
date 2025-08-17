<?php
// Database connection
$conn = new mysqli("localhost", "root", "", "canteen_ordering_system");

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

