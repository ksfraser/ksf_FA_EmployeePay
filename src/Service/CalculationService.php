<?php
/**
 * Pay calculation service.
 *
 * @package ksfraser\FrontAccounting\EmployeePay\Service
 * @BABOK Related: FR-EP-001-002
 */
namespace ksfraser\FrontAccounting\EmployeePay\Service;

class CalculationService
{
    private DeductionService $deductionService;

    public function __construct()
    {
        $this->deductionService = new DeductionService();
    }

    public function calculateEntry(array $hours, float $hourlyRate, array $elements = []): array
    {
        $earnings = 0.0;
        $earnings += ($hours['regular'] ?? 0) * $hourlyRate;
        $earnings += ($hours['overtime'] ?? 0) * $hourlyRate * 1.5;
        $earnings += ($hours['vacation'] ?? 0) * $hourlyRate;
        $earnings += ($hours['holiday'] ?? 0) * $hourlyRate;

        $cpp = $this->deductionService->calculateStatutory('CPP', $earnings, false);
        $ei  = $this->deductionService->calculateStatutory('EI', $earnings, false);
        $tax = $this->deductionService->calculateTax($earnings * 26, date('Y-m-d')) / 26; // approximate per-period projection

        $net = $earnings - $cpp - $ei - $tax;

        return array(
            'gross_earnings' => $earnings,
            'cpp_deduction' => $cpp,
            'ei_deduction' => $ei,
            'tax_deduction' => $tax,
            'net_pay' => max($net, 0.0),
            'mode' => 'incoming',
        );
    }
}
