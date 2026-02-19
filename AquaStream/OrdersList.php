<?php
require_once 'db.php'; 

$conn = connectUserDB();

if (isset($_POST['toggle_status'])) {
    $order_id = intval($_POST['order_id']);
    $new_status = isset($_POST['status']) ? 'Completed' : 'Pending';
    $conn->query("UPDATE orders SET order_status='$new_status' WHERE id=$order_id");
    header("Location: OrdersList.php");
    exit();
}

if (isset($_POST['delete_order'])) {
    $order_id = intval($_POST['order_id']);
    $conn->query("DELETE FROM orders WHERE id=$order_id");
    header("Location: OrdersList.php");
    exit();
}

$orders = $conn->query("SELECT * FROM orders WHERE order_status='Pending' ORDER BY created_at");

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="AquaStream Water Delivery - Create New Order">
    <title>Orders List - AquaStream</title>
    <link rel="stylesheet" href="css/list.css">
    <link rel="stylesheet" href="css/styles.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="icon" type="image/png" href="imgs/logo.png">
</head>
<body>
    <?php include 'sidebar.php'; ?>
    
    <main class="orders-list-container">
        <h2 class="orders-title">Active Order Management</h2>
            
        <?php if ($orders && $orders->num_rows > 0): 
            $rows = $orders->fetch_all(MYSQLI_ASSOC);
        ?>
        <div class="orders-table-wrapper">
            <div class="table-with-icons">
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
                        <?php foreach($rows as $row): 
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
                                    onchange="if(this.checked) setTimeout(() => this.form.submit(), 3000);">
                                </form>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>

                <div class="trash-column">
                    <div class="trash-header"></div>
                    <?php foreach($rows as $row): ?>
                    <div class="trash-row">
                        <form method="POST" action="OrdersList.php" onsubmit="return confirm('Delete this order? This cannot be undone.');">
                            <input type="hidden" name="delete_order" value="1">
                            <input type="hidden" name="order_id" value="<?= $row['id'] ?>">
                            <button type="submit" class="trash-btn">
                                <i class="fas fa-trash trash-icon"></i>
                            </button>
                        </form>
                    </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>
        <?php else: ?>
            <div class="no-orders">
                <p>No orders found. Create your first order now!</p>
            </div>
        <?php endif; ?>
    </main>
    <?php include 'footer.php'; ?>
</body>
</html>
