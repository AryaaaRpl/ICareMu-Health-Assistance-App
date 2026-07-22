<?php

namespace Tests\Unit;

use App\Actions\CheckAmenoreEarlyWarningAction;
use Carbon\Carbon;
use PHPUnit\Framework\TestCase;

class CheckAmenoreEarlyWarningActionTest extends TestCase
{
    public function test_it_returns_normal_when_period_date_is_recent(): void
    {
        $action = new CheckAmenoreEarlyWarningAction();
        $result = $action->execute(Carbon::now()->subDays(14)->toDateString());

        $this->assertFalse($result['has_warning']);
        $this->assertEquals('Siklus Normal', $result['status']);
    }

    public function test_it_triggers_early_warning_when_period_overdue_90_days(): void
    {
        $action = new CheckAmenoreEarlyWarningAction();
        $result = $action->execute(Carbon::now()->subDays(95)->toDateString());

        $this->assertTrue($result['has_warning']);
        $this->assertStringContainsString('Amenore', $result['status']);
    }
}
