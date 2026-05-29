@extends('admin.layout.app')
@section('title', 'Events')
@section('content')
@include('admin.partials.flash')
@include('admin.event.breadcrumb')

<div class="card">
    <div class="card-header admin-card-toolbar">
        <h3 class="card-title">Events</h3>
        <a href="{{ route('admin.events.create') }}" class="btn btn-primary btn-sm"><i class="fas fa-plus mr-1"></i>Add Event</a>
    </div>
    <div class="card-body border-bottom">
        <form method="GET" action="{{ route('admin.events.index') }}" class="form-row">
            <div class="col-md-5 mb-2">
                <input type="text" name="q" value="{{ request('q') }}" class="form-control" placeholder="Search event/category/avenue">
            </div>
            <div class="col-md-3 mb-2">
                <select name="sort" class="form-control">
                    @foreach($sortOptions as $sort)
                        <option value="{{ $sort }}" @selected(request('sort', 'created_at') === $sort)>Sort: {{ ucfirst(str_replace('_', ' ', $sort)) }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-2 mb-2">
                <select name="dir" class="form-control">
                    <option value="desc" @selected(request('dir', 'desc') === 'desc')>Desc</option>
                    <option value="asc" @selected(request('dir') === 'asc')>Asc</option>
                </select>
            </div>
            <div class="col-md-2 mb-2 d-flex">
                <button class="btn btn-info btn-sm mr-1"><i class="fas fa-filter mr-1"></i>Apply</button>
                <a href="{{ route('admin.events.index') }}" class="btn btn-secondary btn-sm"><i class="fas fa-undo mr-1"></i>Reset</a>
            </div>
        </form>
    </div>
    <div class="card-body table-responsive p-0">
        <table class="table table-hover text-nowrap">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Title</th>
                    <th>Category</th>
                    <th>Date</th>
                    <th>Status</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @forelse($events as $event)
                    <tr>
                        <td>{{ $event->id }}</td>
                        <td>{{ $event->title }}</td>
                        <td>{{ $event->category?->name }}</td>
                        <td>{{ $event->start_at?->format('d M Y H:i') }}</td>
                        <td>
                            <form method="POST" action="{{ route('admin.events.status', $event) }}">
                                @csrf
                                @method('PATCH')
                                <select name="event_status" class="form-control form-control-sm" onchange="this.form.submit()">
                                    @foreach($statuses as $status)
                                        <option value="{{ $status->value }}" @selected($event->event_status->value === $status->value)>{{ ucfirst($status->value) }}</option>
                                    @endforeach
                                </select>
                            </form>
                        </td>
                        <td class="d-flex">
                            <a href="{{ route('admin.events.show', $event) }}" class="btn btn-secondary btn-xs mr-1"><i class="fas fa-eye mr-1"></i>Details</a>
                            <a href="{{ route('admin.events.edit', $event) }}" class="btn btn-info btn-xs mr-1"><i class="fas fa-edit mr-1"></i>Edit</a>
                            <form action="{{ route('admin.events.destroy', $event) }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <button class="btn btn-danger btn-xs" onclick="return confirm('Delete event?')"><i class="fas fa-trash-alt mr-1"></i>Delete</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="6" class="text-center">No data found.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div class="card-footer">{{ $events->links() }}</div>
</div>
@stop
@section('css') @vite(['resources/css/app.css']) @stop
@section('js') @vite(['resources/js/app.js']) @stop
