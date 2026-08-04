<?php

declare(strict_types=1);

namespace App\Traits;

use App\Core\Tenant\TenantContext;
use App\Models\Scopes\TenantScope;

/**
 * Trait BelongsToTenant
 *
 * Automatically applies tenant isolation scope to models and ensures new records
 * are implicitly linked to the active tenant resolving from TenantContext.
 *
 * @package App\Traits
 */
trait BelongsToTenant
{
    /**
     * Boot the trait. Adds the global TenantScope and intercepts the creating
     * event to bind the active tenant ID dynamically.
     *
     * @return void
     */
    public static function bootBelongsToTenant(): void
    {
        // Auto-apply tenant isolation scope on queries.
        static::addGlobalScope(new TenantScope());

        // Listen to the creating event hook to automatically populate the tenant ID.
        static::creating(static function (self $model): void {
            if ($model->sekolah_id === null) {
                $model->sekolah_id = TenantContext::getTenantId();
            }
        });
    }
}
