<?php

declare(strict_types=1);

namespace App\Actions;

class CalculateImtAction
{
    /**
     * Calculate IMT score and status risks.
     *
     * @param float|int $heightCm
     * @param float|int $weightKg
     * @return array{imt: float, status_risiko: string}
     */
    public function execute(float|int $heightCm, float|int $weightKg): array
    {
        if ($heightCm <= 0 || $weightKg <= 0) {
            return [
                'imt' => 0.0,
                'status_risiko' => 'Normal',
            ];
        }

        $heightMeters = $heightCm / 100;
        $imt = $weightKg / ($heightMeters * $heightMeters);
        $imtFormatted = round($imt, 2);

        $status = match (true) {
            $imtFormatted < 18.5 => 'Kurang (Underweight)',
            $imtFormatted <= 24.9 => 'Normal',
            $imtFormatted <= 29.9 => 'Gemuk (Overweight)',
            default => 'Obesitas',
        };

        return [
            'imt' => $imtFormatted,
            'status_risiko' => $status,
        ];
    }
}
