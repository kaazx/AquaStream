<?php
require_once 'db.php';
$conn = connectUserDB();

// ─── DAILY: yesterday through next 28 days (grouped by DeliveryDate) ────────
// Window: CURDATE() - 1 day → CURDATE() + 28 days
// Yesterday stays visible; future delivery dates show their completed sales.
$dailyRows = $conn->query(
    "SELECT
        DATE(os.DeliveryDate)       AS day,
        SUM(os.TotalAmount)         AS sales,
        COUNT(DISTINCT os.OrderID)  AS orders
     FROM ordersummary os
     WHERE os.OrderStatus = 'Completed'
       AND os.DeliveryDate >= CURDATE() - INTERVAL 1 DAY
       AND os.DeliveryDate <= CURDATE() + INTERVAL 28 DAY
     GROUP BY DATE(os.DeliveryDate)
     ORDER BY day ASC"
);

$dailyData   = [];
$dailyLabels = [];
$dailySales  = [];
$dailyOrders = [];
while ($r = $dailyRows->fetch_assoc()) {
    $dailyData[$r['day']] = $r;
}
// Fill 30 slots: yesterday (offset -1) through +28 days from today
// Uses date arithmetic directly to avoid strtotime sign ambiguity
// Labels: "Mar 20", "Mar 21", "Mar 22" ... "Apr 18"
$startDate = date('Y-m-d', strtotime('-1 day'));
for ($i = 0; $i < 30; $i++) {
    $d = date('Y-m-d', strtotime($startDate . " +$i days"));
    $dailyLabels[] = date('M j', strtotime($d));
    $dailySales[]  = isset($dailyData[$d]) ? (float)$dailyData[$d]['sales']  : 0;
    $dailyOrders[] = isset($dailyData[$d]) ? (int)  $dailyData[$d]['orders'] : 0;
}

$totalSales30  = array_sum($dailySales);
$avgDailySales = $totalSales30 / 30;
$totalOrders30 = array_sum($dailyOrders);

// Today vs Yesterday — queried directly so $dailyData lookup is never ambiguous
$todayRow = $conn->query(
    "SELECT SUM(TotalAmount) AS sales FROM ordersummary
     WHERE OrderStatus = 'Completed'
       AND DATE(DeliveryDate) = CURDATE()"
)->fetch_assoc();
$yesterdayRow = $conn->query(
    "SELECT SUM(TotalAmount) AS sales FROM ordersummary
     WHERE OrderStatus = 'Completed'
       AND DATE(DeliveryDate) = CURDATE() - INTERVAL 1 DAY"
)->fetch_assoc();
$todaySales     = (float)($todayRow['sales']     ?? 0);
$yesterdaySales = (float)($yesterdayRow['sales'] ?? 0);
$dailyChangePct = $yesterdaySales > 0
    ? round((($todaySales - $yesterdaySales) / $yesterdaySales) * 100, 1)
    : ($todaySales > 0 ? 100 : 0);

// ─── WEEKLY: last 12 weeks (grouped by DeliveryDate) ────────────────────
$weeklyRows = $conn->query(
    "SELECT
        YEARWEEK(os.DeliveryDate, 1)            AS yw,
        SUM(os.TotalAmount)                     AS sales,
        COUNT(DISTINCT os.OrderID)              AS orders,
        COUNT(DISTINCT od.CustomerID)           AS customers
     FROM ordersummary os
     JOIN orderdetails od ON os.OrderID = od.OrderID
     WHERE os.OrderStatus = 'Completed'
       AND os.DeliveryDate >= CURDATE() - INTERVAL 83 DAY
     GROUP BY YEARWEEK(os.DeliveryDate, 1)
     ORDER BY yw ASC
     LIMIT 12"
);

$weeklyData      = [];
$weeklyLabels    = [];
$weeklySales     = [];
$weeklyOrders    = [];
$wIdx = 1;
while ($r = $weeklyRows->fetch_assoc()) {
    $weeklyLabels[]    = 'Week ' . $wIdx++;
    $weeklySales[]     = (float)$r['sales'];
    $weeklyOrders[]    = (int)  $r['orders'];
}
// Pad to 12 weeks if fewer results
while (count($weeklySales) < 12) {
    $weeklyLabels[]    = 'Week ' . $wIdx++;
    $weeklySales[]     = 0;
    $weeklyOrders[]    = 0;
}

$totalSales12W   = array_sum($weeklySales);
$avgWeeklySales  = array_sum($weeklySales) ? $totalSales12W / 12 : 0;
$totalOrders12W  = array_sum($weeklyOrders);

// Query this week and last week directly for accurate comparison
$thisWeekRow = $conn->query(
    "SELECT SUM(TotalAmount) AS sales FROM ordersummary
     WHERE OrderStatus = 'Completed'
       AND YEARWEEK(DeliveryDate, 1) = YEARWEEK(CURDATE(), 1)"
)->fetch_assoc();
$lastWeekRow = $conn->query(
    "SELECT SUM(TotalAmount) AS sales FROM ordersummary
     WHERE OrderStatus = 'Completed'
       AND YEARWEEK(DeliveryDate, 1) = YEARWEEK(CURDATE() - INTERVAL 7 DAY, 1)"
)->fetch_assoc();
$thisWeekSales  = (float)($thisWeekRow['sales'] ?? 0);
$lastWeekSales  = (float)($lastWeekRow['sales'] ?? 0);
$weeklyChangePct = $lastWeekSales > 0
    ? round((($thisWeekSales - $lastWeekSales) / $lastWeekSales) * 100, 1)
    : ($thisWeekSales > 0 ? 100 : 0);

