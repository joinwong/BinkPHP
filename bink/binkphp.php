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
defined('APP_CONTROLLERS_PATH') or define('APP_CONTROLLERS_PATH', BASE_PATH.'/controllers');
defined('APP_MODELS_PATH') or define('APP_MODELS_PATH', BASE_PATH.'/models');
defined('APP_VIEWS_PATH') or define('APP_VIEWS_PATH', BASE_PATH.'/views');

defined('EXT_NAME') or define('EXT_NAME','.php');

//核心类
require CORE_PATH.'/binkphp'.EXT_NAME;

Bink\BinkPHP::start();