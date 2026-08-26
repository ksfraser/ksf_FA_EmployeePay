<?php
$path_to_root = "../../..";
$page_security = 'SA_EMPLOYEEPAY_SETTINGS';
include_once($path_to_root . "/includes/session.inc");
add_access_extensions();
?>
<div class="card">
    <div class="card-header">Tax Brackets</div>
    <div class="card-body">
        <p>Progressive income tax brackets (approximate Canadian federal). Effective dates support annual updates.</p>
        <table class="table table-sm table-striped">
            <thead><tr><th>Bracket</th><th>From</th><th>To</th><th>Rate %</th><th>Fixed</th><th>Effective</th></tr></thead>
            <tbody>
                <tr><td>Federal Basic</td><td>$0</td><td>$55,867</td><td>15.0%</td><td>$0</td><td>2026-01-01</td></tr>
                <tr><td>Federal Middle</td><td>$55,867</td><td>$111,733</td><td>20.5%</td><td>$8,356</td><td>2026-01-01</td></tr>
                <tr><td>Federal High</td><td>$111,733</td><td>No limit</td><td>26.0%</td><td>$19,410</td><td>2026-01-01</td></tr>
            </tbody>
        </table>
        <a href="?view=settings" class="btn btn-secondary btn-sm">Back to Settings</a>
    </div>
</div>
