<?php

declare(strict_types=1);

namespace App\Core\Tenant;

class TenantContext
{
    private static ?int $sekolahId = null;
    private static bool $isSuperAdmin = false;

    public static function setTenantId(?int $id): void
    {
        self::$sekolahId = $id;
    }

    public static function getTenantId(): ?int
    {
        return self::$sekolahId;
    }

    public static function setSuperAdmin(bool $status): void
    {
        self::$isSuperAdmin = $status;
    }

    public static function isSuperAdmin(): bool
    {
        return self::$isSuperAdmin;
    }

    public static function clear(): void
    {
        self::$sekolahId = null;
        self::$isSuperAdmin = false;
    }
}
