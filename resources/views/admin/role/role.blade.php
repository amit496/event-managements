@extends('admin.layout.app')
@section('title', 'Roles')
@section('content')
@include('admin.partials.flash')
@include('admin.role.breadcrumb')

<div class="card">
    <div class="card-header admin-card-toolbar">
        <h3 class="card-title">Roles</h3>
        <button class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#roleCreateModal"><i class="fas fa-plus mr-1"></i>Add Role</button>
    </div>
    <div class="card-body border-bottom">
        <form method="GET" action="{{ route('admin.roles.index') }}" class="form-row">
            <div class="col-md-5 mb-2">
                <input type="text" name="q" value="{{ request('q') }}" class="form-control" placeholder="Search role/permission">
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
                <a href="{{ route('admin.roles.index') }}" class="btn btn-secondary btn-sm"><i class="fas fa-undo mr-1"></i>Reset</a>
            </div>
        </form>
    </div>
    <div class="card-body table-responsive p-0">
        <table class="table table-hover">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Name</th>
                    <th>Permissions</th>
                    <th>Users</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @forelse($roles as $role)
                    <tr>
                        <td>{{ $role->id }}</td>
                        <td>
                            <strong>{{ $role->name }}</strong>
                            <div><small class="text-muted">{{ $role->permissions_count }} permissions</small></div>
                        </td>
                        <td style="min-width: 430px;">
                            @php($previewPermissions = $role->permissions->pluck('name')->take(6))
                            <div class="d-flex flex-wrap">
                                @forelse($previewPermissions as $permissionName)
                                    <span class="badge badge-light border mr-1 mb-1">{{ $permissionName }}</span>
                                @empty
                                    <span class="text-muted">No permissions assigned</span>
                                @endforelse
                                @if($role->permissions_count > 6)
                                    <a href="{{ route('admin.roles.show', $role) }}" class="badge badge-secondary mb-1">+{{ $role->permissions_count - 6 }} more</a>
                                @endif
                            </div>
                        </td>
                        <td><span class="badge badge-info">{{ $role->users_count }}</span></td>
                        <td class="d-flex">
                            <a href="{{ route('admin.roles.show', $role) }}" class="btn btn-secondary btn-xs mr-1"><i class="fas fa-eye mr-1"></i>Details</a>
                            <button class="btn btn-info btn-xs mr-1 btn-edit-role" data-action="{{ route('admin.roles.update', $role) }}" data-name="{{ $role->name }}" data-permissions="{{ $role->permissions->pluck('name')->join(',') }}"><i class="fas fa-edit mr-1"></i>Edit</button>
                            <form action="{{ route('admin.roles.destroy', $role) }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <button class="btn btn-danger btn-xs" onclick="return confirm('Delete role?')"><i class="fas fa-trash-alt mr-1"></i>Delete</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="5" class="text-center">No data found.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div class="card-footer">{{ $roles->links() }}</div>
</div>
@include('admin.role.model-create-update')
@stop
@section('css') @vite(['resources/css/app.css']) @stop
@section('js') @vite(['resources/js/app.js']) @include('admin.role.role-js') @stop
