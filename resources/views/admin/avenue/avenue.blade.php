@extends('admin.layout.app')
@section('title', 'Avenues')
@section('content')
@include('admin.partials.flash')
@include('admin.avenue.breadcrumb')

<div class="card">
    <div class="card-header admin-card-toolbar">
        <h3 class="card-title">Avenues</h3>
        <a href="{{ route('admin.avenues.create') }}" class="btn btn-primary btn-sm"><i class="fas fa-plus mr-1"></i>Add Avenue</a>
    </div>
    <div class="card-body border-bottom">
        <form method="GET" action="{{ route('admin.avenues.index') }}" class="form-row">
            <div class="col-md-5 mb-2">
                <input type="text" name="q" value="{{ request('q') }}" class="form-control" placeholder="Search avenue/place/city">
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
                <a href="{{ route('admin.avenues.index') }}" class="btn btn-secondary btn-sm"><i class="fas fa-undo mr-1"></i>Reset</a>
            </div>
        </form>
    </div>
    <div class="card-body table-responsive p-0">
        <table class="table table-hover text-nowrap">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Name</th>
                    <th>Place</th>
                    <th>City</th>
                    <th>Status</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @forelse($avenues as $avenue)
                    <tr>
                        <td>{{ $avenue->id }}</td>
                        <td>{{ $avenue->name }}</td>
                        <td>{{ $avenue->place }}</td>
                        <td>{{ $avenue->city }}</td>
                        <td>
                            <form method="POST" action="{{ route('admin.avenues.status', $avenue) }}">
                                @csrf
                                @method('PATCH')
                                <select name="status" class="form-control form-control-sm" onchange="this.form.submit()">
                                    @foreach($statuses as $status)
                                        <option value="{{ $status->value }}" @selected($avenue->status->value === $status->value)>{{ ucfirst($status->value) }}</option>
                                    @endforeach
                                </select>
                            </form>
                        </td>
                        <td class="d-flex">
                            <a href="{{ route('admin.avenues.show', $avenue) }}" class="btn btn-secondary btn-xs mr-1"><i class="fas fa-eye mr-1"></i>Details</a>
                            <a href="{{ route('admin.avenues.edit', $avenue) }}" class="btn btn-info btn-xs mr-1"><i class="fas fa-edit mr-1"></i>Edit</a>
                            <form action="{{ route('admin.avenues.destroy', $avenue) }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <button class="btn btn-danger btn-xs" onclick="return confirm('Delete avenue?')"><i class="fas fa-trash-alt mr-1"></i>Delete</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="6" class="text-center">No data found.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div class="card-footer">{{ $avenues->links() }}</div>
</div>
@stop
@section('css') @vite(['resources/css/app.css']) @stop
@section('js') @vite(['resources/js/app.js']) @stop
