function closeUserMaintenanceDropdown() {
    const collapseDiv = document.getElementById('userMaintenanceCollapse');
    if (collapseDiv && collapseDiv.classList.contains('show')) {
        const bsCollapse = bootstrap.Collapse.getOrCreateInstance(collapseDiv);
        bsCollapse.hide();
    }
}

function closeSalesReportDropdown() {
    const collapseDiv = document.getElementById('salesReportCollapse');
    if (collapseDiv && collapseDiv.classList.contains('show')) {
        const bsCollapse = bootstrap.Collapse.getOrCreateInstance(collapseDiv);
        bsCollapse.hide();
    }
}

document.addEventListener('DOMContentLoaded', function () {
    // User Maintenance caret
    const caretIcon = document.getElementById('caretIcon');
    const collapseDiv = document.getElementById('userMaintenanceCollapse');
    const collapseToggle = document.getElementById('userCollapseToggle');

    // Sales Report caret
    const salesCaret = document.getElementById('salesReportCaret');
    const salesCollapse = document.getElementById('salesReportCollapse');
    const salesToggle = document.getElementById('salesReportToggle');

    // Add CSS for caret rotation
    const style = document.createElement('style');
    style.textContent = `
        .rotate-caret {
            transform: rotate(180deg);
            transition: transform 0.2s ease;
        }
    `;
    document.head.appendChild(style);

    // User Maintenance caret rotation
    if (caretIcon && collapseDiv) {
        collapseDiv.addEventListener('show.bs.collapse', () => {
            caretIcon.classList.add('rotate-caret');
        });
        collapseDiv.addEventListener('hide.bs.collapse', () => {
            caretIcon.classList.remove('rotate-caret');
        });
    }

    // Sales Report caret rotation
    if (salesCaret && salesCollapse) {
        salesCollapse.addEventListener('show.bs.collapse', () => {
            salesCaret.classList.add('rotate-caret');
        });
        salesCollapse.addEventListener('hide.bs.collapse', () => {
            salesCaret.classList.remove('rotate-caret');
        });
    }

    // Close dropdowns when clicking outside
    document.addEventListener('click', function (e) {
        // User Maintenance
        if (
            collapseToggle &&
            collapseDiv &&
            !collapseToggle.contains(e.target) &&
            !collapseDiv.contains(e.target) &&
            collapseDiv.classList.contains('show')
        ) {
            closeUserMaintenanceDropdown();
        }
        // Sales Report
        if (
            salesToggle &&
            salesCollapse &&
            !salesToggle.contains(e.target) &&
            !salesCollapse.contains(e.target) &&
            salesCollapse.classList.contains('show')
        ) {
            closeSalesReportDropdown();
        }
    });
});
