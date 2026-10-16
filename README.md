# ksf_FA_EmployeePay

Canadian employee wage/payroll journal entry module for incoming (employee) and outgoing (HRM) modes with CPP/EI/Tax calculations

**Version:** `2.4.19-0` &nbsp;|&nbsp; **FA:** 2.4 &nbsp;|&nbsp; **PHP:** 7.3

---

## What this module does

- **BR-007** - Cross-module Event-Close → Timesheet + Expense Workflow
  - Status: Approved (BR-007, series after BR-006 cross-module DDL caching) Scope : Cross-module — Calendar (anchor), Timesheets, TravelExpense, ProjectManagement, HRM, EmployeePay, Warehouse...
- **BR-EP-001** - canadian-employee-pay-calculation.md
  - Calculate Canadian employee wage pay independently of NotrinosERP (competing FA fork; will not be installed).

## Installing

This is a FrontAccounting extension; it installs into the FA `modules/` tree.

```bash
rsync -a --exclude .git --exclude vendor \
    ~/Documents/ksf_FA_EmployeePay/ ~/Documents/ksf_Infrastructure/fa_modules/ksf_FA_EmployeePay/
cd ~/Documents/ksf_Infrastructure/fa_modules/ksf_FA_EmployeePay \
    && composer install --no-dev
```

Then in the FA UI: **Setup -> Extensions**, tick the module and press
**Refresh/Update**. FA reads `_init/config` for the package name and
version, so that file must stay in sync with this README.

Notes:

- Do **not** deploy `vendor/` from the dev checkout - it carries dev
  dependencies (PHPUnit needs PHP >= 8.1) that fatal on the 7.4 runtime.
- Never edit anything under `fa_modules/` by hand. It is build output;
  development happens in `~/Documents/ksf_FA_EmployeePay`.

## Where to find it in the UI

Page entry points (each enforces its own `$page_security` area):

| Page | Security area |
|------|----------------|
| `entry.php` | `SA_EMPLOYEEPAY_ENTRY` |
| `reimburse.php` | `SA_EMPLOYEEPAY_ENTRY` |
| `sections.php` | `SA_EMPLOYEEPAY_SETTINGS` |
| `settings.php` | `SA_EMPLOYEEPAY_SETTINGS` |
| `statutory.php` | `SA_EMPLOYEEPAY_SETTINGS` |
| `stubs.php` | `SA_EMPLOYEEPAY_VIEW` |
| `tax_brackets.php` | `SA_EMPLOYEEPAY_SETTINGS` |

- Hooks class: `hooks_ksf_FA_EmployeePay`
- Security sections defined: `SS_ksf_FA_EmployeePay`
- **Extensions -> Setup** decides whether the module may run at all;
  grant the areas above under *Access* before the pages appear.

Menu placement is added by the page code (see `pages/` above); if a tab is
missing, check that the module is activated for your company and that your
user holds the listed security areas.

## Repository layout

```
ksf_FA_EmployeePay/
├── hooks.php            # FA extension entry point, security areas
├── _init/config         # FA package manifest (plain Key: Value)
├── composer.json        # PSR-4 autoload, ksfraser/* dependencies
├── pages/               # FA pages, one $page_security each
├── src/                 # PSR-4 classes
├── sql/                 # schema (literal 0_ table prefix)
├── tests/               # PHPUnit suite
├── ProjectDcs/          # BABOK documents
└── vendor/              # not deployed; composer install --no-dev in fa_modules
```

## Contributing

1. Work in `~/Documents/ksf_FA_EmployeePay` - never in `fa_modules/`.
2. Branch: `feat/`, `fix/`, `refactor/`, `docs/`.
3. Tests first: `cd ~/Documents/ksf_FA_EmployeePay && php vendor/bin/phpunit`.
4. Requirements live in `ProjectDcs/` as individual files
   (`BR-<MOD>-<seq>-<slug>.md`, `FR-...`, `UC-...`, `UT-...`), and code
   carries `@BABOK Related: <ID>` in its docblock so traceability can be
   generated from the source.
5. Commit per logical change, then push. Deploys are rsync from dev;
   they must never carry commits of their own.

Conventions that apply across every module are documented in
`AGENTS_ARCH.md` (shared, hardlinked) and `AGENTS_APPENDIX.md`.
