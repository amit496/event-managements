@extends('admin.layout.app')
@section('title', 'User Details')
@section('content')
@include('admin.partials.flash')
<div class="d-flex justify-content-between align-items-center mb-3">
    <h4 class="mb-0">User Details</h4>
    <ol class="breadcrumb mb-0">
        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
        <li class="breadcrumb-item"><a href="{{ route('admin.users.index') }}">Users</a></li>
        <li class="breadcrumb-item active">{{ $user->name }}</li>
    </ol>
</div>

<div class="row">
    <div class="col-md-5">
        <div class="card">
            <div class="card-header"><h3 class="card-title">Profile</h3></div>
            <div class="card-body">
                <p class="mb-2"><strong>Name:</strong> {{ $user->name }}</p>
                <p class="mb-2"><strong>Email:</strong> {{ $user->email }}</p>
                <p class="mb-2"><strong>Phone:</strong> {{ $user->phone ?: 'N/A' }}</p>
                <p class="mb-2"><strong>Address:</strong> {{ $user->address ?: 'N/A' }}</p>
                <p class="mb-2"><strong>Status:</strong> <span class="badge {{ $user->status ? 'badge-success' : 'badge-secondary' }}">{{ $user->status ? 'Active' : 'Inactive' }}</span></p>
                <p class="mb-0"><strong>Created:</strong> {{ $user->created_at?->format('d M Y h:i A') }}</p>
            </div>
        </div>

        <div class="card">
            <div class="card-header"><h3 class="card-title">Assigned Roles</h3></div>
            <div class="card-body">
                @forelse($user->roles as $role)
                    <span class="badge badge-primary mr-1 mb-1">{{ $role->name }}</span>
                @empty
                    <span class="text-muted">No role assigned.</span>
                @endforelse
            </div>
        </div>
    </div>

    <div class="col-md-7">
        <div class="card">
            <div class="card-header"><h3 class="card-title">Effective Permissions</h3></div>
            <div class="card-body">
                @if($permissions->isEmpty())
                    <p class="text-muted mb-0">No permissions available.</p>
                @else
                    <div class="row">
                        @foreach($permissions as $permission)
                            <div class="col-md-6 mb-2"><span class="badge badge-info">{{ $permission->name }}</span></div>
                        @endforeach
                    </div>
                @endif
            </div>
        </div>

        <div class="card">
            <div class="card-header"><h3 class="card-title">Role Wise Permissions</h3></div>
            <div class="card-body p-0 table-responsive">
                <table class="table table-sm table-hover mb-0">
                    <thead>
                        <tr>
                            <th>Role</th>
                            <th>Permissions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($user->roles as $role)
                            <tr>
                                <td>{{ $role->name }}</td>
                                <td>{{ $role->permissions->pluck('name')->join(', ') ?: 'No permission assigned' }}</td>
                            </tr>
                        @empty
                            <tr><td colspan="2" class="text-center">No role data found.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<a href="{{ route('admin.users.index') }}" class="btn btn-secondary btn-sm">Back</a>
@stop
@section('css') @vite(['resources/css/app.css']) @stop
