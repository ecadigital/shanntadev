<?php 
class Backend extends CI_Controller{
	private $view;
	private $perpageFaq = 10;
	
	public function __construct()
    {
        parent::__construct();
    	if($this->request->getParam('check_login') != 'ignor'){
	     	$this->bflibs->check_login_admin();
			$admin= $this->session->userdata('admin');
	   		if(empty($admin->admin_id)){
	        	redirect('/admin/admin/login', 'refresh');
	        }
   	 	}
		$layout = ($this->request->getParam('layout') == "")?'admin':$this->request->getParam('layout');
		$this->layout->setLayout($layout);
		$this->bflibs->setStack('admin');
		$actions = $this->bflibs->insertActionStack();
    	foreach($actions as $action)
		{
			$this->layout->setActionStack($action["name"],$action["view"]);
		}
		$this->model = $this->load->model('faq/Faqmodel');
    }
	
	
	/*  PRODUCT
	-------------------------------------------------------------------------------------------------------*/
	
	public function index()
	{
		$this->view['targetpage'] = $targetpage = 'faq/backend/list_faq';
		$this->view['perPage'] = $this->perpageFaq;
		$this->layout->view('/backend/index', $this->view);
	}
	public function list_faq()
	{
		$this->layout->setLayout('ajax');
		$this->view['module'] = $this->request->getModuleName();
		$this->view['param'] = '';
		$this->view['target'] = '#boxContent';
		$this->view['targetpage'] = $targetpage = 'faq/backend/list_faq';
		
		$page = $this->request->getParam('page');
		$this->view['page'] = $page = (empty($page))?1:$page;
		
		$limit = $this->request->getParam('limit');
		$this->view['limit'] = $limit = (empty($limit))?$this->perpageFaq:$limit;
		
		$q = $this->request->getParam('q');
		
		$targetpage = 'faq/backend/list_faq/limit/'.$limit;
		list($this->view['paginaion'],$this->view['page_description'],$this->view['listFaq']) = $this->model->listFaq($targetpage,$page,$limit,$q);
		$this->layout->view('/backend/list_faq', $this->view);
	}
	public function add_faq()
	{
		$this->view['listAllLang'] = $this->bflibs->listAllLang();
		if($data = $this->input->post()){
		
			$this->model->setValue($data);
			$faq_id = $this->model->addFaq();			
			$this->bflibs->addLog('log_add_faq',$data['faq_name'],DIR_ROOT.'faq/backend/edit_faq/id/'.$faq_id);
			
			$this->view['redirect']="
			<script>
				window.parent.displayNotify('".lang('web_save_success')."','success','#showWarning'); 
				setTimeout(function(){
					window.parent.location='".DIR_ROOT."faq/backend/index';
				},3000);
			</script>";
		}
		$this->layout->view('/backend/add_faq', $this->view);
	}
	public function edit_faq()
	{
		$faq_id = $this->request->getParam('id');
		$this->view['listAllLang'] = $this->bflibs->listAllLang();
		$this->view['listEditFaq'] = $listEditFaq = $this->model->listEditFaq($faq_id);

		if($data = $this->input->post()){
			
			$this->model->setValue($data);
			$faq_id = $this->model->editFaq();
			$this->bflibs->addLog('log_edit_faq',$data['faq_name'],DIR_ROOT.'faq/backend/edit_faq/id/'.$faq_id);
			
			$this->view['redirect']="
			<script>
				window.parent.displayNotify('".lang('web_save_success')."','success','#showWarning');
				setTimeout(function(){
					window.parent.location='".DIR_ROOT."faq/backend/index';
				},3000);
			</script>";
		}
		$this->layout->view('/backend/edit_faq', $this->view);
	}
	public function delete_faq()
	{
		$this->layout->disableLayout();
		$Array_id=array();
		if($data = $this->input->post()){
			$Array_id = explode(',',$data['id']);
		}else{
			$Array_id[0] = $this->request->getParam('id');
		}
		
		for($i=0;$i<count($Array_id);$i++){
			$this->model->deleteFaq($Array_id[$i]);
		}
	}
	public function up_faq()
	{
		$this->layout->disableLayout();
		$id = $this->request->getParam('id');
		$seq = $this->request->getParam('seq');
		$this->bflibs->upMenuDesc('faq','faq_id',$id,'faq_seq',$seq);
	}
	public function down_faq()
	{
		$this->layout->disableLayout();
		$id = $this->request->getParam('id');
		$seq = $this->request->getParam('seq');
		$this->bflibs->downMenuDesc('faq','faq_id',$id,'faq_seq',$seq);
	}
	public function publish_faq()
	{
		$this->layout->disableLayout();
		$status = $this->request->getParam('status');
		
		$Array_id=array();
		if($data = $this->input->post()){
			$Array_id = explode(',',$data['id']);
		}else{
			$Array_id[0] = $this->request->getParam('id');
		}
		
		for($i=0;$i<count($Array_id);$i++){
			$this->bflibs->publish('faq','faq_id',$Array_id[$i],'faq_publish',$status);
		}
	}
	public function pin_faq()
	{
		$this->layout->disableLayout();
		$status = $this->request->getParam('status');
		
		$Array_id=array();
		if($data = $this->input->post()){
			$Array_id = explode(',',$data['id']);
		}else{
			$Array_id[0] = $this->request->getParam('id');
		}
		
		for($i=0;$i<count($Array_id);$i++){
			$this->bflibs->publish('faq','faq_id',$Array_id[$i],'faq_pin',$status);
		}
	}


	/*  AJAX
	-------------------------------------------------------------------------------------------------------*/

	public function showAjax()
	{
		$this->layout->disableLayout();
		$type = $this->request->getParam('type');
		switch ($type){
			case 'remove_file':{
				$data = $this->input->post();
				$this->model->remove_file($data['file']);
				break;
			}
		}
		
	}
}
?>