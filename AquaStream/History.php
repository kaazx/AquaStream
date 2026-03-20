<?php
require_once 'db.php';

$conn = connectUserDB();

// Fetch all completed orders with customer info and quantity
$orders = $conn->query(
    "SELECT
        os.OrderID,
        os.OrderDate,
        c.CustomerName,
        od.Quantity
     FROM ordersummary os
     JOIN orderdetails od ON os.OrderID = od.OrderID
     JOIN customers c     ON od.CustomerID = c.CustomerID
     WHERE os.OrderStatus = 'Completed'
     ORDER BY os.UpdatedAt DESC"
);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order History - AquaStream</title>
    <link rel="stylesheet" href="css/styles.css">
    <link rel="stylesheet" href="css/history.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=League+Spartan:wght@400;500;600;700&display=swap">
    <link rel="icon" type="image/png" href="imgs/logo.png">
</head>
<body>
    <?php include 'sidebar.php'; ?>

    <main>
        <div class="content">
            <div class="title-section">
                <h1>Order History</h1>
            </div>

            <div class="orders-container">
                <?php if ($orders && $orders->num_rows > 0): ?>
                    <?php while ($row = $orders->fetch_assoc()):
                        $formattedDate = date('m-d-Y', strtotime($row['OrderDate']));
                    ?>
                    <div class="order-card">
                        <h3 class="order-number">Order #<?= str_pad($row['OrderID'], 3, '0', STR_PAD_LEFT) ?></h3>
                        <div class="order-details">
                            <div class="order-detail-item">
                                <span class="detail-label">Name:</span>
                                <span class="detail-value"><?= htmlspecialchars($row['CustomerName']) ?></span>
                            </div>
                            <div class="order-detail-item">
                                <span class="detail-label">Date Ordered:</span>
                                <span class="detail-value"><?= $formattedDate ?></span>
                            </div>
                            <div class="order-detail-item">
                                <span class="detail-label">Order:</span>
                                <span class="detail-value"><?= htmlspecialchars($row['Quantity']) ?> gallon(s)</span>
                            </div>
                        </div>
                    </div>
                    <?php endwhile; ?>
                <?php else: ?>
                    <div class="no-orders">
                        <p>No completed orders yet</p>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </main>

    <?php include 'footer.php'; ?>
</body>
</html>

<?php $conn->close(); ?>
