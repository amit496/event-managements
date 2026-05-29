<script>
document.querySelectorAll('.btn-edit-category').forEach((button) => {
    button.addEventListener('click', function () {
        document.getElementById('categoryEditForm').action = this.dataset.action;
        document.getElementById('edit_category_name').value = this.dataset.name;
        document.getElementById('edit_category_description').value = this.dataset.description;
        document.getElementById('edit_category_status').value = this.dataset.status;
        (new bootstrap.Modal(document.getElementById('categoryEditModal'))).show();
    });
});
</script>
