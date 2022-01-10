<?php
defined('INST_PATH') or define('INST_PATH', dirname(dirname(__FILE__)).'/');
$env_vars = parse_ini_file(INST_PATH.'.env');

define('APP_ENV', $env_vars['APP_ENV']);
define('INST_URI', $env_vars['INST_URI']);
define('SITE_NAME', $env_vars['SITE_NAME']);
define('SITE_STATUS','LIVE');
define('LANDING_PAGE','index/landing');
define('LANDING_REPLACE','ALL');

define('DEF_CONTROLLER', 'index');
define('DEF_ACTION', 'index');
define('USE_ALTER_URL', false);
define('ALTER_URL_CONTROLLER_ACTION','index/router');

ini_set('display_errors', 1);
error_reporting(E_ALL);
set_time_limit(0);
ini_set('max_execution_time',0);

define('SALT', '8c4fb7bf681156b52fea93442c7dffc9'); // Always change this string.

date_default_timezone_set('America/Bogota');
ini_set('date.timezone','America/Bogota');
setlocale(LC_ALL, 'es_CO.utf8');
putenv('LC_ALL=es_CO.utf8');
bindtextdomain('translations', INST_PATH.'locale');
$GLOBALS['env'] = APP_ENV;
?>
