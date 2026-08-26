<?php
/**
 * @BABOK Related: FR-EP-001-001
 * @BABOK Related: UT-EP-001-001-001
 */
namespace ksfraser\FrontAccounting\EmployeePay\Tests\Unit;

use PHPUnit\Framework\TestCase;
use ksfraser\FrontAccounting\EmployeePay\Config\EmployeePayConfig;

class EmployeePayConfigTest extends TestCase
{
    public function testGetSettingsReturnsDefaults(): void
    {
        $config = new EmployeePayConfig();
        $settings = $config->getSettings();
        $this->assertArrayHasKey('hours_per_pay_period', $settings);
        $this->assertArrayHasKey('mode', $settings);
    }
}
