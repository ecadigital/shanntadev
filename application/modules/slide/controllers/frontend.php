<?php 
class Frontend extends CI_Controller{
	private $view;
	
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
   	 	$this->model = $this->load->model('slide/Slide_frontmodel');
    }

	public function list_slide()
	{
		$this->layout->disableLayout();
		$lang_id = $this->request->getParam('lang');
		$this->view['listSlide'] = $this->model->listSlide($lang_id);
		$this->layout->view('/frontend/list_slide', $this->view);
	}
	
	
}
?>