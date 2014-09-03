<?php 
class Backend extends CI_Controller{
	private $view;
	private $perpageCollection = 10;
	
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
		$this->model = $this->load->model('collection/Collectionmodel');
    }
	
	
	/*  PRODUCT
	-------------------------------------------------------------------------------------------------------*/
	
	public function index(){
	
		$this->view['targetpage'] = $targetpage = 'collection/backend/list_collection';
		$this->view['thispage'] = $thispage = 'collection/backend/index';
		$this->view['perPage'] = $this->perpageCollection;
		$this->view['target'] = '#boxContent';
		$this->view['type'] = $type = $this->request->getParam('type');
		$this->view['cat'] = $cat = $this->request->getParam('cat');
		$this->view['listCategories'] = $this->model->listCategories(0,0);
		$this->layout->view('/backend/index', $this->view);
	}
	public function list_collection(){
	
		$this->layout->setLayout('ajax');
		$this->view['module'] = $this->request->getModuleName();
		$this->view['param'] = '';
		$this->view['target'] = '#boxContent';
		$this->view['targetpage'] = $targetpage = 'collection/backend/list_collection';
		
		$page = $this->request->getParam('page');
		$this->view['page'] = $page = (empty($page))?1:$page;
		
		$limit = $this->request->getParam('limit');
		$this->view['limit'] = $limit = (empty($limit))?$this->perpageCollection:$limit;
		
		$q = $this->request->getParam('q');
		$this->view['type'] = $type = $this->request->getParam('type');
		$this->view['cat'] = $cat = $this->request->getParam('cat');
		
		$targetpage = 'collection/backend/list_collection/type/'.$type.'/cat/'.$cat.'/limit/'.$limit;
		list($this->view['paginaion'],$this->view['page_description'],$this->view['listCollection']) = $this->model->listCollection($targetpage,$page,$limit,$q,$type,$cat);
		$this->layout->view('/backend/list_collection', $this->view);
	}
	public function add_collection(){
	
		$this->view['listCategories'] = $this->model->listCategories(0,0);
		if($data = $this->input->post()){
		
			$this->model->setValue($data);
			$collection_id = $this->model->addCollection();			
			$this->bflibs->addLog('log_add_collection',$data['collection_name'],DIR_ROOT.'collection/backend/edit_collection/id/'.$collection_id);
			
			if(isset($data['file_upload'])){
				$this->model->upload($data['file_upload'],$collection_id);
			}
			$this->view['redirect']="
			<script>
				window.parent.displayNotify('".lang('web_save_success')."','success','#showWarning'); 
				setTimeout(function(){
					window.parent.location='".DIR_ROOT."collection/backend/add_collection';
				},3000);
			</script>";
		}else{
			$this->model->clearTmpImages();
		}
		$this->layout->view('/backend/add_collection', $this->view);
	}
	public function edit_collection(){
	
		$collection_id = $this->request->getParam('id');
		$this->view['listCategories'] = $this->model->listCategories(0,0);
		$this->view['listEditCollection'] = $listEditCollection = $this->model->listEditCollection($collection_id);

		if($data = $this->input->post()){
			
			$this->model->setValue($data);
			$collection_id = $this->model->editCollection();
			$this->bflibs->addLog('log_edit_collection',$data['collection_name'],DIR_ROOT.'collection/backend/edit_collection/id/'.$collection_id);
			
			if(isset($data['file_upload'])){
				$this->model->upload($data['file_upload'],$collection_id);
			}
			if(isset($data['FileCancel'])){
				$this->model->file_cancel($data['FileCancel'],$collection_id);
			}
			$this->view['redirect']="
			<script>
				window.parent.displayNotify('".lang('web_save_success')."','success','#showWarning');
				setTimeout(function(){
					window.parent.location='".DIR_ROOT."collection/backend/index';
				},3000);
			</script>";
		}else{
			$this->model->clearTmpImages();
		}
		$this->layout->view('/backend/edit_collection', $this->view);
	}
	public function delete_collection(){
	
		$this->layout->disableLayout();
		$Array_id=array();
		if($data = $this->input->post()){
			$Array_id = explode(',',$data['id']);
		}else{
			$Array_id[0] = $this->request->getParam('id');
		}
		
		for($i=0;$i<count($Array_id);$i++){
			$this->model->deleteCollection($Array_id[$i]);
		}
	}
	public function up_collection(){
	
		$this->layout->disableLayout();
		$id = $this->request->getParam('id');
		$seq = $this->request->getParam('seq');
		$this->bflibs->upMenuDesc('collection','collection_id',$id,'collection_seq',$seq);
	}
	public function down_collection(){
	
		$this->layout->disableLayout();
		$id = $this->request->getParam('id');
		$seq = $this->request->getParam('seq');
		$this->bflibs->downMenuDesc('collection','collection_id',$id,'collection_seq',$seq);
	}
	public function publish_collection(){
	
		$this->layout->disableLayout();
		$status = $this->request->getParam('status');
		
		$Array_id=array();
		if($data = $this->input->post()){
			$Array_id = explode(',',$data['id']);
		}else{
			$Array_id[0] = $this->request->getParam('id');
		}
		
		for($i=0;$i<count($Array_id);$i++){
			$this->bflibs->publish('collection','collection_id',$Array_id[$i],'collection_publish',$status);
		}
	}
	public function pin_collection(){
	
		$this->layout->disableLayout();
		$status = $this->request->getParam('status');
		
		$Array_id=array();
		if($data = $this->input->post()){
			$Array_id = explode(',',$data['id']);
		}else{
			$Array_id[0] = $this->request->getParam('id');
		}
		
		for($i=0;$i<count($Array_id);$i++){
			$this->bflibs->publish('collection','collection_id',$Array_id[$i],'collection_pin',$status);
		}
	}
	public function hot_collection(){
	
		$this->layout->disableLayout();
		$status = $this->request->getParam('status');
		
		$Array_id=array();
		if($data = $this->input->post()){
			$Array_id = explode(',',$data['id']);
		}else{
			$Array_id[0] = $this->request->getParam('id');
		}
		
		for($i=0;$i<count($Array_id);$i++){
			$this->bflibs->publish('collection','collection_id',$Array_id[$i],'collection_hot',$status);
		}
	}
	public function rec_collection(){
	
		$this->layout->disableLayout();
		$status = $this->request->getParam('status');
		
		$Array_id=array();
		if($data = $this->input->post()){
			$Array_id = explode(',',$data['id']);
		}else{
			$Array_id[0] = $this->request->getParam('id');
		}
		
		for($i=0;$i<count($Array_id);$i++){
			$this->bflibs->publish('collection','collection_id',$Array_id[$i],'collection_rec',$status);
		}
	}
	public function pro_collection(){
	
		$this->layout->disableLayout();
		$status = $this->request->getParam('status');
		
		$Array_id=array();
		if($data = $this->input->post()){
			$Array_id = explode(',',$data['id']);
		}else{
			$Array_id[0] = $this->request->getParam('id');
		}
		
		for($i=0;$i<count($Array_id);$i++){
			$this->bflibs->publish('collection','collection_id',$Array_id[$i],'collection_pro',$status);
		}
	}
	public function sale_collection(){
	
		$this->layout->disableLayout();
		$status = $this->request->getParam('status');
		
		$Array_id=array();
		if($data = $this->input->post()){
			$Array_id = explode(',',$data['id']);
		}else{
			$Array_id[0] = $this->request->getParam('id');
		}
		
		for($i=0;$i<count($Array_id);$i++){
			$this->bflibs->publish('collection','collection_id',$Array_id[$i],'collection_sale',$status);
		}
	}
	
	
	
	/*  CATEGORIES
	-------------------------------------------------------------------------------------------------------*/


	public function index_categories(){
	
		$this->view['targetpage'] = $targetpage = 'collection/backend/list_categories';
		$this->view['perPage'] = $this->perpageCollection;
		$this->layout->view('/backend/index_categories', $this->view);
	}
	public function list_categories(){
	
		$this->layout->setLayout('ajax');
		$this->view['module'] = $this->request->getModuleName();
		$this->view['param'] = '';
		$this->view['target'] = '#boxContent';
		$this->view['listCategories'] = $this->model->listCategories(0,0);
		$this->layout->view('/backend/list_categories', $this->view);
	}
	public function index_categories_hot(){
	
		$this->view['targetpage'] = $targetpage = 'collection/backend/list_categories_hot';
		$this->view['perPage'] = $this->perpageCollection;
		$this->layout->view('/backend/index_categories_hot', $this->view);
	}
	public function list_categories_hot(){
	
		$this->layout->setLayout('ajax');
		$this->view['module'] = $this->request->getModuleName();
		$this->view['param'] = '';
		$this->view['target'] = '#boxContent';
		$this->view['listCategories'] = $this->model->listCategories(0,0);
		$this->layout->view('/backend/list_categories_hot', $this->view);
	}
	public function add_categories(){
	
		$this->view['listCategoriesParent'] = $this->model->listCategoriesParent(0,0,'');
		if($data = $this->input->post()){
		
			$this->model->setValue($data);
			$collection_categories_id = $this->model->addCategories();
			//$this->bflibs->addLog('log_add_collection_categories',$data['collection_categories_name'],DIR_ROOT.'collection/backend/edit_categories/id/'.$collection_categories_id);
			
			if($data['image_path_home']!=''){
				$this->model->upload_categories($data['image_path_home'],$collection_categories_id,'home');
			}
			if($data['image_path_banner']!=''){
				$this->model->upload_categories($data['image_path_banner'],$collection_categories_id,'banner');
			}
			
			$this->view['redirect']="
			<script>
				window.parent.displayNotify('".lang('web_save_success')."','success','#showWarning');
				setTimeout(function(){
					window.parent.location='".DIR_ROOT."collection/backend/index_categories';
				},3000);
			</script>";//parent.document.getElementById('collection_categories_form').reset();
		}else{
			$this->model->clearTmpImages();
		}
		$this->layout->view('/backend/add_categories', $this->view);
	}
	public function edit_categories(){
	
		$collection_categories_id = $this->request->getParam('id');
		$this->view['listEditCategories'] = $listEditCategories = $this->model->listEditCategories($collection_categories_id);
		$this->view['listCategoriesParent'] = $this->model->listCategoriesParent(0,0,$collection_categories_id);
		
		/////////////////////////////////// No data //////////////////////////////////////////
		if(empty($listEditCategories)){
			$this->view['redirect']='<div class="nodata">No data</a>';
		}
		/////////////////////////////////// No data //////////////////////////////////////////
		
		if($data = $this->input->post()){
		
			$this->model->setValue($data);
			$this->model->editCategories();
			$collection_categories_id = $data['collection_categories_id'];
			//$this->bflibs->addLog('log_edit_collection_categories',$data['collection_categories_name'],DIR_ROOT.'collection/backend/edit_categories/id/'.$collection_categories_id);

			if($data['image_path_home']!=''){
				$this->model->upload_categories($data['image_path_home'],$collection_categories_id,'home');
			}
			if($data['image_path_banner']!=''){
				$this->model->upload_categories($data['image_path_banner'],$collection_categories_id,'banner');
			}
			
			$this->view['redirect']="
			<script>
				window.parent.displayNotify('".lang('web_save_success')."','success','#showWarning');
				setTimeout(function(){
					window.parent.location='".DIR_ROOT."collection/backend/index_categories';
				},3000);
			</script>";
		}else{
			$this->model->clearTmpImages();
		}
		$this->layout->view('/backend/edit_categories', $this->view);
	}
	public function delete_categories(){
	
		$this->layout->disableLayout();
		$Array_id=array();
		if($data = $this->input->post()){
			$Array_id = explode(',',$data['id']);
		}else{
			$Array_id[0] = $this->request->getParam('id');
		}
		
		for($i=0;$i<count($Array_id);$i++){
			$this->model->deleteCategories($Array_id[$i]);
		}
	}
	public function chk_hasdata(){
	
		$this->layout->disableLayout();
		$id = $this->request->getParam('id');
		echo $this->model->chkHasData($id);
	}
	public function up_categories(){
	
		$this->layout->disableLayout();
		$id = $this->request->getParam('id');
		$seq = $this->request->getParam('seq');
		$parent_id = $this->request->getParam('parent_id');
		$this->bflibs->upMenuWithParent('collection_categories','collection_categories_id',$id,'collection_categories_seq',$seq,'collection_categories_parent_id',$parent_id);
	}
	public function down_categories(){
	
		$this->layout->disableLayout();
		$id = $this->request->getParam('id');
		$seq = $this->request->getParam('seq');
		$parent_id = $this->request->getParam('parent_id');
		$this->bflibs->downMenuWithParent('collection_categories','collection_categories_id',$id,'collection_categories_seq',$seq,'collection_categories_parent_id',$parent_id);
	}
	public function publish_categories(){
	
		$this->layout->disableLayout();
		$status = $this->request->getParam('status');
		
		$Array_id=array();
		if($data = $this->input->post()){
			$Array_id = explode(',',$data['id']);
		}else{
			$Array_id[0] = $this->request->getParam('id');
		}
		
		for($i=0;$i<count($Array_id);$i++){
			$this->bflibs->publish('collection_categories','collection_categories_id',$Array_id[$i],'collection_categories_publish',$status);
		}
	}
	
	
	/*  PROMOTION
	-------------------------------------------------------------------------------------------------------*/
	
	public function index_promotion()
	{
		$this->view['targetpage'] = $targetpage = 'collection/backend/list_promotion';
		$this->view['perPage'] = $this->perpageCollection;
		$this->layout->view('/backend/index_promotion', $this->view);
	}
	public function list_promotion()
	{
		$this->layout->setLayout('ajax');
		$this->view['module'] = $this->request->getModuleName();
		$this->view['param'] = '';
		$this->view['target'] = '#boxContent';
		$this->view['targetpage'] = $targetpage = 'collection/backend/list_promotion';
		
		$page = $this->request->getParam('page');
		$this->view['page'] = $page = (empty($page))?1:$page;
		
		$limit = $this->request->getParam('limit');
		$this->view['limit'] = $limit = (empty($limit))?$this->perpageCollection:$limit;
		
		$q = $this->request->getParam('q');
		$categories_id = $this->request->getParam('categories_id');
		
		$targetpage = 'collection/backend/list_promotion/limit/'.$limit;
		list($this->view['paginaion'],$this->view['page_description'],$this->view['listPromotion']) = $this->model->listPromotion($targetpage,$page,$limit,$q,$categories_id);
		$this->layout->view('/backend/list_promotion', $this->view);
	}
	public function add_promotion()
	{
		$this->view['listCollection'] = $this->model->listAllCollection();
		if($data = $this->input->post()){
		
			$this->model->setValue($data);
			$collection_promotion_id = $this->model->addPromotion();			
			$this->bflibs->addLog('log_add_promotion',$data['collection_promotion_name'],DIR_ROOT.'collection/backend/edit_promotion/id/'.$collection_promotion_id);
			
			$this->view['redirect']="
			<script>
				window.parent.displayNotify('".lang('web_save_success')."','success','#showWarning'); 
				setTimeout(function(){
					window.parent.location='".DIR_ROOT."collection/backend/add_promotion';
				},3000);
			</script>";
		}
		$this->layout->view('/backend/add_promotion', $this->view);
	}
	public function edit_promotion()
	{
		$collection_promotion_id = $this->request->getParam('id');
		$this->view['listCollection'] = $this->model->listAllCollection();
		$this->view['listEditPromotion'] = $listEditPromotion = $this->model->listEditPromotion($collection_promotion_id);

		if($data = $this->input->post()){
			
			$this->model->setValue($data);
			$collection_promotion_id = $this->model->editPromotion();
			$this->bflibs->addLog('log_edit_promotion',$data['collection_promotion_name'],DIR_ROOT.'collection/backend/edit_promotion/id/'.$collection_promotion_id);
			
			$this->view['redirect']="
			<script>
				window.parent.displayNotify('".lang('web_save_success')."','success','#showWarning');
				setTimeout(function(){
					window.parent.location='".DIR_ROOT."collection/backend/index_promotion';
				},3000);
			</script>";
		}
		$this->layout->view('/backend/edit_promotion', $this->view);
	}
	public function delete_promotion()
	{
		$this->layout->disableLayout();
		$Array_id=array();
		if($data = $this->input->post()){
			$Array_id = explode(',',$data['id']);
		}else{
			$Array_id[0] = $this->request->getParam('id');
		}
		
		for($i=0;$i<count($Array_id);$i++){
			$this->model->deletePromotion($Array_id[$i]);
		}
	}
	public function up_promotion()
	{
		$this->layout->disableLayout();
		$id = $this->request->getParam('id');
		$seq = $this->request->getParam('seq');
		$this->bflibs->upMenuDesc('collection_promotion','collection_promotion_id',$id,'collection_promotion_seq',$seq);
	}
	public function down_promotion()
	{
		$this->layout->disableLayout();
		$id = $this->request->getParam('id');
		$seq = $this->request->getParam('seq');
		$this->bflibs->downMenuDesc('collection_promotion','collection_promotion_id',$id,'collection_promotion_seq',$seq);
	}
	public function publish_promotion()
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
			$this->bflibs->publish('collection_promotion','collection_promotion_id',$Array_id[$i],'collection_promotion_publish',$status);
		}
	}
	public function pin_promotion()
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
			$this->bflibs->publish('collection_promotion','collection_promotion_id',$Array_id[$i],'collection_promotion_pin',$status);
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
	
	public function delete_image_banner()
	{
		$this->layout->disableLayout();
		if($data = $this->input->post())
		{
			$this->model->setValue($data);
			$this->model->delete_image('image_path_banner');
		}
	}
	public function delete_image_home()
	{
		$this->layout->disableLayout();
		if($data = $this->input->post())
		{
			$this->model->setValue($data);
			$this->model->delete_image('image_path_home');
		}
	}
	public function upload_image()
	{
		$this->layout->disableLayout();
		if (!empty($_FILES)) {
			$collection_id = $this->request->getParam('id');
			$this->model->movefile_single();
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