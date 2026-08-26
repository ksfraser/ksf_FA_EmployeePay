@startuml ksf_FA_EmployeePay_ERD

!theme plain
skinparam backgroundColor #FEFEFE
skinparam arrowColor #333333
skinparam entityBackgroundColor #E8F4FD
skinparam entityBorderColor #2E5AA0

' --- Our Module Tables ---
entity "0_ksf_employeepay_settings" as settings {
  *id (PK)
  hours_per_pay_period
  mode
  updated_at
}

entity "0_ksf_employeepay_pay_elements" as pay_elements {
  *element_id (PK)
  element_code <<UK>> (G01, O01, V01, H01, I00-I99, CPP, EI, TAX...)
  element_name
  category <<earning|deduction|statutory|employer_contrib|reimbursement>>
  calculation_type <<fixed|percent_basic|percent_gross|formula|attendance>>
  default_value
  gl_account_code
  is_taxable
  affects_gross
  is_active
  created_at
}

entity "0_ksf_employeepay_entries" as entries {
  *entry_id (PK)
  period_start
  period_end
  mode <<incoming|outgoing>>
  employee_id (FK -> HRM)
  regular_hours
  overtime_hours
  vacation_hours
  holiday_hours
  incentive_amount
  commission_amount
  reimbursement_amount
  gross_earnings
  cpp_deduction
  ei_deduction
  tax_deduction
  rrsp_deduction
  grsp_deduction
  dpsp_accrual
  insurance_deduction
  medical_deduction
  other_deduction
  net_pay
  gl_posted
  status
  created_at
}

entity "0_ksf_employeepay_calculations" as calculations {
  *calc_id (PK)
  entry_id (FK -> entries)
  calculated_at
  annual_projected_earnings
  cpp_annual_projected
  ei_annual_projected
  tax_annual_projected
  mode
}

entity "0_ksf_employeepay_statutory" as statutory {
  *stat_id (PK)
  statutory_code <<UK>> (CPP, EI, etc)
  statutory_name
  employee_rate
  employer_rate
  employee_fixed
  employer_fixed
  ceiling_amount
  floor_amount
  calculation_base <<basic|gross>>
  employee_account
  employer_account
  effective_from
  effective_to
  is_active
}

entity "0_ksf_employeepay_tax_brackets" as tax_brackets {
  *bracket_id (PK)
  bracket_name
  from_amount
  to_amount (NULL = no limit)
  rate
  fixed_amount
  effective_from
  effective_to
  is_active
}

entity "0_ksf_employeepay_sections" as sections {
  *section_id (PK)
  section_name <<UK>> (Income, Pension / RSP, Tax Deductions, Other Deductions, Net Pay)
  display_order
  section_type <<earnings|deductions|net>>
  is_active
}

entity "0_ksf_employeepay_section_items" as section_items {
  *item_id (PK)
  section_id (FK -> sections)
  element_code <<FK -> pay_elements>>
  display_order
  is_fixed_rate
  unit_description
}

' --- HRM References (optional) ---
entity "0_hrm_grades" as hrm_grades [label="HRM: Grades (optional)"] {
  *grade_id (PK)
  grade_code
  grade_name
  min_salary
  max_salary
  is_active
}

entity "0_hrm_positions" as hrm_positions [label="HRM: Positions (optional)"] {
  *position_id (PK)
  position_code
  department_id
  team_id
  role_id
  description
  is_active
}

entity "0_hrm_work_assignments" as hrm_assignments [label="HRM: Work Assignments (optional)"] {
  *assignment_id (PK)
  employment_id
  position_id
  grade_id
  salary_amount
  hourly_rate
  pay_frequency
  effective_date
  is_current
}

entity "0_hrm_pay_elements" as hrm_pay_elements [label="HRM: Pay Elements (optional)"] {
  *element_id (PK)
  element_code
  element_name
  category
  calculation_type
  default_value
  gl_account_code
  is_taxable
}

entity "0_hrm_payroll" as hrm_payroll [label="HRM: Payroll (optional)"] {
  *payroll_id (PK)
  person_id
  pay_period_start
  pay_period_end
  gross_pay
  total_deductions
  net_pay
  pay_date
  status
  gl_posted
}

entity "0_hrm_commission_entries" as hrm_commissions [label="HRM: Commission Entries (optional)"] {
  *entry_id (PK)
  person_id
  fa_order_no
  commission_amount
  rate
  status
}

entity "0_crm_persons" as crm_persons [label="FA: CRM Persons (optional link)"] {
  *id (PK)
  name
  email
}

' --- GL ---
entity "0_gl_trans" as gl_trans [label="FA: GL Transactions"] {
  *id (PK)
  type_no
  reference
  tran_date
}

' --- Relationships ---
settings ||--|{ entries : "1:N (per mode/settings)"
sections ||--|{ section_items : "1:N"
pay_elements ||--|{ section_items : "1:N (via element_code)"

entries ||--o{ calculations : "1:N (calculation per entry)"
entries ||--o{ hrm_payroll : "optional link (entry_id not FK; employee match)"
entries ||--o{ hrm_commissions : "optional reference (commission_amount)"

statutory }o--|| tax_brackets : "independent rules"

' HRM optional relationships (dashed)
hrm_grades }o--o{ hrm_assignments : "optional"
hrm_positions ||--o{ hrm_assignments : "optional"
hrm_assignments }o--o{ entries : "optional (hourly_rate lookup via employee/assignment)"
hrm_pay_elements ||--o{ section_items : "optional cross-reference"
hrm_payroll ||--o{ entries : "optional (mode reference)"
hrm_commissions ||--o{ entries : "optional (commission reference)"

crm_persons ||--o{ hrm_assignments : "optional (employment -> person)"
crm_persons ||--o{ entries : "optional (employee_id -> person)"

' GL posting
entries }o--|| gl_trans : "optional (gl_account_code per item; gl_posted flag)"

' Note annotations
note top of sections : "Unlimited editable sections\nPre-seeded: 1=Income, 2=Pension/RSP, 3=Tax, 4=Other, 5=Net"
note top of pay_elements : "G01=Regular, O01=OT, V01=Vac, H01=Hol, ALLOW, BONUS, COMM, REIMB\nI00-I99=Incentives (fixed*unit or % salary)"
note top of entries : "Incoming (we receive) vs Outgoing (HRM calculates)\nGL targets differ per mode"
note right of stat : "Dynamic Canadian rules: CPP (~5.95%), EI (~1.66%)\nProgressive tax brackets with floor/ceiling\nAnnual projection for limits"

@enduml
