<?php 
class Backend extends CI_Controller{
	private $view;
	private $perpageNews = 10;
	
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
		$this->model = $this->load->model('news/Newsmodel');
    }
	
	
	/*  PRODUCT
	-------------------------------------------------------------------------------------------------------*/
	
	public function index()
	{
		$this->view['targetpage'] = $targetpage = 'news/backend/list_news';
		$this->view['perPage'] = $this->perpageNews;
		$this->layout->view('/backend/index', $this->view);
	}
	public function list_news()
	{
		$this->layout->setLayout('ajax');
		$this->view['module'] = $this->request->getModuleName();
		$this->view['param'] = '';
		$this->view['target'] = '#boxContent';
		$this->view['targetpage'] = $targetpage = 'news/backend/list_news';
		
		$page = $this->request->getParam('page');
		$this->view['page'] = $page = (empty($page))?1:$page;
		
		$limit = $this->request->getParam('limit');
		$this->view['limit'] = $limit = (empty($limit))?$this->perpageNews:$limit;
		
		$q = $this->request->getParam('q');
		
		$targetpage = 'news/backend/list_news/limit/'.$limit;
		list($this->view['paginaion'],$this->view['page_description'],$this->view['listNews']) = $this->model->listNews($targetpage,$page,$limit,$q);
		$this->layout->view('/backend/list_news', $this->view);
	}
	public function add_news()
	{
		if($data = $this->input->post()){
		
			$this->model->setValue($data);
			$news_id = $this->model->addNews();			
			$this->bflibs->addLog('log_add_news',$data['news_name'],DIR_ROOT.'news/backend/edit_news/id/'.$news_id);
			
			if(isset($data['file_upload'])){
				$this->model->upload($data['file_upload'],$news_id);
			}
			$this->view['redirect']="
			<script>
				window.parent.displayNotify('".lang('web_save_success')."','success','#showWarning'); 
				setTimeout(function(){
					window.parent.location='".DIR_ROOT."news/backend/index';
				},3000);
			</script>";
		}else{
			$this->model->clearTmpImages();
		}
		$this->layout->view('/backend/add_news', $this->view);
	}
	public function edit_news()
	{
		$news_id = $this->request->getParam('id');
		$this->view['listEditNews'] = $listEditNews = $this->model->listEditNews($news_id);

		if($data = $this->input->post()){
			
			$this->model->setValue($data);
			$news_id = $this->model->editNews();
			$this->bflibs->addLog('log_edit_news',$data['news_name'],DIR_ROOT.'news/backend/edit_news/id/'.$news_id);
			
			if(isset($data['file_upload'])){
				$this->model->upload($data['file_upload'],$news_id);
			}
			if(isset($data['FileCancel'])){
				$this->model->file_cancel($data['FileCancel'],$news_id);
			}
			$this->view['redirect']="
			<script>
				window.parent.displayNotify('".lang('web_save_success')."','success','#showWarning');
				setTimeout(function(){
					window.parent.location='".DIR_ROOT."news/backend/index';
				},3000);
			</script>";
		}else{
			$this->model->clearTmpImages();
		}
		$this->layout->view('/backend/edit_news', $this->view);
	}
	public function delete_news()
	{
		$this->layout->disableLayout();
		$Array_id=array();
		if($data = $this->input->post()){
			$Array_id = explode(',',$data['id']);
		}else{
			$Array_id[0] = $this->request->getParam('id');
		}
		
		for($i=0;$i<count($Array_id);$i++){
			$this->model->deleteNews($Array_id[$i]);
		}
	}
	public function up_news()
	{
		$this->layout->disableLayout();
		$id = $this->request->getParam('id');
		$seq = $this->request->getParam('seq');
		$this->bflibs->upMenuDesc('news','news_id',$id,'news_seq',$seq);
	}
	public function down_news()
	{
		$this->layout->disableLayout();
		$id = $this->request->getParam('id');
		$seq = $this->request->getParam('seq');
		$this->bflibs->downMenuDesc('news','news_id',$id,'news_seq',$seq);
	}
	public function publish_news()
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
			$this->bflibs->publish('news','news_id',$Array_id[$i],'news_publish',$status);
		}
	}
	public function pin_news()
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
			$this->bflibs->publish('news','news_id',$Array_id[$i],'news_pin',$status);
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