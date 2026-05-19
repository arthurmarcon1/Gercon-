<?php

namespace Database\Seeders;

use App\Models\Tenant;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    public function run(): void
    {
        $this->call(RoleSeeder::class);

        $tenant = Tenant::factory()->create([
            'name' => 'Gercon Administradora',
            'slug' => 'gercon',
        ]);

        $user = User::factory()->create([
            'name' => 'Admin Gercon',
            'email' => 'admin@gercon.com',
        ]);

        $tenant->users()->attach($user);

        setPermissionsTeamId($tenant->id);
        $user->assignRole('admin');
    }
}
