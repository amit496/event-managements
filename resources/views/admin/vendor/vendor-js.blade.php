<script>
document.querySelectorAll('.btn-edit-vendor').forEach((button) => {
    button.addEventListener('click', function () {
        const d = this.dataset;
        document.getElementById('vendorEditForm').action = d.action;
        document.getElementById('edit_vendor_name').value = d.name || '';
        document.getElementById('edit_vendor_service_type').value = d.service_type || '';
        document.getElementById('edit_vendor_contact_person').value = d.contact_person || '';
        document.getElementById('edit_vendor_phone').value = d.phone || '';
        document.getElementById('edit_vendor_email').value = d.email || '';
        document.getElementById('edit_vendor_rate_card').value = d.rate_card || '';
        document.getElementById('edit_vendor_address').value = d.address || '';
        document.getElementById('edit_vendor_status').checked = d.status === '1';
        document.getElementById('edit_vendor_notes').value = d.notes || '';

        const selectedServiceIds = (d.service_ids || '')
            .split(',')
            .map((value) => value.trim())
            .filter((value) => value !== '');

        const serviceSelect = document.getElementById('edit_vendor_service_ids');
        Array.from(serviceSelect.options).forEach((option) => {
            option.selected = selectedServiceIds.includes(option.value);
        });

        (new bootstrap.Modal(document.getElementById('vendorEditModal'))).show();
    });
});
</script>
