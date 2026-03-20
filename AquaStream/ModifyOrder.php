<?php
require_once 'db.php';

$conn = connectUserDB();

$errors = [];
$successMessage = '';

// ------------------------------------------------------------------
// 1. Validate the ?id= parameter and confirm order is still Pending
// ------------------------------------------------------------------
$orderID = intval($_GET['id'] ?? $_POST['order_id'] ?? 0);

if ($orderID <= 0) {
    header("Location: OrdersList.php");
    exit();
}

$stmt = $conn->prepare(
    "SELECT
        os.OrderID,
        os.DeliveryDate,
        os.ModeOfPayment,
        os.OrderStatus,
        c.CustomerID,
        c.CustomerName,
        c.CustomerAddress,
        od.OrderDetailID,
        od.Quantity,
        od.UnitPrice
     FROM ordersummary os
     JOIN orderdetails od ON os.OrderID  = od.OrderID
     JOIN customers c     ON od.CustomerID = c.CustomerID
     WHERE os.OrderID = ? AND os.OrderStatus = 'Pending'
     LIMIT 1"
);
$stmt->bind_param("i", $orderID);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
    // Order doesn't exist or is no longer pending — bounce back
    header("Location: OrdersList.php");
    exit();
}

$order = $result->fetch_assoc();
$stmt->close();

