document.addEventListener('DOMContentLoaded', function () {
    const editButtons = document.querySelectorAll('.edit-product');
    const form = document.getElementById('editForm');
    const quantityField = document.getElementById('edit-quantity');
    const reasonContainer = document.getElementById('edit-reason-container');
    const reasonField = document.getElementById('edit-reason');
    const applyApprovalBtn = document.getElementById('applyApprovalBtn');
    let originalQuantity = 0;

    editButtons.forEach(button => {
        button.addEventListener('click', function (e) {
            e.preventDefault();

            const id = this.dataset.id;
            const product_name = this.dataset.product_name;
            const clothing_type = this.dataset.clothing_type;
            const color = this.dataset.color;
            const size = this.dataset.size;
            const quantity = parseInt(this.dataset.quantity);
            const price = this.dataset.price;
            const image = this.dataset.image;

            originalQuantity = quantity;

            form.action = `/admin/product/update/${id}`;
            document.getElementById('edit-productName').value = product_name;
            document.getElementById('edit-clothing_type').value = clothing_type;
            document.getElementById('edit-color').value = color;
            document.getElementById('edit-size').value = size;
            document.getElementById('edit-quantity').value = quantity;
            document.getElementById('edit-price').value = price;

            if (image) {
                const imageEl = document.getElementById('edit-current-image');
                if (imageEl) imageEl.src = image;
            }

            // Reset reason and approval button
            reasonContainer.style.display = 'none';
            reasonField.value = '';
            applyApprovalBtn.style.display = 'none';
        });
    });

    quantityField.addEventListener('input', function () {
        const newQuantity = parseInt(this.value);
        if (!isNaN(newQuantity) && newQuantity < originalQuantity) {
            reasonContainer.style.display = 'block';
            applyApprovalBtn.style.display = 'inline-block';
        } else {
            reasonContainer.style.display = 'none';
            reasonField.value = '';
            applyApprovalBtn.style.display = 'none';
        }
    });
});
