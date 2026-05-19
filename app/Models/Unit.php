<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Unit extends Model
{
    /** @use HasFactory<\Database\Factories\UnitFactory> */
    use HasFactory, HasUuids;

    const TYPES = [
        'apartment'  => 'Apartamento',
        'penthouse'  => 'Cobertura',
        'commercial' => 'Comercial',
        'garage'     => 'Garagem',
    ];

    protected $fillable = [
        'condominium_id',
        'block_id',
        'number',
        'type',
        'floor',
    ];

    protected function casts(): array
    {
        return [
            'floor' => 'integer',
        ];
    }

    public function condominium(): BelongsTo
    {
        return $this->belongsTo(Condominium::class);
    }

    public function block(): BelongsTo
    {
        return $this->belongsTo(Block::class);
    }

    public function residents(): HasMany
    {
        return $this->hasMany(Resident::class);
    }
}
