<?php
namespace Bink;

class Config extends Base{
	private static $_config = array();

	/**
	 * @param  [type]
	 * @return [type]
	 */
	public function getConfig($_key){
		if(isset(self::$_config[$_key])){
			return $_config[$_key];
		}else{
			$_core_config = CONF_PATH.DIRECTORY_SEPARATOR.'config'.EXT_NAME;
			if(file_exists($_core_config))
				require $_core_config;
			$_app_config = APP_CONF_PATH.DIRECTORY_SEPARATOR.'config'.EXT_NAME;
			if(file_exists($_app_config))
				require $_app_config;

			self::$_config[$_key] = $config[$_key];
			return self::$_config[$_key];
		}
	}

}