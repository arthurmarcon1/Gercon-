<?php

use App\Models\Resident;
use App\Models\Unit;
use App\Models\User;

it('creates a resident without a user account', function () {
    $resident = Resident::factory()->create(['user_id' => null]);

    expect($resident->user_id)->toBeNull()
        ->and($resident->active)->toBeTrue();
});

it('links a resident to a user account', function () {
    $user = User::factory()->create();
    $resident = Resident::factory()->withLogin()->create(['user_id' => $user->id]);

    expect($resident->user->id)->toBe($user->id);
});

it('belongs to a unit', function () {
    $unit = Unit::factory()->create();
    $resident = Resident::factory()->create(['unit_id' => $unit->id]);

    expect($resident->unit->id)->toBe($unit->id);
});

it('nullifies user_id when user is deleted', function () {
    $user = User::factory()->create();
    $resident = Resident::factory()->create(['user_id' => $user->id]);

    $user->delete();

    expect($resident->fresh()->user_id)->toBeNull();
});
