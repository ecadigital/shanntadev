<?php 
class Backend extends CI_Controller{
	private $view;
	private $perpage = 10;
	
	public function __construct()
    {
        parent::__construct();
        $this->bflibs->setStack('admin');
		$this->model = $this->load->model('promotions/Promotionsmodel');
		$layout = ($this->request->getParam('layout') == "")?'admin':$this->request->getParam('layout');
		$this->layout->setLayout($layout);
    }
	public function index(){
		
		$this->layout->disableLayout();
		$this->view['targetpage'] = $targetpage = 'promotions/backend/list_promotions';
		$this->view['perpage'] = $this->perpage;
		$this->view['tab'] = $this->request->getParam('tab');
		$this->layout->view('/backend/index', $this->view);
	}
	/*  ARTICLES
	-------------------------------------------------------------------------------------------------------*/
	
	public function list_promotions(){

		$this->layout->setLayout('ajax');
		$this->view['modulename'] = $this->request->getModuleName();
		$page = $this->request->getParam('page');
		$limit = $this->request->getParam('limit');
		$q = $this->request->getParam('q');
		$this->view['page'] = $page = (empty($page))?1:$page;
		$this->view['limit'] = $limit = (empty($limit))?$this->perpage:$limit;
		$this->view['targetpage'] = $targetpage = 'promotions/backend/list_promotions/limit/'.$limit.'/q/'.$q;;
		list($this->view['paginaion'],$this->view['page_description'],$this->view['listPromotions']) = $this->model->listPromotions($targetpage,$page,$limit,$q);
		$this->layout->view('/backend/list_promotions', $this->view);
	}
	public function add_promotions()
	{
		$this->layout->disableLayout();
		$this->view['listAllLang'] = $this->bflibs->listAllLang();
		if($data = $this->input->post()){

			$this->model->setValue($data);
			list($success,$detail) = $this->model->addPromotions();
			if($success){
				$this->view['redirect']="<script>window.parent.loadAjax('".DIR_ROOT."promotions/backend/index','#','')</script>";
			}else{
				$this->view['redirect']="<script>window.parent.displayNotify('".$detail['error']."','error','#showWarning')</script>";
			}
		}
		$this->layout->view('/backend/add_promotions', $this->view);
	}
	public function edit_promotions()
	{
		$this->layout->disableLayout();
		$id = $this->request->getParam('id');
		$this->view['listEditPromotions'] = $this->model->listEditPromotions($id);
		$this->view['listAllLang'] = $this->bflibs->listAllLang();
		
		if($data = $this->input->post()){

			$this->model->setValue($data);
			list($success,$detail) = $this->model->editPromotions();
			if($success){
				$this->view['redirect']="<script>window.parent.loadAjax('".DIR_ROOT."promotions/backend/index','#','')</script>";
			}else{
				$this->view['redirect']="<script>window.parent.displayNotify('".$detail['error']."','error','#showWarning')</script>";
			}
		}
		
		$this->layout->view('/backend/edit_promotions', $this->view);
	}
	public function delete_promotions()
	{
		$this->layout->disableLayout();
		$id = $this->request->getParam('id');
		$this->model->deletePromotions($id);
	}
	public function delete_image()
	{
		$this->layout->disableLayout();
		$id = $this->request->getParam('id');
		$lang = $this->request->getParam('lang');
		$this->model->delete_image($id, $lang);
	}
	public function up_promotions()
	{
		$this->layout->disableLayout();
		$id = $this->request->getParam('id');
		$seq = $this->request->getParam('seq');
		$this->bflibs->upMenuDesc('promotions','promotions_id',$id,'promotions_seq',$seq);
	}
	public function down_promotions()
	{
		$this->layout->disableLayout();
		$id = $this->request->getParam('id');
		$seq = $this->request->getParam('seq');
		$this->bflibs->downMenuDesc('promotions','promotions_id',$id,'promotions_seq',$seq);
	}
	public function publish_promotions()
	{
		$this->layout->disableLayout();
		$id = $this->request->getParam('id');
		$status = $this->request->getParam('status');
		$this->bflibs->publish('promotions','promotions_id',$id,'promotions_publish',$status);
	}
}
?>