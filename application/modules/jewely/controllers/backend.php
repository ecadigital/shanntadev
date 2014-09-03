<?php 
class Backend extends CI_Controller{
	private $view;
	private $perpageJewely = 10;
	
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
		$this->model = $this->load->model('jewely/Jewelymodel');
    }
	
	
	/*  PRODUCT
	-------------------------------------------------------------------------------------------------------*/
	
	public function index()
	{
		$this->view['targetpage'] = $targetpage = 'jewely/backend/list_jewely';
		$this->view['perPage'] = $this->perpageJewely;
		$this->layout->view('/backend/index', $this->view);
	}
	public function list_jewely()
	{
		$this->layout->setLayout('ajax');
		$this->view['module'] = $this->request->getModuleName();
		$this->view['param'] = '';
		$this->view['target'] = '#boxContent';
		$this->view['targetpage'] = $targetpage = 'jewely/backend/list_jewely';
		
		$page = $this->request->getParam('page');
		$this->view['page'] = $page = (empty($page))?1:$page;
		
		$limit = $this->request->getParam('limit');
		$this->view['limit'] = $limit = (empty($limit))?$this->perpageJewely:$limit;
		
		$q = $this->request->getParam('q');
		
		$targetpage = 'jewely/backend/list_jewely/limit/'.$limit;
		list($this->view['paginaion'],$this->view['page_description'],$this->view['listJewely']) = $this->model->listJewely($targetpage,$page,$limit,$q);
		$this->layout->view('/backend/list_jewely', $this->view);
	}
	public function add_jewely()
	{
		if($data = $this->input->post()){
		
			$this->model->setValue($data);
			$jewely_id = $this->model->addJewely();			
			$this->bflibs->addLog('log_add_jewely',$data['jewely_name'],DIR_ROOT.'jewely/backend/edit_jewely/id/'.$jewely_id);
			
			if(isset($data['file_upload'])){
				$this->model->upload($data['file_upload'],$jewely_id);
			}
			$this->view['redirect']="
			<script>
				window.parent.displayNotify('".lang('web_save_success')."','success','#showWarning'); 
				setTimeout(function(){
					window.parent.location='".DIR_ROOT."jewely/backend/index';
				},3000);
			</script>";
		}else{
			$this->model->clearTmpImages();
		}
		$this->layout->view('/backend/add_jewely', $this->view);
	}
	public function edit_jewely()
	{
		$jewely_id = $this->request->getParam('id');
		$this->view['listEditJewely'] = $listEditJewely = $this->model->listEditJewely($jewely_id);

		if($data = $this->input->post()){
			
			$this->model->setValue($data);
			$jewely_id = $this->model->editJewely();
			$this->bflibs->addLog('log_edit_jewely',$data['jewely_name'],DIR_ROOT.'jewely/backend/edit_jewely/id/'.$jewely_id);
			
			if(isset($data['file_upload'])){
				$this->model->upload($data['file_upload'],$jewely_id);
			}
			if(isset($data['FileCancel'])){
				$this->model->file_cancel($data['FileCancel'],$jewely_id);
			}
			$this->view['redirect']="
			<script>
				window.parent.displayNotify('".lang('web_save_success')."','success','#showWarning');
				setTimeout(function(){
					window.parent.location='".DIR_ROOT."jewely/backend/index';
				},3000);
			</script>";
		}else{
			$this->model->clearTmpImages();
		}
		$this->layout->view('/backend/edit_jewely', $this->view);
	}
	public function delete_jewely()
	{
		$this->layout->disableLayout();
		$Array_id=array();
		if($data = $this->input->post()){
			$Array_id = explode(',',$data['id']);
		}else{
			$Array_id[0] = $this->request->getParam('id');
		}
		
		for($i=0;$i<count($Array_id);$i++){
			$this->model->deleteJewely($Array_id[$i]);
		}
	}
	public function up_jewely()
	{
		$this->layout->disableLayout();
		$id = $this->request->getParam('id');
		$seq = $this->request->getParam('seq');
		$this->bflibs->upMenuDesc('jewely','jewely_id',$id,'jewely_seq',$seq);
	}
	public function down_jewely()
	{
		$this->layout->disableLayout();
		$id = $this->request->getParam('id');
		$seq = $this->request->getParam('seq');
		$this->bflibs->downMenuDesc('jewely','jewely_id',$id,'jewely_seq',$seq);
	}
	public function publish_jewely()
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
			$this->bflibs->publish('jewely','jewely_id',$Array_id[$i],'jewely_publish',$status);
		}
	}
	public function pin_jewely()
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
			$this->bflibs->publish('jewely','jewely_id',$Array_id[$i],'jewely_pin',$status);
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
	public function upload_images()
	{
		$this->layout->disableLayout();
		if (!empty($_FILES)) {
			$folder = DIR_FILE.DS.'public'.DS.'upload'.DS.$this->request->getModuleName();
			if(!file_exists($folder)){mkdir($folder);}
			$this->model->movefile();
		}
	}
}
?>