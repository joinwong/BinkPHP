<?php

if(!function_exists('getPathInfo')){
	/**
	 * 解析url
	 * @param  string
	 * @return [type]
	 */
	function getPathInfo($pathinfo = ''){
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
		}
	}
}
