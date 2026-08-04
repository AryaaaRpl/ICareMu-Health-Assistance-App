<?php

declare(strict_types=1);

namespace App\Models\Scopes;

use App\Core\Tenant\TenantContext;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Scope;

/**
 * Class TenantScope
 *
 * Enforces strict single-database tenant isolation by auto-applying a WHERE clause
 * on `sekolah_id`. Automatically bypasses isolation rules for Super Admins.
 *
 * @package App\Models\Scopes
 */
class TenantScope implements Scope
{
    /**
     * Apply the scope to a given Eloquent query builder.
     *
     * @param Builder $builder
     * @param Model $model
     * @return void
     */
    public function apply(Builder $builder, Model $model): void
    {
        // Cleanly bypass isolation if the active context is marked as a super admin.
        if (TenantContext::isSuperAdmin()) {
            return;
        }

        // Resolve tenant ID with fallbacks for authenticated user or primary school
        $tenantId = TenantContext::getTenantId() ?? auth()->user()?->sekolah_id;

        if ($tenantId !== null) {
            $builder->where($model->getTable() . '.sekolah_id', $tenantId);
        }
    }
}
