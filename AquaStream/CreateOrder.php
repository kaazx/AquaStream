<?php
require_once 'db.php';
$conn = connectUserDB();

$errors = [];
$successMessage = '';

if (isset($_POST['add'])) {
    $customer_name    = trim($_POST['Name'] ?? '');
    $customer_address = trim($_POST['Address'] ?? '');
    $quantity         = intval($_POST['Quantity'] ?? 0);
    $delivery_date    = trim($_POST['DeliveryDate'] ?? '');
    $payment_method   = trim($_POST['ModeOfPayment'] ?? '');

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

        // Find or create customer (uses correct column names: CustomerName, CustomerAddress)
        $stmt = $conn->prepare("SELECT CustomerID FROM customers WHERE CustomerName = ? AND CustomerAddress = ?");
        $stmt->bind_param("ss", $customer_name, $customer_address);
        $stmt->execute();
        $stmt->store_result();

        if ($stmt->num_rows > 0) {
            $stmt->bind_result($customerID);
            $stmt->fetch();
            $stmt->close();
        } else {
            $stmt->close();
            $stmt = $conn->prepare("INSERT INTO customers (CustomerName, CustomerAddress) VALUES (?, ?)");
            $stmt->bind_param("ss", $customer_name, $customer_address);
            $stmt->execute();
            $customerID = $conn->insert_id;
            $stmt->close();
        }

        // Fetch product (uses correct column name: ProductName, UnitPrice)
        $stmt = $conn->prepare("SELECT ProductID, UnitPrice FROM products WHERE ProductName = 'Gallon of Water' LIMIT 1");
        $stmt->execute();
        $stmt->bind_result($productID, $unitPrice);
        $stmt->fetch();
        $stmt->close();

        if (empty($productID)) {
            $errors['database'] = 'Default product not found. Please contact support.';
        } else {
            $totalAmount = $quantity * $unitPrice;

            // Insert into ordersummary first (OrderID is the PK referenced by orderdetails)
            $stmt = $conn->prepare(
                "INSERT INTO ordersummary (OrderDate, DeliveryDate, ModeOfPayment, OrderStatus, TotalAmount)
                 VALUES (CURDATE(), ?, ?, 'Pending', ?)"
            );
            $stmt->bind_param("ssd", $delivery_date, $payment_method, $totalAmount);

            if ($stmt->execute()) {
                $orderID = $conn->insert_id;
                $stmt->close();

                // Insert into orderdetails
                $stmt = $conn->prepare(
                    "INSERT INTO orderdetails (OrderID, CustomerID, ProductID, Quantity, UnitPrice)
                     VALUES (?, ?, ?, ?, ?)"
                );
                $stmt->bind_param("iiiid", $orderID, $customerID, $productID, $quantity, $unitPrice);

                if ($stmt->execute()) {
                    $stmt->close();
                    $_SESSION['success_message'] = "Order #$orderID created successfully!";
                    header("Location: CreateOrder.php");
                    exit();
                } else {
                    // Roll back ordersummary row if detail insert fails
                    $conn->query("DELETE FROM ordersummary WHERE OrderID = $orderID");
                    $errors['database'] = 'Failed to save order details. Please try again.';
                    $stmt->close();
                }
            } else {
                $errors['database'] = 'Failed to create order. Please try again.';
                $stmt->close();
            }
        }
    }
}

if (isset($_SESSION['success_message'])) {
    $successMessage = $_SESSION['success_message'];
    unset($_SESSION['success_message']);
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="AquaStream Water Delivery - Create New Order">
    <title>Create Order - AquaStream</title>
    <link rel="stylesheet" href="css/styles.css">
    <link rel="stylesheet" href="css/orders.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="icon" type="image/png" href="imgs/logo.png">
</head>
<body>
    <?php include 'sidebar.php'; ?>

    <main class="main-content">
        <div class="order-container">
            <div class="order-card">
                <div class="card-header">
                    <h2 class="form-title">New Order Form</h2>
                </div>

                <!-- Success Message -->
                <?php if (!empty($successMessage)): ?>
                <div class="alert alert-success" role="alert">
                    <i class="fas fa-check-circle"></i>
                    <?php echo htmlspecialchars($successMessage); ?>
                </div>
                <?php endif; ?>

                <!-- Error Messages -->
                <?php if (!empty($errors)): ?>
                <div class="alert alert-error" role="alert">
                    <i class="fas fa-exclamation-circle"></i>
                    <?php foreach ($errors as $error): ?>
                        <p><?php echo htmlspecialchars($error); ?></p>
                    <?php endforeach; ?>
                </div>
                <?php endif; ?>

                <!-- Order Form -->
                <form method="POST" class="order-form" id="orderForm">

                    <!-- Customer Name -->
                    <div class="form-group">
                        <label for="customer_name" class="form-label">Name <span class="required">*</span></label>
                        <input type="text" id="customer_name" name="Name" class="form-input" placeholder="Customer name"
                               value="<?php echo htmlspecialchars($_POST['Name'] ?? ''); ?>" required>
                    </div>

                    <!-- Customer Address -->
                    <div class="form-group">
                        <label for="customer_address" class="form-label">Address <span class="required">*</span></label>
                        <textarea id="customer_address" name="Address" class="form-input form-textarea" placeholder="Customer address" rows="2" required><?php echo htmlspecialchars($_POST['Address'] ?? ''); ?></textarea>
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
                                       value="<?php echo htmlspecialchars($_POST['Quantity'] ?? '1'); ?>"
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
                                       min="<?php echo date('Y-m-d'); ?>"
                                       value="<?php echo htmlspecialchars($_POST['DeliveryDate'] ?? ''); ?>" required>
                                <i class="fas fa-calendar date-icon"></i>
                            </div>
                        </div>
                    </div>

                    <!-- Payment Method -->
                    <div class="payment-container">
                        <label class="form-label">Payment Method <span class="required">*</span></label>
                        <?php
                            $selectedPayment = $_POST['ModeOfPayment'] ?? 'Cash on Delivery';
                            $methods = ['Cash', 'G-Cash', 'Card', 'Cash on Delivery'];
                            foreach ($methods as $method):
                        ?>
                        <label class="radio-option">
                            <input type="radio" name="ModeOfPayment" value="<?php echo $method; ?>"
                                <?php echo ($selectedPayment === $method) ? 'checked' : ''; ?> required>
                            <?php echo $method; ?>
                        </label>
                        <?php endforeach; ?>
                    </div>

                    <!-- Submit Button -->
                    <div class="form-actions">
                        <button type="submit" name="add" class="btn btn-primary">
                            <span class="btn-text">Log Order</span>
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
