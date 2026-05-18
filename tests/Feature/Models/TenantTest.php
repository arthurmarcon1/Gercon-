<?php

use App\Models\Tenant;
use App\Models\User;

it('creates a tenant with correct attributes', function () {
    $tenant = Tenant::factory()->create([
        'name' => 'Gercon Administradora',
        'slug' => 'gercon',
        'active' => true,
    ]);

    expect($tenant->name)->toBe('Gercon Administradora')
        ->and($tenant->slug)->toBe('gercon')
        ->and($tenant->active)->toBeTrue();
});

it('casts active as boolean', function () {
    $tenant = Tenant::factory()->create();

    expect($tenant->active)->toBeBool();
});

it('can be marked inactive', function () {
    $tenant = Tenant::factory()->inactive()->create();

    expect($tenant->active)->toBeFalse();
});

it('has unique slug', function () {
    Tenant::factory()->create(['slug' => 'gercon']);

    expect(fn () => Tenant::factory()->create(['slug' => 'gercon']))
        ->toThrow(\Illuminate\Database\QueryException::class);
});

it('has a users relationship', function () {
    $tenant = Tenant::factory()->create();
    $user = User::factory()->create();

    $tenant->users()->attach($user);

    expect($tenant->users)->toHaveCount(1)
        ->and($tenant->users->first()->id)->toBe($user->id);
});
