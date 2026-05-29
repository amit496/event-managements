<script>
document.querySelectorAll('.btn-edit-booking').forEach((button) => {
    button.addEventListener('click', function () {
        const d = this.dataset;
        document.getElementById('bookingEditForm').action = d.action;
        document.getElementById('edit_booking_code').value = d.booking_code || '';
        document.getElementById('edit_booking_status').value = d.status || 'new';
        document.getElementById('edit_booking_client_id').value = d.client_id || '';
        document.getElementById('edit_booking_event_id').value = d.event_id || '';
        document.getElementById('edit_booking_expected_amount').value = d.expected_amount || '';
        document.getElementById('edit_booking_event_date').value = d.event_date || '';
        document.getElementById('edit_booking_guest_count').value = d.guest_count || '';
        document.getElementById('edit_booking_notes').value = d.notes || '';
        (new bootstrap.Modal(document.getElementById('bookingEditModal'))).show();
    });
});
</script>
