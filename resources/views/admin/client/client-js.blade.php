<script>
document.querySelectorAll('.btn-edit-client').forEach((button) => {
    button.addEventListener('click', function () {
        const d = this.dataset;
        document.getElementById('clientEditForm').action = d.action;
        document.getElementById('edit_client_name').value = d.name || '';
        document.getElementById('edit_client_email').value = d.email || '';
        document.getElementById('edit_client_phone').value = d.phone || '';
        document.getElementById('edit_client_company_name').value = d.company_name || '';
        document.getElementById('edit_client_city').value = d.city || '';
        document.getElementById('edit_client_address').value = d.address || '';
        document.getElementById('edit_client_notes').value = d.notes || '';
        (new bootstrap.Modal(document.getElementById('clientEditModal'))).show();
    });
});
</script>
