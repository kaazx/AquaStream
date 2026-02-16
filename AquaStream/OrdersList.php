<?php
session_start();

// Connect to database
$conn = new mysqli("localhost", "root", "", "AdminDB");

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// CUpdates order status when checkbox is toggled
if (isset($_POST['toggle_status'])) {
    $order_id = intval($_POST['order_id']);
    $new_status = isset($_POST['status']) ? 'Completed' : 'Pending';
    
    $conn->query("UPDATE orders SET order_status='$new_status' WHERE id=$order_id");
    header("Location: OrdersList.php");
    exit();
}

// Read all orders
$orders = $conn->query("SELECT * FROM orders WHERE order_status='Pending' ORDER BY created_at");

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="AquaStream Water Delivery - Create New Order">
    <title>Orders List - AquaStream</title>
    <link rel="stylesheet" href="css/styles.css">
    <link rel="stylesheet" href="css/orders.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="icon" type="image/png" href="imgs/logo.png">
</head>
<body>
    <?php include 'sidebar.php'; ?>
    
    <main class="orders-list-container">
        <h2 class="orders-title">Active Order Management</h2>
            
        <?php if ($orders && $orders->num_rows > 0): ?>
        <div class="orders-table-wrapper">
            <table class="orders-table-clean">
                <thead>
                    <tr>
                        <th>Order ID</th>
                        <th>Customer Name</th>
                        <th>Address</th>
                        <th>Quantity</th>
                        <th>Delivery Date</th>
                        <th>Payment</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    <?php 
                    while($row = $orders->fetch_assoc()): 
                        $isChecked = ($row['order_status'] == 'Completed') ? 'checked' : '';
                    ?>
                    <tr>
                        <td>ORD-<?= str_pad($row['id'], 3, '0', STR_PAD_LEFT) ?></td>
                        <td><?= htmlspecialchars($row['customer_name']) ?></td>
                        <td><?= htmlspecialchars($row['customer_address']) ?></td>
                        <td><?= $row['quantity'] ?></td>
                        <td><?= date('m-d-Y', strtotime($row['delivery_date'])) ?></td>
                        <td><?= htmlspecialchars($row['payment_method']) ?></td>
                        <td class="status-cell">
                            <form method="POST" action="OrdersList.php">
                                <input type="hidden" name="toggle_status" value="1">
                                <input type="hidden" name="order_id" value="<?= $row['id'] ?>">
                                <input type="checkbox" 
                                class="status-checkbox" 
                                name="status" 
                                <?= $isChecked ?> 
                                onclick="return confirm('Mark this order as completed? It will be moved to history.');"
                                onchange="if(this.checked) this.form.submit();">
                            </form>
                        </td>
                    </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        </div>
        <?php else: ?>
        <p>No orders found. Create your first order above!</p>
        <?php endif; ?>
    </main>
    <!-- Footer -->
    <?php include 'footer.php'; ?>
</body>
</html>
