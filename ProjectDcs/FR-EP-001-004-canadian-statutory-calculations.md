# FR-EP-001-004-canadian-statutory-calculations.md

**Module:** EP  
**Related:** BR-EP-001  
**Status:** Implemented

## Requirement
Canadian statutory deductions (CPP, EI, Tax) calculated dynamically per pay period with progressive tax brackets (`0_ksf_employeepay_tax_brackets`), floor/ceiling (`0_ksf_employeepay_statutory`), and annual projection (`0_ksf_employeepay_calculations`). Independent of NotrinosERP.

## Traceability
- `sql/install.sql` (`0_ksf_employeepay_statutory`, `0_ksf_employeepay_tax_brackets`, `0_ksf_employeepay_calculations`)
- `pages/statutory.php`, `pages/tax_brackets.php`
- `src/Service/DeductionService.php`
- `tests/Unit/DeductionServiceTest.php`
