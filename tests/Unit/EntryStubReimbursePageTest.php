<?php
/**
 * @BABOK Related: UC-EP-001, UC-EP-006
 */
namespace ksfraser\FrontAccounting\EmployeePay\Tests\Unit;

use PHPUnit\Framework\TestCase;

class EntryStubReimbursePageTest extends TestCase
{
    public function testPagesExist(): void
    {
        $pages = ['entry.php', 'stubs.php', 'reimburse.php', 'statutory.php', 'tax_brackets.php', 'sections.php', 'settings.php'];
        foreach ($pages as $p) {
            $this->assertFileExists(__DIR__ . '/../../pages/' . $p, "Page missing: $p");
        }
    }
}
