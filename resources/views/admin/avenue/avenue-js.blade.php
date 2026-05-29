<script>
document.querySelectorAll('.btn-edit-avenue').forEach((button) => {
    button.addEventListener('click', function () {
        document.getElementById('avenueEditForm').action = this.dataset.action;
        document.getElementById('edit_avenue_name').value = this.dataset.name ?? '';
        document.getElementById('edit_avenue_place').value = this.dataset.place ?? '';
        document.getElementById('edit_avenue_address').value = this.dataset.address ?? '';
        document.getElementById('edit_avenue_city').value = this.dataset.city ?? '';
        document.getElementById('edit_avenue_state').value = this.dataset.state ?? '';
        document.getElementById('edit_avenue_country').value = this.dataset.country ?? '';
        document.getElementById('edit_avenue_postal_code').value = this.dataset.postalCode ?? '';
        document.getElementById('edit_avenue_latitude').value = this.dataset.latitude ?? '';
        document.getElementById('edit_avenue_longitude').value = this.dataset.longitude ?? '';
        document.getElementById('edit_avenue_status').value = this.dataset.status ?? 'active';
        (new bootstrap.Modal(document.getElementById('avenueEditModal'))).show();
    });
});
</script>

