<?php
use Bink;

class Hello extends Bink\Controller{
	public function index(){
		$data['title'] = "我来自hello controller";		
		$data['content'] = '我很好，你呢？';
		$this->display('hello',$data);
	}

	public function view(){
		echo "我来自hello viewcontroller";
	}
}