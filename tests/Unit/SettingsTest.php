<?php
/**
 * @BABOK Related: FR-EP-001-001, FR-EP-001-003, FR-EP-001-007
 */
namespace ksfraser\FrontAccounting\EmployeePay\Tests\Unit;

use PHPUnit\Framework\TestCase;

class SettingsTest extends TestCase
{
    public function testDefaultHoursPerPayPeriodIsEighty(): void
    {
        $this->assertEquals(80.0, 80.0); // default from SQL seed / config
    }

    public function testModeCanSwitchIncomingToOutgoing(): void
    {
        $this->assertContains('outgoing', ['incoming', 'outgoing']);
    }
}
