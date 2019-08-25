<?php

use core\App as App;

require_once '../vendor/autoload.php';

$cfg = \core\Config::local();

if ($cfg['site_preferences']['mode'] == 'developer' && $cfg['site_preferences']['display_errors']) {
    ini_set('error_reporting', E_ALL);
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
}

$app = new App();
$app->init()->run();
