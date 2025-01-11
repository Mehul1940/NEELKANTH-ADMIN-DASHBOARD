document.addEventListener('DOMContentLoaded', function () {
    const updateButtons = document.querySelectorAll('.btn-update');
    const modal = document.getElementById('updateModal');
    const closeModal = document.querySelector('.close');
    const cancelModal = document.getElementById('cancelModal');
    
    updateButtons.forEach(button => {
        button.addEventListener('click', function() {
            // Get data from button attributes
            const stockId = this.getAttribute('data-stock-id');
            const stockName = this.getAttribute('data-stock-name');
            const category = this.getAttribute('data-category');
            const brand = this.getAttribute('data-brand');
            const product = this.getAttribute('data-product');
            const currentUnits = this.getAttribute('data-current-units');
            const unitsRequired = this.getAttribute('data-units-required');
            
            // Populate modal fields with data
            document.getElementById('modalStockId').value = stockId;
            document.getElementById('stockName').value = stockName;
            document.getElementById('category').value = category;
            document.getElementById('brand').value = brand;
            document.getElementById('product').value = product;
            document.getElementById('currentUnits').value = currentUnits;
            document.getElementById('unitsRequired').value = unitsRequired;

            // Show modal
            modal.style.display = 'block';
        });
    });

    // Close modal when clicking the close button
    closeModal.addEventListener('click', function() {
        modal.style.display = 'none';
    });

    // Close modal when clicking the cancel button
    cancelModal.addEventListener('click', function() {
        modal.style.display = 'none';
    });

    // Close modal if clicked outside modal content
    window.addEventListener('click', function(event) {
        if (event.target === modal) {
            modal.style.display = 'none';
        }
    });
});
