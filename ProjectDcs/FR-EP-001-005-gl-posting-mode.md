# FR-EP-001-005-gl-posting-mode.md

**Module:** EP  
**Related:** BR-EP-001  
**Status:** Implemented

## Requirement
GL posting per mode (`incoming` vs `outgoing`). `gl_posted` flag on `0_ksf_employeepay_entries`. GL account codes mapped per pay element (`gl_account_code`). Incoming: Salary Expense → Payable Liability. Outgoing: HRM calculates; GL targets differ per mode (reference HRM payroll if available, otherwise module settings).

## Traceability
- `sql/install.sql` (`0_ksf_employeepay_pay_elements.gl_account_code`)
- `pages/settings.php` (`mode` setting)
