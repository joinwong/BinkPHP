<?php
header('content-type:text/html;charset=utf-8');

class sub{

}

class A{
	public $var1;
	public $var2;

/**/
	public function __clone(){
		$this->var1 = clone $this->var1;
	}
	/**/
}






$a = new A;
$a->var1 = new sub();
$a->var2 = new sub();

$b = clone $a;

xdebug_debug_zval('a');
xdebug_debug_zval('b');


$a->var2 = 4;
xdebug_debug_zval('a');
xdebug_debug_zval('b');

var_dump(token_get_all('<?php echo $a?>'));