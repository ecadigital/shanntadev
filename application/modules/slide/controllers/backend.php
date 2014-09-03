<?php 
class Backend extends CI_Controller{
	private $view;
	private $perpageSlide = 10;
	
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
		$this->model = $this->load->model('slide/Slidemodel');
    }
	
	
	/*  PRODUCT
	-------------------------------------------------------------------------------------------------------*/
	
	public function index()
	{
		$this->view['targetpage'] = $targetpage = 'slide/backend/list_slide';
		$this->view['perPage'] = $this->perpageSlide;
		$this->layout->view('/backend/index', $this->view);
	}
	public function list_slide()
	{
		$this->layout->setLayout('ajax');
		$this->view['module'] = $this->request->getModuleName();
		$this->view['param'] = '';
		$this->view['target'] = '#boxContent';
		$this->view['targetpage'] = $targetpage = 'slide/backend/list_slide';
		
		$page = $this->request->getParam('page');
		$this->view['page'] = $page = (empty($page))?1:$page;
		
		$limit = $this->request->getParam('limit');
		$this->view['limit'] = $limit = (empty($limit))?$this->perpageSlide:$limit;
		
		$q = $this->request->getParam('q');
		
		$targetpage = 'slide/backend/list_slide/limit/'.$limit;
		list($this->view['paginaion'],$this->view['page_description'],$this->view['listSlide']) = $this->model->listSlide($targetpage,$page,$limit,$q);
		$this->layout->view('/backend/list_slide', $this->view);
	}
	public function add_slide()
	{
		if($data = $this->input->post()){
		
			$this->model->setValue($data);
			$slide_id = $this->model->addSlide();			
			$this->bflibs->addLog('log_add_slide',$data['slide_name'],DIR_ROOT.'slide/backend/edit_slide/id/'.$slide_id);
			
			if($data['image_path']!=''){
				$this->model->upload($data['image_path'],$slide_id);
			}
			
			$this->view['redirect']="
			<script>
				window.parent.displayNotify('".lang('web_save_success')."','success','#showWarning'); 
				setTimeout(function(){
					window.parent.location='".DIR_ROOT."slide/backend/add_slide';
				},3000);
			</script>";
		}else{
			$this->model->clearTmpImages();
		}
		$this->layout->view('/backend/add_slide', $this->view);
	}
	public function edit_slide()
	{
		$slide_id = $this->request->getParam('id');
		$this->view['listEditSlide'] = $listEditSlide = $this->model->listEditSlide($slide_id);

		if($data = $this->input->post()){
			
			$this->model->setValue($data);
			$slide_id = $this->model->editSlide();
			$this->bflibs->addLog('log_edit_slide',$data['slide_name'],DIR_ROOT.'slide/backend/edit_slide/id/'.$slide_id);
			
			if($data['image_path']!=''){
				$this->model->upload($data['image_path'],$slide_id);
			}
			
			$this->view['redirect']="
			<script>
				window.parent.displayNotify('".lang('web_save_success')."','success','#showWarning');
				setTimeout(function(){
					window.parent.location='".DIR_ROOT."slide/backend/index';
				},3000);
			</script>";
		}else{
			$this->model->clearTmpImages();
		}
		$this->layout->view('/backend/edit_slide', $this->view);
	}
	public function delete_slide()
	{
		$this->layout->disableLayout();
		$Array_id=array();
		if($data = $this->input->post()){
			$Array_id = explode(',',$data['id']);
		}else{
			$Array_id[0] = $this->request->getParam('id');
		}
		
		for($i=0;$i<count($Array_id);$i++){
			$this->model->deleteSlide($Array_id[$i]);
		}
	}
	public function up_slide()
	{
		$this->layout->disableLayout();
		$id = $this->request->getParam('id');
		$seq = $this->request->getParam('seq');
		$this->bflibs->upMenuDesc('slide','slide_id',$id,'slide_seq',$seq);
	}
	public function down_slide()
	{
		$this->layout->disableLayout();
		$id = $this->request->getParam('id');
		$seq = $this->request->getParam('seq');
		$this->bflibs->downMenuDesc('slide','slide_id',$id,'slide_seq',$seq);
	}
	public function publish_slide()
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
			$this->bflibs->publish('slide','slide_id',$Array_id[$i],'slide_publish',$status);
		}
	}
	public function pin_slide()
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
			$this->bflibs->publish('slide','slide_id',$Array_id[$i],'slide_pin',$status);
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
	
	public function delete_image()
	{
		$this->layout->disableLayout();
		if($data = $this->input->post())
		{
			$this->model->setValue($data);
			$this->model->delete_image();
		}
	}
	public function upload_image()
	{
		$this->layout->disableLayout();
		if (!empty($_FILES)) {
			$slide_id = $this->request->getParam('id');
			$this->model->movefile();
		}
	}
}
?>