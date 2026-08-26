# FR-EP-001-003-pay-element-categories.md

**Module:** EP  
**Related:** BR-EP-001  
**Status:** Implemented

## Requirement
Module defines pay element categories: `earning` (G01/O01/V01/H01/ALLOW/BONUS/COMM/REIMB/I00-I99), `deduction` (CPP/EI/TAX/RRSP/GRSP/INS/MED/LOAN), `statutory` (CPP/EI/TAX), `employer_contrib` (DPSP), `reimbursement` (REIMB). Each has `calculation_type`: `fixed`, `percent_basic`, `percent_gross`, `formula`, `attendance`. Admin screen shows these categories.

## Traceability
- `sql/install.sql` (`0_ksf_employeepay_pay_elements`)
- `pages/settings.php` (reference)
