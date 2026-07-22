<?php

declare(strict_types=1);

namespace Tests\Unit;

use App\Actions\Medical\CalculateImtAction;
use PHPUnit\Framework\TestCase;

class CalculateImtActionTest extends TestCase
{
    public function test_it_calculates_normal_imt_correctly(): void
    {
        $action = new CalculateImtAction();
        $result = $action->execute(170, 65);

        $this->assertEquals(22.49, $result['imt']);
        $this->assertEquals('Normal', $result['status_risiko']);
    }

    public function test_it_identifies_overweight_status(): void
    {
        $action = new CalculateImtAction();
        $result = $action->execute(160, 68);

        $this->assertEquals(26.56, $result['imt']);
        $this->assertEquals('Gemuk (Overweight)', $result['status_risiko']);
    }
}
