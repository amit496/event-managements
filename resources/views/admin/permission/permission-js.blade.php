<script>
document.querySelectorAll('.btn-edit-permission').forEach((button) => {
    button.addEventListener('click', function () {
        document.getElementById('permissionEditForm').action = this.dataset.action;
        document.getElementById('edit_permission_name').value = this.dataset.name;
        (new bootstrap.Modal(document.getElementById('permissionEditModal'))).show();
    });
});
</script>
