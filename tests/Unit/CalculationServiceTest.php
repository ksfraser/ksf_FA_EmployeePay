<?php
/**
 * @BABOK Related: FR-EP-001-002
 * @BABOK Related: UT-EP-001-002-001
 */
namespace ksfraser\FrontAccounting\EmployeePay\Tests\Unit;

use PHPUnit\Framework\TestCase;

class CalculationServiceTest extends TestCase
{
    public function testCalculateEntryReturnsPositiveNet(): void
    {
        $service = new \ksfraser\FrontAccounting\EmployeePay\Service\CalculationService();
        $result = $service->calculateEntry(
            ['regular' => 80, 'overtime' => 5, 'vacation' => 8, 'holiday' => 8],
            25.00
        );
        $this->assertArrayHasKey('gross_earnings', $result);
        $this->assertGreaterThan(0, $result['gross_earnings']);
        $this->assertArrayHasKey('net_pay', $result);
        $this->assertGreaterThanOrEqual(0, $result['net_pay']);
    }
}
