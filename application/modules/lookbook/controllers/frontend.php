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
		
   	 	$this->model = $this->load->model('lookbook/Lookbookmodel');
    }

	public function index()
	{
		$this->layout->disableLayout();
		$this->view['lang'] = $lang_id = $this->request->getParam('lang');
		$this->view['listLookbook'] = $this->model->listAllLookbook($lang_id);
		$this->layout->view('/frontend/index', $this->view);
	}
}
?>