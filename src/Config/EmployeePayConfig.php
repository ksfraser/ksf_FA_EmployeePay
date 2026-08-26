<?php
/**
 * Config access for module settings.
 * @package ksfraser\FrontAccounting\EmployeePay\Config
 */
namespace ksfraser\FrontAccounting\EmployeePay\Config;

class EmployeePayConfig
{
    public function getSettings(): array
    {
        // In production: query 0_ksf_employeepay_settings
        return array('hours_per_pay_period' => 80.00, 'mode' => 'incoming');
    }

    public function saveSettings(array $data): void
    {
        // Persist to 0_ksf_employeepay_settings
    }
}
