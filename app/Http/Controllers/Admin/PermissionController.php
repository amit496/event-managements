<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\PermissionSaveRequest;
use App\Models\Permission;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class PermissionController extends Controller
{
    public function index(Request $request)
    {
        $sort = $request->string('sort')->toString();
        $dir = $request->string('dir')->toString() === 'asc' ? 'asc' : 'desc';
        $allowedSorts = ['name', 'created_at'];
        $sort = in_array($sort, $allowedSorts, true) ? $sort : 'created_at';

        $permissions = Permission::query()
            ->when($request->filled('q'), function ($query) use ($request): void {
                $term = trim((string) $request->input('q'));
                $query->where('name', 'like', '%'.$term.'%');
            })
            ->orderBy($sort, $dir)
            ->paginate(15)
            ->appends($request->query());

        return view('admin.permission.permission', [
            'permissions' => $permissions,
            'sortOptions' => $allowedSorts,
        ]);
    }

    public function store(PermissionSaveRequest $request): RedirectResponse
    {
        $data = $request->validated();

        Permission::create(['name' => $data['name'], 'guard_name' => 'web']);

        return back()->with('flash', ['type' => 'success', 'message' => 'Permission created successfully.']);
    }

    public function show(Permission $permission)
    {
        $permission->load(['roles', 'users']);

        return view('admin.permission.show', [
            'permission' => $permission,
        ]);
    }

    public function update(PermissionSaveRequest $request, Permission $permission): RedirectResponse
    {
        $data = $request->validated();

        $permission->update(['name' => $data['name']]);

        return back()->with('flash', ['type' => 'success', 'message' => 'Permission updated successfully.']);
    }

    public function destroy(Permission $permission): RedirectResponse
    {
        $permission->delete();

        return back()->with('flash', ['type' => 'warning', 'message' => 'Permission deleted successfully.']);
    }
}
