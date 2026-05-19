<?php

namespace App\Actions;

use App\Models\Block;
use App\Models\Condominium;

class CreateBlockAction
{
    public function handle(Condominium $condominium, array $data): Block
    {
        return $condominium->blocks()->create([
            'name' => $data['name'],
        ]);
    }
}
