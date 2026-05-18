<?php

namespace App\Http\Middleware;

use App\Models\Tenant;
use App\Services\TenantManager;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class SetCurrentTenant
{
    public function __construct(private TenantManager $tenantManager) {}

    public function handle(Request $request, Closure $next): Response
    {
        if (app()->environment('testing', 'local')) {
            return $next($request);
        }

        $host = $request->getHost();
        $slug = explode('.', $host)[0];

        $tenant = Tenant::where('slug', $slug)->where('active', true)->first();

        if (! $tenant) {
            abort(404);
        }

        $this->tenantManager->set($tenant);
        setPermissionsTeamId($tenant->id);

        return $next($request);
    }
}
