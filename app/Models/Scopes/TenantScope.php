<?php

declare(strict_types=1);

namespace App\Models\Scopes;

use App\Core\Tenant\TenantContext;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Scope;

class TenantScope implements Scope
{
    public function apply(Builder $builder, Model $model): void
    {
        if (TenantContext::isSuperAdmin()) {
            return;
        }

        $tenantId = TenantContext::getTenantId();

        if ($tenantId !== null) {
            $builder->where($model->getTable() . '.sekolah_id', '=', $tenantId);
        }
    }
}
