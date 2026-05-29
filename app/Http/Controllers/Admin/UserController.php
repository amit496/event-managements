<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\UserStatusRequest;
use App\Http\Requests\Admin\UserStoreRequest;
use App\Http\Requests\Admin\UserUpdateRequest;
use App\Models\Role;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function index(Request $request)
    {
        $sort = $request->string('sort')->toString();
        $dir = $request->string('dir')->toString() === 'asc' ? 'asc' : 'desc';
        $allowedSorts = ['name', 'email', 'status', 'created_at'];
        $sort = in_array($sort, $allowedSorts, true) ? $sort : 'created_at';

        $users = User::with('roles')
            ->when(auth()->check(), fn ($query) => $query->whereKeyNot(auth()->id()))
            ->when($request->filled('q'), function ($query) use ($request): void {
                $term = trim((string) $request->input('q'));
                $query->where(function ($inner) use ($term): void {
                    $inner->where('name', 'like', '%'.$term.'%')
                        ->orWhere('email', 'like', '%'.$term.'%')
                        ->orWhere('phone', 'like', '%'.$term.'%')
                        ->orWhereHas('roles', fn ($role) => $role->where('name', 'like', '%'.$term.'%'));
                });
            })
            ->orderBy($sort, $dir)
            ->paginate(10)
            ->appends($request->query());

        return view('admin.user.user', [
            'users' => $users,
            'roles' => Role::query()->orderBy('name')->get(),
            'sortOptions' => $allowedSorts,
        ]);
    }

    public function show(User $user)
    {
        $user->load(['roles.permissions']);

        return view('admin.user.show', [
            'user' => $user,
            'permissions' => $user->getAllPermissions()->sortBy('name')->values(),
        ]);
    }

    public function store(UserStoreRequest $request): RedirectResponse
    {
        $data = $request->validated();

        $user = User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'phone' => $data['phone'] ?? null,
            'address' => $data['address'] ?? null,
            'password' => Hash::make($data['password']),
            'status' => (bool) ($data['status'] ?? true),
        ]);

        $user->syncRoles($data['roles'] ?? []);

        return back()->with('flash', ['type' => 'success', 'message' => 'User created successfully.']);
    }

    public function update(UserUpdateRequest $request, User $user): RedirectResponse
    {
        if ($user->id === auth()->id()) {
            return back()->with('flash', ['type' => 'error', 'message' => 'You can not update your own account from user management.']);
        }

        $data = $request->validated();

        $payload = [
            'name' => $data['name'],
            'email' => $data['email'],
            'phone' => $data['phone'] ?? null,
            'address' => $data['address'] ?? null,
            'status' => (bool) ($data['status'] ?? false),
        ];

        if (! empty($data['password'])) {
            $payload['password'] = Hash::make($data['password']);
        }

        $user->update($payload);
        $user->syncRoles($data['roles'] ?? []);

        return back()->with('flash', ['type' => 'success', 'message' => 'User updated successfully.']);
    }

    public function destroy(User $user): RedirectResponse
    {
        if ($user->id === auth()->id()) {
            return back()->with('flash', ['type' => 'error', 'message' => 'You can not delete your own account.']);
        }

        $user->delete();

        return back()->with('flash', ['type' => 'warning', 'message' => 'User deleted successfully.']);
    }

    public function updateStatus(UserStatusRequest $request, User $user): RedirectResponse
    {
        if ($user->id === auth()->id()) {
            return back()->with('flash', ['type' => 'error', 'message' => 'You can not change your own status.']);
        }

        $user->update(['status' => (bool) $request->validated('status')]);

        return back()->with('flash', ['type' => 'success', 'message' => 'User status updated successfully.']);
    }
}
