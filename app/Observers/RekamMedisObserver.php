<?php

declare(strict_types=1);

namespace App\Observers;

use App\Models\RekamMedis;
use DomainException;

class RekamMedisObserver
{
    public function updating(RekamMedis $rekamMedis): void
    {
        if ($rekamMedis->getOriginal('status_verifikasi') === 'verified') {
            throw new DomainException('Rekam medis yang sudah diverifikasi tidak dapat diubah (Immutable).');
        }
    }

    public function deleting(RekamMedis $rekamMedis): void
    {
        if ($rekamMedis->getOriginal('status_verifikasi') === 'verified') {
            throw new DomainException('Rekam medis yang sudah diverifikasi tidak dapat dihapus (Immutable).');
        }
    }
}
