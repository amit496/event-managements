@extends('admin.layout.app')
@section('title', 'Event Details')
@section('content')
@include('admin.partials.flash')
@php
    $totalReceived = $event->totalReceivedAmount();
    $totalDue = $event->totalDueAmount();
    $collectionStatus = $event->collectionStatusLabel();
@endphp

<div class="d-flex justify-content-between align-items-center mb-3">
    <h4 class="mb-0">Event Details</h4>
    <ol class="breadcrumb mb-0">
        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
        <li class="breadcrumb-item"><a href="{{ route('admin.events.index') }}">Events</a></li>
        <li class="breadcrumb-item active">{{ $event->title }}</li>
    </ol>
</div>

<div class="row">
    <div class="col-md-5">
        <div class="card">
            <div class="card-header"><h3 class="card-title">Overview</h3></div>
            <div class="card-body">
                @if($event->image)
                    <img src="{{ asset('storage/'.$event->image) }}" alt="{{ $event->title }}" class="img-fluid rounded mb-3">
                @endif
                <p class="mb-2"><strong><i class="fas fa-heading mr-1"></i>Title:</strong> {{ $event->title }}</p>
                <p class="mb-2"><strong><i class="fas fa-folder mr-1"></i>Category:</strong> {{ $event->category?->name ?: 'N/A' }}</p>
                <p class="mb-2"><strong><i class="fas fa-map-marker-alt mr-1"></i>Avenue:</strong> {{ $event->avenue?->name ?: 'N/A' }}</p>
                <p class="mb-2"><strong><i class="fas fa-map-pin mr-1"></i>Venue:</strong> {{ $event->venue ?: 'N/A' }}</p>
                <p class="mb-2"><strong><i class="fas fa-location-arrow mr-1"></i>Address:</strong> {{ $event->address ?: 'N/A' }}</p>
                <p class="mb-2"><strong><i class="fas fa-calendar-alt mr-1"></i>Start:</strong> {{ $event->start_at?->format('d M Y H:i') }}</p>
                <p class="mb-2"><strong><i class="fas fa-calendar-check mr-1"></i>End:</strong> {{ $event->end_at?->format('d M Y H:i') }}</p>
                <p class="mb-2"><strong><i class="fas fa-users mr-1"></i>Capacity:</strong> {{ $event->capacity ?: 'N/A' }}</p>
                <p class="mb-2"><strong><i class="fas fa-money-bill-wave mr-1"></i>Price:</strong> {{ $event->price !== null ? number_format((float) $event->price, 2) : 'N/A' }}</p>
                <p class="mb-2"><strong><i class="fas fa-wallet mr-1"></i>Total Client Payable:</strong> {{ $event->client_payable_amount !== null ? number_format((float) $event->client_payable_amount, 2) : 'N/A' }}</p>
                <p class="mb-2"><strong>Status:</strong> <span class="badge badge-info">{{ ucfirst($event->event_status->value) }}</span></p>
                <p class="mb-2"><strong>Payment Required:</strong> <span class="badge {{ $event->payment_required ? 'badge-success' : 'badge-secondary' }}">{{ $event->payment_required ? 'Yes' : 'No' }}</span></p>
                <p class="mb-2"><strong>Featured:</strong> <span class="badge {{ $event->is_featured ? 'badge-warning' : 'badge-secondary' }}">{{ $event->is_featured ? 'Yes' : 'No' }}</span></p>
                <p class="mb-0"><strong><i class="fas fa-user mr-1"></i>Created By:</strong> {{ $event->creator?->name ?: 'N/A' }}</p>
            </div>
        </div>
    </div>

    <div class="col-md-7">
        <div class="card mb-3">
            <div class="card-header"><h3 class="card-title">Description</h3></div>
            <div class="card-body">
                {!! nl2br(e($event->description)) !!}
            </div>
        </div>

        <div class="card">
            <div class="card-header"><h3 class="card-title">Payment Records</h3></div>
            <div class="card-body p-0 table-responsive">
                <div class="p-3 border-bottom">
                    <span class="mr-3"><strong>Received:</strong> {{ number_format($totalReceived, 2) }}</span>
                    <span class="mr-3"><strong>Due:</strong> {{ $totalDue !== null ? number_format($totalDue, 2) : 'N/A' }}</span>
                    <span><strong>Collection Status:</strong> {{ $collectionStatus }}</span>
                </div>
                <table class="table table-sm table-hover mb-0">
                    <thead>
                        <tr>
                            <th>User</th>
                            <th>Amount</th>
                            <th>Method</th>
                            <th>Status</th>
                            <th>Transaction Details</th>
                            <th>Paid At</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($event->payments as $payment)
                            <tr>
                                <td>{{ $payment->user?->name ?: 'Guest' }}</td>
                                <td>{{ number_format((float) $payment->amount, 2) }} {{ $payment->currency }}</td>
                                <td>{{ ucfirst(str_replace('_', ' ', $payment->payment_method->value)) }}</td>
                                <td>{{ ucfirst($payment->payment_status->value) }}</td>
                                <td>
                                    <div>{{ $payment->transaction_ref ?: 'N/A' }}</div>
                                    @if($payment->bank_name || $payment->bank_account_number)
                                        <small class="text-muted d-block">{{ $payment->bank_name ?: 'Bank' }} / {{ $payment->bank_account_number ?: 'N/A' }}</small>
                                    @endif
                                    @if($payment->cheque_number)
                                        <small class="text-muted d-block">Cheque: {{ $payment->cheque_number }}{{ $payment->cheque_date ? ' ('.$payment->cheque_date->format('d M Y').')' : '' }}</small>
                                    @endif
                                </td>
                                <td>{{ $payment->paid_at?->format('d M Y H:i') ?: 'N/A' }}</td>
                            </tr>
                        @empty
                            <tr><td colspan="6" class="text-center">No payment records found.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<a href="{{ route('admin.events.index') }}" class="btn btn-secondary btn-sm"><i class="fas fa-arrow-left mr-1"></i>Back</a>
@stop
@section('css') @vite(['resources/css/app.css']) @stop
