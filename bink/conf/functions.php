<?php

/**
 * 
 */
if(!function_exists('getstrlen')){
	function getstrlen($_str){
		if(ENABLE_MB)
			return mb_strlen($_str,getCharset());
		else
			return strlen($_str);
	}
}


/**
 * 
 */
if(!function_exists('getsubstr')){
	function getsubstr($_str,$_start,$_length = ''){
		if(ENABLE_MB)
			return mb_substr($_str, $_start,$_length);
		else
			return substr($_str, $_start,$_length);
	}
}

/**
 * 加载文件
 */
if(!function_exists('load')){
	function load($_file){
		static $_loaded = array();
		if(isset($_loaded[$_file]))
			require $_loaded[$_file];
		else{
			is_file($_file) ? $_loaded[$_file] = $_file : null;
			require $_loaded[$_file];
		}
	}
}

/**
 * 默认utf-8
 */
if(!function_exists('getCharset')){
	function getCharset(){
		$charset = getConfig('default_charset');
		return $charset ?: 'utf-8';
	}
}

if(!function_exists('getConfig')){
	function getConfig($_key){
		static $_config = array();
		if(isset($_config[$_key])){
			return $_config[$_key];
		}else{
			$_core_config = CONF_PATH.DIRECTORY_SEPARATOR.'config'.EXT_NAME;
			load($_core_config);

			$_app_config = APP_CONF_PATH.DIRECTORY_SEPARATOR.'config'.EXT_NAME;
			load($_app_config);

			$_config[$_key] = $config[$_key];
			return $_config[$_key];
		}
	}
}
