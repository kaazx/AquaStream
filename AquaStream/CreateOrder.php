<?php
session_start();

// Connect to database
$conn = new mysqli("localhost", "root", "", "AdminDB");

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Creates a new order with validation and error handling
$errors = [];
$successMessage = '';

if (isset($_POST['add'])) {
    $customer_name = trim($_POST['customer_name'] ?? '');
    $customer_address = trim($_POST['customer_address'] ?? '');
    $quantity = intval($_POST['quantity'] ?? 0);
    $delivery_date = trim($_POST['delivery_date'] ?? '');
    $payment_method = trim($_POST['payment_method'] ?? '');
    
    // Basic validation
    if (empty($customer_name)) {
        $errors['customer_name'] = 'Customer name is required.';}
    
    if (empty($customer_address)) {
        $errors['customer_address'] = 'Customer address is required.';}
    
    if (empty($delivery_date)) {
        $errors['delivery_date'] = 'Delivery date is required.';}
    
    if (empty($payment_method)) {
        $errors['payment_method'] = 'Payment method is required.';}
    
    // If no errors, add order to database
    if (empty($errors)) {
        $customer_name = $conn->real_escape_string($customer_name);
        $customer_address = $conn->real_escape_string($customer_address);
        $delivery_date = $conn->real_escape_string($delivery_date);
        $payment_method = $conn->real_escape_string($payment_method);
        
        $result = $conn->query("INSERT INTO orders (customer_name, customer_address, quantity, delivery_date, payment_method, order_status, created_at) 
                                VALUES ('$customer_name', '$customer_address', $quantity, '$delivery_date', '$payment_method', 'Pending', NOW())");
        
        if ($result) {
            $orderId = $conn->insert_id;
            $_SESSION['success_message'] = "Order #$orderId created successfully!";
            header("Location: CreateOrder.php");
            exit();
        } else {
            $errors['database'] = 'Failed to create order. Please try again.';}
    }
}

// Get success message from session
if (isset($_SESSION['success_message'])) {
    $successMessage = $_SESSION['success_message'];
    unset($_SESSION['success_message']);}
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
                
                <!-- Order Form -->
                <form method="POST" class="order-form" id="orderForm">
                    
                    <!-- Customer Name -->
                    <div class="form-group">
                        <label for="customer_name" class="form-label">Name <span class="required">*</span></label>
                        <input type="text" id="customer_name" name="customer_name" class="form-input" placeholder="Customer name" required>
                    </div>
                    
                    <!-- Customer Address -->
                    <div class="form-group">
                        <label for="customer_address" class="form-label">Address <span class="required">*</span></label>
                        <textarea id="customer_address" name="customer_address" class="form-input form-textarea" placeholder="Customer address" rows="2" required></textarea>
                    </div>
                    
                    <div class="form-row">
                        <!-- Quantity -->
                        <div class="form-group form-group-half">
                            <label for="quantity" class="form-label">Quantity <span class="required">*</span></label>
                            <div class="quantity-control">
                                <button type="button" class="quantity-btn quantity-minus" id="quantityMinus" aria-label="Decrease quantity">
                                    <i class="fas fa-minus"></i>
                                </button>
                                <input type="number" id="quantity" name="quantity" class="form-input quantity-input" value="<?php echo htmlspecialchars($formData['quantity'] ?? '1'); ?>" min="1" required readonly>
                                <button type="button" class="quantity-btn quantity-plus" id="quantityPlus" aria-label="Increase quantity">
                                    <i class="fas fa-plus"></i>
                                </button>
                            </div>
                        </div>
                        
                        <!-- Delivery Date -->
                        <div class="form-group form-group-half">
                            <label for="delivery_date" class="form-label">Delivery Date <span class="required">*</span></label>
                            <div class="date-input-wrapper">
                                <input type="date" id="delivery_date" name="delivery_date" class="form-input date-input" min="<?php echo date('Y-m-d'); ?>" required>
                                <i class="fas fa-calendar date-icon"></i>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Payment Method -->
                    <div class="payment-container">
                        <label class="form-label">Payment Method <span class="required">*</span></label>
                        <label class="radio-option">
                            <input type="radio" name="payment_method" value="Cash" required>
                            Cash
                        </label>

                        <label class="radio-option">
                            <input type="radio" name="payment_method" value="G-Cash">
                            G-Cash
                        </label>

                        <label class="radio-option">
                            <input type="radio" name="payment_method" value="Card">
                            Card
                        </label>

                        <label class="radio-option">
                            <input type="radio" name="payment_method" value="Cash on Delivery" checked>
                            Cash on Delivery
                        </label>
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
        
        <!-- Footer -->
        <?php include 'footer.php'; ?>
    </main>
    
    <script src="js/main.js"></script>
</body>
</html>