// ------------------------------------------------------------------
// 2. Handle form submission
// ------------------------------------------------------------------
if (isset($_POST['update'])) {
    $customer_name    = trim($_POST['Name'] ?? '');
    $customer_address = trim($_POST['Address'] ?? '');
    $quantity         = intval($_POST['Quantity'] ?? 0);
    $delivery_date    = trim($_POST['DeliveryDate'] ?? '');
    $payment_method   = trim($_POST['ModeOfPayment'] ?? '');

    // Validation — same rules as CreateOrder
    if (empty($customer_name)) {
        $errors['Name'] = 'Customer name is required.';
    }
    if (empty($customer_address)) {
        $errors['Address'] = 'Customer address is required.';
    }
    if ($quantity < 1) {
        $errors['Quantity'] = 'Quantity must be at least 1.';
    }
    if (empty($delivery_date)) {
        $errors['DeliveryDate'] = 'Delivery date is required.';
    } elseif ($delivery_date < date('Y-m-d')) {
        $errors['DeliveryDate'] = 'Delivery date cannot be in the past.';
    }
    if (empty($payment_method)) {
        $errors['ModeOfPayment'] = 'Payment method is required.';
    }

    if (empty($errors)) {

        // -- Customer: check if name+address already exists, else create new --
        $stmt = $conn->prepare(
            "SELECT CustomerID FROM customers WHERE CustomerName = ? AND CustomerAddress = ?"
        );
        $stmt->bind_param("ss", $customer_name, $customer_address);
        $stmt->execute();
        $stmt->store_result();

        if ($stmt->num_rows > 0) {
            $stmt->bind_result($newCustomerID);
            $stmt->fetch();
            $stmt->close();
        } else {
            $stmt->close();
            $stmt = $conn->prepare(
                "INSERT INTO customers (CustomerName, CustomerAddress) VALUES (?, ?)"
            );
            $stmt->bind_param("ss", $customer_name, $customer_address);
            $stmt->execute();
            $newCustomerID = $conn->insert_id;
            $stmt->close();
        }

        // -- Recalculate total using the stored unit price --
        $newTotal = $quantity * $order['UnitPrice'];

        // -- Update ordersummary --
        $stmt = $conn->prepare(
            "UPDATE ordersummary
             SET DeliveryDate = ?, ModeOfPayment = ?, TotalAmount = ?
             WHERE OrderID = ? AND OrderStatus = 'Pending'"
        );
        $stmt->bind_param("ssdi", $delivery_date, $payment_method, $newTotal, $orderID);
        $summaryOk = $stmt->execute();
        $stmt->close();

        // -- Update orderdetails --
        $stmt = $conn->prepare(
            "UPDATE orderdetails
             SET CustomerID = ?, Quantity = ?
             WHERE OrderID = ?"
        );
        $stmt->bind_param("iii", $newCustomerID, $quantity, $orderID);
        $detailOk = $stmt->execute();
        $stmt->close();

        if ($summaryOk && $detailOk) {
            $_SESSION['success_message'] = "Order #$orderID updated successfully!";
            header("Location: OrdersList.php");
            exit();
        } else {
            $errors['database'] = 'Failed to update order. Please try again.';
        }
    }

    // Re-populate $order with submitted values so the form reflects what the user typed
    $order['CustomerName']    = $customer_name;
    $order['CustomerAddress'] = $customer_address;
    $order['Quantity']        = $quantity;
    $order['DeliveryDate']    = $delivery_date;
    $order['ModeOfPayment']   = $payment_method;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="AquaStream Water Delivery - Modify Order">
    <title>Modify Order - AquaStream</title>
    <link rel="stylesheet" href="css/styles.css">
    <link rel="stylesheet" href="css/modify.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="icon" type="image/png" href="imgs/logo.png">
</head>
<body>
    <?php include 'sidebar.php'; ?>

    <main class="main-content">
        <div class="order-container">
            <div class="order-card">
                <div class="card-header">
                    <h2 class="form-title">
                        Edit Order
                        <span class="order-id-badge">ORD-<?= str_pad($orderID, 3, '0', STR_PAD_LEFT) ?></span>
                    </h2>
                </div>

                <!-- Error Messages -->
                <?php if (!empty($errors)): ?>
                <div class="alert alert-error" role="alert">
                    <i class="fas fa-exclamation-circle"></i>
                    <?php foreach ($errors as $error): ?>
                        <p><?php echo htmlspecialchars($error); ?></p>
                    <?php endforeach; ?>
                </div>
                <?php endif; ?>

                <!-- Edit Form -->
                <form method="POST" class="order-form" id="orderForm">
                    <input type="hidden" name="order_id" value="<?= $orderID ?>">

                    <!-- Customer Name -->
                    <div class="form-group">
                        <label for="customer_name" class="form-label">Name <span class="required">*</span></label>
                        <input type="text" id="customer_name" name="Name" class="form-input"
                               placeholder="Customer name"
                               value="<?= htmlspecialchars($order['CustomerName']) ?>" required>
                    </div>

                    <!-- Customer Address -->
                    <div class="form-group">
                        <label for="customer_address" class="form-label">Address <span class="required">*</span></label>
                        <textarea id="customer_address" name="Address" class="form-input form-textarea"
                                  placeholder="Customer address" rows="2" required><?= htmlspecialchars($order['CustomerAddress']) ?></textarea>
                    </div>

                    <div class="form-row">
                        <!-- Quantity -->
                        <div class="form-group form-group-half">
                            <label for="quantity" class="form-label">Quantity <span class="required">*</span></label>
                            <div class="quantity-control">
                                <button type="button" class="quantity-btn quantity-minus" id="quantityMinus" aria-label="Decrease quantity">
                                    <i class="fas fa-minus"></i>
                                </button>
                                <input type="number" id="quantity" name="Quantity" class="form-input quantity-input"
                                       value="<?= htmlspecialchars($order['Quantity']) ?>"
                                       min="1" required readonly>
                                <button type="button" class="quantity-btn quantity-plus" id="quantityPlus" aria-label="Increase quantity">
                                    <i class="fas fa-plus"></i>
                                </button>
                            </div>
                        </div>

                        <!-- Delivery Date -->
                        <div class="form-group form-group-half">
                            <label for="delivery_date" class="form-label">Delivery Date <span class="required">*</span></label>
                            <div class="date-input-wrapper">
                                <input type="date" id="delivery_date" name="DeliveryDate" class="form-input date-input"
                                       min="<?= date('Y-m-d') ?>"
                                       value="<?= htmlspecialchars($order['DeliveryDate']) ?>" required>
                                <i class="fas fa-calendar date-icon"></i>
                            </div>
                        </div>
                    </div>

                    <!-- Payment Method -->
                    <div class="payment-container">
                        <label class="form-label">Payment Method <span class="required">*</span></label>
                        <?php
                            $selectedPayment = $order['ModeOfPayment'];
                            $methods = ['Cash', 'G-Cash', 'Card', 'Cash on Delivery'];
                            foreach ($methods as $method):
                        ?>
                        <label class="radio-option">
                            <input type="radio" name="ModeOfPayment" value="<?= $method ?>"
                                <?= ($selectedPayment === $method) ? 'checked' : '' ?> required>
                            <?= $method ?>
                        </label>
                        <?php endforeach; ?>
                    </div>

                    <!-- Actions -->
                    <div class="form-actions modify-actions">
                        <a href="OrdersList.php" class="btn btn-secondary">
                            <i class="fas fa-arrow-left"></i>
                            <span class="btn-text">Cancel</span>
                        </a>
                        <button type="submit" name="update" class="btn btn-primary">
                            <i class="fas fa-save"></i>
                            <span class="btn-text">Save Changes</span>
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <?php include 'footer.php'; ?>
    </main>

    <script src="js/main.js"></script>
</body>
</html>