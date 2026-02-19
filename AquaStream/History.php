<?php 
require_once 'db.php'; 

$conn = connectUserDB();

$orders = $conn->query("SELECT * FROM orders WHERE order_status='Completed' ORDER BY created_at DESC");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>AquaStream</title>
    <link rel="stylesheet" href="css/styles.css">
    <link rel="stylesheet" href="css/history.css">
    <link rel='stylesheet' href='https://fonts.googleapis.com/css2?family=League+Spartan:wght@400;500;600;700&display=swap'>
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
                    <?php while($row = $orders->fetch_assoc()):
                        $dateObj = new DateTime($row['created_at']);
                        $formattedDate = $dateObj->format('m-d-Y');
                    ?>
                    <div class="order-card">
                        <h3 class="order-number">Order #<?php echo ($row['id']); ?></h3>
                        <div class="order-details">
                            <div class="order-detail-item">
                                <span class="detail-label">Name:</span>
                                <span class="detail-value"><?php echo ($row['customer_name']); ?></span>
                            </div>
                            <div class="order-detail-item">
                                <span class="detail-label">Date Ordered:</span>
                                <span class="detail-value"><?php echo $formattedDate; ?></span>
                            </div>
                            <div class="order-detail-item">
                                <span class="detail-label">Order:</span>
                                <span class="detail-value"><?php echo ($row['quantity']); ?> gallons</span>
                            </div>
                        </div>
                    </div>
                    <?php endwhile; ?>
                </div>
            </div>
        </main>
        <?php include 'footer.php'; ?>
</body>
</html>

<?php
$conn->close();
?>
