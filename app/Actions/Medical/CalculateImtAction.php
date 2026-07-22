<?php

declare(strict_types=1);

namespace App\Actions\Medical;

class CalculateImtAction
{
    /**
     * Calculate Body Mass Index (IMT) and determine risk category.
     *
     * @param float $heightCm Height in centimeters
     * @param float $weightKg Weight in kilograms
     * @return array{imt: float, status_risiko: string}
     */
    public function execute(float $heightCm, float $weightKg): array
    {
        $heightMeters = $heightCm / 100;
        if ($heightMeters <= 0) {
            return ['imt' => 0.0, 'status_risiko' => 'invalid'];
        }

        $imt = round($weightKg / ($heightMeters * $heightMeters), 2);

        $status = match (true) {
            $imt < 17.0 => 'Sangat Kurus',
            $imt >= 17.0 && $imt < 18.5 => 'Kurus',
            $imt >= 18.5 && $imt <= 25.0 => 'Normal',
            $imt > 25.0 && $imt <= 27.0 => 'Gemuk (Overweight)',
            default => 'Obesitas',
        };

        return [
            'imt' => $imt,
            'status_risiko' => $status,
        ];
    }
}
