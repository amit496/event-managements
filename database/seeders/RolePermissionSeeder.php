<?php

namespace Database\Seeders;

use App\Models\Permission;
use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class RolePermissionSeeder extends Seeder
{
    public function run(): void
    {
        $permissions = [
            'dashboard.view',
            'category.view', 'category.create', 'category.update', 'category.delete',
            'avenue.view', 'avenue.create', 'avenue.update', 'avenue.delete',
            'service.view', 'service.create', 'service.update', 'service.delete',
            'event.view', 'event.create', 'event.update', 'event.delete',
            'payment.view', 'payment.create', 'payment.update', 'payment.delete',
            'client.view', 'client.create', 'client.update', 'client.delete',
            'booking.view', 'booking.create', 'booking.update', 'booking.delete',
            'quotation.view', 'quotation.create', 'quotation.update', 'quotation.delete',
            'task.view', 'task.create', 'task.update', 'task.delete',
            'vendor.view', 'vendor.create', 'vendor.update', 'vendor.delete',
            'user.view', 'user.create', 'user.update', 'user.delete',
            'role.view', 'role.create', 'role.update', 'role.delete',
            'permission.view', 'permission.create', 'permission.update', 'permission.delete',
            'setting.manage',
        ];

        foreach ($permissions as $permission) {
            Permission::findOrCreate($permission, 'web');
        }

        $roleMatrix = [
            'admin' => $permissions,
            'manager' => [
                'dashboard.view',
                'category.view', 'category.create', 'category.update',
                'avenue.view', 'avenue.create', 'avenue.update',
                'service.view', 'service.create', 'service.update',
                'event.view', 'event.create', 'event.update', 'event.delete',
                'payment.view', 'payment.update',
                'client.view', 'client.create', 'client.update',
                'booking.view', 'booking.create', 'booking.update',
                'quotation.view', 'quotation.create', 'quotation.update',
                'task.view', 'task.create', 'task.update',
                'vendor.view', 'vendor.create', 'vendor.update',
                'user.view',
            ],
            'event_coordinator' => [
                'dashboard.view',
                'category.view',
                'avenue.view',
                'service.view',
                'event.view', 'event.create', 'event.update',
                'payment.view',
                'client.view',
                'booking.view', 'booking.create', 'booking.update',
                'task.view', 'task.create', 'task.update',
            ],
            'finance_executive' => [
                'dashboard.view',
                'event.view',
                'service.view',
                'payment.view', 'payment.create', 'payment.update',
                'client.view',
                'booking.view',
                'quotation.view', 'quotation.create', 'quotation.update',
                'vendor.view',
                'user.view',
            ],
            'support_staff' => [
                'dashboard.view',
                'category.view',
                'avenue.view',
                'service.view',
                'event.view',
                'payment.view',
                'client.view',
                'booking.view',
                'task.view',
                'vendor.view',
                'user.view',
            ],
            'user' => ['event.view'],
        ];

        foreach ($roleMatrix as $roleName => $rolePermissions) {
            $role = Role::findOrCreate($roleName, 'web');
            $role->syncPermissions($rolePermissions);
        }

        $staffUsers = [
            [
                'name' => 'System Admin',
                'email' => 'admin@event.local',
                'phone' => '+10000000000',
                'address' => 'Head Office',
                'status' => true,
                'role' => 'admin',
            ],
            [
                'name' => 'Operations Manager',
                'email' => 'manager@event.local',
                'phone' => '+10000000001',
                'address' => 'Operations Floor',
                'status' => true,
                'role' => 'manager',
            ],
            [
                'name' => 'Event Coordinator',
                'email' => 'coordinator@event.local',
                'phone' => '+10000000002',
                'address' => 'Event Desk',
                'status' => true,
                'role' => 'event_coordinator',
            ],
            [
                'name' => 'Finance Executive',
                'email' => 'finance@event.local',
                'phone' => '+10000000003',
                'address' => 'Accounts Department',
                'status' => true,
                'role' => 'finance_executive',
            ],
            [
                'name' => 'Support Staff',
                'email' => 'support@event.local',
                'phone' => '+10000000004',
                'address' => 'Support Desk',
                'status' => true,
                'role' => 'support_staff',
            ],
        ];

        foreach ($staffUsers as $staffUser) {
            $user = User::updateOrCreate(
                ['email' => $staffUser['email']],
                [
                    'name' => $staffUser['name'],
                    'phone' => $staffUser['phone'],
                    'address' => $staffUser['address'],
                    'password' => Hash::make('password123'),
                    'status' => $staffUser['status'],
                ]
            );

            $user->syncRoles([$staffUser['role']]);
        }
    }
}
