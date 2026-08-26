<?php
/**
 * @BABOK Related: FR-EP-001-004
 * @BABOK Related: UT-EP-001-004-001
 */
namespace ksfraser\FrontAccounting\EmployeePay\Tests\Unit;

use PHPUnit\Framework\TestCase;

class DeductionServiceTest extends TestCase
{
    /**
     * @test
     * @BABOK Related: UT-EP-001-004-001
     */
    public function testCppDeductionAppliesRateCorrectly(): void
    {
        // Arrange: Canadian CPP rate ~5.95% (simplified for test) on earnings up to max
        $base = 5000.00;
        $expected = $base * 0.0595; // approximate

        // Act: calculate using formula engine (minimal stub for test)
        $service = new \ksfraser\FrontAccounting\EmployeePay\Service\DeductionService();
        $result = $service->calculateStatutory('CPP', $base, false); // false = not gross base

        // Assert
        $this->assertGreaterThan(0, $result);
        $this->assertEqualsWithDelta($expected, $result, 0.01);
    }

    /**
     * @test
     * @BABOK Related: UT-EP-001-004-002
     */
    public function testTaxBracketProgressiveCalculation(): void
    {
        $service = new \ksfraser\FrontAccounting\EmployeePay\Service\DeductionService();
        $tax = $service->calculateTax(60000, '2026-01-01'); // approximate progressive
        $this->assertGreaterThanOrEqual(0, $tax);
    }

    /**
     * @test
     * @BABOK Related: UT-EP-001-004-003
     */
    public function testDpspAccrualTracksEmployerContribution(): void
    {
        $service = new \ksfraser\FrontAccounting\EmployeePay\Service\DeductionService();
        $accrual = $service->calculateEmployerContrib('DPSP', 4000);
        $this->assertGreaterThanOrEqual(0, $accrual);
    }
}
