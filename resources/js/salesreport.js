import 'bootstrap/dist/js/bootstrap.bundle.min.js';


document.addEventListener('DOMContentLoaded', function () {
    // Initialize all tooltips
    const tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
    tooltipTriggerList.forEach(function (tooltipTriggerEl) {
        new bootstrap.Tooltip(tooltipTriggerEl);
    });

    // Initialize the history modal
    const historyModal = new bootstrap.Modal(document.getElementById('historyModal'));

    // Add confirmation for delete action
    document.querySelectorAll('.delete-entry').forEach(button => {
        button.addEventListener('click', function(e) {
            if (!confirm('Are you sure you want to delete this entry?')) {
                e.preventDefault();
            }
        });
    });

    // Auto-hide alerts after 3 seconds
    const alerts = document.querySelectorAll('.alert');
    alerts.forEach(alert => {
        setTimeout(() => {
            const bsAlert = new bootstrap.Alert(alert);
            bsAlert.close();
        }, 3000);
    });
});

// Floating tooltip for sales difference
document.addEventListener('DOMContentLoaded', function() {
    // Create tooltip div if it doesn't exist
    let tooltip = document.getElementById('salesDiffTooltip');
    if (!tooltip) {
        tooltip = document.createElement('div');
        tooltip.id = 'salesDiffTooltip';
        tooltip.style.display = 'none';
        tooltip.style.position = 'fixed';
        tooltip.style.zIndex = '9999';
        tooltip.style.padding = '8px 14px';
        tooltip.style.background = '#fff';
        tooltip.style.border = '1px solid #ccc';
        tooltip.style.borderRadius = '6px';
        tooltip.style.boxShadow = '0 2px 8px rgba(0,0,0,0.1)';
        tooltip.style.pointerEvents = 'none';
        tooltip.style.fontSize = '0.95em';
        tooltip.style.color = '#212529';
        tooltip.style.whiteSpace = 'nowrap';
        document.body.appendChild(tooltip);
    }

    document.querySelectorAll('.sales-diff-indicator').forEach(function(el) {
        el.addEventListener('mouseenter', function(e) {
            // Example: "₱1,000 higher than target"
            const diffText = el.dataset.diff;
            const match = diffText.match(/(₱[\d,]+) (higher|lower)(.*)/);
            if (match) {
                const peso = match[1];
                const direction = match[2];
                const rest = match[3];
                let colorClass = direction === 'higher' ? 'text-success' : 'text-danger';
                tooltip.innerHTML = `<span class="${colorClass}">${peso}</span> ${direction}${rest}`;
            } else {
                tooltip.textContent = diffText;
            }
            tooltip.className = '';
            tooltip.style.display = 'block';
        });
        el.addEventListener('mousemove', function(e) {
            tooltip.style.left = (e.clientX + 15) + 'px';
            tooltip.style.top = (e.clientY - 10) + 'px';
        });
        el.addEventListener('mouseleave', function() {
            tooltip.style.display = 'none';
        });
    });

    function setupMonthlySalesTooltip() {
        document.querySelectorAll('.monthly-sales-diff-indicator').forEach(function(el) {
            el.addEventListener('mouseenter', function(e) {
                const diffText = el.dataset.diff;
                // Match ₱1,000.00 (with decimals)
                const match = diffText.match(/(₱[\d,]+\.\d{2}) (higher|lower)(.*)/);
                if (match) {
                    const peso = match[1];
                    const direction = match[2];
                    const rest = match[3];
                    let colorClass = direction === 'higher' ? 'text-success' : 'text-danger';
                    tooltip.innerHTML = `<span class="${colorClass}">${peso}</span> ${direction}${rest}`;
                } else {
                    tooltip.textContent = diffText;
                }
                tooltip.className = '';
                tooltip.style.display = 'block';
            });
            el.addEventListener('mousemove', function(e) {
                tooltip.style.left = (e.clientX + 15) + 'px';
                tooltip.style.top = (e.clientY - 10) + 'px';
            });
            el.addEventListener('mouseleave', function() {
                tooltip.style.display = 'none';
            });
        });
    }

    function setupQuarterlySalesTooltip() {
        document.querySelectorAll('.quarterly-sales-diff-indicator').forEach(function(el) {
            el.addEventListener('mouseenter', function(e) {
                const diffText = el.dataset.diff;
                // Match ₱1,000 (no decimals)
                const match = diffText.match(/(₱[\d,]+) (higher|lower)(.*)/);
                if (match) {
                    const peso = match[1];
                    const direction = match[2];
                    const rest = match[3];
                    let colorClass = direction === 'higher' ? 'text-success' : 'text-danger';
                    tooltip.innerHTML = `<span class="${colorClass}">${peso}</span> ${direction}${rest}`;
                } else {
                    tooltip.textContent = diffText;
                }
                tooltip.className = '';
                tooltip.style.display = 'block';
            });
            el.addEventListener('mousemove', function(e) {
                tooltip.style.left = (e.clientX + 15) + 'px';
                tooltip.style.top = (e.clientY - 10) + 'px';
            });
            el.addEventListener('mouseleave', function() {
                tooltip.style.display = 'none';
            });
        });
    }

    setupMonthlySalesTooltip();
    setupQuarterlySalesTooltip();
});



