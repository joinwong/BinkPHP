<?php
namespace Bink;

class Controller extends Base{
	public $loader;

	private $_controller;
	private $_function;
	private $_param;

	public function __construct(){
		$route = $this->getPathInfo();
		if(isset($route)){
			$this->_controller = $route['_controller'];
			$this->_function = $route['_function'];
			$this->_param = $route['_param'];
		}

		//模板加载器
		$this->loader = new Loader();
	}

	/**
	 * 解析url
	 * @param  string
	 * @return [type]
	 */
	private function getPathInfo($pathinfo = ''){
		$pathinfo = $pathinfo !='' ?: $_SERVER['PATH_INFO'];
		if(isset($pathinfo)){
			$pathinfo = ltrim($pathinfo,'/');
			$arr = explode('/', $pathinfo);
			
			$tmp = array_splice($arr, 0 ,2);
			list($_controller,$_function) = $tmp;
			unset($tmp);

			for($i=0,$len=count($arr);$i<$len;$i+=2){
				$param[$arr[$i]] = $arr[$i+1];
			}

			$param = array_merge($param,$_REQUEST);

			return array(
				'_controller' =>ucfirst( $_controller),
				'_function' => $_function,
				'_param' => $param
			);
		}else{
			return array(
				'_controller' =>ucfirst( Config::getConfig('default_controller')),
				'_function' => Config::getConfig('default_index'),
				'_param' => ''
			);
		}
	}

	/**
	 * @return [type]
	 */
	public function execute(){
		$_file_path = APP_CONTROLLER_PATH.DIRECTORY_SEPARATOR.$this->_controller.EXT_NAME;
		load($_file_path);


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

	/**
	 * @param  [type]
	 * @param  [type]
	 * @return [type]
	 */
	public function display($_viewpath,$_data){
		$this->loader->view($_viewpath,$_data);
	}

}
