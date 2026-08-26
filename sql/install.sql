-- ksf_FA_EmployeePay SQL installation
-- Uses 0_ prefix per module convention

CREATE TABLE IF NOT EXISTS `0_ksf_employeepay_settings` (
    `id` INT(11) NOT NULL AUTO_INCREMENT,
    `hours_per_pay_period` DECIMAL(8,2) DEFAULT 80.00 COMMENT 'Normal hours per payroll',
    `mode` VARCHAR(20) DEFAULT 'incoming' COMMENT 'incoming=employee receives; outgoing=HRM calculates',
    `updated_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    PRIMARY KEY (`id`),
    UNIQUE KEY `uk_settings` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS `0_ksf_employeepay_pay_elements` (
    `element_id` INT(11) NOT NULL AUTO_INCREMENT,
    `element_code` VARCHAR(20) NOT NULL COMMENT 'G01,O01,V01,H01,ALLOW,BONUS,COMM,REIMB',
    `element_name` VARCHAR(100) NOT NULL,
    `category` VARCHAR(20) DEFAULT 'earning' COMMENT 'earning|deduction|statutory|employer_contrib|bonus|reimbursement',
    `calculation_type` VARCHAR(20) DEFAULT 'fixed' COMMENT 'fixed|percent_basic|percent_gross|formula|attendance',
    `default_value` DECIMAL(15,2) DEFAULT 0,
    `gl_account_code` VARCHAR(20) DEFAULT NULL COMMENT 'GL account for posting',
    `is_taxable` TINYINT(1) DEFAULT 1,
    `affects_gross` TINYINT(1) DEFAULT 1,
    `is_active` TINYINT(1) DEFAULT 1,
    `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (`element_id`),
    UNIQUE KEY `uk_code` (`element_code`),
    KEY `idx_category` (`category`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS `0_ksf_employeepay_calculations` (
    `calc_id` INT(11) NOT NULL AUTO_INCREMENT,
    `entry_id` INT(11) DEFAULT NULL COMMENT 'FK to 0_ksf_employeepay_entries',
    `calculated_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    `annual_projected_earnings` DECIMAL(15,2) DEFAULT 0,
    `cpp_annual_projected` DECIMAL(15,2) DEFAULT 0,
    `ei_annual_projected` DECIMAL(15,2) DEFAULT 0,
    `tax_annual_projected` DECIMAL(15,2) DEFAULT 0,
    `mode` VARCHAR(20) DEFAULT 'incoming',
    PRIMARY KEY (`calc_id`),
    KEY `idx_entry` (`entry_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS `0_ksf_employeepay_entries` (
    `entry_id` INT(11) NOT NULL AUTO_INCREMENT,
    `period_start` DATE NOT NULL,
    `period_end` DATE NOT NULL,
    `mode` VARCHAR(20) DEFAULT 'incoming',
    `employee_id` INT(11) DEFAULT NULL COMMENT 'FK to employee/HRM',
    `regular_hours` DECIMAL(8,2) DEFAULT 0,
    `overtime_hours` DECIMAL(8,2) DEFAULT 0,
    `vacation_hours` DECIMAL(8,2) DEFAULT 0,
    `holiday_hours` DECIMAL(8,2) DEFAULT 0,
    `incentive_amount` DECIMAL(15,2) DEFAULT 0,
    `commission_amount` DECIMAL(15,2) DEFAULT 0,
    `reimbursement_amount` DECIMAL(15,2) DEFAULT 0,
    `gross_earnings` DECIMAL(15,2) DEFAULT 0,
    `cpp_deduction` DECIMAL(15,2) DEFAULT 0,
    `ei_deduction` DECIMAL(15,2) DEFAULT 0,
    `tax_deduction` DECIMAL(15,2) DEFAULT 0,
    `rrsp_deduction` DECIMAL(15,2) DEFAULT 0,
    `grsp_deduction` DECIMAL(15,2) DEFAULT 0,
    `dpsp_accrual` DECIMAL(15,2) DEFAULT 0,
    `insurance_deduction` DECIMAL(15,2) DEFAULT 0,
    `medical_deduction` DECIMAL(15,2) DEFAULT 0,
    `other_deduction` DECIMAL(15,2) DEFAULT 0,
    `net_pay` DECIMAL(15,2) DEFAULT 0,
    `gl_posted` TINYINT(1) DEFAULT 0,
    `status` VARCHAR(20) DEFAULT 'draft',
    `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (`entry_id`),
    KEY `idx_employee` (`employee_id`),
    KEY `idx_period` (`period_start`, `period_end`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Reference pay elements (seed data) - independent of Notrinos
INSERT IGNORE INTO `0_ksf_employeepay_pay_elements` (element_code, element_name, category, calculation_type, default_value, is_taxable, affects_gross) VALUES
('G01', 'Regular Time', 'earning', 'fixed', 0.00, 1, 1),
('O01', 'Overtime', 'earning', 'percent_basic', 1.50, 1, 1),
('V01', 'Vacation Pay', 'earning', 'fixed', 0.00, 1, 1),
('H01', 'Holiday Pay', 'earning', 'fixed', 0.00, 1, 1),
('ALLOW', 'Allowance', 'earning', 'fixed', 0.00, 1, 1),
('BONUS', 'Bonus / Incentive', 'earning', 'percent_gross', 0.00, 1, 1),
('COMM', 'Commission', 'earning', 'fixed', 0.00, 1, 1),
('REIMB', 'Expense Reimbursement', 'reimbursement', 'fixed', 0.00, 0, 0),
('CPP', 'CPP Deduction', 'statutory', 'fixed', 0.00, 0, 0),
('EI', 'EI Deduction', 'statutory', 'fixed', 0.00, 0, 0),
('TAX', 'Income Tax', 'statutory', 'formula', 0.00, 0, 0),
('RRSP', 'RRSP Deduction', 'deduction', 'fixed', 0.00, 0, 1),
('GRSP', 'GRSP Deduction', 'deduction', 'fixed', 0.00, 0, 1),
('DPSP', 'DPSP Accrual', 'employer_contrib', 'fixed', 0.00, 0, 0),
('INS', 'Insurance Deduction', 'deduction', 'fixed', 0.00, 0, 0),
('MED', 'Medical Deduction', 'deduction', 'fixed', 0.00, 0, 0),
('LOAN', 'Loan Repayment', 'deduction', 'fixed', 0.00, 0, 0);

CREATE TABLE IF NOT EXISTS `0_ksf_employeepay_statutory` (
    `stat_id` INT(11) NOT NULL AUTO_INCREMENT,
    `statutory_code` VARCHAR(20) DEFAULT NULL COMMENT 'CPP, EI, etc',
    `statutory_name` VARCHAR(100) NOT NULL,
    `employee_rate` DECIMAL(5,4) DEFAULT 0.0000 COMMENT 'Rate % e.g., 0.0595',
    `employer_rate` DECIMAL(5,4) DEFAULT 0.0000,
    `employee_fixed` DECIMAL(15,2) DEFAULT 0,
    `employer_fixed` DECIMAL(15,2) DEFAULT 0,
    `ceiling_amount` DECIMAL(15,2) DEFAULT NULL COMMENT 'Max annual earnings for deduction',
    `floor_amount` DECIMAL(15,2) DEFAULT NULL COMMENT 'Min earnings before deduction',
    `calculation_base` VARCHAR(20) DEFAULT 'basic' COMMENT 'basic|gross',
    `employee_account` VARCHAR(20) DEFAULT NULL COMMENT 'GL account code',
    `employer_account` VARCHAR(20) DEFAULT NULL,
    `effective_from` DATE NOT NULL DEFAULT '2026-01-01',
    `effective_to` DATE DEFAULT NULL,
    `is_active` TINYINT(1) DEFAULT 1,
    PRIMARY KEY (`stat_id`),
    UNIQUE KEY `uk_code` (`statutory_code`, `effective_from`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS `0_ksf_employeepay_tax_brackets` (
    `bracket_id` INT(11) NOT NULL AUTO_INCREMENT,
    `bracket_name` VARCHAR(50) DEFAULT NULL,
    `from_amount` DECIMAL(15,2) DEFAULT 0,
    `to_amount` DECIMAL(15,2) DEFAULT NULL COMMENT 'NULL = no limit',
    `rate` DECIMAL(5,4) DEFAULT 0.0000 COMMENT 'Rate %',
    `fixed_amount` DECIMAL(15,2) DEFAULT 0,
    `effective_from` DATE NOT NULL DEFAULT '2026-01-01',
    `effective_to` DATE DEFAULT NULL,
    `is_active` TINYINT(1) DEFAULT 1,
    PRIMARY KEY (`bracket_id`),
    KEY `idx_dates` (`effective_from`, `effective_to`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
