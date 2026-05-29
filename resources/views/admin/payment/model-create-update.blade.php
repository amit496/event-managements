<div class="modal fade" id="paymentCreateModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <form method="POST" action="{{ route('admin.payments.store') }}" class="modal-content">
            @csrf
            <div class="modal-header">
                <h5 class="modal-title">Create Payment</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="form-group col-md-6">
                        <label>Event</label>
                        <select name="event_id" class="form-control" required>
                            <option value="">Select event</option>
                            @foreach($events as $event)
                                <option value="{{ $event->id }}">{{ $event->title }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group col-md-6">
                        <label>User (optional)</label>
                        <select name="user_id" class="form-control">
                            <option value="">Guest</option>
                            @foreach($users as $user)
                                <option value="{{ $user->id }}">{{ $user->name }} ({{ $user->email }})</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group col-md-4">
                        <label>Amount</label>
                        <input type="number" step="0.01" min="0" name="amount" class="form-control" required>
                    </div>
                    <div class="form-group col-md-2">
                        <label>Currency</label>
                        <input type="text" name="currency" maxlength="3" value="USD" class="form-control text-uppercase" required>
                    </div>
                    <div class="form-group col-md-3">
                        <label>Method</label>
                        <select name="payment_method" class="form-control" required>
                            @foreach($methods as $method)
                                <option value="{{ $method->value }}">{{ ucfirst(str_replace('_', ' ', $method->value)) }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group col-md-3">
                        <label>Status</label>
                        <select name="payment_status" class="form-control" required>
                            @foreach($statuses as $status)
                                <option value="{{ $status->value }}">{{ ucfirst($status->value) }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group col-md-6">
                        <label>Transaction Ref</label>
                        <input type="text" name="transaction_ref" class="form-control" maxlength="120">
                    </div>
                    <div class="form-group col-md-6">
                        <label>Bank Name</label>
                        <input type="text" name="bank_name" class="form-control" maxlength="120">
                    </div>
                    <div class="form-group col-md-6">
                        <label>Bank Account Name</label>
                        <input type="text" name="bank_account_name" class="form-control" maxlength="120">
                    </div>
                    <div class="form-group col-md-6">
                        <label>Bank Account Number</label>
                        <input type="text" name="bank_account_number" class="form-control" maxlength="40">
                    </div>
                    <div class="form-group col-md-6">
                        <label>IFSC / Routing Code</label>
                        <input type="text" name="bank_ifsc" class="form-control" maxlength="30">
                    </div>
                    <div class="form-group col-md-3">
                        <label>Cheque Number</label>
                        <input type="text" name="cheque_number" class="form-control" maxlength="40">
                    </div>
                    <div class="form-group col-md-3">
                        <label>Cheque Date</label>
                        <input type="date" name="cheque_date" class="form-control">
                    </div>
                    <div class="form-group col-md-6">
                        <label>Paid At</label>
                        <input type="datetime-local" name="paid_at" class="form-control">
                    </div>
                    <div class="form-group col-md-12">
                        <label>Notes</label>
                        <textarea name="notes" rows="3" class="form-control"></textarea>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button class="btn btn-primary">Save</button>
            </div>
        </form>
    </div>
</div>

<div class="modal fade" id="paymentEditModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <form method="POST" id="paymentEditForm" class="modal-content">
            @csrf
            @method('PUT')
            <div class="modal-header">
                <h5 class="modal-title">Update Payment</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="form-group col-md-6">
                        <label>Event</label>
                        <select name="event_id" id="edit_payment_event_id" class="form-control" required>
                            <option value="">Select event</option>
                            @foreach($events as $event)
                                <option value="{{ $event->id }}">{{ $event->title }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group col-md-6">
                        <label>User (optional)</label>
                        <select name="user_id" id="edit_payment_user_id" class="form-control">
                            <option value="">Guest</option>
                            @foreach($users as $user)
                                <option value="{{ $user->id }}">{{ $user->name }} ({{ $user->email }})</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group col-md-4">
                        <label>Amount</label>
                        <input type="number" step="0.01" min="0" name="amount" id="edit_payment_amount" class="form-control" required>
                    </div>
                    <div class="form-group col-md-2">
                        <label>Currency</label>
                        <input type="text" name="currency" id="edit_payment_currency" maxlength="3" class="form-control text-uppercase" required>
                    </div>
                    <div class="form-group col-md-3">
                        <label>Method</label>
                        <select name="payment_method" id="edit_payment_method" class="form-control" required>
                            @foreach($methods as $method)
                                <option value="{{ $method->value }}">{{ ucfirst(str_replace('_', ' ', $method->value)) }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group col-md-3">
                        <label>Status</label>
                        <select name="payment_status" id="edit_payment_status" class="form-control" required>
                            @foreach($statuses as $status)
                                <option value="{{ $status->value }}">{{ ucfirst($status->value) }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group col-md-6">
                        <label>Transaction Ref</label>
                        <input type="text" name="transaction_ref" id="edit_payment_transaction_ref" class="form-control" maxlength="120">
                    </div>
                    <div class="form-group col-md-6">
                        <label>Bank Name</label>
                        <input type="text" name="bank_name" id="edit_payment_bank_name" class="form-control" maxlength="120">
                    </div>
                    <div class="form-group col-md-6">
                        <label>Bank Account Name</label>
                        <input type="text" name="bank_account_name" id="edit_payment_bank_account_name" class="form-control" maxlength="120">
                    </div>
                    <div class="form-group col-md-6">
                        <label>Bank Account Number</label>
                        <input type="text" name="bank_account_number" id="edit_payment_bank_account_number" class="form-control" maxlength="40">
                    </div>
                    <div class="form-group col-md-6">
                        <label>IFSC / Routing Code</label>
                        <input type="text" name="bank_ifsc" id="edit_payment_bank_ifsc" class="form-control" maxlength="30">
                    </div>
                    <div class="form-group col-md-3">
                        <label>Cheque Number</label>
                        <input type="text" name="cheque_number" id="edit_payment_cheque_number" class="form-control" maxlength="40">
                    </div>
                    <div class="form-group col-md-3">
                        <label>Cheque Date</label>
                        <input type="date" name="cheque_date" id="edit_payment_cheque_date" class="form-control">
                    </div>
                    <div class="form-group col-md-6">
                        <label>Paid At</label>
                        <input type="datetime-local" name="paid_at" id="edit_payment_paid_at" class="form-control">
                    </div>
                    <div class="form-group col-md-12">
                        <label>Notes</label>
                        <textarea name="notes" id="edit_payment_notes" rows="3" class="form-control"></textarea>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button class="btn btn-primary">Update</button>
            </div>
        </form>
    </div>
</div>
