@extends('admin.layout.app')
@section('title', $title)

@section('content')
    @include('admin.partials.flash')
    @include('admin.event.breadcrumb')

    <div class="card">
        <div class="card-header">
            <h3 class="card-title">{{ $title }}</h3>
        </div>
        <form method="POST" action="{{ $action }}" enctype="multipart/form-data">
            @csrf
            @if ($method !== 'POST')
                @method($method)
            @endif

            <div class="card-body row">
                <div class="col-md-6 form-group">
                    <label>Title</label>
                    <input name="title" class="form-control" value="{{ old('title', $event->title) }}" required>
                </div>
                <div class="col-md-6 form-group">
                    <label>Category</label>
                    <select name="category_id" class="form-control" required>
                        <option value="">Select Category</option>
                        @foreach ($categories as $category)
                            <option value="{{ $category->id }}" @selected(old('category_id', $event->category_id) == $category->id)>{{ $category->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-6 form-group">
                    <label>Avenue / Place (optional)</label>
                    <select name="avenue_id" class="form-control">
                        <option value="">Select Avenue</option>
                        @foreach ($avenues as $avenue)
                            <option value="{{ $avenue->id }}" @selected(old('avenue_id', $event->avenue_id) == $avenue->id)>{{ $avenue->name }}
                                ({{ $avenue->place }})</option>
                        @endforeach
                    </select>
                    <small class="form-text text-muted">If selected, venue and address can be auto-filled.</small>
                </div>
                <div class="col-md-6 form-group">
                    <label>Event Status</label>
                    <select name="event_status" class="form-control" required>
                        @foreach ($statuses as $status)
                            <option value="{{ $status->value }}" @selected(old('event_status', $event->event_status?->value ?? 'draft') === $status->value)>{{ ucfirst($status->value) }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-6 form-group">
                    <label>Start</label>
                    <input type="datetime-local" name="start_at" class="form-control"
                        value="{{ old('start_at', $event->start_at?->format('Y-m-d\TH:i')) }}" required>
                </div>
                <div class="col-md-6 form-group">
                    <label>End</label>
                    <input type="datetime-local" name="end_at" class="form-control"
                        value="{{ old('end_at', $event->end_at?->format('Y-m-d\TH:i')) }}" required>
                </div>
                <div class="col-md-6 form-group">
                    <label>Venue / Location Name (optional)</label>
                    <input name="venue" class="form-control" placeholder="Example: Hall A, Block B"
                        value="{{ old('venue', $event->venue) }}">
                    <small class="form-text text-muted">This is where the event will happen.</small>
                </div>
                <div class="col-md-6 form-group">
                    <label>Address</label>
                    <input name="address" class="form-control" value="{{ old('address', $event->address) }}">
                </div>
                <div class="col-md-6 form-group">
                    <label>Latitude</label>
                    <input name="latitude" class="form-control" value="{{ old('latitude', $event->latitude) }}">
                </div>
                <div class="col-md-6 form-group">
                    <label>Longitude</label>
                    <input name="longitude" class="form-control" value="{{ old('longitude', $event->longitude) }}">
                </div>
                <div class="col-md-6 form-group">
                    <label>Capacity</label>
                    <input name="capacity" type="number" min="1" class="form-control"
                        value="{{ old('capacity', $event->capacity) }}">
                </div>
                <div class="col-md-6 form-group">
                    <label>Price</label>
                    <input name="price" type="number" min="0" step="0.01" class="form-control"
                        value="{{ old('price', $event->price) }}">
                </div>
                <div class="col-md-6 form-group">
                    <label>Total Client Payable Amount</label>
                    <input name="client_payable_amount" type="number" min="0" step="0.01" class="form-control"
                        value="{{ old('client_payable_amount', $event->client_payable_amount) }}">
                    <small class="form-text text-muted">Full amount expected from client for this event.</small>
                </div>
                <div class="col-md-12 form-group">
                    <label>Description</label>
                    <textarea name="description" rows="4" class="form-control" required>{{ old('description', $event->description) }}</textarea>
                </div>
                <div class="col-md-6 form-group">
                    <label>Image</label>
                    <input type="file" name="image" class="form-control">
                </div>
                <div class="col-md-3 form-check mt-4">
                    <input type="checkbox" class="form-check-input" name="payment_required" value="1"
                        @checked(old('payment_required', $event->payment_required))>
                    <label class="form-check-label">Paid Event (ticket/payment required)</label>
                </div>
                <div class="col-md-3 form-check mt-4">
                    <input type="checkbox" class="form-check-input" name="is_featured" value="1"
                        @checked(old('is_featured', $event->is_featured))>
                    <label class="form-check-label">Featured (highlight on homepage)</label>
                </div>
            </div>

            <div class="card-footer d-flex justify-content-between">
                <a href="{{ route('admin.events.index') }}" class="btn btn-secondary">Back</a>
                <button class="btn btn-primary">{{ $method === 'POST' ? 'Save Event' : 'Update Event' }}</button>
            </div>
        </form>
    </div>
@stop

@section('css') @vite(['resources/css/app.css']) @stop
@section('js') @vite(['resources/js/app.js']) @stop
