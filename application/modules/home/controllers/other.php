<?php 
class other extends CI_Controller{
	public function __construct()
    {
        parent::__construct();
		
		$layout = ($this->request->getParam('layout') == "")?'default':$this->request->getParam('layout');
		$this->layout->setLayout($layout);
		// set lang
		$lang_id = $this->request->getParam('lang');
    	$this->bflibs->setLang($lang_id,$_SERVER['REQUEST_URI']);
    	
   	 	$actions=$this->bflibs->insertActionStackFront();
   	 	if(!empty($actions)){
			foreach($actions as $action)
			{
				$this->layout->setActionStack($action["name"],$action["view"]);
			}
   	 	}
    }
	public function contactus()
	{
		$this->layout->view('contactus');
	}
}
?>