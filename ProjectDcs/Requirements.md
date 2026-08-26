# Requirements — ksf_FA_EmployeePay (Notrinos-independent)

## Capabilities (must match or exceed NotrinosERP payroll without dependency)

### Earnings
- Basic Salary (`G01`) — from grade/hourly rate or position
- Overtime (`O01`) — 1.5x rate for hours > normal (e.g., 80/hr pay period)
- Vacation (`V01`) — rate * vacation hours
- Holiday (`H01`) — rate * holiday hours
- Allowance — fixed or % basic
- Bonus — fixed or % gross
- Commission — linked to orders (reference HRM `0_hrm_commission_entries`)
- Incentives (`I00-I99`) — fixed rate * unit (e.g., 2x $3 per booking) or % of annual/salary

### Sections (Pay Stub Grouping — unlimited, editable)
| Order | Section | Type | Example Codes |
|---|---|---|---|
| 1 | Income | earnings | G01, O01, V01, H01, ALLOW, BONUS, COMM, I00-I99 |
| 2 | Pension / RSP | deductions | RRSP, GRSP |
| 3 | Tax Deductions | deductions | CPP, EI, TAX |
| 4 | Other Deductions | deductions | INS, MED, LOAN |
| 5 | Net Pay | net | Calculated result (not a pay element) |

### Deductions
- Statutory Deduction (`STAT`): CPP, EI (employee + employer amounts, floor/ceiling, base=basic/gross)
- Income Tax (`TAX`): progressive brackets (`tax_brackets` table: from/to, rate, fixed amount, effective dates)
- RRSP/GRSP (`PRE_TAX` deduction — pre-tax)
- DPSP (`ACCRUAL` — employer contribution accrual until vested)
- Insurance (`INS`) / Medical (`MED`)
- Loan Repayment (`LOAN` — reference `0_hrm_loan` if available)
- Attendance Deduction (`ATT`) — based on absence days, configurable rules

### Contributions / Employer
- Employer CPP/EI (calculated separately, not deducted from net)
- Employer RRSP match (optional)

### GL Recording
- Per mode (`incoming` vs `outgoing`): GL accounts mapped per pay element (`gl_account_code` in `0_hrm_pay_elements` or module settings)
- Incoming: Salary Expense (Debit) → Payable Liability (Credit)
- Outgoing (HRM): Employee Payable (Debit) → Cash/Bank (Credit) or Salary Expense per department

### Calculation Rules
- Dynamic per pay period: project annual earnings based on current rate/hours to determine CPP/EI/Tax impact.
- Annual projection: `current_earnings * (annual_hours / pay_period_hours)` to check if CPP basic exemption / EI max is exceeded.
- Initial limits: CPP basic exemption applies to first pay period; EI applies to every period until max.

### Platform / Constraints (Updated per clarifications)
- PHP 7.3, FA 2.4.19
- Namespace `ksfraser\FrontAccounting\EmployeePay\`
- DB prefix `0_ksf_employeepay_`
- NotrinosERP (competing FA fork) will NOT be installed; module fully independent
- Composer dependencies via `ComposerDependencies::ensure()` (Calendar module pattern)
- Sections (`0_ksf_employeepay_sections`) and items (`0_ksf_employeepay_section_items`) editable via admin (`pages/sections.php`)
- Incentive codes (`I00-I99`) use fixed rate * unit or percentage
