<?php
require_once 'db.php';

$conn = connectUserDB();

header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode(['success' => false, 'message' => 'Invalid request method']);
    exit;
}

$order_id = isset($_POST['OrderID']) ? intval($_POST['OrderID']) : 0;
$action   = isset($_POST['action'])  ? trim($_POST['action'])    : '';

if ($order_id <= 0) {
    echo json_encode(['success' => false, 'message' => 'Invalid order ID']);
    exit;
}

if ($action === 'complete') {
    $stmt = $conn->prepare(
        "UPDATE ordersummary
         SET OrderStatus = 'Completed'
         WHERE OrderID = ? AND OrderStatus = 'Pending'"
    );

    $stmt->bind_param("i", $order_id);

    if ($stmt->execute()) {
        if ($stmt->affected_rows > 0) {
            echo json_encode(['success' => true, 'message' => 'Order completed successfully']);
        } else {
            echo json_encode(['success' => false, 'message' => 'Order not found or already completed']);
        }
    } else {
        echo json_encode(['success' => false, 'message' => 'Failed to update order: ' . $conn->error]);
    }

    $stmt->close();
} else {
    echo json_encode(['success' => false, 'message' => 'Invalid action']);
}

$conn->close();
?>
