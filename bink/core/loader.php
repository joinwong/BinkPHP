<?php
namespace Bink;

class Loader extends Base{
	private static $view_map = array();

	public function __constructor(){
	}

	/**
	 * 加载模板
	 * @param  [type]
	 * @return [type]
	 */
	public function view($_view_path,$_data,$_contentType='text/html',$_cacheTime='',$_charset='utf-8'){
		header('Content-Type:'.$_contentType.';charset='.$_charset);
		header('X-Power-By:BinkPHP');

		extract( $_data);

		if(isset(self::$view_map[$_view_path]))
			require self::$view_map[$_view_path];
		else{
			self::$view_map[$_view_path] = APP_VIEW_PATH.DIRECTORY_SEPARATOR.$_view_path.VIEW_EXT_NAME;
			require self::$view_map[$_view_path];
		}
	}
}