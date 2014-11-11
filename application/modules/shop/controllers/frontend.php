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
   	 	$this->model = $this->load->model('shop/Shopmodel');
    }

	public function index()
	{
		$this->layout->disableLayout();
		$this->view['lang'] = $lang_id = $this->request->getParam('lang');
		$this->view['listShop'] = $this->model->listAllShop($lang_id);
		$this->layout->view('/frontend/index', $this->view);
	}
	public function detail()
	{
		$this->layout->disableLayout();
		$this->view['shop_id'] = $shop_id = $this->request->getParam('id');
		$this->view['lang'] = $lang_id = $this->request->getParam('lang');
		$this->view['getShop'] = $this->model->getShop($lang_id,$shop_id);
		$this->layout->view('/frontend/detail', $this->view);
	}
}
?>