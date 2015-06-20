<?php
namespace Bink;

class BinkPHP {
	static $load  = array();

	static function start(){
		spl_autoload_register('Bink\BinkPHP::autoload');
		set_error_handler('Bink\BinkPHP::appError');
		set_exception_handler('Bink\BinkPHP::appException');

		echo $_SERVER['PATH_INFO'];

		//加载一系列默认配置和文件
		$c = new Controllers();

	}

	/**
	 * 加载默认类库
	 * @return [type]
	 */
	static function loadLibrary(){

	}

	/**
	 * @param  [type]
	 * @return [type]
	 */
	static function autoload($class){
		$class = str_replace('bink','',strtolower($class));

		if(isset(self::$load[$class])){
			require self::$load[$class];
		}
		else{
			self::$load[$class]  = dirname(__file__).DIRECTORY_SEPARATOR.$class.EXT_NAME;
			require self::$load[$class];
		}
	}


	/**
	 * @return [type]
	 */
	static function appError($errno, $errstr, $errfile, $errline){
		return 0;
	}

	/**
	 * @return [type]
	 */
	static function appException($e){
		return 0;
	}

}