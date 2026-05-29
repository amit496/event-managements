<script>
document.querySelectorAll('.btn-edit-service').forEach((button) => {
    button.addEventListener('click', function () {
        const d = this.dataset;
        document.getElementById('serviceEditForm').action = d.action;
        document.getElementById('edit_service_name').value = d.name || '';
        document.getElementById('edit_service_description').value = d.description || '';
        document.getElementById('edit_service_status').checked = d.status === '1';
        (new bootstrap.Modal(document.getElementById('serviceEditModal'))).show();
    });
});
</script>
