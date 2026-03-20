<?php
require_once 'db.php';

$conn = connectUserDB();

// Toggle status: mark as Completed (removes from active list, appears in history)
if (isset($_POST['toggle_status'])) {
    $order_id = intval($_POST['order_id']);
    $stmt = $conn->prepare("UPDATE ordersummary SET OrderStatus = 'Completed' WHERE OrderID = ?");
    $stmt->bind_param("i", $order_id);
    $stmt->execute();
    $stmt->close();
    header("Location: OrdersList.php");
    exit();
}

// Delete order (cascades to orderdetails via FK ON DELETE CASCADE)
if (isset($_POST['delete_order'])) {
    $order_id = intval($_POST['order_id']);
    $stmt = $conn->prepare("DELETE FROM ordersummary WHERE OrderID = ?");
    $stmt->bind_param("i", $order_id);
    $stmt->execute();
    $stmt->close();
    header("Location: OrdersList.php");
    exit();
}

// Redirect to modify/edit page
if (isset($_POST['modify_order'])) {
    $order_id = intval($_POST['order_id']);
    header("Location: ModifyOrder.php?id=$order_id");
    exit();
}

// Fetch all pending orders with customer info and totals
$orders = $conn->query(
    "SELECT
        os.OrderID,
        os.OrderDate,
        os.DeliveryDate,
        os.ModeOfPayment,
        os.OrderStatus,
        os.TotalAmount,
        c.CustomerName,
        c.CustomerAddress,
        od.Quantity
     FROM ordersummary os
     JOIN orderdetails od ON os.OrderID = od.OrderID
     JOIN customers c     ON od.CustomerID = c.CustomerID
     WHERE os.OrderStatus = 'Pending'
     ORDER BY os.OrderDate ASC"
);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="AquaStream Water Delivery - Orders List">
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
            <table class="orders-table-clean">
                <thead>
                    <tr>
                        <th>Order ID</th>
                        <th>Customer Name</th>
                        <th>Address</th>
                        <th>Quantity</th>
                        <th>Delivery Date</th>
                        <th>Payment</th>
                        <th>Total Amount</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($rows as $row): ?>
                    <tr>
                        <td>ORD-<?= str_pad($row['OrderID'], 3, '0', STR_PAD_LEFT) ?></td>
                        <td><?= htmlspecialchars($row['CustomerName']) ?></td>
                        <td><?= htmlspecialchars($row['CustomerAddress']) ?></td>
                        <td><?= htmlspecialchars($row['Quantity']) ?></td>
                        <td><?= date('m-d-Y', strtotime($row['DeliveryDate'])) ?></td>
                        <td><?= htmlspecialchars($row['ModeOfPayment']) ?></td>
                        <td>&#8369;<?= number_format($row['TotalAmount'], 2) ?></td>

                        <!-- Status: checkbox completes the order and moves it to history -->
                        <td class="status-cell">
                            <form method="POST" action="OrdersList.php" id="completeForm-<?= $row['OrderID'] ?>">
                                <input type="hidden" name="toggle_status" value="1">
                                <input type="hidden" name="order_id" value="<?= $row['OrderID'] ?>">
                                <input type="checkbox"
                                    class="status-checkbox"
                                    name="status"
                                    onclick="handleComplete(event, <?= $row['OrderID'] ?>)">
                            </form>
                        </td>

                        <!-- Actions: edit + delete -->
                        <td>
                            <div class="action-cell">
                                <form method="POST" action="OrdersList.php"
                                      onsubmit="return confirm('Modify this order?');">
                                    <input type="hidden" name="modify_order" value="1">
                                    <input type="hidden" name="order_id" value="<?= $row['OrderID'] ?>">
                                    <button type="submit" class="edit-btn" title="Modify order">
                                        <i class="fas fa-edit edit-icon"></i>
                                    </button>
                                </form>
                                <form method="POST" action="OrdersList.php"
                                      onsubmit="return confirm('Delete this order? This cannot be undone.');">
                                    <input type="hidden" name="delete_order" value="1">
                                    <input type="hidden" name="order_id" value="<?= $row['OrderID'] ?>">
                                    <button type="submit" class="trash-btn" title="Delete order">
                                        <i class="fas fa-trash trash-icon"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
        <?php else: ?>
            <div class="no-orders">
                <p>No active orders found. Create your first order now!</p>
            </div>
        <?php endif; ?>
    </main>

    <?php include 'footer.php'; ?>

    <script>
    function handleComplete(event, orderId) {
        const checkbox = event.target;
        if (!confirm('Mark this order as completed? It will be moved to history.')) {
            checkbox.checked = false;
            return;
        }
        setTimeout(() => {
            document.getElementById('completeForm-' + orderId).submit();
        }, 3000);
    }
    </script>
</body>
</html>
