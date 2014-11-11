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
		
   	 	$this->model = $this->load->model('faq/Faqmodel');
    }

	public function index()
	{
		$this->layout->disableLayout();
		$this->view['lang'] = $lang_id = $this->request->getParam('lang');
		$this->view['listFaq'] = $this->model->listAllFaq($lang_id);
		$this->layout->view('/frontend/index', $this->view);
	}
}
?>