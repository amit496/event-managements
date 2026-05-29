@extends('admin.layout.app')
@section('title', 'Role Details')
@section('content')
@include('admin.partials.flash')

<div class="d-flex justify-content-between align-items-center mb-3">
    <h4 class="mb-0">Role Details</h4>
    <ol class="breadcrumb mb-0">
        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
        <li class="breadcrumb-item"><a href="{{ route('admin.roles.index') }}">Roles</a></li>
        <li class="breadcrumb-item active">{{ $role->name }}</li>
    </ol>
</div>

<div class="card mb-3">
    <div class="card-body">
        <h5 class="mb-2"><i class="fas fa-user-shield text-primary mr-2"></i>{{ $role->name }}</h5>
        <p class="mb-1"><strong>Total Permissions:</strong> {{ $role->permissions->count() }}</p>
        <p class="mb-0"><strong>Total Users:</strong> {{ $role->users->count() }}</p>
    </div>
</div>

<div class="row">
    <div class="col-md-7">
        <div class="card">
            <div class="card-header"><h3 class="card-title">Permissions (Module Wise)</h3></div>
            <div class="card-body">
                @php
                    $groupedPermissions = $role->permissions
                        ->map(function ($permission) {
                            $parts = explode('.', $permission->name, 2);
                            return [
                                'module' => $parts[0] ?? 'general',
                                'action' => $parts[1] ?? 'access',
                                'name' => $permission->name,
                            ];
                        })
                        ->groupBy('module');
                @endphp

                @forelse($groupedPermissions as $module => $permissions)
                    <div class="mb-3 pb-2 border-bottom">
                        <div class="font-weight-bold text-uppercase mb-2">
                            <i class="fas fa-layer-group text-primary mr-1"></i>{{ str_replace('_', ' ', $module) }}
                        </div>
                        @foreach($permissions as $perm)
                            <span class="badge badge-info mr-1 mb-1">
                                <i class="fas fa-check-circle mr-1"></i>{{ $perm['action'] }}
                            </span>
                        @endforeach
                    </div>
                @empty
                    <span class="text-muted">No permissions assigned.</span>
                @endforelse
            </div>
        </div>
    </div>
    <div class="col-md-5">
        <div class="card">
            <div class="card-header"><h3 class="card-title">Assigned Users</h3></div>
            <div class="card-body p-0 table-responsive">
                <table class="table table-sm table-hover mb-0">
                    <thead><tr><th>Name</th><th>Email</th><th>Status</th></tr></thead>
                    <tbody>
                        @forelse($role->users as $user)
                            <tr>
                                <td>{{ $user->name }}</td>
                                <td>{{ $user->email }}</td>
                                <td>
                                    <span class="badge {{ $user->status ? 'badge-success' : 'badge-secondary' }}">{{ $user->status ? 'Active' : 'Inactive' }}</span>
                                </td>
                            </tr>
                        @empty
                            <tr><td colspan="3" class="text-center">No users assigned.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<a href="{{ route('admin.roles.index') }}" class="btn btn-secondary btn-sm"><i class="fas fa-arrow-left mr-1"></i>Back</a>
@stop
@section('css') @vite(['resources/css/app.css']) @stop
