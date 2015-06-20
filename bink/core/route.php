<?php
namespace Bink;

class Route{
	private $_crontroller;
	private $_function;
	private $_param;

	static function parseRoute(){
		$route = getPathInfo();
		if(isset($route)){
			$this->_crontroller = $route['_controller'];
			$this->_function = $route['_function'];
			$this->_param = $route['_param'];
		}
	}
}