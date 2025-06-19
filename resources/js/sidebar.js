function closeUserMaintenanceDropdown() {
    const collapseDiv = document.getElementById('userMaintenanceCollapse');
    if (collapseDiv && collapseDiv.classList.contains('show')) {
        const bsCollapse = bootstrap.Collapse.getOrCreateInstance(collapseDiv);
        bsCollapse.hide();
    }
}

document.addEventListener('DOMContentLoaded', function () {
    const caretIcon = document.getElementById('caretIcon');
    const collapseDiv = document.getElementById('userMaintenanceCollapse');
    const collapseToggle = document.getElementById('userCollapseToggle');

    if (!caretIcon || !collapseDiv || !collapseToggle) return;

    // Add CSS for caret rotation
    const style = document.createElement('style');
    style.textContent = `
        .rotate-caret {
            transform: rotate(180deg);
            transition: transform 0.2s ease;
        }
    `;
    document.head.appendChild(style);

    // Handle collapse events
    collapseDiv.addEventListener('show.bs.collapse', () => {
        caretIcon.classList.add('rotate-caret');
    });

    collapseDiv.addEventListener('hide.bs.collapse', () => {
        caretIcon.classList.remove('rotate-caret');
    });

    // Close dropdown when clicking outside
    document.addEventListener('click', function (e) {
        // If click is NOT on the toggle or inside the collapse, close it
        if (
            !collapseToggle.contains(e.target) &&
            !collapseDiv.contains(e.target) &&
            collapseDiv.classList.contains('show')
        ) {
            closeUserMaintenanceDropdown();
        }
    });
});
