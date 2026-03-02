<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sales Dashboard</title>
    <link rel="stylesheet" href="css/sales.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>
</head>
<body>
    <div class="container">
        <header class="header">
            <h1>Sales Dashboard</h1>
            <p class="subtitle">Track your daily and weekly sales performance</p>
        </header>

        <div class="tabs">
            <button class="tab-button active" data-tab="daily">
                Daily Sales
            </button>
            <button class="tab-button" data-tab="weekly">
                Weekly Sales
            </button>
        </div>

        <!-- Daily Sales Tab Content -->
        <div id="daily-content" class="tab-content active">
            <div class="metrics-grid">
                <div class="card metric-card">
                    <div class="metric-label">Total Sales (30 days)</div>
                    <div class="metric-value" id="daily-total-sales">$0</div>
                    <div class="metric-subtext" id="daily-total-orders">0 orders</div>
                </div>
                <div class="card metric-card">
                    <div class="metric-label">Average Daily Sales</div>
                    <div class="metric-value" id="daily-avg-sales">$0</div>
                    <div class="metric-subtext" id="daily-avg-orders">~0 orders/day</div>
                </div>
                <div class="card metric-card">
                    <div class="metric-label">Today vs Yesterday</div>
                    <div class="metric-value" id="daily-today-sales">$0</div>
                    <div class="metric-change" id="daily-change">
                        0% vs yesterday
                    </div>
                </div>
            </div>

            <!-- Daily Sales Trend Chart -->
            <div class="card chart-card">
                <h3 class="chart-title">Daily Sales Trend</h3>
                <div class="chart-container">
                    <canvas id="dailySalesChart"></canvas>
                </div>
            </div>

            <!-- Daily Orders Chart -->
            <div class="card chart-card">
                <h3 class="chart-title">Daily Orders</h3>
                <div class="chart-container">
                    <canvas id="dailyOrdersChart"></canvas>
                </div>
            </div>
        </div>

        <!-- Weekly Sales Tab Content -->
        <div id="weekly-content" class="tab-content">
            <div class="metrics-grid">
                <div class="card metric-card">
                    <div class="metric-label">Total Sales (12 weeks)</div>
                    <div class="metric-value" id="weekly-total-sales">$0</div>
                    <div class="metric-subtext" id="weekly-total-orders">0 orders</div>
                </div>
                <div class="card metric-card">
                    <div class="metric-label">Average Weekly Sales</div>
                    <div class="metric-value" id="weekly-avg-sales">$0</div>
                    <div class="metric-subtext" id="weekly-avg-orders">~0 orders/week</div>
                </div>
                <div class="card metric-card">
                    <div class="metric-label">This Week vs Last Week</div>
                    <div class="metric-value" id="weekly-current-sales">$0</div>
                    <div class="metric-change" id="weekly-change">
                        0% vs last week
                    </div>
                </div>
            </div>

            <!-- Weekly Sales Chart -->
            <div class="card chart-card">
                <h3 class="chart-title">Weekly Sales Trend</h3>
                <div class="chart-container">
                    <canvas id="weeklySalesChart"></canvas>
                </div>
            </div>

            <!-- Orders and Customers Chart -->
            <div class="card chart-card">
                <h3 class="chart-title">Orders & Customers</h3>
                <div class="chart-container">
                    <canvas id="weeklyOrdersChart"></canvas>
                </div>
            </div>
        </div>
    </div>

    <script src="js/main.js"></script>
</body>
</html>