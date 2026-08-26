<?php
/**
 * ksf_FA_EmployeePay Entry Point
 * @package ksf_FA_EmployeePay
 */
$path_to_root = "../..";
$page_security = 'SA_EMPLOYEEPAY_VIEW';
include_once($path_to_root . "/includes/session.inc");
add_access_extensions();

$view = isset($_GET['view']) ? $_GET['view'] : 'entry';
$validViews = array(
    'entry' => array('file' => 'pages/entry.php', 'security' => 'SA_EMPLOYEEPAY_ENTRY'),
    'settings' => array('file' => 'pages/settings.php', 'security' => 'SA_EMPLOYEEPAY_SETTINGS'),
    'reimburse' => array('file' => 'pages/reimburse.php', 'security' => 'SA_EMPLOYEEPAY_ENTRY'),
    'statutory' => array('file' => 'pages/statutory.php', 'security' => 'SA_EMPLOYEEPAY_SETTINGS'),
    'tax_brackets' => array('file' => 'pages/tax_brackets.php', 'security' => 'SA_EMPLOYEEPAY_SETTINGS'),
    'stubs' => array('file' => 'pages/stubs.php', 'security' => 'SA_EMPLOYEEPAY_VIEW'),
);

if (!isset($validViews[$view])) {
    $view = 'entry';
}
$page_security = $validViews[$view]['security'];
$pageFile = dirname(__FILE__) . '/' . $validViews[$view]['file'];

$menu = new \ksfraser\FrontAccounting\Common\Menu\FAModuleMenu(
    'index.php', 'view', $view
);
$menu->addItem('entry',     _("Pay Entry"), MENU_ENTRY)
     ->addItem('settings',  _("Settings"), MENU_SETTINGS)
     ->addItem('statutory', _("Statutory"), MENU_SETTINGS)
     ->addItem('tax_brackets', _("Tax Brackets"), MENU_SETTINGS)
     ->addItem('reimburse', _("Reimbursements"), MENU_ENTRY)
     ->addItem('stubs',     _("Pay Stubs"), MENU_INQUIRY);

page(_("Employee Pay"), false, false, '', '');
echo $menu->render();

if (file_exists($pageFile)) {
    include($pageFile);
} else {
    echo "<div class='alert alert-warning'>Page not found: " . htmlspecialchars($view) . "</div>";
}
end_page();
