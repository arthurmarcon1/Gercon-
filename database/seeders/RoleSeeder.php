<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class RoleSeeder extends Seeder
{
    public function run(): void
    {
        // Global role — team_id null means it applies across all tenants
        setPermissionsTeamId(null);
        Role::firstOrCreate(['name' => 'super-admin', 'guard_name' => 'web']);

        // Per-tenant roles are created on demand when assigning to a user,
        // but we seed them with a placeholder team_id so they exist in the DB.
        // In practice, setPermissionsTeamId($tenant->id) must be called before
        // assigning these roles to users.
        $tenantRoles = ['admin', 'sindico', 'morador'];

        foreach ($tenantRoles as $role) {
            Role::firstOrCreate(['name' => $role, 'guard_name' => 'web', 'team_id' => null]);
        }
    }
}
