<?php
// Get current page filename
$current_page = basename($_SERVER['PHP_SELF']);
?>

<div class="sidebar">
    <div class="logo-section">
        <img src="imgs/logo.png" alt="AquaStream Logo" class="logo-img">
    </div>
    
    <nav class="sidebar-nav">
        <a href="Index.php" class="nav-item <?php echo ($current_page == 'Index.php') ? 'active' : ''; ?>">
            <img src="imgs/dashboard-icon.png" alt="Dashboard" class="nav-icon">
            <span>Dashboard</span>
        </a>
        
        <a href="CreateOrder.php" class="nav-item <?php echo ($current_page == 'CreateOrder.php') ? 'active' : ''; ?>">
            <img src="imgs/createorder-icon.png" alt="Create Order" class="nav-icon">
            <span>Create Order</span>
        </a>
        
        <a href="OrdersList.php" class="nav-item <?php echo ($current_page == 'OrdersList.php') ? 'active' : ''; ?>">
            <img src="imgs/orderslist-icon.png" alt="Orders List" class="nav-icon">
            <span>Orders List</span>
        </a>

        <a href="Sales.php" class="nav-item <?php echo ($current_page == 'Sales.php') ? 'active' : ''; ?>">
            <img src="imgs/sales-icon.png" alt="Sales" class="nav-icon">
            <span>Sales</span>
        </a>
        
        <a href="History.php" class="nav-item <?php echo ($current_page == 'History.php') ? 'active' : ''; ?>">
            <img src="imgs/history-icon.png" alt="History" class="nav-icon">
            <span>History</span>
        </a>
    </nav>
</div>
