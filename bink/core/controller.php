<?php
namespace Bink;

class Controller extends Base{
	public $loader;

	private $_controller;
	private $_function;
	private $_param;

	public function __construct(){
		$route = getPathInfo();
		if(isset($route)){
			$this->_controller = $route['_controller'];
			$this->_function = $route['_function'];
			$this->_param = $route['_param'];
		}

		//模板加载器
		$this->loader = new Loader();
	}

	/**
	 * @return [type]
	 */
	public function run(){
		$_file_path = APP_CONTROLLER_PATH.DIRECTORY_SEPARATOR.$this->_controller.EXT_NAME;
		if(is_file($_file_path)){
			require $_file_path;
		}


		try{
			$method =   new \ReflectionMethod($this->_controller, $this->_function);

			if($method->isPublic() && !$method->isStatic()){
				$_class = new \ReflectionClass($this->_controller);
				if(isset($this->_param) && count($this->_param) > 0){
					$method->invokeArgs(new $this->_controller,array($_param));
				}else{
					$method->invoke(new $this->_controller);
				}
			}
		}catch(\Exception $ex){
			throw new \Exception('Controller:'.$this->_controller.'Function:'.$this->_function.' execute fail,ex:'.$ex);			
		}

	}

	public function display($_viewpath,$_data){
		$this->loader->view($_viewpath,$_data);
	}

}
