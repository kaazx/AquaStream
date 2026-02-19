function completeOrder(orderId) {
        if (confirm('Mark this order as complete?')) {
            // AJAX request to update order status
            fetch('UpdateOrder.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded',
                },
                body: 'id=' + orderId + '&action=complete'
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

document.addEventListener('DOMContentLoaded', function() {
    
    const quantityInput = document.getElementById('quantity');
    const quantityMinus = document.getElementById('quantityMinus');
    const quantityPlus = document.getElementById('quantityPlus');
    
    if (quantityMinus) {
        quantityMinus.addEventListener('click', function() {
            let value = parseInt(quantityInput.value) || 1;
            if (value > 1) {
                quantityInput.value = value - 1;
                quantityMinus.disabled = (value - 1 <= 1);
            }
        });
    }
    
    if (quantityPlus) {
        quantityPlus.addEventListener('click', function() {
            let value = parseInt(quantityInput.value) || 1;
            quantityInput.value = value + 1;
            quantityMinus.disabled = false;
        });
    }
    
    const deliveryDateInput = document.getElementById('delivery_date');
    if (deliveryDateInput) {
        const today = new Date().toISOString().split('T')[0];
        deliveryDateInput.setAttribute('min', today);
    }
    
    const successAlert = document.querySelector('.alert-success');
    if (successAlert) {
        setTimeout(() => {
            successAlert.style.opacity = '0';
            setTimeout(() => successAlert.remove(), 500);
        }, 5000);
    }
});
