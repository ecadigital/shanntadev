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
		
   	 	$this->model = $this->load->model('jewely/Jewelymodel');
    }

	public function index()
	{
		$this->layout->disableLayout();
		$this->view['id'] = $id = $this->request->getParam('id');
		$this->view['lang'] = $lang_id = $this->request->getParam('lang');
		$this->view['getJewely'] = $this->model->getJewely($id,$lang_id);
		//$this->view['listJewely'] = $this->model->listAllJewely($lang_id,$id);
		$this->layout->view('/frontend/index', $this->view);
	}
}
?>