@extends('admin.layout.app')
@section('title', 'Permissions')
@section('content')
@include('admin.partials.flash')
@include('admin.permission.breadcrumb')

<div class="card">
    <div class="card-header admin-card-toolbar">
        <h3 class="card-title">Permissions</h3>
        <button class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#permissionCreateModal"><i class="fas fa-plus mr-1"></i>Add Permission</button>
    </div>
    <div class="card-body border-bottom">
        <form method="GET" action="{{ route('admin.permissions.index') }}" class="form-row">
            <div class="col-md-5 mb-2">
                <input type="text" name="q" value="{{ request('q') }}" class="form-control" placeholder="Search permission">
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
                <a href="{{ route('admin.permissions.index') }}" class="btn btn-secondary btn-sm"><i class="fas fa-undo mr-1"></i>Reset</a>
            </div>
        </form>
    </div>
    <div class="card-body table-responsive p-0">
        <table class="table table-hover">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Name</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @forelse($permissions as $permission)
                    <tr>
                        <td>{{ $permission->id }}</td>
                        <td>{{ $permission->name }}</td>
                        <td class="d-flex">
                            <a href="{{ route('admin.permissions.show', $permission) }}" class="btn btn-secondary btn-xs mr-1"><i class="fas fa-eye mr-1"></i>Details</a>
                            <button class="btn btn-info btn-xs mr-1 btn-edit-permission" data-action="{{ route('admin.permissions.update', $permission) }}" data-name="{{ $permission->name }}"><i class="fas fa-edit mr-1"></i>Edit</button>
                            <form method="POST" action="{{ route('admin.permissions.destroy', $permission) }}">
                                @csrf
                                @method('DELETE')
                                <button class="btn btn-danger btn-xs" onclick="return confirm('Delete permission?')"><i class="fas fa-trash-alt mr-1"></i>Delete</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="3" class="text-center">No data found.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div class="card-footer">{{ $permissions->links() }}</div>
</div>
@include('admin.permission.model-create-update')
@stop
@section('css') @vite(['resources/css/app.css']) @stop
@section('js') @vite(['resources/js/app.js']) @include('admin.permission.permission-js') @stop
