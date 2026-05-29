@extends('admin.layout.app')
@section('title', 'Users')
@section('content')
@include('admin.partials.flash')
@include('admin.user.breadcrumb')

<div class="card">
    <div class="card-header admin-card-toolbar">
        <h3 class="card-title">Users</h3>
        <button class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#userCreateModal">
            <i class="fas fa-plus mr-1"></i>Add User
        </button>
    </div>
    <div class="card-body border-bottom">
        <form method="GET" action="{{ route('admin.users.index') }}" class="form-row">
            <div class="col-md-5 mb-2">
                <input type="text" name="q" value="{{ request('q') }}" class="form-control" placeholder="Search user/email/role">
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
                <button class="btn btn-info btn-sm mr-1">Apply</button>
                <a href="{{ route('admin.users.index') }}" class="btn btn-secondary btn-sm">Reset</a>
            </div>
        </form>
    </div>
    <div class="card-body table-responsive p-0">
        <table class="table table-hover text-nowrap">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Roles</th>
                    <th>Status</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @forelse($users as $user)
                    <tr>
                        <td>{{ $user->id }}</td>
                        <td>{{ $user->name }}</td>
                        <td>{{ $user->email }}</td>
                        <td>{{ $user->roles->pluck('name')->join(', ') }}</td>
                        <td>
                            <form method="POST" action="{{ route('admin.users.status', $user) }}">
                                @csrf
                                @method('PATCH')
                                <select name="status" class="form-control form-control-sm" onchange="this.form.submit()">
                                    <option value="1" @selected($user->status)>Active</option>
                                    <option value="0" @selected(! $user->status)>Inactive</option>
                                </select>
                            </form>
                        </td>
                        <td class="d-flex">
                            <a href="{{ route('admin.users.show', $user) }}" class="btn btn-secondary btn-xs mr-1">Details</a>
                            <button class="btn btn-info btn-xs mr-1 btn-edit-user" data-action="{{ route('admin.users.update', $user) }}" data-name="{{ $user->name }}" data-email="{{ $user->email }}" data-phone="{{ $user->phone }}" data-address="{{ $user->address }}" data-status="{{ $user->status ? 1 : 0 }}" data-roles="{{ $user->roles->pluck('name')->join(',') }}">Edit</button>
                            <form action="{{ route('admin.users.destroy', $user) }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <button class="btn btn-danger btn-xs" onclick="return confirm('Delete user?')">Delete</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="6" class="text-center">No data found.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div class="card-footer">{{ $users->links() }}</div>
</div>
@include('admin.user.model-create-update')
@stop
@section('css') @vite(['resources/css/app.css']) @stop
@section('js') @vite(['resources/js/app.js']) @include('admin.user.user-js') @stop
