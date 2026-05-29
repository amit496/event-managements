@extends('admin.layout.app')
@section('title', 'Payments')
@section('content')
@include('admin.partials.flash')
@include('admin.payment.breadcrumb')

<div class="card">
    <div class="card-header admin-card-toolbar">
        <h3 class="card-title">Payments</h3>
        <button class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#paymentCreateModal">
            <i class="fas fa-plus mr-1"></i>Add Payment
        </button>
    </div>

    <div class="card-body table-responsive p-0">
        <table class="table table-hover text-nowrap">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Event</th>
                    <th>User</th>
                    <th>Amount</th>
                    <th>Method</th>
                    <th>Status</th>
                    <th>Transaction</th>
                    <th>Paid At</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @forelse($payments as $payment)
                    <tr>
                        <td>{{ $payment->id }}</td>
                        <td>{{ $payment->event?->title ?? 'N/A' }}</td>
                        <td>{{ $payment->user?->name ?? 'Guest' }}</td>
                        <td>{{ number_format((float) $payment->amount, 2) }} {{ strtoupper($payment->currency) }}</td>
                        <td>{{ ucfirst(str_replace('_', ' ', $payment->payment_method->value)) }}</td>
                        <td>
                            <span class="badge {{ $payment->payment_status->value === 'paid' ? 'badge-success' : ($payment->payment_status->value === 'partial' ? 'badge-info' : ($payment->payment_status->value === 'failed' ? 'badge-danger' : ($payment->payment_status->value === 'refunded' ? 'badge-warning' : 'badge-secondary'))) }}">
                                {{ ucfirst($payment->payment_status->value) }}
                            </span>
                        </td>
                        <td>
                            <div>{{ $payment->transaction_ref ?: 'N/A' }}</div>
                            @if($payment->bank_name || $payment->bank_account_number)
                                <small class="text-muted d-block">{{ $payment->bank_name ?: 'Bank' }} / {{ $payment->bank_account_number ?: 'N/A' }}</small>
                            @endif
                            @if($payment->cheque_number)
                                <small class="text-muted d-block">Cheque: {{ $payment->cheque_number }}{{ $payment->cheque_date ? ' ('.$payment->cheque_date->format('d M Y').')' : '' }}</small>
                            @endif
                        </td>
                        <td>{{ $payment->paid_at?->format('d M Y H:i') ?? 'N/A' }}</td>
                        <td class="d-flex">
                            <button
                                class="btn btn-info btn-xs mr-1 btn-edit-payment"
                                data-action="{{ route('admin.payments.update', $payment) }}"
                                data-event_id="{{ $payment->event_id }}"
                                data-user_id="{{ $payment->user_id }}"
                                data-amount="{{ $payment->amount }}"
                                data-currency="{{ strtoupper($payment->currency) }}"
                                data-payment_method="{{ $payment->payment_method->value }}"
                                data-payment_status="{{ $payment->payment_status->value }}"
                                data-transaction_ref="{{ $payment->transaction_ref }}"
                                data-bank_name="{{ $payment->bank_name }}"
                                data-bank_account_name="{{ $payment->bank_account_name }}"
                                data-bank_account_number="{{ $payment->bank_account_number }}"
                                data-bank_ifsc="{{ $payment->bank_ifsc }}"
                                data-cheque_number="{{ $payment->cheque_number }}"
                                data-cheque_date="{{ $payment->cheque_date?->format('Y-m-d') }}"
                                data-paid_at="{{ $payment->paid_at?->format('Y-m-d\TH:i') }}"
                                data-notes="{{ $payment->notes }}"
                            >
                                <i class="fas fa-edit mr-1"></i>Edit
                            </button>

                            <form method="POST" action="{{ route('admin.payments.destroy', $payment) }}">
                                @csrf
                                @method('DELETE')
                                <button class="btn btn-danger btn-xs" onclick="return confirm('Delete payment?')">
                                    <i class="fas fa-trash-alt mr-1"></i>Delete
                                </button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="9" class="text-center">No payment records found.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="card-footer">{{ $payments->links() }}</div>
</div>

@include('admin.payment.model-create-update')
@stop

@section('css') @vite(['resources/css/app.css']) @stop
@section('js') @vite(['resources/js/app.js']) @include('admin.payment.payment-js') @stop
