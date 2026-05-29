<script>
document.querySelectorAll('.btn-edit-payment').forEach((button) => {
    button.addEventListener('click', function () {
        const d = this.dataset;

        document.getElementById('paymentEditForm').action = d.action;
        document.getElementById('edit_payment_event_id').value = d.event_id || '';
        document.getElementById('edit_payment_user_id').value = d.user_id || '';
        document.getElementById('edit_payment_amount').value = d.amount || '';
        document.getElementById('edit_payment_currency').value = d.currency || '';
        document.getElementById('edit_payment_method').value = d.payment_method || '';
        document.getElementById('edit_payment_status').value = d.payment_status || '';
        document.getElementById('edit_payment_transaction_ref').value = d.transaction_ref || '';
        document.getElementById('edit_payment_bank_name').value = d.bank_name || '';
        document.getElementById('edit_payment_bank_account_name').value = d.bank_account_name || '';
        document.getElementById('edit_payment_bank_account_number').value = d.bank_account_number || '';
        document.getElementById('edit_payment_bank_ifsc').value = d.bank_ifsc || '';
        document.getElementById('edit_payment_cheque_number').value = d.cheque_number || '';
        document.getElementById('edit_payment_cheque_date').value = d.cheque_date || '';
        document.getElementById('edit_payment_paid_at').value = d.paid_at || '';
        document.getElementById('edit_payment_notes').value = d.notes || '';

        (new bootstrap.Modal(document.getElementById('paymentEditModal'))).show();
    });
});
</script>
