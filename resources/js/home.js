import 'bootstrap/dist/js/bootstrap.bundle.min';

document.addEventListener('DOMContentLoaded', function () {
    // Set today's date as max for date
    const today = new Date().toISOString().split('T')[0];
    
    const dateInput = document.getElementById('date');
    if (dateInput) {
        dateInput.setAttribute('max', today);
    }

    // Set today's date as max for edit-date
    const editDate = document.getElementById('edit-date');
    if (editDate) {
        editDate.setAttribute('max', today);
    }

    // Edit button functionality
    const editButtons = document.querySelectorAll('.edit-product');
    editButtons.forEach(button => {
        button.addEventListener('click', function (e) {
            e.preventDefault();

            const id = this.dataset.id;
            const product_name = this.dataset.product_name;
            const clothing_type = this.dataset.clothing_type;
            const color = this.dataset.color;
            const size = this.dataset.size;
            const date = this.dataset.date;
            const quantity = this.dataset.quantity;

            const form = document.getElementById('editForm');
            if (form) {
                form.action = `/product/update/${id}`;
            }

            document.getElementById('edit-productName').value = product_name;
            document.getElementById('edit-clothing_type').value = clothing_type;
            document.getElementById('edit-color').value = color;
            document.getElementById('edit-size').value = size;
            document.getElementById('edit-date').value = date;
            document.getElementById('edit-quantity').value = quantity;
        });
    });
});
