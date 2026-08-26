# UC-EP-003-hr-runs-payroll.md

**Module:** EP  
**Related:** BR-EP-001

## Actor
HR / Payroll Administrator

## Flow
1. HR selects approved entries (`0_ksf_employeepay_entries`) for pay period.
2. Runs `CalculationService` (earnings, deductions, net) using current statutory settings (`0_ksf_employeepay_statutory`, `0_ksf_employeepay_tax_brackets`) and section grouping (`0_ksf_employeepay_sections`).
3. System writes `0_ksf_employeepay_calculations` (annual projected earnings, CPP/EI/Tax projections) for audit.
4. HR reviews projections; approves final pay run.
