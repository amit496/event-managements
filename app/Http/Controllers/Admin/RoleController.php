<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\RoleSaveRequest;
use App\Models\Permission;
use App\Models\Role;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class RoleController extends Controller
{
    public function index(Request $request)
    {
        $sort = $request->string('sort')->toString();
        $dir = $request->string('dir')->toString() === 'asc' ? 'asc' : 'desc';
        $allowedSorts = ['name', 'created_at'];
        $sort = in_array($sort, $allowedSorts, true) ? $sort : 'created_at';

        $roles = Role::with('permissions')
            ->withCount(['permissions', 'users'])
            ->when($request->filled('q'), function ($query) use ($request): void {
                $term = trim((string) $request->input('q'));
                $query->where(function ($inner) use ($term): void {
                    $inner->where('name', 'like', '%'.$term.'%')
                        ->orWhereHas('permissions', fn ($perm) => $perm->where('name', 'like', '%'.$term.'%'));
                });
            })
            ->orderBy($sort, $dir)
            ->paginate(10)
            ->appends($request->query());

        return view('admin.role.role', [
            'roles' => $roles,
            'permissions' => Permission::query()->orderBy('name')->get(),
            'sortOptions' => $allowedSorts,
        ]);
    }

    public function store(RoleSaveRequest $request): RedirectResponse
    {
        $data = $request->validated();

        $role = Role::create(['name' => $data['name'], 'guard_name' => 'web']);
        $role->syncPermissions($data['permissions'] ?? []);

        return back()->with('flash', ['type' => 'success', 'message' => 'Role created successfully.']);
    }

    public function show(Role $role)
    {
        $role->load(['permissions', 'users']);

        return view('admin.role.show', [
            'role' => $role,
        ]);
    }

    public function update(RoleSaveRequest $request, Role $role): RedirectResponse
    {
        $data = $request->validated();

        $role->update(['name' => $data['name']]);
        $role->syncPermissions($data['permissions'] ?? []);

        return back()->with('flash', ['type' => 'success', 'message' => 'Role updated successfully.']);
    }

    public function destroy(Role $role): RedirectResponse
    {
        $role->delete();

        return back()->with('flash', ['type' => 'warning', 'message' => 'Role deleted successfully.']);
    }
}
