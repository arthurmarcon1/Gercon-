<?php

namespace App\Actions;

use App\Models\Unit;

class UpdateUnitAction
{
    public function handle(Unit $unit, array $data): Unit
    {
        $unit->update([
            'block_id' => $data['block_id'] ?? null,
            'number'   => $data['number'],
            'type'     => $data['type'] ?? null,
            'floor'    => $data['floor'] ?? null,
        ]);

        return $unit;
    }
}
