# Design — ksf_FA_EmployeePay

## Module: EP (Employee Pay)

## Scope
- Calculate wage pay for Canadian employees.
- Both incoming (employee receives) and outgoing (HRM calculates) modes.
- Dynamic statutory deductions per pay period (CPP, EI, Tax) based on current earnings and annual projection.
- GL posting per mode.

## Capability Completeness (independent of NotrinosERP)
- Pay element categories: Basic, Allowance, Deduction, Employer Contribution, Statutory Deduction, Bonus, Reimbursement.
- Formula engine for earnings/deductions.
- Progressive tax brackets with floor/ceiling.
- Attendance-based calculations.
- Grade/pay rate lookup (reference `0_hrm_grades`, `0_hrm_work_assignments`, `0_hrm_pay_elements`).
- GL posting via FA GL abstraction (`0_gl_trans` references).

## Architecture
```
Entry (pages/entry.php) → Config (EmployeePayConfig) → Service (EmployeePayCalculationService) → Repository (EmployeePayRepository)

CalculationService uses:
- PayScaleService (reads grades/positions/hourly_rate)
- DeductionService (CPP/EI/Tax, RRSP/GRSP, Insurance/Medical)
- ReimbursementService (expense reimbursement)
```

## Data Model (0_ prefix, no `TB_PREF` dependency for own tables; use `TB_PREF` for HRM references)
- `0_ksf_employeepay_settings` (mode, hours_per_pay)
- `0_ksf_employeepay_pay_elements` (categories, codes)
- `0_ksf_employeepay_entries` (line items with category reference)
- `0_ksf_employeepay_calculations` (calculation audit/results)
- `0_ksf_employeepay_sections` (pay stub grouping: Income 1, Pension/RSP 2, Tax 3, Other 4, Net 5)
- `0_ksf_employeepay_section_items` (maps `element_code` to sections; editable; unlimited sections)
