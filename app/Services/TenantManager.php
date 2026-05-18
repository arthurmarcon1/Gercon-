<?php

namespace App\Services;

use App\Models\Tenant;

class TenantManager
{
    private ?Tenant $current = null;

    public function set(Tenant $tenant): void
    {
        $this->current = $tenant;
    }

    public function get(): ?Tenant
    {
        return $this->current;
    }

    public function id(): ?int
    {
        return $this->current?->id;
    }

    public function isSet(): bool
    {
        return $this->current !== null;
    }
}
