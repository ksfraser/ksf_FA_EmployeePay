# FR-EP-001-006-reimbursements.md

**Module:** EP  
**Related:** BR-EP-001  
**Status:** Implemented

## Requirement
Expense reimbursement section (`REIMB`) — fixed amount, non-taxable (`is_taxable=0`), does not affect gross (`affects_gross=0`). Page `pages/reimburse.php` provides entry screen.

## Traceability
- `sql/install.sql` (`REIMB` seed in `0_ksf_employeepay_pay_elements`)
- `pages/reimburse.php`
