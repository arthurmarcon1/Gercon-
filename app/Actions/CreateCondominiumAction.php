<?php

namespace App\Actions;

use App\Models\Condominium;

class CreateCondominiumAction
{
    public function handle(array $data): Condominium
    {
        return Condominium::create([
            'name'     => $data['name'],
            'address'  => $data['address'],
            'document' => $data['document'] ?? null,
            'active'   => $data['active'] ?? true,
        ]);
    }
}
