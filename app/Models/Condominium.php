<?php

namespace App\Models;

use App\Traits\BelongsToTenant;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Condominium extends Model
{
    /** @use HasFactory<\Database\Factories\CondominiumFactory> */
    use HasFactory, HasUuids, BelongsToTenant;

    protected $table = 'condominiums';

    protected $fillable = [
        'tenant_id',
        'name',
        'address',
        'document',
        'active',
    ];

    protected function casts(): array
    {
        return [
            'address' => 'array',
            'active' => 'boolean',
        ];
    }

    public function blocks(): HasMany
    {
        return $this->hasMany(Block::class);
    }

    public function units(): HasMany
    {
        return $this->hasMany(Unit::class);
    }
}
