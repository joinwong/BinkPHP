<?php
use Bink;

class Hello extends Bink\Controller{
	public function index(){
		$data['title'] = "我来自hello controller";		
		$data['content'] = '我很好，你呢？';


		$this->display('hello',$data);
	}

	public function view(){
		$start = microtime(1);
		for($i=0;$i<100000000;$i++){

		}
		$end = microtime(1);
		echo 'total:'.($end-$start);
	}
}