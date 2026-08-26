<?php
$path_to_root = "../../..";
$page_security = 'SA_EMPLOYEEPAY_SETTINGS';
include_once($path_to_root . "/includes/session.inc");
add_access_extensions();

require_once($path_to_root . "/modules/ksf_FA_EmployeePay/src/Config/EmployeePayConfig.php");

use ksfraser\FrontAccounting\EmployeePay\Config\EmployeePayConfig;

$config = new EmployeePayConfig();
$settings = $config->getSettings();

if (isset($_POST['save_settings'])) {
    $hours = (float)($_POST['hours_per_pay_period'] ?? 80);
    $mode = ($_POST['mode'] === 'outgoing') ? 'outgoing' : 'incoming';
    $config->saveSettings(array('hours_per_pay_period' => $hours, 'mode' => $mode));
    $settings = $config->getSettings();
}
?>
<div class="card">
    <div class="card-header"><?php echo _("Pay Settings"); ?></div>
    <div class="card-body">
        <form method="post" action="?view=settings">
            <div class="form-group">
                <label for="hours_per_pay_period"><?php echo _("Hours per Pay Period"); ?></label>
                <input type="number" step="0.01" min="1" class="form-control" id="hours_per_pay_period" name="hours_per_pay_period"
                    value="<?php echo htmlspecialchars($settings['hours_per_pay_period'] ?? 80); ?>">
            </div>
            <div class="form-group">
                <label><?php echo _("Mode"); ?></label><br>
                <div class="form-check">
                    <input class="form-check-input" type="radio" name="mode" id="mode_incoming" value="incoming"
                        <?php echo (($settings['mode'] ?? 'incoming') === 'incoming') ? 'checked' : ''; ?>>
                    <label class="form-check-label" for="mode_incoming">Incoming (we are the employee)</label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="radio" name="mode" id="mode_outgoing" value="outgoing"
                        <?php echo (($settings['mode'] ?? 'incoming') === 'outgoing') ? 'checked' : ''; ?>>
                    <label class="form-check-label" for="mode_outgoing">Outgoing (HRM employee pay)</label>
                </div>
            </div>
            <button type="submit" name="save_settings" class="btn btn-success btn-sm"><?php echo _("Save Settings"); ?></button>
        </form>
    </div>
</div>
