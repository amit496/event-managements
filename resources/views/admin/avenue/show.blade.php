@extends('admin.layout.app')
@section('title', 'Avenue Details')
@section('content')
@include('admin.partials.flash')

<div class="d-flex justify-content-between align-items-center mb-3">
    <h4 class="mb-0">Avenue Details</h4>
    <ol class="breadcrumb mb-0">
        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
        <li class="breadcrumb-item"><a href="{{ route('admin.avenues.index') }}">Avenues</a></li>
        <li class="breadcrumb-item active">{{ $avenue->name }}</li>
    </ol>
</div>

<div class="row">
    <div class="col-md-5">
        <div class="card">
            <div class="card-header"><h3 class="card-title">Profile</h3></div>
            <div class="card-body">
                <p class="mb-2"><strong><i class="fas fa-map-marker-alt mr-1"></i>Name:</strong> {{ $avenue->name }}</p>
                <p class="mb-2"><strong><i class="fas fa-building mr-1"></i>Place:</strong> {{ $avenue->place }}</p>
                <p class="mb-2"><strong><i class="fas fa-city mr-1"></i>City:</strong> {{ $avenue->city ?: 'N/A' }}</p>
                <p class="mb-2"><strong><i class="fas fa-map mr-1"></i>State:</strong> {{ $avenue->state ?: 'N/A' }}</p>
                <p class="mb-2"><strong><i class="fas fa-flag mr-1"></i>Country:</strong> {{ $avenue->country ?: 'N/A' }}</p>
                <p class="mb-2"><strong><i class="fas fa-mail-bulk mr-1"></i>Postal Code:</strong> {{ $avenue->postal_code ?: 'N/A' }}</p>
                <p class="mb-2"><strong><i class="fas fa-map-pin mr-1"></i>Address:</strong> {{ $avenue->address ?: 'N/A' }}</p>
                <p class="mb-2"><strong><i class="fas fa-globe mr-1"></i>Coordinates:</strong> {{ $avenue->latitude && $avenue->longitude ? $avenue->latitude.', '.$avenue->longitude : 'N/A' }}</p>
                <p class="mb-0"><strong>Status:</strong> <span class="badge {{ $avenue->status->value === 'active' ? 'badge-success' : 'badge-secondary' }}">{{ ucfirst($avenue->status->value) }}</span></p>
            </div>
        </div>

        <div class="card">
            <div class="card-header"><h3 class="card-title">Image Gallery</h3></div>
            <div class="card-body">
                @php
                    $groups = [
                        'Location Images' => $avenue->location_images ?? [],
                        'Event Room Images' => $avenue->event_room_images ?? [],
                        'Building Images' => $avenue->building_images ?? [],
                    ];
                @endphp

                @foreach($groups as $groupTitle => $images)
                    <p class="mb-1"><strong>{{ $groupTitle }}</strong></p>
                    @if(empty($images))
                        <p class="text-muted mb-2">No images.</p>
                    @else
                        <div class="d-flex flex-wrap mb-2">
                            @foreach($images as $imagePath)
                                <a href="{{ asset('storage/'.$imagePath) }}" target="_blank" class="mr-2 mb-2 d-inline-block">
                                    <img src="{{ asset('storage/'.$imagePath) }}" alt="{{ $groupTitle }}" style="width: 84px; height: 84px; object-fit: cover;" class="border rounded">
                                </a>
                            @endforeach
                        </div>
                    @endif
                @endforeach
            </div>
        </div>
    </div>

    <div class="col-md-7">
        <div class="card">
            <div class="card-header"><h3 class="card-title">Events In This Avenue</h3></div>
            <div class="card-body p-0 table-responsive">
                <table class="table table-sm table-hover mb-0">
                    <thead>
                        <tr>
                            <th>Title</th>
                            <th>Category</th>
                            <th>Date</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($avenue->events as $event)
                            <tr>
                                <td><a href="{{ route('admin.events.show', $event) }}">{{ $event->title }}</a></td>
                                <td>{{ $event->category?->name ?: 'N/A' }}</td>
                                <td>{{ $event->start_at?->format('d M Y H:i') }}</td>
                                <td>{{ ucfirst($event->event_status->value) }}</td>
                            </tr>
                        @empty
                            <tr><td colspan="4" class="text-center">No events found for this avenue.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<a href="{{ route('admin.avenues.index') }}" class="btn btn-secondary btn-sm"><i class="fas fa-arrow-left mr-1"></i>Back</a>
@stop
@section('css') @vite(['resources/css/app.css']) @stop
