<?php

namespace App\Scopes;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Scope;

/**
 * Global scope that automatically limits queries to the current tenant (organization_id)
 * Resolution order:
 *  - `TenantManager::getOrganizationId()` (centralized resolver)
 *  - `auth()->user()->organization_id` if available
 *  - Request header `X-Organization-Id`
 * If no organization id is resolvable, the scope is not applied (useful for console/global admin ops).
 */
class TenantScope implements Scope
{
    public function apply(Builder $builder, Model $model)
    {
        $orgId = \App\Services\TenantManager::getOrganizationId();

        if ($orgId) {
            $builder->where($model->getTable().'.organization_id', $orgId);
        }
    }

    // Optionally allow removing the scope by name
    public function extend(Builder $builder)
    {
        $builder->macro('withoutTenant', function (Builder $b) {
            return $b->withoutGlobalScope($this);
        });
    }
}
