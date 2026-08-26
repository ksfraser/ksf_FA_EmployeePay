# Dependencies — ksf_FA_EmployeePay

**Module:** EP (Employee Pay)
**Status:** Implemented
**Related:** BR-EP-001, Architecture.md

## Required for Basic Function
None. Module is fully self-contained (Notrinos-independent). It uses its own `0_ksf_employeepay_*` tables and does not require any other module to calculate/pay.

## Optional HRM Integration (ksf_FA_HRM — recommended for full capability)
When `ksf_FA_HRM` is installed and active, our module can reference these HRM entities for rate lookup and employee context:

| HRM Table | Our Reference | Required? | Usage |
|---|---|---|---|
| `0_hrm_grades` | Grade/min/max/salary range | Optional | Rate lookup (`hourly_rate`, grade % of midpoint) |
| `0_hrm_positions` | Position/department/team | Optional | Rate lookup via work assignment |
| `0_hrm_work_assignments` | Employment + hourly rate + frequency | Optional | Current rate for wage calculations |
| `0_hrm_contacts_employment` | Employee record (person link) | Optional | Link `employee_id` to HRM employee |
| `0_hrm_pay_elements` | Pay element codes/names/categories | Optional | Cross-reference for pay stub categories |
| `0_hrm_payroll` | Payroll period/header | Optional | Link pay entry to HRM payroll run |
| `0_hrm_payroll_entries` | Line items per payroll | Optional | Reference for GL posting |
| `0_hrm_pay_periods` | Pay period dates/frequency/status | Optional | Period validation |
| `0_hrm_commission_entries` | Commission amounts per order | Optional | Commission data (`COMM`) |
| `0_hrm_pay_rate_history` | Rate history / raises / promotions | Optional | Historical rate tracking |
| `0_hrm_benefits` / `0_hrm_employee_benefits` | Benefit enrollment / rates | Optional | Deduction reference (INS, MED, etc.) |

## Dependency Check Pattern (matches Calendar)
In `hooks.php`, `ComposerDependencies::ensure(__DIR__)` ensures `vendor/autoload.php` exists. Module activates independently. If HRM is present, `hook_invoke('ksf_FA_HRM', ...)` provides capabilities (`payroll`, `calculation`, `deduction`) without direct dependency.

## Module Activation Order (if using HRM)
1. `ksf_FA_Common` (Menu, Traits, HTML, ComposerDependencies)
2. `ksf_FA_HRM` (optional — grades, positions, pay elements)
3. `ksf_FA_EmployeePay` (this module)

Without HRM: Step 2 can be skipped; module calculates using admin-set rates (`pages/settings.php`) and manual entry (`pages/entry.php`).
