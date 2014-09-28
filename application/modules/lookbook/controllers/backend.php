<?php 
class Backend extends CI_Controller{
	private $view;
	private $perpageLookbook = 10;
	
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
		$this->model = $this->load->model('lookbook/Lookbookmodel');
    }
	
	
	/*  PRODUCT
	-------------------------------------------------------------------------------------------------------*/
	
	public function index()
	{
		$this->view['targetpage'] = $targetpage = 'lookbook/backend/list_lookbook';
		$this->view['perPage'] = $this->perpageLookbook;
		$this->layout->view('/backend/index', $this->view);
	}
	public function list_lookbook()
	{
		$this->layout->setLayout('ajax');
		$this->view['module'] = $this->request->getModuleName();
		$this->view['param'] = '';
		$this->view['target'] = '#boxContent';
		$this->view['targetpage'] = $targetpage = 'lookbook/backend/list_lookbook';
		
		$page = $this->request->getParam('page');
		$this->view['page'] = $page = (empty($page))?1:$page;
		
		$limit = $this->request->getParam('limit');
		$this->view['limit'] = $limit = (empty($limit))?$this->perpageLookbook:$limit;
		
		$q = $this->request->getParam('q');
		
		$targetpage = 'lookbook/backend/list_lookbook/limit/'.$limit;
		list($this->view['paginaion'],$this->view['page_description'],$this->view['listLookbook']) = $this->model->listLookbook($targetpage,$page,$limit,$q);
		$this->layout->view('/backend/list_lookbook', $this->view);
	}
	public function add_lookbook()
	{
		$this->view['listAllLang'] = $listAllLang = $this->bflibs->listAllLang();
		if($data = $this->input->post()){
		
			$this->model->setValue($data);
			$lookbook_id = $this->model->addLookbook();		
			print_r($data);
	        if(!empty($listAllLang)){foreach($listAllLang as $lang){
				$lang_id = $lang['language_id'];
				if($data['image_path_'.$lang_id]!=''){
					$this->model->upload_lookbook($data['image_path_'.$lang_id],$lookbook_id,$lang_id);
				}
			}}
						
			$this->view['redirect']="
			<script>
				window.parent.displayNotify('".lang('web_save_success')."','success','#showWarning'); 
				setTimeout(function(){
					window.parent.location='".DIR_ROOT."lookbook/backend/index';
				},3000);
			</script>";
		}
		$this->layout->view('/backend/add_lookbook', $this->view);
	}
	public function edit_lookbook()
	{
		$lookbook_id = $this->request->getParam('id');
		$this->view['listAllLang'] = $listAllLang = $this->bflibs->listAllLang();
		$this->view['listEditLookbook'] = $listEditLookbook = $this->model->listEditLookbook($lookbook_id);

		if($data = $this->input->post()){
			
			$this->model->setValue($data);
			$lookbook_id = $this->model->editLookbook();
			
	        if(!empty($listAllLang)){foreach($listAllLang as $lang){
				$lang_id = $lang['language_id'];
				if($data['image_path_'.$lang_id]!=''){
					$this->model->upload_lookbook($data['image_path_'.$lang_id],$lookbook_id,$lang_id);
				}
			}}
			
			$this->view['redirect']="
			<script>
				window.parent.displayNotify('".lang('web_save_success')."','success','#showWarning');
				setTimeout(function(){
					window.parent.location='".DIR_ROOT."lookbook/backend/index';
				},3000);
			</script>";
		}
		$this->layout->view('/backend/edit_lookbook', $this->view);
	}
	public function delete_lookbook()
	{
		$this->layout->disableLayout();
		$Array_id=array();
		if($data = $this->input->post()){
			$Array_id = explode(',',$data['id']);
		}else{
			$Array_id[0] = $this->request->getParam('id');
		}
		
		for($i=0;$i<count($Array_id);$i++){
			$this->model->deleteLookbook($Array_id[$i]);
		}
	}
	public function up_lookbook()
	{
		$this->layout->disableLayout();
		$id = $this->request->getParam('id');
		$seq = $this->request->getParam('seq');
		$this->bflibs->upMenuDesc('lookbook','lookbook_id',$id,'lookbook_seq',$seq);
	}
	public function down_lookbook()
	{
		$this->layout->disableLayout();
		$id = $this->request->getParam('id');
		$seq = $this->request->getParam('seq');
		$this->bflibs->downMenuDesc('lookbook','lookbook_id',$id,'lookbook_seq',$seq);
	}
	public function publish_lookbook()
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
			$this->bflibs->publish('lookbook','lookbook_id',$Array_id[$i],'lookbook_publish',$status);
		}
	}
	public function pin_lookbook()
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
			$this->bflibs->publish('lookbook','lookbook_id',$Array_id[$i],'lookbook_pin',$status);
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
	public function upload_image()
	{
		$this->layout->disableLayout();
		if (!empty($_FILES)) {
			$product_id = $this->request->getParam('id');
			$this->model->movefile();
		}
	}
}
?>