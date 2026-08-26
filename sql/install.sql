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
