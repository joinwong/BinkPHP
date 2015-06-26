<?php
namespace Bink;

class Log extends Base{
	const PRIORITY_INFO		= 'I';
	const PRIORITY_WARN		= 'W';
	const PRIORITY_DEBUG	= 'D';
	const PRIORITY_ERROR	= 'E';

	//最大缓存日志条数
	const MAX_FLUSH_COUNT = 5;	

	protected $log_priority = array(
		self::PRIORITY_INFO => 'INFO',
		self::PRIORITY_WARN => 'WARN',
		self::PRIORITY_DEBUG => 'DEBUG',
		self::PRIORITY_ERROR => 'ERROR'
		);

	//日志内容
	protected $log_contents = array();


	private static $instance = NULL;
	public static function getInstance(){
		//if(self::$instance == NULL){
		//	self::$instance = new Log();
		//}

		//return self::$instance;

		return new Log;
	}

	public function info($_msg){
		return $this->_log($_msg,self::PRIORITY_INFO);
	}

	public function warn($_msg){
		//$log = new Log();
		return $this->_log($_msg,self::PRIORITY_WARN);
	}

	public function debug($_msg){		
		return $this->_log($_msg,self::PRIORITY_DEBUG);
	}

	public function error($_msg){
		return $this->_log($_msg,self::PRIORITY_ERROR);
	}

	/**
	 * 析构函数
	 */
	public function __destruct(){
		if(isset($this->log_contents)){
			foreach ($this->log_contents as $key => $value) {
				$this->_flush($key);
			}
		}
	}

	private function _log($_msg,$_priority){
		if(!array_key_exists($_priority, $this->log_contents)){
			//不存在当前日志类型，创建
			$this->log_contents[$_priority] = array();
			$this->log_contents[$_priority]['count'] = 0;
			$this->log_contents[$_priority]['contents'] = '';
		}

		$this->log_contents[$_priority]['count']++;
		$this->log_contents[$_priority]['contents'] .= date('Y-m-d H:i:s') . "\t" . $_msg . PHP_EOL;
		
		if($this->log_contents[$_priority]['count'] > self::MAX_FLUSH_COUNT)
			$this->_flush($_priority);  //刷新此类型的日志

		return $this;
	}


	/**
	 * 输出缓冲区内容到硬盘
	 * @return [type]
	 */
	private function _flush($_priority){
		if(isset($_priority) && array_key_exists($_priority, $this->log_priority)){	
			$_file_path = LOG_PATH.DIRECTORY_SEPARATOR.$this->log_priority[$_priority];	
			
			if(!is_dir($_file_path)){
				mkdir($_file_path,0777,true);
			}

			$_file_path .= DIRECTORY_SEPARATOR . date('y-m-d_H') . '.log' ;
			
			$_fid = @fopen($_file_path, 'a+');
			if($_fid){
				fwrite($_fid, $this->log_contents[$_priority]['contents']);
				$this->log_contents[$_priority]['count'] = 0;
				$this->log_contents[$_priority]['contents'] = '';
				//fflush($_fid);
				fclose($_fid);
			}
		}
	}
}