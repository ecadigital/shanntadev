<?php 
class Frontend extends CI_Controller{
	private $view;
	public $perPage=12;
	
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
   	 	$this->model = $this->load->model('promotions/Promotionsmodel');
    }
	public function index(){

		$this->view['modulename'] = $this->request->getModuleName();
		$page = $this->request->getParam('page');
		$limit = $this->request->getParam('limit');
		$q = $this->request->getParam('q');
		$this->view['page'] = $page = (empty($page))?1:$page;
		$this->view['limit'] = $limit = (empty($limit))?$this->perPage:$limit;
		$this->view['targetpage'] = $targetpage = 'promotions/frontend/index';
		list($this->view['paginaion'],$this->view['page_description'],$this->view['listPromotions']) = $this->model->listPromotionsFront($targetpage,$page,$limit,$q);
		$this->layout->view('/frontend/index', $this->view);
	}
	public function detail(){
	
		$id = $this->request->getParam('id');
		$this->view['listDetailPromotions'] = $this->model->listDetailPromotions($id);
		$this->layout->view('/frontend/detail', $this->view);
	}
}
?>