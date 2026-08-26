# FR-EP-001-007-pay-stub-sections.md

**Module:** EP  
**Related:** BR-EP-001  
**Status:** Implemented

## Requirement
Unlimited editable sections (`0_ksf_employeepay_sections`) with display order. Pre-seeded: Income (1), Pension/RSP (2), Tax Deductions (3), Other Deductions (4), Net Pay (5). Section items (`0_ksf_employeepay_section_items`) map `element_code` (G01, O01, V01, H01, CPP, EI, TAX, RRSP, INS, MED, I00-I99) to sections. Incentives (`I00-I99`) either fixed rate * unit or % of annual/salary.

## Traceability
- `sql/install.sql`
- `pages/sections.php`
