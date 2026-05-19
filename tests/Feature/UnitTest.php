<?php

use App\Models\Block;
use App\Models\Condominium;
use App\Models\Tenant;
use App\Models\Unit;
use App\Models\User;
use App\Services\TenantManager;

beforeEach(function () {
    $this->tenant = Tenant::factory()->create();
    $this->user = User::factory()->create();
    $this->tenant->users()->attach($this->user);
    app(TenantManager::class)->set($this->tenant);
    $this->condominium = Condominium::factory()->create(['tenant_id' => $this->tenant->id]);
});

it('renders create unit form', function () {
    $this->actingAs($this->user)
        ->get(route('condominiums.units.create', $this->condominium))
        ->assertOk()
        ->assertInertia(fn ($page) => $page->component('Units/Create'));
});

it('creates a unit without block', function () {
    $this->actingAs($this->user)
        ->post(route('condominiums.units.store', $this->condominium), [
            'number' => '101',
            'type'   => 'apartment',
            'floor'  => 1,
        ])
        ->assertRedirect(route('condominiums.show', $this->condominium));

    expect($this->condominium->units()->where('number', '101')->exists())->toBeTrue();
});

it('creates a unit with block', function () {
    $block = Block::factory()->create(['condominium_id' => $this->condominium->id]);

    $this->actingAs($this->user)
        ->post(route('condominiums.units.store', $this->condominium), [
            'number'   => '202',
            'type'     => 'apartment',
            'floor'    => 2,
            'block_id' => $block->id,
        ])
        ->assertRedirect(route('condominiums.show', $this->condominium));

    $unit = $this->condominium->units()->where('number', '202')->first();
    expect($unit->block_id)->toBe($block->id);
});

it('validates required fields on unit store', function () {
    $this->actingAs($this->user)
        ->post(route('condominiums.units.store', $this->condominium), [])
        ->assertSessionHasErrors('number');
});

it('renders edit unit form', function () {
    $unit = Unit::factory()->create(['condominium_id' => $this->condominium->id]);

    $this->actingAs($this->user)
        ->get(route('units.edit', $unit))
        ->assertOk()
        ->assertInertia(fn ($page) => $page->component('Units/Edit'));
});

it('updates a unit', function () {
    $unit = Unit::factory()->create(['condominium_id' => $this->condominium->id]);

    $this->actingAs($this->user)
        ->patch(route('units.update', $unit), [
            'number' => '999',
            'type'   => 'penthouse',
            'floor'  => 10,
        ])
        ->assertRedirect(route('condominiums.show', $this->condominium->id));

    expect($unit->fresh()->number)->toBe('999')
        ->and($unit->fresh()->type)->toBe('penthouse');
});

it('deletes a unit', function () {
    $unit = Unit::factory()->create(['condominium_id' => $this->condominium->id]);

    $this->actingAs($this->user)
        ->delete(route('units.destroy', $unit))
        ->assertRedirect(route('condominiums.show', $this->condominium->id));

    expect(Unit::find($unit->id))->toBeNull();
});
