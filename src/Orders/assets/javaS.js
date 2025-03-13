
    flatpickr(".datepicker", { 
        dateFormat: "Y-m-d",
        allowInput: true,
        maxDate: "today",
        disableMobile: "true"
    });

   function toggleDetails(id) {
    var detailsRow = document.getElementById("details-" + id);
    var ordersTable = document.getElementById("orders-" + id);
    var btn = document.querySelector(`span[onclick="toggleDetails(${id})"]`);
    
    if (!detailsRow) return;
    
    if (detailsRow.classList.contains("hidden")) {
        detailsRow.classList.remove("hidden");
        detailsRow.classList.add("slide-down");
        if (ordersTable) {
            ordersTable.classList.remove("hidden");
        }        
        btn.textContent = " - ";
        btn.style.background = "var(--primary)";
    } else {
        detailsRow.classList.add("hidden");
        detailsRow.classList.remove("slide-down");        
        btn.textContent = " + ";
        btn.style.background = "var(--secondary)";
        if (ordersTable) {
            var orderButtons = ordersTable.querySelectorAll('.toggle-btn');
            orderButtons.forEach(function(orderBtn) {
                var orderId = orderBtn.getAttribute('onclick').match(/\d+/)[0];
                var orderDetails = document.getElementById("details-" + orderId);
                if (orderDetails && !orderDetails.classList.contains("hidden")) {
                    orderDetails.classList.add("hidden");
                    orderBtn.textContent = " + ";
                    orderBtn.style.background = "var(--secondary)";
                }
            });
        }
    }
}

    function confirmCancel(id, dateFrom, dateTo) {
        if(confirm('Are you sure you want to cancel this order?')) {
            window.location.href = `cancelOrder.php?id=${id}&dateFrom=${dateFrom}&dateTo=${dateTo}`;
        }
    }
    
    document.addEventListener('DOMContentLoaded', function() {
        document.getElementById('dateFrom').value = "<?php echo $dateFrom; ?>";
        document.getElementById('dateTo').value = "<?php echo $dateTo; ?>";
        

        const orderRows = document.querySelectorAll('.order-row');
        orderRows.forEach(row => {
            row.addEventListener('mouseenter', function() {
                this.style.backgroundColor = '#f5f5f5';
                this.style.transition = 'background-color 0.3s';
            });
            
            row.addEventListener('mouseleave', function() {
                this.style.backgroundColor = '';
            });
        });
    });
