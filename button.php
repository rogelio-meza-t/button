<?php

class Button
{
    private $_server = [];
    public $pins = [];
    public $pins_path = './';


    public function __construct()
    {
        $this->_server = &$_SERVER;
    }

    public function hook($type, $pattern, $callback, $ajax = NULL)
    {        
        
        if( ($ajax !== NULL) AND (is_bool($ajax) === false) ){
            $ajax = NULL;
        }

        $this->_route(strtoupper($type), $pattern, $callback, $ajax);
        
    }

    protected function _route($method, $pattern, $callback, $ajax)
    {
        
        if ($this->_server['REQUEST_METHOD'] != $method)
        {
            return;
        }

        $regex = preg_replace('#:([\w]+)#', '(?<\\1>[^/]+)', str_replace(['*', ')'], ['[^/]+', ')?'], $pattern));

        if (substr($pattern,-1) === '/')
        {
            $regex .= '?';
        }

        if (!preg_match('#^'.$regex.'$#', $this->_server['PATH_INFO'], $values))
        {
            return;
        }

        preg_match_all('#:([\w]+)#', $pattern, $params, PREG_PATTERN_ORDER);
        $args = [];
        foreach ($params[1] as $param)
        {
            if (isset($values[$param])) $args[] = urldecode($values[$param]);
        }


        $execute = ($ajax === NULL) || !($ajax XOR $this->is_ajax());        
        if($execute === true){        
            $this->_run($callback, $args);
        }
        
    }

    protected function _run(&$callback, &$args)
    {
        $output = [];
        foreach ((array)$callback as $fn)
        {            
            $output[] = call_user_func_array($fn, $args);
        }
        header('Content-Type: application/json; charset=utf-8');
        echo json_encode($output);
    }

    public function __get($name)
    {
        if (isset($_REQUEST[$name])) return $_REQUEST[$name];
        return '';
    }

    public function sew(){
        foreach($this->pins as $pin){
            include_once $this->pins_path . $pin;
        }
    }

    private function is_ajax(){
        if (isset($_SERVER['HTTP_X_REQUESTED_WITH'])
            AND strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) === 'xmlhttprequest') {           
           return true;
        }
        return false;
    }
}
?>