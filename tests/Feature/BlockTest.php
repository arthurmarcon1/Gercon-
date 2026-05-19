<?php

use App\Models\Block;
use App\Models\Condominium;
use App\Models\Tenant;
use App\Models\User;
use App\Services\TenantManager;

beforeEach(function () {
    $this->tenant = Tenant::factory()->create();
    $this->user = User::factory()->create();
    $this->tenant->users()->attach($this->user);
    app(TenantManager::class)->set($this->tenant);
    $this->condominium = Condominium::factory()->create(['tenant_id' => $this->tenant->id]);
});

it('renders create block form', function () {
    $this->actingAs($this->user)
        ->get(route('condominiums.blocks.create', $this->condominium))
        ->assertOk()
        ->assertInertia(fn ($page) => $page->component('Blocks/Create'));
});

it('creates a block', function () {
    $this->actingAs($this->user)
        ->post(route('condominiums.blocks.store', $this->condominium), ['name' => 'Bloco A'])
        ->assertRedirect(route('condominiums.show', $this->condominium));

    expect($this->condominium->blocks()->where('name', 'Bloco A')->exists())->toBeTrue();
});

it('validates block name is required', function () {
    $this->actingAs($this->user)
        ->post(route('condominiums.blocks.store', $this->condominium), [])
        ->assertSessionHasErrors('name');
});

it('renders edit block form', function () {
    $block = Block::factory()->create(['condominium_id' => $this->condominium->id]);

    $this->actingAs($this->user)
        ->get(route('blocks.edit', $block))
        ->assertOk()
        ->assertInertia(fn ($page) => $page->component('Blocks/Edit'));
});

it('updates a block', function () {
    $block = Block::factory()->create(['condominium_id' => $this->condominium->id]);

    $this->actingAs($this->user)
        ->patch(route('blocks.update', $block), ['name' => 'Bloco B'])
        ->assertRedirect(route('condominiums.show', $this->condominium->id));

    expect($block->fresh()->name)->toBe('Bloco B');
});

it('deletes a block', function () {
    $block = Block::factory()->create(['condominium_id' => $this->condominium->id]);

    $this->actingAs($this->user)
        ->delete(route('blocks.destroy', $block))
        ->assertRedirect(route('condominiums.show', $this->condominium->id));

    expect(Block::find($block->id))->toBeNull();
});
