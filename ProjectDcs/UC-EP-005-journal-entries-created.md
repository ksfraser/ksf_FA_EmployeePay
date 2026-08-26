# UC-EP-005-journal-entries-created.md

**Module:** EP  
**Related:** FR-EP-001-005

## Actor
GL / Finance System (via `GLPostingService` or manual entry)

## Flow
1. After approval, `gl_posted` flag set on entry.
2. Per mode (`incoming`/`outgoing`), GL accounts (`gl_account_code` per pay element) determine debit/credit lines.
3. Incoming: Salary Expense (Debit from section 1) → Payable Liability (Credit) → Net Pay (Credit section 5).
4. Outgoing: HRM calculates; GL targets reference HRM payroll accounts or module settings.
5. GL reference (`0_gl_trans`) created with `type_no` linked to entry (`ST_PAYSLIP` convention if available).
