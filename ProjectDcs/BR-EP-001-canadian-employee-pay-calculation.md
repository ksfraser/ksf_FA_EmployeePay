# BR-EP-001-canadian-employee-pay-calculation.md

**Module:** EP (Employee Pay)  
**Status:** Approved  
**Related:** FR-EP-001-001 (pay period settings), FR-EP-001-002 (entry screen), FR-EP-001-003 (pay elements/sections), FR-EP-001-004 (Canadian statutory calculations), FR-EP-001-005 (GL posting per mode), FR-EP-001-006 (reimbursements)

## Requirement (Updated per clarifications)
Calculate Canadian employee wage pay independently of NotrinosERP (competing FA fork; will not be installed). Module must be capability-complete or exceed NotrinosERP payroll capabilities using only `ksf_FA_Common`, peer packages (`famock`, `exceptions`, `ksf-modules-dao`), and optional HRM references (`ksf_FA_HRM` grades/positions/pay elements).

### Earnings
- Regular Time (`G01`), Overtime (`O01` — 1.5x rate), Vacation (`V01`), Holiday (`H01`)
- Allowance (`ALLOW` — fixed or % basic), Bonus (`BONUS` — % gross), Commission (`COMM` — linked to orders)
- Incentives (`I00-I99`) — either fixed rate * unit (e.g., 2x $3 per booking) or percentage of salary / annual salary

### Pay Stub Sections (unlimited, editable; pre-seeded)
| Order | Section Name | Type | Codes (examples) |
|---|---|---|---|
| 1 | Income | earnings | G01, O01, V01, H01, ALLOW, BONUS, COMM, I00-I99 |
| 2 | Pension / RSP | deductions | RRSP, GRSP |
| 3 | Tax Deductions | deductions | CPP, EI, TAX |
| 4 | Other Deductions | deductions | INS, MED, LOAN |
| 5 | Net Pay | net | Calculated result (not a pay element) |

### Canadian Statutory Rules
- CPP (`CPP`) — employee rate ~5.95%, employer rate ~5.95%, basic exemption applies, max annual ceiling tracked (`0_ksf_employeepay_statutory.ceiling_amount`)
- EI (`EI`) — employee rate ~1.66%, employer rate ~2.32%, floor/min tracked (`floor_amount`)
- Tax (`TAX`) — progressive brackets (`0_ksf_employeepay_tax_brackets`: from/to, rate %, fixed amount, effective dates)
- Dynamic per pay period: annual earnings projected (`current_earnings * (annual_hours / pay_period_hours)`) to determine annual CPP/EI/Tax impact; initial limits applied per period.

### Deductions / Contributions
- RRSP (`RRSP`) / GRSP (`GRSP`) — pre-tax deduction (employee portion); employer match optional (`DPSP` — accrual until vested)
- Insurance (`INS`) / Medical (`MED`) — fixed or % based
- Loan Repayment (`LOAN`) — optional link to HRM loans if available

### GL Recording
- Incoming (`mode=incoming`): Salary Expense (Debit) → Payable Liability (Credit); GL account per section/item (`gl_account_code`)
- Outgoing (`mode=outgoing`): HRM calculates employee pay; GL targets different accounts per mode; same calculation engine used

### Mode / Direction
- Incoming: employee receives pay (wage/incentive/comms)
- Outgoing: HRM calculates employee pay for company books; GL targets differ
- Admin setting (`0_ksf_employeepay_settings.mode` and `hours_per_pay_period`)

### Platform Constraints
- PHP 7.3, FA 2.4.19
- No typed properties (PHP 7.4+); no union types; use `declare(strict_types=1)` cautiously (optional)
- Namespace `ksfraser\FrontAccounting\EmployeePay\`
- DB prefix `0_ksf_employeepay_`
- Composer dependencies installed via `ComposerDependencies::ensure()` (matches Calendar module pattern)
