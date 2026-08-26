# AGENTS_APPENDIX.md — ksf_FA_EmployeePay

Project-specific extensions to master AGENTS.md.

- Module code: `EP`
- Module directory: `ksf_FA_EmployeePay`
- Namespace: `ksfraser\FrontAccounting\EmployeePay`
- DB prefix: `0_ksf_employeepay_`
- Canadian rules: CPP/EI/Tax calculations per pay period, dynamic annual projection
- Direction mode: `incoming` (employee receives) vs `outgoing` (HRM calculates); same math, different GL targets
- References HRM grades/positions/payroll where applicable (optional dependency)
- Packages used: `famock`, `ksf-modules-dao`, `exceptions`, `ksf_FA_Common` (Menu, Traits, HTML)
- Coverage target: 100%