$conn->close();

// helpers for formatting
function peso(float $n): string {
    return '₱ ' . number_format($n, 0, '.', ',');
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sales Dashboard - AquaStream</title>
    <link rel="stylesheet" href="css/styles.css">
    <link rel="stylesheet" href="css/sales.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="icon" type="image/png" href="imgs/logo.png">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/4.4.1/chart.umd.min.js"></script>
</head>
<body>
    <?php include 'sidebar.php'; ?>

    <main class="sales-main">
        <div class="sales-container">

            <header class="sales-header">
                <h1>Sales Dashboard</h1>
            </header>

            <!-- Tab buttons -->
            <div class="tabs">
                <button class="tab-button active" data-tab="daily">
                    <i class="fas fa-chart-line"></i> Daily Sales
                </button>
                <button class="tab-button" data-tab="weekly">
                    <i class="fas fa-calendar-week"></i> Weekly Sales
                </button>
            </div>

            <!-- ══════════════ DAILY TAB ══════════════ -->
            <div id="daily-content" class="tab-content active">

                <div class="metrics-grid">
                    <div class="card metric-card">
                        <div class="metric-label">Total Sales (30 days)</div>
                        <div class="metric-value"><?= peso($totalSales30) ?></div>
                        <div class="metric-subtext"><?= number_format($totalOrders30) ?> orders</div>
                    </div>
                    <div class="card metric-card">
                        <div class="metric-label">Average Daily Sales</div>
                        <div class="metric-value"><?= peso($avgDailySales) ?></div>
                        <div class="metric-subtext">~<?= number_format($totalOrders30 / 30, 1) ?> orders/day</div>
                    </div>
                    <div class="card metric-card">
                        <div class="metric-label">Today vs Yesterday</div>
                        <div class="metric-value"><?= peso($todaySales) ?></div>
                        <div class="metric-change <?= $dailyChangePct >= 0 ? 'positive' : 'negative' ?>">
                            <?= ($dailyChangePct >= 0 ? '▲ +' : '▼ ') . $dailyChangePct ?>% vs yesterday
                        </div>
                    </div>
                </div>

                <div class="card chart-card">
                    <h3 class="chart-title">Daily Sales Trend</h3>
                    <div class="chart-container">
                        <canvas id="dailySalesChart"></canvas>
                    </div>
                </div>

                <div class="card chart-card">
                    <h3 class="chart-title">Daily Orders</h3>
                    <div class="chart-container">
                        <canvas id="dailyOrdersChart"></canvas>
                    </div>
                </div>
            </div>

            <!-- ══════════════ WEEKLY TAB ══════════════ -->
            <div id="weekly-content" class="tab-content">

                <div class="metrics-grid">
                    <div class="card metric-card">
                        <div class="metric-label">Total Sales (12 weeks)</div>
                        <div class="metric-value"><?= peso($totalSales12W) ?></div>
                        <div class="metric-subtext"><?= number_format($totalOrders12W) ?> orders</div>
                    </div>
                    <div class="card metric-card">
                        <div class="metric-label">Average Weekly Sales</div>
                        <div class="metric-value"><?= peso($avgWeeklySales) ?></div>
                        <div class="metric-subtext">~<?= number_format($totalOrders12W / 12, 1) ?> orders/week</div>
                    </div>
                    <div class="card metric-card">
                        <div class="metric-label">This Week vs Last Week</div>
                        <div class="metric-value"><?= peso($thisWeekSales) ?></div>
                        <div class="metric-change <?= $weeklyChangePct >= 0 ? 'positive' : 'negative' ?>">
                            <?= ($weeklyChangePct >= 0 ? '▲ +' : '▼ ') . $weeklyChangePct ?>% vs last week
                        </div>
                    </div>
                </div>

                <div class="card chart-card">
                    <h3 class="chart-title">Weekly Sales Trend</h3>
                    <div class="chart-container">
                        <canvas id="weeklySalesChart"></canvas>
                    </div>
                </div>

                <div class="card chart-card">
                    <h3 class="chart-title">Orders</h3>
                    <div class="chart-container">
                        <canvas id="weeklyOrdersChart"></canvas>
                    </div>
                </div>
            </div>

        </div><!-- /.sales-container -->
    </main>

    <?php include 'footer.php'; ?>

    <script>
    // PHP → JS: data variables read by main.js for chart rendering
    const dailyLabels  = <?= json_encode($dailyLabels) ?>;
    const dailySales   = <?= json_encode($dailySales) ?>;
    const dailyOrders  = <?= json_encode($dailyOrders) ?>;
    const weeklyLabels = <?= json_encode($weeklyLabels) ?>;
    const weeklySales  = <?= json_encode($weeklySales) ?>;
    const weeklyOrders = <?= json_encode($weeklyOrders) ?>;
    </script>
    <script src="js/main.js"></script>
</body>
</html>
