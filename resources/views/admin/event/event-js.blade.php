<script>
document.querySelectorAll('.btn-edit-event').forEach((button) => {
    button.addEventListener('click', function () {
        const d = this.dataset;
        document.getElementById('eventEditForm').action = d.action;
        document.getElementById('edit_event_title').value = d.title;
        document.getElementById('edit_event_category').value = d.category;
        document.getElementById('edit_event_start').value = d.start;
        document.getElementById('edit_event_end').value = d.end;
        document.getElementById('edit_event_venue').value = d.venue;
        document.getElementById('edit_event_address').value = d.address;
        document.getElementById('edit_event_lat').value = d.lat;
        document.getElementById('edit_event_lng').value = d.lng;
        document.getElementById('edit_event_capacity').value = d.capacity;
        document.getElementById('edit_event_price').value = d.price;
        document.getElementById('edit_event_description').value = d.description;
        document.getElementById('edit_event_status').checked = d.status === '1';
        document.getElementById('edit_event_featured').checked = d.featured === '1';
        (new bootstrap.Modal(document.getElementById('eventEditModal'))).show();
    });
});
</script>
