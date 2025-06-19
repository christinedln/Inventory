document.addEventListener('DOMContentLoaded', () => {
    const openUserMaintenance = document.getElementById('openUserMaintenance');
    const backToMain = document.getElementById('backToMain');
    const mainMenu = document.getElementById('mainMenu');
    const userMaintenanceMenu = document.getElementById('userMaintenanceMenu');

    if (openUserMaintenance && backToMain) {
        openUserMaintenance.addEventListener('click', (e) => {
            e.preventDefault();
            mainMenu.classList.add('d-none');
            userMaintenanceMenu.classList.remove('d-none');
        });

        backToMain.addEventListener('click', () => {
            userMaintenanceMenu.classList.add('d-none');
            mainMenu.classList.remove('d-none');
        });
    }
});
