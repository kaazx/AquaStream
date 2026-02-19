<?php

require_once 'db.php';

$conn = connectUserDB();

$userName = htmlspecialchars($_SESSION['user_name']);

$totalOrders = $conn->query("SELECT COUNT(*) as count FROM orders")->fetch_assoc()['count'];
$pendingOrders = $conn->query("SELECT COUNT(*) as count FROM orders WHERE order_status = 'Pending'")->fetch_assoc()['count'];
$completedOrders = $conn->query("SELECT COUNT(*) as count FROM orders WHERE order_status = 'Completed'")->fetch_assoc()['count'];

$today = date('Y-m-d');
$urgentOrders = $conn->query(
    "SELECT * FROM orders
     WHERE order_status = 'Pending'
     AND delivery_date <= '$today'
     ORDER BY delivery_date ASC
     LIMIT 6"
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

        <div class="stats-container">
            <div class="stat-card">
                <h3>Total Orders</h3>
                <div class="number"><?php echo $totalOrders; ?></div>
            </div>
            <div class="stat-card">
                <h3>Pendings</h3>
                <div class="number"><?php echo $pendingOrders; ?></div>
            </div>
            <div class="stat-card">
                <h3>Completed</h3>
                <div class="number"><?php echo $completedOrders; ?></div>
            </div>
        </div>

        <div class="urgent-section">
            <h2>Urgent Orders</h2>
            <div class="orders-grid">
                <?php if (mysqli_num_rows($urgentOrders) > 0): ?>
                    <?php while ($row = $urgentOrders->fetch_assoc()): ?>
                        <div class="order-card">
                            <div class="order-info">
                                <h4>Order #<?php echo htmlspecialchars($row['id']); ?> - 
                                    <?php echo ($row['delivery_date'] < $today) ? 'Overdue' : 'Due Today'; ?>
                                </h4>
                                <p><?php echo htmlspecialchars($row['customer_name']); ?>, <?php echo htmlspecialchars($row['customer_address']); ?></p>
                            </div>
                            <button class="complete-btn" onclick="completeOrder(<?php echo $row['id']; ?>)">
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
