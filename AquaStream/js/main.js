// ── Complete an order from the dashboard's urgent orders panel ────────────
function completeOrder(orderId) {
    if (confirm('Mark this order as complete?')) {
        fetch('UpdateOrder.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded',
            },
            body: 'OrderID=' + orderId + '&action=complete'
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                alert('Order completed successfully!');
                location.reload();
            } else {
                alert('Error: ' + data.message);
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('An error occurred. Please try again.');
        });
    }
}

document.addEventListener('DOMContentLoaded', function () {

    // ── Quantity stepper on CreateOrder / ModifyOrder forms ──────────────
    const quantityInput = document.getElementById('quantity');
    const quantityMinus = document.getElementById('quantityMinus');
    const quantityPlus  = document.getElementById('quantityPlus');

    if (quantityMinus) {
        quantityMinus.addEventListener('click', function () {
            let value = parseInt(quantityInput.value) || 1;
            if (value > 1) {
                quantityInput.value = value - 1;
                quantityMinus.disabled = (value - 1 <= 1);
            }
        });
    }

    if (quantityPlus) {
        quantityPlus.addEventListener('click', function () {
            let value = parseInt(quantityInput.value) || 1;
            quantityInput.value = value + 1;
            if (quantityMinus) quantityMinus.disabled = false;
        });
    }

    // ── Enforce today as minimum delivery date (client-side guard) ────────
    // Uses local date parts instead of toISOString() which returns UTC
    // and can show yesterday's date in UTC+8 timezones like the Philippines
    const deliveryDateInput = document.getElementById('delivery_date');
    if (deliveryDateInput) {
        const now   = new Date();
        const yyyy  = now.getFullYear();
        const mm    = String(now.getMonth() + 1).padStart(2, '0');
        const dd    = String(now.getDate()).padStart(2, '0');
        const today = `${yyyy}-${mm}-${dd}`;
        deliveryDateInput.setAttribute('min', today);
    }

    // ── Auto-dismiss success alert after 5 seconds ────────────────────────
    const successAlert = document.querySelector('.alert-success');
    if (successAlert) {
        setTimeout(() => {
            successAlert.style.opacity = '0';
            setTimeout(() => successAlert.remove(), 500);
        }, 5000);
    }

});

if (typeof dailyLabels !== 'undefined') {

    Chart.defaults.font.family = "'League Spartan', sans-serif";
    Chart.defaults.font.size   = 11;
    Chart.defaults.color       = '#6b7280';

    const gridOpts = {
        color: 'rgba(0,0,0,0.06)',
        drawBorder: false
    };

    // ── Daily Sales Trend (line) ──────────────────────────────────────────
    new Chart(document.getElementById('dailySalesChart'), {
        type: 'line',
        data: {
            labels: dailyLabels,
            datasets: [{
                label: 'Sales (₱)',
                data: dailySales,
                borderColor: '#4A90D9',
                backgroundColor: 'rgba(74,144,217,0.08)',
                borderWidth: 2,
                pointRadius: 3,
                pointBackgroundColor: '#4A90D9',
                tension: 0.4,
                fill: true
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: { display: false },
                tooltip: {
                    callbacks: {
                        label: ctx => ' ₱ ' + ctx.parsed.y.toLocaleString()
                    }
                }
            },
            scales: {
                x: { grid: gridOpts, ticks: { maxTicksLimit: 10 } },
                y: {
                    grid: gridOpts,
                    ticks: {
                        callback: v => '₱' + v.toLocaleString()
                    }
                }
            }
        }
    });

    // ── Daily Orders (bar) ────────────────────────────────────────────────
    new Chart(document.getElementById('dailyOrdersChart'), {
        type: 'bar',
        data: {
            labels: dailyLabels,
            datasets: [{
                label: 'Orders',
                data: dailyOrders,
                backgroundColor: 'rgba(74,144,217,0.75)',
                borderRadius: 3,
                borderSkipped: false
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: { display: false }
            },
            scales: {
                x: { grid: { display: false }, ticks: { maxTicksLimit: 10 } },
                y: { grid: gridOpts, beginAtZero: true }
            }
        }
    });

    // ── Weekly Sales Trend (bar) ──────────────────────────────────────────
    new Chart(document.getElementById('weeklySalesChart'), {
        type: 'bar',
        data: {
            labels: weeklyLabels,
            datasets: [{
                label: 'Sales (₱)',
                data: weeklySales,
                backgroundColor: 'rgba(74,144,217,0.75)',
                borderRadius: 4,
                borderSkipped: false
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: { display: false },
                tooltip: {
                    callbacks: {
                        label: ctx => ' ₱ ' + ctx.parsed.y.toLocaleString()
                    }
                }
            },
            scales: {
                x: { grid: { display: false } },
                y: {
                    grid: gridOpts,
                    beginAtZero: true,
                    ticks: {
                        callback: v => '₱' + v.toLocaleString()
                    }
                }
            }
        }
    });

    // ── Weekly Orders (line) ──────────────────────────────────────────────
    new Chart(document.getElementById('weeklyOrdersChart'), {
        type: 'line',
        data: {
            labels: weeklyLabels,
            datasets: [
                {
                    label: 'Orders',
                    data: weeklyOrders,
                    borderColor: '#4A90D9',
                    backgroundColor: 'transparent',
                    borderWidth: 2,
                    pointRadius: 4,
                    pointBackgroundColor: '#4A90D9',
                    tension: 0.4
                }
            ]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    display: false,
                    position: 'top',
                    labels: { boxWidth: 12, padding: 16 }
                }
            },
            scales: {
                x: { grid: gridOpts },
                y: { grid: gridOpts, beginAtZero: true }
            }
        }
    });

    // ── Tab switching ─────────────────────────────────────────────────────
    document.querySelectorAll('.tab-button').forEach(btn => {
        btn.addEventListener('click', () => {
            document.querySelectorAll('.tab-button').forEach(b => b.classList.remove('active'));
            document.querySelectorAll('.tab-content').forEach(c => c.classList.remove('active'));
            btn.classList.add('active');
            document.getElementById(btn.dataset.tab + '-content').classList.add('active');
        });
    });
}
