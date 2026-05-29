<script>
document.querySelectorAll('.btn-edit-quotation').forEach((button) => {
    button.addEventListener('click', function () {
        const d = this.dataset;
        document.getElementById('quotationEditForm').action = d.action;
        document.getElementById('edit_quote_no').value = d.quote_no || '';
        document.getElementById('edit_quote_status').value = d.status || 'draft';
        document.getElementById('edit_quote_valid_until').value = d.valid_until || '';
        document.getElementById('edit_quote_client_id').value = d.client_id || '';
        document.getElementById('edit_quote_booking_id').value = d.booking_id || '';
        document.getElementById('edit_quote_event_id').value = d.event_id || '';
        document.getElementById('edit_quote_subtotal').value = d.subtotal || '';
        document.getElementById('edit_quote_tax_amount').value = d.tax_amount || '';
        document.getElementById('edit_quote_discount_amount').value = d.discount_amount || '';
        document.getElementById('edit_quote_total_amount').value = d.total_amount || '';
        document.getElementById('edit_quote_notes').value = d.notes || '';
        (new bootstrap.Modal(document.getElementById('quotationEditModal'))).show();
    });
});
</script>
