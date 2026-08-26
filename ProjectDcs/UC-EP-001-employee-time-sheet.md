# UC-EP-001-employee-time-sheet.md

**Module:** EP  
**Related:** BR-EP-001

## Actor
Employee (incoming mode) or HRM staff (outgoing mode)

## Flow
1. Employee opens `?view=entry` (security: `SA_EMPLOYEEPAY_ENTRY`).
2. Enters hours: Regular (`G01`), OT (`O01`), Vacation (`V01`), Holiday (`H01`).
3. Enters incentives: `I00-I99` (fixed rate * unit or % of salary/annual).
4. System calculates earnings (`CalculationService`), applies section grouping (`sections.php`).
5. User submits; entry saved (`0_ksf_employeepay_entries`) with `status=draft`.
