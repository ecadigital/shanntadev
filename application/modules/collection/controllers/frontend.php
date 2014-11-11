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
		
   	 	$this->model = $this->load->model('collection/Collection_frontmodel');
    }

	public function index()
	{
		$this->layout->disableLayout();
		$this->view['lang'] = $lang_id = $this->request->getParam('lang');
		$this->view['listCategories'] = $this->model->listAllCategories($lang_id);
		$this->layout->view('/frontend/index', $this->view);
	}
	public function widget()
	{
		$this->layout->disableLayout();
		$this->view['lang'] = $lang_id = $this->request->getParam('lang');
		$this->view['getCategories'] = $this->model->getFirstCategories($lang_id);
		$this->layout->view('/frontend/widget', $this->view);
	}
	public function list_collection()
	{
		$this->layout->disableLayout();
		$lang_id = $this->request->getParam('lang');
		$collection_categories_id = $this->request->getParam('cat');
		$this->view['listCollection'] = $this->model->listCollection($lang_id,$collection_categories_id);
		$this->layout->view('/frontend/list_collection', $this->view);
	}
	public function get_bannercategories()
	{
		$this->layout->disableLayout();
		$lang_id = $this->request->getParam('lang');
		$collection_categories_id = $this->request->getParam('cat');
		$this->view['getCategories'] = $this->model->getCategories($lang_id,$collection_categories_id);
		$this->layout->view('/frontend/get_bannercategories', $this->view);
	}
}
?>