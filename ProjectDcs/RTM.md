# RTM — ksf_FA_EmployeePay

Auto-generated reference mapping. Update after each release.

| Code Ref | Requirement | Module File | Test File |
|---|---|---|---|
| BR-EP-001 | Canadian employee pay calc | `hooks.php` | `tests/Unit/EmployeePayConfigTest.php` |
| FR-EP-001-001 | Pay period hours / mode | `pages/settings.php`, `src/Config/EmployeePayConfig.php` | `tests/Unit/EmployeePayConfigTest.php` |
| FR-EP-001-002 | Entry screen (Regular/OT/Vac/Holiday) | `pages/entry.php`, `sql/install.sql` | `tests/Unit/EmployeePayConfigTest.php` |
| FR-EP-001-003 | Pay element categories (Basic/Allowance/Deduction/Statutory/Bonus/Reimbursement) | `sql/install.sql`, `src/Config/EmployeePayConfig.php` | `tests/Unit/EmployeePayConfigTest.php` |
| FR-EP-001-004 | Canadian statutory deductions (CPP/EI/Tax progressive) | `src/Service/DeductionService.php` (planned) | `tests/Unit/DeductionServiceTest.php` (planned) |
| FR-EP-001-005 | GL posting per mode (incoming/outgoing) | `pages/stubs.php`, `sql/install.sql` | `tests/Unit/GLServiceTest.php` (planned) |
| FR-EP-001-006 | Reimbursements / Expense section | `pages/reimburse.php` | `tests/Unit/ReimbursementServiceTest.php` (planned) |

Reference HRM: `ksf_FA_HRM` grades (`0_hrm_grades`), positions, pay elements (`0_hrm_pay_elements`), payroll (`0_hrm_payroll`).
