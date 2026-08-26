# UC-EP-006-pay-stubs-created.md

**Module:** EP  
**Related:** FR-EP-001-007

## Actor
Payroll Module / System

## Flow
1. Pay stub generated from `0_ksf_employeepay_entries` + section grouping (`0_ksf_employeepay_sections` + `0_ksf_employeepay_section_items`).
2. Sections rendered in order: Income (1), Pension/RSP (2), Tax Deductions (3), Other Deductions (4), Net Pay (5).
3. Incentive codes (`I00-I99`) shown under Income with description (`unit_description`: per booking, per add-on, % salary).
4. Net Pay calculated and highlighted.
5. Page `pages/stubs.php` lists stubs; `pages/reimburse.php` handles reimbursement details.
