<?php

declare(strict_types=1);

namespace App\Actions;

use Carbon\Carbon;

class CheckAmenoreEarlyWarningAction
{
    /**
     * Determine AI Early Warning status based on last menstrual period date.
     *
     * @param string|\DateTimeInterface|null $lastPeriodDate
     * @return array{has_warning: bool, status: string, description: string, months_overdue: int}
     */
    public function execute(string|\DateTimeInterface|null $lastPeriodDate): array
    {
        if (!$lastPeriodDate) {
            return [
                'has_warning' => false,
                'status' => 'Normal',
                'description' => 'Belum ada data pencatatan menstruasi.',
                'months_overdue' => 0,
            ];
        }

        $lastDate = Carbon::parse($lastPeriodDate);
        $diffInDays = (int) $lastDate->diffInDays(Carbon::now());
        $diffInMonths = (int) floor($diffInDays / 30);

        if ($diffInDays >= 90) {
            return [
                'has_warning' => true,
                'status' => 'Indikasi Amenore (Keterlambatan 3+ Bulan)',
                'description' => sprintf(
                    'Siswa tidak mencatat siklus menstruasi selama %d hari (~%d bulan). Disarankan untuk berkonsultasi dengan petugas UKS atau dokter.',
                    $diffInDays,
                    $diffInMonths
                ),
                'months_overdue' => $diffInMonths,
            ];
        }

        if ($diffInDays > 35) {
            return [
                'has_warning' => false,
                'status' => 'Siklus Terlambat',
                'description' => sprintf('Siklus menstruasi terlambat (%d hari sejak haid terakhir). Tetap pantau kesehatan.', $diffInDays),
                'months_overdue' => 0,
            ];
        }

        return [
            'has_warning' => false,
            'status' => 'Siklus Normal',
            'description' => 'Siklus menstruasi terpantau teratur.',
            'months_overdue' => 0,
        ];
    }
}
