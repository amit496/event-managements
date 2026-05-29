@extends('admin.layout.app')
@section('title', 'Permission Details')
@section('content')
@include('admin.partials.flash')

<div class="d-flex justify-content-between align-items-center mb-3">
    <h4 class="mb-0">Permission Details</h4>
    <ol class="breadcrumb mb-0">
        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
        <li class="breadcrumb-item"><a href="{{ route('admin.permissions.index') }}">Permissions</a></li>
        <li class="breadcrumb-item active">{{ $permission->name }}</li>
    </ol>
</div>

<div class="card mb-3">
    <div class="card-body">
        <h5 class="mb-2"><i class="fas fa-key text-warning mr-2"></i>{{ $permission->name }}</h5>
        <p class="mb-1"><strong>Total Roles:</strong> {{ $permission->roles->count() }}</p>
        <p class="mb-0"><strong>Direct Users:</strong> {{ $permission->users->count() }}</p>
    </div>
</div>

<div class="row">
    <div class="col-md-6">
        <div class="card">
            <div class="card-header"><h3 class="card-title">Roles With Permission</h3></div>
            <div class="card-body">
                @forelse($permission->roles as $role)
                    <span class="badge badge-primary mr-1 mb-1">{{ $role->name }}</span>
                @empty
                    <span class="text-muted">No role linked.</span>
                @endforelse
            </div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="card">
            <div class="card-header"><h3 class="card-title">Users With Direct Permission</h3></div>
            <div class="card-body p-0 table-responsive">
                <table class="table table-sm table-hover mb-0">
                    <thead><tr><th>Name</th><th>Email</th><th>Status</th></tr></thead>
                    <tbody>
                        @forelse($permission->users as $user)
                            <tr>
                                <td>{{ $user->name }}</td>
                                <td>{{ $user->email }}</td>
                                <td><span class="badge {{ $user->status ? 'badge-success' : 'badge-secondary' }}">{{ $user->status ? 'Active' : 'Inactive' }}</span></td>
                            </tr>
                        @empty
                            <tr><td colspan="3" class="text-center">No users linked.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<a href="{{ route('admin.permissions.index') }}" class="btn btn-secondary btn-sm"><i class="fas fa-arrow-left mr-1"></i>Back</a>
@stop
@section('css') @vite(['resources/css/app.css']) @stop
