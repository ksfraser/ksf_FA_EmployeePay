<?php
$path_to_root = "../../..";
$page_security = 'SA_EMPLOYEEPAY_ENTRY';
include_once($path_to_root . "/includes/session.inc");
add_access_extensions();
?>
<div class="card">
    <div class="card-header"><?php echo _("Pay Entry"); ?></div>
    <div class="card-body">
        <p class="text-muted">Entry screen: Regular, OT, Vacation, Holiday hours; Incentives/Commissions; Deductions (CPP/EI/Tax, RRSP/GRSP, DPSP, Insurance, Medical); Reimbursements.</p>
        <form method="post" action="?view=entry">
            <div class="row">
                <div class="col-md-2"><label>Regular Hours</label></div>
                <div class="col-md-2"><label>OT Hours</label></div>
                <div class="col-md-2"><label>Vacation Hours</label></div>
                <div class="col-md-2"><label>Holiday Hours</label></div>
            </div>
            <div class="row mb-3">
                <div class="col-md-2"><input type="number" step="0.01" class="form-control" name="regular_hours"></div>
                <div class="col-md-2"><input type="number" step="0.01" class="form-control" name="overtime_hours"></div>
                <div class="col-md-2"><input type="number" step="0.01" class="form-control" name="vacation_hours"></div>
                <div class="col-md-2"><input type="number" step="0.01" class="form-control" name="holiday_hours"></div>
            </div>
            <button type="submit" class="btn btn-primary btn-sm">Calculate</button>
        </form>
    </div>
</div>
