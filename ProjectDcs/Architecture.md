# Architecture — ksf_FA_EmployeePay

## Namespace
`ksfraser\FrontAccounting\EmployeePay\`

## Services (DI-friendly)
- `EmployeePayConfigService` (settings)
- `PayScaleService` (grades, hourly_rate from HRM)
- `CalculationService` (earnings = hours * rate; OT = 1.5x; vacation/holiday = rate * hours)
- `DeductionService` (CPP/EI/Tax progressive; RRSP/GRSP pre-tax; DPSP accrual; Insurance/Medical)
- `ReimbursementService` (expense reimbursement)
- `GLPostingService` (posts to `0_gl_trans`, references mode)
- `SectionService` (manages `0_ksf_employeepay_sections` and `0_ksf_employeepay_section_items`; unlimited editable sections)

## Entities
- `PayEntry` (line item with category, amount, note, gl_account)
- `CalculationResult` (earnings, deductions, net)

## Traits
- Uses `ksfraser\FrontAccounting\Common\Traits\CrudOperationsTrait` (if needed for settings)
- Uses `WorkflowHooksTrait` for module hooks (`payroll` workflow type registered)

## Module Integration Pattern
- `hook_invoke('ksf_FA_HRM', 'getModuleConstants', $data)` for capabilities
- `hook_invoke('ksf_FA_HRM', 'respondToCapabilityRequest', $data, ['request'=>'capabilities'])`
- Direct DB joins to `0_hrm_payroll`, `0_hrm_grades`, `0_hrm_pay_elements` where needed (optional dependency; module functional without HRM)
