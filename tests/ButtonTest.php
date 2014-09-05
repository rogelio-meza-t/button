<?php

require ("../button.php");
class ButtonTest extends PHPUnit_Framework_TestCase{
    public function testCanHook(){
        $b = new BUtton();
        $b->hook('get', 'hello/test/', function(){});
    }
}

?>