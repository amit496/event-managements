<script>
document.querySelectorAll('.btn-edit-user').forEach((button) => {
    button.addEventListener('click', function () {
        const d = this.dataset;
        document.getElementById('userEditForm').action = d.action;
        document.getElementById('edit_user_name').value = d.name;
        document.getElementById('edit_user_email').value = d.email;
        document.getElementById('edit_user_phone').value = d.phone;
        document.getElementById('edit_user_address').value = d.address;
        document.getElementById('edit_user_status').checked = d.status === '1';
        const selected = (d.roles || '').split(',').filter(Boolean);
        [...document.getElementById('edit_user_roles').options].forEach((opt) => { opt.selected = selected.includes(opt.value); });
        (new bootstrap.Modal(document.getElementById('userEditModal'))).show();
    });
});
</script>
