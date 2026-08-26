<?php
$path_to_root = "../../..";
$page_security = 'SA_EMPLOYEEPAY_SETTINGS';
include_once($path_to_root . "/includes/session.inc");
add_access_extensions();
?>
<div class="card mb-3">
    <div class="card-header">Pay Stub Sections</div>
    <div class="card-body">
        <p>Unlimited sections. Pre-seeded: Income (1), Pension / RSP (2), Tax Deductions (3), Other Deductions (4), Net Pay (5).</p>
        <table class="table table-sm table-striped">
            <thead><tr><th>Order</th><th>Section Name</th><th>Type</th><th>Items / Codes</th></tr></thead>
            <tbody>
                <tr><td>1</td><td>Income</td><td>earnings</td><td>G01, O01, V01, H01, ALLOW, BONUS, COMM, I00-I99 (incentives)</td></tr>
                <tr><td>2</td><td>Pension / RSP</td><td>deductions</td><td>RRSP, GRSP, DPSP</td></tr>
                <tr><td>3</td><td>Tax Deductions</td><td>deductions</td><td>CPP, EI, TAX</td></tr>
                <tr><td>4</td><td>Other Deductions</td><td>deductions</td><td>INS, MED, LOAN</td></tr>
                <tr><td>5</td><td>Net Pay</td><td>net</td><td>Calculated result (not a pay element)</td></tr>
            </tbody>
        </table>
        <p class="text-muted">Section items use <code>element_code</code> (e.g. G01, I01-I99). Incentives: I00-I99 = fixed rate * unit (e.g. 2x $3 per booking) or % of salary.</p>
        <a href="?view=settings" class="btn btn-secondary btn-sm">Back to Settings</a>
    </div>
</div>
