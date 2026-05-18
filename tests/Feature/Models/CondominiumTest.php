<?php

use App\Models\Condominium;
use App\Models\Tenant;
use App\Services\TenantManager;

it('creates a condominium with uuid primary key', function () {
    $condominium = Condominium::factory()->create();

    expect($condominium->id)->toBeString()
        ->and(strlen($condominium->id))->toBe(36);
});

it('casts address as array', function () {
    $condominium = Condominium::factory()->create([
        'address' => ['street' => 'Rua das Flores', 'city' => 'São Paulo'],
    ]);

    expect($condominium->fresh()->address)->toBeArray()
        ->and($condominium->fresh()->address['city'])->toBe('São Paulo');
});

it('belongs to a tenant', function () {
    $tenant = Tenant::factory()->create();
    $condominium = Condominium::factory()->create(['tenant_id' => $tenant->id]);

    expect($condominium->tenant->id)->toBe($tenant->id);
});

it('is automatically scoped to current tenant', function () {
    $tenantA = Tenant::factory()->create();
    $tenantB = Tenant::factory()->create();

    Condominium::factory()->create(['tenant_id' => $tenantA->id]);
    Condominium::factory()->create(['tenant_id' => $tenantB->id]);

    app(TenantManager::class)->set($tenantA);

    expect(Condominium::count())->toBe(1);
});

it('fills tenant_id automatically on create when tenant is set', function () {
    $tenant = Tenant::factory()->create();
    app(TenantManager::class)->set($tenant);

    $condominium = Condominium::factory()->create(['tenant_id' => null]);

    expect($condominium->tenant_id)->toBe($tenant->id);
});
