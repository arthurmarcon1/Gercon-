<?php

namespace App\Actions;

use App\Models\Condominium;
use App\Models\Unit;

class CreateUnitAction
{
    public function handle(Condominium $condominium, array $data): Unit
    {
        return $condominium->units()->create([
            'block_id' => $data['block_id'] ?? null,
            'number'   => $data['number'],
            'type'     => $data['type'] ?? null,
            'floor'    => $data['floor'] ?? null,
        ]);
    }
}
