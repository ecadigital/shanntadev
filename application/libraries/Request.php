<?php 
if (!defined('BASEPATH')) exit('No direct script access allowed');
class Request{

	var $_params = array();
    
	public function getModuleName()
    {
		return $this->_params['module'];
    }
	public function getControllerName()
    {
		return $this->_params['controller'];
    }
	public function getActionName()
    {
		return $this->_params['action'];
    }
    
	public function __construct()
    {
    	if(DIR_ROOT == '/'){
   	 		$new_params = array();
    		$params = explode('/',$_SERVER['REQUEST_URI']);
    		foreach($params as $index=>$param){
    			if($index != 0)$new_params[] = $param;
    		}
    		$params = $new_params;
    	}else{
	    	$basepath = explode(DIR_ROOT,$_SERVER['REQUEST_URI']);
			$params = explode('/',$basepath[1]);
    	}
    	
		$count = (count($params)>3)?count($params)-1:count($params);
		$this->_params['controller'] = $params[0];
    	$this->_params['action']='index';
		for($i=0;$i<$count;$i++){
			switch($i){
				case 0 : {$this->_params['module'] = $params[$i];break;}
				case 1 : {$this->_params['controller'] = $params[$i];break;}
				case 2 : {$this->_params['action'] = $params[$i];break;}
				default : {$this->_params[$params[$i]] = $params[++$i];break;}
			}
		}
    }
    public function getParam($key)
    {
		return (isset($this->_params[$key]))?$this->_params[$key]:'';
    }
}
?>