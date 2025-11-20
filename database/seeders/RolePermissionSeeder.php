<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RolePermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Reset cached roles and permissions
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        // Create permissions
        $permissions = [
            // User Management
            'users.view' => 'View users',
            'users.create' => 'Create users',
            'users.edit' => 'Edit users',
            'users.delete' => 'Delete users',
            'users.restore' => 'Restore users',
            'users.force-delete' => 'Force delete users',
            'users.impersonate' => 'Impersonate users',
            'users.change-password' => 'Change user passwords',

            // Role Management
            'roles.view' => 'View roles',
            'roles.create' => 'Create roles',
            'roles.edit' => 'Edit roles',
            'roles.delete' => 'Delete roles',
            'roles.assign' => 'Assign roles to users',

            // Permission Management
            'permissions.view' => 'View permissions',
            'permissions.assign' => 'Assign permissions',

            // Donation Management
            'donations.view' => 'View donations',
            'donations.create' => 'Create donations',
            'donations.edit' => 'Edit donations',
            'donations.delete' => 'Delete donations',
            'donations.approve' => 'Approve donations',
            'donations.export' => 'Export donations',

            // Project Management
            'projects.view' => 'View projects',
            'projects.create' => 'Create projects',
            'projects.edit' => 'Edit projects',
            'projects.delete' => 'Delete projects',
            'projects.publish' => 'Publish projects',
            'projects.unpublish' => 'Unpublish projects',

            // Category Management
            'categories.view' => 'View categories',
            'categories.create' => 'Create categories',
            'categories.edit' => 'Edit categories',
            'categories.delete' => 'Delete categories',

            // Payment Management
            'payments.view' => 'View payments',
            'payments.edit' => 'Edit payments',
            'payments.refund' => 'Refund payments',
            'payments.export' => 'Export payments',

            // Beneficiary Management
            'beneficiaries.view' => 'View beneficiaries',
            'beneficiaries.create' => 'Create beneficiaries',
            'beneficiaries.edit' => 'Edit beneficiaries',
            'beneficiaries.delete' => 'Delete beneficiaries',

            // Settings Management
            'settings.view' => 'View settings',
            'settings.edit' => 'Edit settings',

            // Audit Logs
            'audit-logs.view' => 'View audit logs',
            'audit-logs.export' => 'Export audit logs',

            // Statistics & Reports
            'statistics.view' => 'View statistics',
            'reports.view' => 'View reports',
            'reports.export' => 'Export reports',

            // Page Management
            'pages.view' => 'View pages',
            'pages.create' => 'Create pages',
            'pages.edit' => 'Edit pages',
            'pages.delete' => 'Delete pages',
            'pages.publish' => 'Publish pages',
        ];

        // Create permissions
        foreach ($permissions as $name => $description) {
            Permission::firstOrCreate(
                ['name' => $name],
                ['guard_name' => 'web']
            );
        }

        // Create roles and assign permissions
        $roles = [
            'admin' => [
                'description' => 'Full system administrator with all permissions',
                'permissions' => array_keys($permissions), // All permissions
            ],
            'manager' => [
                'description' => 'Manager with most permissions except system settings and user management',
                'permissions' => [
                    'donations.view', 'donations.create', 'donations.edit', 'donations.approve', 'donations.export',
                    'projects.view', 'projects.create', 'projects.edit', 'projects.publish', 'projects.unpublish',
                    'categories.view', 'categories.create', 'categories.edit', 'categories.delete',
                    'payments.view', 'payments.edit', 'payments.export',
                    'beneficiaries.view', 'beneficiaries.create', 'beneficiaries.edit', 'beneficiaries.delete',
                    'audit-logs.view',
                    'statistics.view', 'reports.view', 'reports.export',
                    'pages.view', 'pages.create', 'pages.edit', 'pages.publish',
                    'users.view', 'users.edit',
                ],
            ],
            'editor' => [
                'description' => 'Content editor with project and page management permissions',
                'permissions' => [
                    'donations.view',
                    'projects.view', 'projects.create', 'projects.edit',
                    'categories.view', 'categories.create', 'categories.edit',
                    'beneficiaries.view', 'beneficiaries.create', 'beneficiaries.edit',
                    'pages.view', 'pages.create', 'pages.edit',
                    'statistics.view', 'reports.view',
                ],
            ],
            'viewer' => [
                'description' => 'Read-only access to most content',
                'permissions' => [
                    'donations.view',
                    'projects.view',
                    'categories.view',
                    'payments.view',
                    'beneficiaries.view',
                    'pages.view',
                    'statistics.view',
                    'reports.view',
                ],
            ],
            'donor' => [
                'description' => 'Regular donor with limited access',
                'permissions' => [
                    'donations.view',
                    'projects.view',
                ],
            ],
        ];

        foreach ($roles as $roleName => $roleData) {
            // Create or update the role
            $role = Role::firstOrCreate(
                ['name' => $roleName],
                ['guard_name' => 'web']
            );

            // Sync permissions
            $rolePermissions = Permission::whereIn('name', $roleData['permissions'])->get();
            $role->syncPermissions($rolePermissions);

            $this->command->info("✅ Role '$roleName' created with " . count($roleData['permissions']) . " permissions");
        }

        $this->command->info('🛡️  Roles and permissions seeded successfully!');
    }
}