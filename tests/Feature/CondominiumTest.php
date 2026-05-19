<?php

use App\Models\Condominium;
use App\Models\Tenant;
use App\Models\User;
use App\Services\TenantManager;

beforeEach(function () {
    $this->tenant = Tenant::factory()->create();
    $this->user = User::factory()->create();
    $this->tenant->users()->attach($this->user);
    app(TenantManager::class)->set($this->tenant);
});

it('lists condominiums for authenticated user', function () {
    Condominium::factory()->count(3)->create(['tenant_id' => $this->tenant->id]);

    $this->actingAs($this->user)
        ->get(route('condominiums.index'))
        ->assertOk()
        ->assertInertia(fn ($page) => $page
            ->component('Condominiums/Index')
            ->has('condominiums.data', 3)
        );
});

it('redirects guests away from condominiums', function () {
    $this->get(route('condominiums.index'))
        ->assertRedirect(route('login'));
});

it('renders create form', function () {
    $this->actingAs($this->user)
        ->get(route('condominiums.create'))
        ->assertOk()
        ->assertInertia(fn ($page) => $page->component('Condominiums/Create'));
});

it('creates a condominium with valid data', function () {
    $this->actingAs($this->user)
        ->post(route('condominiums.store'), [
            'name' => 'Residencial das Flores',
            'address' => [
                'street' => 'Rua das Flores',
                'number' => '100',
                'city'   => 'São Paulo',
                'state'  => 'SP',
                'zip'    => '01310-100',
            ],
            'document' => null,
            'active'   => true,
        ])
        ->assertRedirect(route('condominiums.index'));

    expect(Condominium::where('name', 'Residencial das Flores')->exists())->toBeTrue();
});

it('validates required fields on store', function () {
    $this->actingAs($this->user)
        ->post(route('condominiums.store'), [])
        ->assertSessionHasErrors(['name', 'address.street', 'address.city']);
});

it('renders edit form with condominium data', function () {
    $condominium = Condominium::factory()->create(['tenant_id' => $this->tenant->id]);

    $this->actingAs($this->user)
        ->get(route('condominiums.edit', $condominium))
        ->assertOk()
        ->assertInertia(fn ($page) => $page
            ->component('Condominiums/Edit')
            ->has('condominium')
        );
});

it('updates a condominium', function () {
    $condominium = Condominium::factory()->create(['tenant_id' => $this->tenant->id]);

    $this->actingAs($this->user)
        ->patch(route('condominiums.update', $condominium), [
            'name' => 'Nome Atualizado',
            'address' => [
                'street' => 'Av. Paulista',
                'number' => '1000',
                'city'   => 'São Paulo',
                'state'  => 'SP',
                'zip'    => '01310-100',
            ],
            'document' => null,
            'active'   => true,
        ])
        ->assertRedirect(route('condominiums.index'));

    expect($condominium->fresh()->name)->toBe('Nome Atualizado');
});

it('deletes a condominium', function () {
    $condominium = Condominium::factory()->create(['tenant_id' => $this->tenant->id]);

    $this->actingAs($this->user)
        ->delete(route('condominiums.destroy', $condominium))
        ->assertRedirect(route('condominiums.index'));

    expect(Condominium::find($condominium->id))->toBeNull();
});

it('cannot access condominiums from another tenant', function () {
    $otherTenant = Tenant::factory()->create();
    $condominium = Condominium::factory()->create(['tenant_id' => $otherTenant->id]);

    $this->actingAs($this->user)
        ->get(route('condominiums.edit', $condominium))
        ->assertStatus(404);
});
