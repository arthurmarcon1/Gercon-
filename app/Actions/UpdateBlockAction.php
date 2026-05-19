<?php

namespace App\Actions;

use App\Models\Block;

class UpdateBlockAction
{
    public function handle(Block $block, array $data): Block
    {
        $block->update(['name' => $data['name']]);

        return $block;
    }
}
