<script>
document.querySelectorAll('.btn-edit-role').forEach((button) => {
    button.addEventListener('click', function () {
        const d = this.dataset;
        document.getElementById('roleEditForm').action = d.action;
        document.getElementById('edit_role_name').value = d.name;
        const selected = (d.permissions || '').split(',').filter(Boolean);
        [...document.getElementById('edit_role_permissions').options].forEach((opt) => { opt.selected = selected.includes(opt.value); });
        (new bootstrap.Modal(document.getElementById('roleEditModal'))).show();
    });
});
</script>
