<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Readscript{
	private $moduleName;
	private $controllerName;

	public function setModuleName($moduleName) {
		$this->moduleName = $moduleName;
	}
	private function getModuleName() {
		return $this->moduleName;
	}
	
	public function setControllerName($controllerName) {
		$this->controllerName = $controllerName;
	}
	private function getControllerName() {
		return $this->controllerName;
	}

	public function __construct()
    {
    	$CI =& get_instance();
		$this->request = $CI->load->library('request');
        include(DIR_FILE.'application/config/routes.php');
        
   	 	$module = $this->request->getModuleName();
   	 	$this->setModuleName($module);
   	 	
   	 	$controller = $this->request->getControllerName();
   	 	if(empty($controller) || $controller == $module){
   	 		$routesUrl = (isset($route[$module]))?$route[$module]:'';
	   	 	if($routesUrl != ''){
				$routesArr = explode('/',$routesUrl);
				$controller = $routesArr[1];
			}else{
				$controller = '';
			}
   	 	}
		$this->setControllerName($controller);
    }
	
	public function readCSS()
	{
		$realPathCss = DIR_FILE."public/module/".$this->getModuleName()."/".$this->getControllerName()."/css";
		$pathCss = $this->cutPath($realPathCss);
		$tagcss= "";
		if(is_dir($realPathCss))
		{
			$dirHandle=opendir($realPathCss);
		    while($file=readdir($dirHandle))
		    {
		        if($file!="." && $file!="..")
		        {
		             if(!is_dir($realPathCss."/".$file)) {
		             	$pathview = $pathCss."/".$file;
		             	$tagcss .=  '<link href="'.$pathview.'" type="text/css" rel="stylesheet"/>';
		            }
		        }
		    }
		    closedir($dirHandle);
		}
		return $tagcss;
	}
	
	public function readJS()
	{
		
		
		$realPathJs = DIR_FILE."public/module/".$this->getModuleName()."/".$this->getControllerName()."/js";
		$pathJs = $this->cutPath($realPathJs);
		$tagJs= "";
		if(is_dir($realPathJs))
		{
			$dirHandle=opendir($realPathJs);
		    while($file=readdir($dirHandle))
		    {
		        if($file!="." && $file!="..")
		        {
		             if(!is_dir($realPathJs."/".$file)) {
		             	$pathview = $pathJs."/".$file;
		             	$tagJs .= '<script src="'.$pathview.'" type="text/javascript"></script>';
		            }
		        }
		    }
		    closedir($dirHandle);
		}
		return $tagJs;
	}
	private function cutPath($text)
	{
		$text = str_replace("\\","/",$text);
		$pt = str_replace($_SERVER['DOCUMENT_ROOT'],"",$text);
		return $pt;
	}
}
?>