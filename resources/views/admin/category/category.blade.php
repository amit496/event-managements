@extends('admin.layout.app')
@section('title', 'Categories')
@section('content')
@include('admin.partials.flash')
@include('admin.category.breadcrumb')

<div class="card">
    <div class="card-header admin-card-toolbar">
        <h3 class="card-title">Categories</h3>
        <button class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#categoryCreateModal">
            <i class="fas fa-plus mr-1"></i>Add Category
        </button>
    </div>
    <div class="card-body border-bottom">
        <form method="GET" action="{{ route('admin.categories.index') }}" class="form-row">
            <div class="col-md-5 mb-2">
                <input type="text" name="q" value="{{ request('q') }}" class="form-control" placeholder="Search category">
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
                <a href="{{ route('admin.categories.index') }}" class="btn btn-secondary btn-sm">Reset</a>
            </div>
        </form>
    </div>
    <div class="card-body table-responsive p-0">
        <table class="table table-hover text-nowrap">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Name</th>
                    <th>Status</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @forelse($categories as $category)
                    <tr>
                        <td>{{ $category->id }}</td>
                        <td>{{ $category->name }}</td>
                        <td>
                            <form method="POST" action="{{ route('admin.categories.status', $category) }}" class="d-flex">
                                @csrf
                                @method('PATCH')
                                <select name="status" class="form-control form-control-sm mr-1" onchange="this.form.submit()">
                                    @foreach($statuses as $status)
                                        <option value="{{ $status->value }}" @selected($category->status->value === $status->value)>{{ ucfirst($status->value) }}</option>
                                    @endforeach
                                </select>
                            </form>
                        </td>
                        <td class="d-flex">
                            <button class="btn btn-info btn-xs mr-1 btn-edit-category" data-action="{{ route('admin.categories.update', $category) }}" data-name="{{ $category->name }}" data-description="{{ $category->description }}" data-status="{{ $category->status->value }}">Edit</button>
                            <form action="{{ route('admin.categories.destroy', $category) }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <button class="btn btn-danger btn-xs" onclick="return confirm('Delete category?')">Delete</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="4" class="text-center">No data found.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div class="card-footer">{{ $categories->links() }}</div>
</div>
@include('admin.category.model-create-update')
@stop
@section('css') @vite(['resources/css/app.css']) @stop
@section('js') @vite(['resources/js/app.js']) @include('admin.category.category-js') @stop

