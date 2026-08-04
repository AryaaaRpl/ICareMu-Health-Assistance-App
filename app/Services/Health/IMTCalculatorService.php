<?php

declare(strict_types=1);

namespace App\Services\Health;

/**
 * Class IMTCalculatorService
 *
 * Calculates the Index Massa Tubuh (IMT / BMI) and determines the risk status
 * based on the Indonesian Ministry of Health (Kemenkes RI) guidelines.
 *
 * @package App\Services\Health
 */
class IMTCalculatorService
{
    /**
     * Calculate IMT score and determine Indonesian Kemenkes risk status.
     *
     * @param float $beratBadanKg
     * @param float $tinggiBadanCm
     * @return array{imt_score: float, status_risiko: string}
     */
    public function calculate(float $beratBadanKg, float $tinggiBadanCm): array
    {
        // Prevent division by zero.
        if ($tinggiBadanCm <= 0.0) {
            return [
                'imt_score' => 0.0,
                'status_risiko' => 'Kurus',
            ];
        }

        // Convert height to meters.
        $tinggiMeters = $tinggiBadanCm / 100.0;

        // Calculate score (weight / height^2).
        $score = $beratBadanKg / ($tinggiMeters * $tinggiMeters);
        $scoreRounded = round($score, 2);

        // Determine Indonesian Ministry of Health (Kemenkes) risk status.
        if ($scoreRounded < 18.5) {
            $status = 'Kurus';
        } elseif ($scoreRounded <= 25.0) {
            $status = 'Normal';
        } elseif ($scoreRounded <= 27.0) {
            $status = 'Gemuk';
        } else {
            $status = 'Obesitas';
        }

        return [
            'imt_score' => $scoreRounded,
            'status_risiko' => $status,
        ];
    }
}
