<?php
//入口文件
const BINK_VERSION = '1.0.0';

defined('BASE_PATH') or define('BASE_PATH', './bink');
defined('CONF_PATH') or define('CONF_PATH', BASE_PATH.'/conf');
defined('CORE_PATH') or define('CORE_PATH', BASE_PATH.'/core');
defined('HOOK_PATH') or define('HOOK_PATH', BASE_PATH.'/hooks');
defined('LANG_PATH') or define('LANG_PATH', BASE_PATH.'/lang');
defined('DATABASE_PATH') or define('DATABASE_PATH', BASE_PATH.'/lang');

defined('APP_CONF_PATH') or define('APP_CONF_PATH', APP_PATH.'/conf');
defined('APP_CONTROLLERS_PATH') or define('APP_CONTROLLER_PATH', APP_PATH.'/controller');
defined('APP_MODELS_PATH') or define('APP_MODEL_PATH', APP_PATH.'/model');
defined('APP_VIEWS_PATH') or define('APP_VIEW_PATH', APP_PATH.'/view');

defined('EXT_NAME') or define('EXT_NAME','.php');
defined('VIEW_EXT_NAME') or define('VIEW_EXT_NAME','.views.php');

//核心类
require CORE_PATH.'/binkphp'.EXT_NAME;

Bink\BinkPHP::start();