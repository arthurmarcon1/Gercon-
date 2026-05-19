<?php

namespace App\Actions;

use App\Models\Condominium;

class UpdateCondominiumAction
{
    public function handle(Condominium $condominium, array $data): Condominium
    {
        $condominium->update([
            'name'     => $data['name'],
            'address'  => $data['address'],
            'document' => $data['document'] ?? null,
            'active'   => $data['active'] ?? true,
        ]);

        return $condominium;
    }
}
