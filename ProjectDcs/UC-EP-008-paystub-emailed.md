# UC-EP-008-paystub-emailed.md

**Module:** EP  
**Related:** BR-EP-001

## Actor
System / Notification Module (`ksf_FA_Mail` or `ksf_FA_EmailManager`)

## Flow
1. After pay stub created (`pages/stubs.php` or via `CalculationService`), stub PDF or HTML generated.
2. Email sent to employee (from HRM `0_hrm_contacts_employment` or module settings) with stub attachment/reference.
3. Email uses `ComposerDependencies::ensure()` to load `ksf_FA_Mail` SMTP if available; falls back to `mail()`.
4. Email template includes sections grouped by order (Income, Pension, Tax, Other, Net Pay) and references `entry_id`, `mode`, `status`.
