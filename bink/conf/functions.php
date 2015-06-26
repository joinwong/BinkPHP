<?php

if(!function_exists('getstrlen')){
	function getstrlen($_str){
		if(ENABLE_MB)
			return mb_strlen($_str,getCharset());
		else
			return strlen($_str);
	}
}


if(!function_exists('getsubstr')){
	function getsubstr($_str,$_start,$_length = ''){
		if(ENABLE_MB)
			return mb_substr($_str, $_start,$_length);
		else
			return substr($_str, $_start,$_length);
	}
}


if(!function_exists('L')){
	/**
	 * 加载文件 load
	 * @param  [type]
	 * @return [type]
	 */
	function L($_file){
		static $_loaded = array();
		if(isset($_loaded[$_file]))
			require $_loaded[$_file];
		else{
			is_file($_file) ? ($_loaded[$_file] = $_file) : null;
			$_loaded[$_file] = $_file;
			require $_loaded[$_file];
		}
	}
}


if(!function_exists('getCharset')){
	/**
	 * 获取默认charset
	 * @return [type]
	 */
	function getCharset(){
		$charset = C('default_charset');
		return $charset ?: 'utf-8';
	}
}



if(!function_exists('C')){
	/**
	 * 获取配置,不区分大小写 config
	 * @param  [string|array]
	 * @return [type]
	 */
	function C($_key){
		if(isset($_config[strtolower($_key)])){
			return $_config[strtolower($_key)];
		}else{
			$_core_config = CONF_PATH.DIRECTORY_SEPARATOR.'config'.EXT_NAME;
			if(file_exists($_core_config))
				require $_core_config;

			$_app_config = APP_CONF_PATH.DIRECTORY_SEPARATOR.'config'.EXT_NAME;
			if(file_exists($_app_config))
				require $_app_config;

			$_config[strtolower($_key)] = $config[strtolower($_key)];
			return $_config[$_key];
		}
	}
}


if(!function_exists('I')){
	/**
	 * 过滤输入值，input
	 * 全部转换为小写
	 * @param [type]
	 */
	function I($_key){
		$_REQUEST = array_merge($_GET,$_POST);
		$_REQUEST = array_change_key_case($_REQUEST,CASE_LOWER);
		if(isset($_REQUEST))
			return $_REQUEST[$_key];
		return NULL;
	}
}


