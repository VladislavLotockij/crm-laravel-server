<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class RoleSeeder extends Seeder
{
    public function run(): void
    {
        // Очистка кэша разрешений
        app(\Spatie\Permission\PermissionRegistrar::class)->forgetCachedPermissions();

        // Определение ролей и их разрешений
        $roles = [
            'admin' => [
                'permissions' => [
                    'manage_users',
                    'manage_clients',
                    'manage_deals',
                    'manage_tasks',
                    'view_reports',
                    'view_logs',
                ],
            ],
            'head' => [
                'permissions' => [
                    'manage_clients',
                    'manage_deals',
                    'manage_tasks',
                    'view_reports',
                ],
            ],
            'manager' => [
                'permissions' => [
                    'manage_own_clients',
                    'manage_own_deals',
                    'manage_own_tasks',
                ],
            ],
            'guest' => [
                'permissions' => [
                    'view_reports',
                ],
            ],
        ];

        // Создание ролей и назначение разрешений
        foreach ($roles as $roleName => $data) {
            $role = Role::create([
                'name' => $roleName,
                'guard_name' => 'api',
            ]);

            foreach ($data['permissions'] as $permissionName) {
                $permission = Permission::firstOrCreate([
                    'name' => $permissionName,
                    'guard_name' => 'api',
                ]);
                $role->givePermissionTo($permission);
            }
        }

        // Создание администратора
        $admin = User::updateOrCreate(
            ['email' => 'admin@admin.com'],
            [
                'name' => 'Admin',
                'password' => Hash::make('admin123'), // Временный пароль
            ]
        );

        // Назначение роли админа
        $admin->assignRole('admin');
    }
}
