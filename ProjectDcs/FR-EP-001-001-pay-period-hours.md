# FR-EP-001-001-pay-period-hours.md

**Module:** EP  
**Related:** BR-EP-001  
**Status:** Implemented  

## Requirement (Updated)
Admin UI must allow setting:
- Normal hours per pay period (`hours_per_pay_period`, default 80 for bi-weekly)
- Mode: `incoming` (we are the employee) or `outgoing` (HRM calculates pay)
- Sections: unlimited, editable, pre-seeded (Income 1, Pension/RSP 2, Tax Deductions 3, Other Deductions 4, Net Pay 5)
- Pay element categories: earning (`G01`, `O01`, `V01`, `H01`, `ALLOW`, `BONUS`, `COMM`, `REIMB`, `I00-I99`), deduction (`CPP`, `EI`, `TAX`, `RRSP`, `GRSP`, `INS`, `MED`, `LOAN`), employer contribution (`DPSP`)

## Traceability
- `pages/settings.php`
- `pages/statutory.php`
- `pages/tax_brackets.php`
- `pages/sections.php`
- `sql/install.sql` (`0_ksf_employeepay_settings`, `0_ksf_employeepay_sections`, `0_ksf_employeepay_section_items`)
- `src/Config/EmployeePayConfig.php`
