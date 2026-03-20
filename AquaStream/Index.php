<?php

require_once 'db.php';

$conn = connectUserDB();

$userName = htmlspecialchars($_SESSION['user_name']);

$totalOrders     = $conn->query("SELECT COUNT(*) AS count FROM ordersummary")->fetch_assoc()['count'];
$pendingOrders   = $conn->query("SELECT COUNT(*) AS count FROM ordersummary WHERE OrderStatus = 'Pending'")->fetch_assoc()['count'];
$completedOrders = $conn->query("SELECT COUNT(*) AS count FROM ordersummary WHERE OrderStatus = 'Completed'")->fetch_assoc()['count'];

$today = date('Y-m-d');

// Urgent = all Pending orders whose DeliveryDate is today or overdue
// Uses a subquery to avoid GROUP BY issues with non-aggregated columns
$urgentOrders = $conn->query(
    "SELECT os.OrderID, os.DeliveryDate, c.CustomerName, c.CustomerAddress
     FROM ordersummary os
     JOIN orderdetails od ON os.OrderID = od.OrderID
     JOIN customers c     ON od.CustomerID = c.CustomerID
     WHERE os.OrderStatus = 'Pending'
       AND os.DeliveryDate <= CURDATE()
     ORDER BY os.DeliveryDate ASC"
);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - AquaStream</title>
    <link rel="stylesheet" href="css/styles.css">
    <link rel="stylesheet" href="css/index.css">
    <link rel="icon" type="image/png" href="imgs/logo.png">
</head>
<body>
    <?php include 'sidebar.php'; ?>

    <div class="main-content">
        <div class="header">
            <h1>Hello, <?php echo $userName; ?>!</h1>
            <button class="logout-btn" onclick="location.href='logout.php'">Log Out</button>
        </div>

        <!-- Stats -->
        <div class="stats-container">
            <div class="stat-card">
                <h3>Total Orders</h3>
                <div class="number"><?php echo $totalOrders; ?></div>
            </div>
            <div class="stat-card">
                <h3>Pending</h3>
                <div class="number"><?php echo $pendingOrders; ?></div>
            </div>
            <div class="stat-card">
                <h3>Completed</h3>
                <div class="number"><?php echo $completedOrders; ?></div>
            </div>
        </div>

        <!-- Urgent Orders -->
        <div class="urgent-section">
            <h2>Urgent Orders</h2>
            <div class="orders-grid">
                <?php if ($urgentOrders && $urgentOrders->num_rows > 0): ?>
                    <?php while ($row = $urgentOrders->fetch_assoc()): ?>
                        <div class="order-card" id="order-card-<?php echo $row['OrderID']; ?>">
                            <div class="order-info">
                                <h4>
                                    Order #<?php echo htmlspecialchars($row['OrderID']); ?> &mdash;
                                    <?php echo ($row['DeliveryDate'] < $today) ? 'Overdue' : 'Due Today'; ?>
                                </h4>
                                <p>
                                    <?php echo htmlspecialchars($row['CustomerName']); ?>,
                                    <?php echo htmlspecialchars($row['CustomerAddress']); ?>
                                </p>
                            </div>
                            <button class="complete-btn" onclick="completeOrder(<?php echo $row['OrderID']; ?>)">
                                Complete
                            </button>
                        </div>
                    <?php endwhile; ?>
                <?php else: ?>
                    <div class="no-orders">
                        <p>No urgent orders at the moment</p>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <?php include 'footer.php'; ?>

    <script src="js/main.js"></script>
</body>
</html>

<?php $conn->close(); ?>
