# UC-EP-004-payroll-calculation.md

**Module:** EP  
**Related:** BR-EP-001, FR-EP-001-004

## Actor
Payroll Module (`CalculationService` + `DeductionService`)

## Flow
1. Reads entry (`entry_id`), mode (`incoming`/`outgoing`), hours (`regular_hours`, etc.), hourly rate (from HRM grade/position or admin settings).
2. Computes earnings per pay element (`G01`, `O01`, `V01`, `H01`, `ALLOW`, `COMM`, `I00-I99`).
3. Applies section grouping (`0_ksf_employeepay_sections`): Income (1) → Pension/RSP (2) → Tax (3) → Other Deductions (4) → Net Pay (5).
4. Calculates statutory deductions (`CPP`, `EI`) with annual projection (`current_earnings * (annual_hours / pay_period_hours)`) checking floor/ceiling.
5. Calculates progressive tax (`TAX`) using `0_ksf_employeepay_tax_brackets`.
6. Calculates pre-tax deductions (`RRSP`, `GRSP`) and employer contributions (`DPSP`).
7. Stores result in `0_ksf_employeepay_entries` and audit in `0_ksf_employeepay_calculations`.
