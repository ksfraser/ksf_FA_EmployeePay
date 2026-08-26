<?php
$path_to_root = "../../..";
$page_security = 'SA_EMPLOYEEPAY_SETTINGS';
include_once($path_to_root . "/includes/session.inc");
add_access_extensions();
?>
<div class="card">
    <div class="card-header">Statutory Settings (CPP / EI / Tax)</div>
    <div class="card-body">
        <p>Admin screen for setting employee rate, employer rate, annual ceiling/floor, and GL account mapping per statutory deduction.</p>
        <table class="table table-sm">
            <thead><tr><th>Code</th><th>Name</th><th>Emp Rate</th><th>Er Rate</th><th>Ceiling</th><th>Base</th></tr></thead>
            <tbody>
                <tr><td>CPP</td><td>Canada Pension Plan</td><td>5.95%</td><td>5.95%</td><td>$68,500 (2026)</td><td>basic</td></tr>
                <tr><td>EI</td><td>Employment Insurance</td><td>1.66%</td><td>2.32%</td><td>$63,200 (2026)</td><td>basic</td></tr>
                <tr><td>TAX</td><td>Federal/Provincial Income Tax</td><td>Progressive</td><td>N/A</td><td>N/A</td><td>gross</td></tr>
            </tbody>
        </table>
        <a href="?view=settings" class="btn btn-secondary btn-sm">Back to Settings</a>
    </div>
</div>
