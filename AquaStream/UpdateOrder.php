<?php
// Handles AJAX requests to update order status in AdminDB

session_start();

// Connect to database
$conn = new mysqli("localhost", "root", "", "AdminDB");

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $order_id = isset($_POST['id']) ? intval($_POST['id']) : 0;
    $action = isset($_POST['action']) ? $_POST['action'] : '';

    if ($order_id <= 0) {
        echo json_encode(['success' => false, 'message' => 'Invalid order ID']);
        exit;
    }

    if ($action === 'complete') {
        // Update order status to completed
        $updateQuery = "UPDATE orders 
                       SET order_status = 'Completed' 
                       WHERE id = ?";
        
        $stmt = mysqli_prepare($conn, $updateQuery);
        
        if ($stmt) {
            mysqli_stmt_bind_param($stmt, "i", $order_id);
            
            if (mysqli_stmt_execute($stmt)) {
                echo json_encode([
                    'success' => true, 
                    'message' => 'Order completed successfully'
                ]);
            } else {
                echo json_encode([
                    'success' => false, 
                    'message' => 'Failed to update order: ' . mysqli_error($conn)
                ]);
            }
            
            mysqli_stmt_close($stmt);
        } else {
            echo json_encode([
                'success' => false, 
                'message' => 'Failed to prepare statement: ' . mysqli_error($conn)
            ]);
        }
    } else {
        echo json_encode(['success' => false, 'message' => 'Invalid action']);
    }
    
    mysqli_close($conn);
} else {
    echo json_encode(['success' => false, 'message' => 'Invalid request method']);
}
?>