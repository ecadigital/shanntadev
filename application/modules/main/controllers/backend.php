<?php 
class Backend extends CI_Controller{
	private $view;
	private $perpageMain = 10;
	
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
		$this->model = $this->load->model('main/Mainmodel');
    }
	
	
	/*  MAIN
	-------------------------------------------------------------------------------------------------------*/
	
	public function index()
	{
		$this->view['p'] = $p = $this->request->getParam('p');
		$this->view['listEditMain'] = $listEditMain = $this->model->listEditMain();

		if($data = $this->input->post()){
			
			$this->model->setValue($data);
			$this->model->editMain();
			//$this->bflibs->addLog('log_edit_main',$data['main_name'],DIR_ROOT.'main/backend/index/p/'.$data['p']);
			//print_r($_FILES);
			if($data['image_path']!=''){
				$this->model->upload($data['image_path'],$data['p']);
			}
			
			$this->view['redirect']="
			<script>
				window.parent.displayNotify('".lang('web_save_success')."','success','#showWarning');
				setTimeout(function(){
					//window.parent.location='".DIR_ROOT."main/backend/index/p/".$data['p']."';
				},3000);
			</script>";
		}else{
			$this->model->clearTmpImages();
		}
		$this->layout->view('/backend/index', $this->view);
	}
	public function delete_main()
	{
		$this->layout->disableLayout();
		$Array_id=array();
		if($data = $this->input->post()){
			$Array_id = explode(',',$data['id']);
		}else{
			$Array_id[0] = $this->request->getParam('id');
		}
		
		for($i=0;$i<count($Array_id);$i++){
			$this->model->deleteMain($Array_id[$i]);
		}
	}
	public function up_main()
	{
		$this->layout->disableLayout();
		$id = $this->request->getParam('id');
		$seq = $this->request->getParam('seq');
		$this->bflibs->upMenuDesc('main','main_id',$id,'main_seq',$seq);
	}
	public function down_main()
	{
		$this->layout->disableLayout();
		$id = $this->request->getParam('id');
		$seq = $this->request->getParam('seq');
		$this->bflibs->downMenuDesc('main','main_id',$id,'main_seq',$seq);
	}
	public function publish_main()
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
			$this->bflibs->publish('main','main_id',$Array_id[$i],'main_publish',$status);
		}
	}
	public function pin_main()
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
			$this->bflibs->publish('main','main_id',$Array_id[$i],'main_pin',$status);
		}
	}
	public function intro()
	{
		//$this->view['listAllLang'] = $listAllLang = $this->bflibs->listAllLang();
		$this->view['listEditMain'] = $listEditMain = $this->model->listEditMain();

		if($data = $this->input->post()){
			//print_r($_POST);
			$this->model->setValue($data);
			$this->model->editIntro();
			
			$this->view['redirect']="
			<script>
				window.parent.displayNotify('".lang('web_save_success')."','success','#showWarning');
				setTimeout(function(){
					window.parent.location='".DIR_ROOT."main/backend/intro';
				},3000);
			</script>";
		}
		$this->layout->view('/backend/intro', $this->view);
	}
	public function contact()
	{
		$this->view['listEditMain'] = $listEditMain = $this->model->listEditMain();

		if($data = $this->input->post()){
			$this->model->setValue($data);			
			$this->model->editContact();
			
			$this->view['redirect']="
			<script>
				window.parent.displayNotify('".lang('web_save_success')."','success','#showWarning');
				setTimeout(function(){
					window.parent.location='".DIR_ROOT."main/backend/contact';
				},3000);
			</script>";
		}
		$this->layout->view('/backend/contact', $this->view);
	}
	/*public function lookbook()
	{
		$this->view['listAllLang'] = $listAllLang = $this->bflibs->listAllLang();
		$this->view['listEditMain'] = $listEditMain = $this->model->listEditLookbook();

		if($data = $this->input->post()){
			$this->model->setValue($data);			
			
	        if(!empty($listAllLang)){foreach($listAllLang as $lang){
				$lang_id = $lang['language_id'];
				if($data['image_path_'.$lang_id]!=''){
					$this->model->upload_lookbook($data['image_path_'.$lang_id],$lang_id);
				}
			}}
			
			$this->view['redirect']="
			<script>
				window.parent.displayNotify('".lang('web_save_success')."','success','#showWarning');
				setTimeout(function(){
					window.parent.location='".DIR_ROOT."main/backend/lookbook';
				},3000);
			</script>";
		}
		$this->layout->view('/backend/lookbook', $this->view);
	}*/
	public function policy()
	{
		$this->view['listAllLang'] = $listAllLang = $this->bflibs->listAllLang();
		$this->view['listEditMain'] = $listEditMain = $this->model->listEditMainLang();

		if($data = $this->input->post()){
			$this->model->setValue($data);
			
	        if(!empty($listAllLang)){foreach($listAllLang as $lang){
				$lang_id = $lang['language_id'];
				$this->model->editMainLang($lang_id);
			}}
			
			$this->view['redirect']="
			<script>
				window.parent.displayNotify('".lang('web_save_success')."','success','#showWarning');
				setTimeout(function(){
					window.parent.location='".DIR_ROOT."main/backend/policy';
				},3000);
			</script>";
		}
		$this->layout->view('/backend/policy', $this->view);
	}
	public function shipping()
	{
		$this->view['listAllLang'] = $listAllLang = $this->bflibs->listAllLang();
		$this->view['listEditMain'] = $listEditMain = $this->model->listEditMainLang();

		if($data = $this->input->post()){
			$this->model->setValue($data);	
			
	        if(!empty($listAllLang)){foreach($listAllLang as $lang){
				$lang_id = $lang['language_id'];
				$this->model->editMainLang($lang_id);
			}}
			
			$this->view['redirect']="
			<script>
				window.parent.displayNotify('".lang('web_save_success')."','success','#showWarning');
				setTimeout(function(){
					window.parent.location='".DIR_ROOT."main/backend/shipping';
				},3000);
			</script>";
		}
		$this->layout->view('/backend/shipping', $this->view);
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
			//$bank_id = $this->request->getParam('id');
			$this->model->movefile();
		}
		/*if (!empty($_FILES)) {
			$folder = DIR_FILE.DS.'public'.DS.'upload'.DS.$this->request->getModuleName();
			if(!file_exists($folder)){mkdir($folder);}
			$this->model->movefile();
		}*/
	}
	

	
	public function delete_image_lookbook()
	{
		$this->layout->disableLayout();
		if($data = $this->input->post())
		{
			$this->model->setValue($data);
			$this->model->delete_image('image_path_banner');
		}
	}
	public function upload_image_single()
	{
		$this->layout->disableLayout();
		if (!empty($_FILES)) {
			$this->model->movefile_single();
		}
	}
}
?>