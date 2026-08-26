<?php
// Bootstrap: use module autoload + peer packages (famock, traits, exceptions)
$paths = array(
    __DIR__ . '/../vendor/autoload.php',
    __DIR__ . '/../../ksf_ModulesDAO/vendor/autoload.php',
    __DIR__ . '/../../famock/vendor/autoload.php',
    __DIR__ . '/../../Exceptions/vendor/autoload.php',
    __DIR__ . '/../../ksf_FA_Common/vendor/autoload.php',
);
$found = false;
foreach ($paths as $p) {
    if (file_exists($p)) {
        require_once $p;
        $found = true;
    }
}
// Always load module source files explicitly (PHP 7.3 / FA 2.4.19 compatibility)
$moduleFiles = glob(__DIR__ . '/../src/**/*.php');
foreach ($moduleFiles as $f) {
    require_once $f;
}

if (!$found) {
    // Fallback PSR-4 autoload for this module
    spl_autoload_register(function ($class) {
        $prefix = 'ksfraser\\FrontAccounting\\EmployeePay\\';
        $base = __DIR__ . '/../src/';
        $len = strlen($prefix);
        if (strncmp($prefix, $class, $len) !== 0) return;
        $relative = substr($class, $len);
        $file = $base . str_replace('\\', '/', $relative) . '.php';
        if (file_exists($file)) require $file;
    });
}
