<?php
/**
 * ksf_FA_EmployeePay Module Hooks
 *
 * @package ksf_FA_EmployeePay
 * @version 2.4.19-0
 * @since 1.0.0
 */

use ksfraser\FrontAccounting\Common\Traits\WorkflowHooksTrait;
use ksfraser\FrontAccounting\Common\Traits\CrudOperationsTrait;

define('SS_ksf_FA_EmployeePay', 145 << 8);
define('KSF_EMPLOYEEPAY_MODULE_NAME', 'ksf_FA_EmployeePay');
define('KSF_EMPLOYEEPAY_CAPABILITIES', 'payroll,calculation,deduction,entry,settings,reimbursement');

class hooks_ksf_FA_EmployeePay extends hooks
{
    use WorkflowHooksTrait;
    use CrudOperationsTrait;

    var $module_name = 'ksf_FA_EmployeePay';
    var $version     = '2.4.19-0';

    function install_tabs($app)
    {
        set_ext_domain('modules/ksf_FA_EmployeePay');
        $app->add_application(new employeepay_app());
        set_ext_domain();
    }

    function install_access()
    {
        $security_sections[SS_ksf_FA_EmployeePay] = _("Employee Pay");
        $security_areas['SA_EMPLOYEEPAY_VIEW'] = array(
            SS_ksf_FA_EmployeePay | 1, _("View Pay Entries")
        );
        $security_areas['SA_EMPLOYEEPAY_MANAGE'] = array(
            SS_ksf_FA_EmployeePay | 2, _("Manage Pay")
        );
        $security_areas['SA_EMPLOYEEPAY_ENTRY'] = array(
            SS_ksf_FA_EmployeePay | 3, _("Pay Entry")
        );
        $security_areas['SA_EMPLOYEEPAY_SETTINGS'] = array(
            SS_ksf_FA_EmployeePay | 4, _("Pay Settings")
        );
        return array($security_areas, $security_sections);
    }

    function activate_extension($company, $check_only = true)
    {
        if (!file_exists(dirname(__FILE__) . '/sql/install.sql')) {
            return true;
        }
        $updates = array('install.sql' => array('0_ksf_employeepay_settings', '0_ksf_employeepay_entries', '0_ksf_employeepay_calculations'));
        return $this->update_databases($company, $updates, $check_only);
    }

    function init()
    {
        $this->registerWorkflowType('payroll', 'employeepay_payroll');
    }

    public function getModuleConstants(&$data, $opts = null)
    {
        $constants = array(
            'KSF_EMPLOYEEPAY_MODULE_NAME' => KSF_EMPLOYEEPAY_MODULE_NAME,
            'KSF_EMPLOYEEPAY_CAPABILITIES' => KSF_EMPLOYEEPAY_CAPABILITIES,
        );
        $data['constants'] = $constants;
        return $constants;
    }

    public function getModuleCapabilities(&$data, $opts = null)
    {
        $capabilities = array(
            'payroll' => array('description' => 'Employee pay entry and calculation', 'methods' => array('calculatePay', 'createEntry')),
            'calculation' => array('description' => 'Wage calculation with CPP/EI/Tax', 'methods' => array('computeDeductions')),
        );
        $data['capabilities'] = $capabilities;
        return $capabilities;
    }

    public function hasCapability(&$data, $opts = null)
    {
        $capability = isset($opts['capability']) ? $opts['capability'] : (isset($data['capability']) ? $data['capability'] : null);
        if ($capability === null) {
            $data['has_capability'] = false;
            return false;
        }
        $caps = explode(',', KSF_EMPLOYEEPAY_CAPABILITIES);
        $has = in_array($capability, $caps);
        $data['has_capability'] = $has;
        return $has;
    }

    public function respondToCapabilityRequest(&$data, $opts = null)
    {
        $request = isset($opts['request']) ? $opts['request'] : (isset($data['request']) ? $data['request'] : 'capabilities');
        $data['request'] = $request;
        $data['module'] = $this->module_name;
        if (strpos($request, 'has:') === 0) {
            return $this->hasCapability($data, array('capability' => substr($request, 4)));
        }
        switch ($request) {
            case 'capabilities': return $this->getModuleCapabilities($data, $opts);
            case 'constants': return $this->getModuleConstants($data, $opts);
            default:
                $data['error'] = 'Unknown request: ' . $request;
                return null;
        }
    }
}

class employeepay_app extends application
{
    function __construct()
    {
        parent::__construct("EmployeePay", _($this->help_context = "&Employee Pay"));
        $this->add_module(_("Employee Pay"));
        $menu = new \ksfraser\FrontAccounting\Common\Menu\FAModuleMenu(
            'modules/ksf_FA_EmployeePay/index.php',
            'view',
            ''
        );
        $menu->addItem('entry',     _("Pay Entry"),      MENU_ENTRY)
             ->addItem('settings',  _("Settings"),      MENU_SETTINGS)
             ->addItem('reimburse', _("Reimbursements"), MENU_ENTRY)
             ->addItem('stubs',     _("Pay Stubs"),      MENU_INQUIRY);
        $menu->registerWithApp($this, 'SA_EMPLOYEEPAY_VIEW');
        $this->add_extensions();
    }
}
