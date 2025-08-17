<?php

include 'connection.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get form data
    $stall_id = intval($_POST['stall_id']);
    $total_paid = floatval($_POST['total_amount']);
    $payment_method = $_POST['payment_method'];
    
    try {
        // Prepare the SQL statement
        $sql = "INSERT INTO orders (
            order_number,
            stall_id,
            seller_id,
            total_paid,
            payment_method,
            cash_received,
            change_amount,
            status
        ) VALUES (
            '', 
            ?, 
            NULL,
            ?,
            ?,
            0,
            0,
            'Pending'
        )";
        
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ids", $stall_id, $total_paid, $payment_method);
        
        if ($stmt->execute()) {
            $order_id = $conn->insert_id;
            
            // Get cart items from session storage
            $cartItems = json_decode($_POST['cart_items'], true);
            
            // Insert into order_items table
            $item_sql = "INSERT INTO order_items (order_id, item_id, quantity, price) VALUES (?, ?, ?, ?)";
            $item_stmt = $conn->prepare($item_sql);
            
            foreach ($cartItems as $item) {
                $item_stmt->bind_param("iiid", 
                    $order_id,
                    $item['id'],
                    $item['qty'],
                    $item['price']
                );
                $item_stmt->execute();
            }
            
            // Clear cart from session
            session_start();
            unset($_SESSION['cart']);
            
            // Redirect to success page
            header("Location: order_success.php?order_id=" . $order_id);
            exit;
            
        } else {
            throw new Exception("Error processing order");
        }
        
    } catch (Exception $e) {
        // Log error and redirect
        error_log("Order processing error: " . $e->getMessage());
        header("Location: error.php?message=" . urlencode("Failed to process order. Please try again."));
        exit;
    }
} else {
    // If not POST request, redirect to menu
    header("Location: viewmenu.php");
    exit;
}