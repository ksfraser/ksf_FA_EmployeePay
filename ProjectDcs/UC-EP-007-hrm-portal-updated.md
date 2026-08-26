# UC-EP-007-hrm-portal-updated.md

**Module:** EP  
**Related:** BR-EP-001, Dependencies.md

## Actor
HRM System / Employee Portal

## Flow
1. When `ksf_FA_HRM` is installed, module links `employee_id` to `0_hrm_contacts_employment` (optional).
2. Pay stub data (`entry_id`, gross, net, deductions, sections) available to HRM via capability request (`respondToCapabilityRequest` with `payroll` capability).
3. Employee portal (`ksf_HRM_UI` or similar) queries module for latest pay stub (`stubs` view) using `hook_invoke('ksf_FA_EmployeePay', 'getPayStub', ...)` or direct DB read (`0_ksf_employeepay_entries`).
4. Portal displays stub sections in order; updates employee record with current pay period info.
5. If HRM module not installed, module functions independently with manual entry (`pages/entry.php`).
