<?php

declare(strict_types=1);

namespace App\Core\Tenant;

/**
 * Class TenantContext
 *
 * A thread-safe static/singleton context manager storing the active tenant scope state
 * (sekolah_id) and super admin bypass flags for the lifecycle of a request.
 *
 * @package App\Core\Tenant
 */
final class TenantContext
{
    /**
     * The active tenant ID (sekolah_id).
     *
     * @var int|null
     */
    private static ?int $tenantId = null;

    /**
     * Flag indicating if the current context is authorized to bypass tenant isolation.
     *
     * @var bool
     */
    private static bool $isSuperAdmin = false;

    /**
     * Prevent instantiation.
     */
    private function __construct()
    {
    }

    /**
     * Set the active tenant ID.
     *
     * @param int|null $id
     * @return void
     */
    public static function setTenantId(?int $id): void
    {
        self::$tenantId = $id;
    }

    /**
     * Get the active tenant ID.
     *
     * @return int|null
     */
    public static function getTenantId(): ?int
    {
        return self::$tenantId;
    }

    /**
     * Set the super admin bypass status.
     *
     * @param bool $status
     * @return void
     */
    public static function setSuperAdmin(bool $status): void
    {
        self::$isSuperAdmin = $status;
    }

    /**
     * Determine if the current context is a super admin.
     *
     * @return bool
     */
    public static function isSuperAdmin(): bool
    {
        return self::$isSuperAdmin;
    }

    /**
     * Reset the tenant context state.
     * Useful for clean states in long-running processes (Octane, tests).
     *
     * @return void
     */
    public static function reset(): void
    {
        self::$tenantId = null;
        self::$isSuperAdmin = false;
    }
}
