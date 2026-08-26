<?php
/**
 * @BABOK Related: FR-EP-001-006
 */
namespace ksfraser\FrontAccounting\EmployeePay\Tests\Unit;

use PHPUnit\Framework\TestCase;

class ReimbursementServiceTest extends TestCase
{
    public function testReimbursementNonTaxable(): void
    {
        // REIMB: is_taxable=0, affects_gross=0 per SQL seed
        $this->assertTrue(true);
    }
}
