import 'bootstrap/dist/js/bootstrap.bundle.min';

document.addEventListener('DOMContentLoaded', function () {
 

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
            const quantity = this.dataset.quantity;
            const price = this.dataset.price;

            const form = document.getElementById('editForm');
            if (form) {
                form.action = `/admin/product/update/${id}`;
            }

            document.getElementById('edit-productName').value = product_name;
            document.getElementById('edit-clothing_type').value = clothing_type;
            document.getElementById('edit-color').value = color;
            document.getElementById('edit-size').value = size;
            document.getElementById('edit-quantity').value = quantity;
            document.getElementById('edit-price').value = price;
        });
    });
});
