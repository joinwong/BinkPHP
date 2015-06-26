<?php
namespace Bink;

class Controller extends Base{
	public $loader;

	private $_controller;
	private $_function;
	private $_request;

	public function __construct(){
		$_route = $this->_getPathInfo();
		if(isset($_route)){
			$this->_controller = $_route['_controller'];
			$this->_function = $_route['_function'];
			$this->_request = $_route['_request'];
		}

		//模板加载器
		$this->loader = new Loader();
	}

	/**
	 * 解析url
	 * @param  string
	 * @return [type]
	 */
	private function _getPathInfo($pathinfo = ''){
		$pathinfo = $pathinfo !='' ?: (isset($_SERVER['PATH_INFO'])?:$_SERVER['PATH_INFO']);
		if(isset($pathinfo)){
			$pathinfo = ltrim($pathinfo,'/');
			$arr = explode('/', $pathinfo);
			
			$tmp = array_splice($arr, 0 ,2);
			list($_controller,$_function) = $tmp;
			unset($tmp);

			for($i=0,$len=count($arr);$i<$len;$i+=2){
				$_GET[$arr[$i]] = $arr[$i+1];
			}

			return array(
				'_controller' =>ucfirst( $_controller),
				'_function' => $_function,
				'_request' => $_REQUEST
			);
		}else{
			return array(
				'_controller' =>ucfirst(C('default_controller')),
				'_function' => C('default_index'),
				'_request' => ''
			);
		}
	}

	/**
	 * @return [type]
	 */
	public function execute(){
		$_file_path = APP_CONTROLLER_PATH.DIRECTORY_SEPARATOR.$this->_controller.EXT_NAME;
		L($_file_path);

		try{
			$method =   new \ReflectionMethod($this->_controller, $this->_function);

			if($method->isPublic() && !$method->isStatic()){
				$_class = new \ReflectionClass($this->_controller);
				if(isset($this->_request) && count($this->_request) > 0){
					$method->invokeArgs(new $this->_controller,array($this->_request));
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
	 * @param  string
	 * @param  string
	 * @param  string
	 * @return [type]
	 */
	public function display($_viewpath,$_data,$_contentType='text/html',$_cacheTime='',$_charset='utf-8'){
		$this->loader->view($_viewpath,$_data,$_contentType,$_cacheTime,$_charset);
	}

}
