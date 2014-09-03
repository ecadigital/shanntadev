<?php 
class Backend extends CI_Controller{
	private $view;
	private $perpageProduct = 10;
	
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
		$this->model = $this->load->model('product/Productmodel');
    }
	
	
	/*  PRODUCT
	-------------------------------------------------------------------------------------------------------*/
	
	public function index(){
	
		$this->view['targetpage'] = $targetpage = 'product/backend/list_product';
		$this->view['thispage'] = $thispage = 'product/backend/index';
		$this->view['perPage'] = $this->perpageProduct;
		$this->view['target'] = '#boxContent';
		$this->view['type'] = $type = $this->request->getParam('type');
		$this->view['cat'] = $cat = $this->request->getParam('cat');
		$this->view['listCategories'] = $this->model->listCategories(0,0);
		$this->layout->view('/backend/index', $this->view);
	}
	public function list_product(){
	
		$this->layout->setLayout('ajax');
		$this->view['module'] = $this->request->getModuleName();
		$this->view['param'] = '';
		$this->view['target'] = '#boxContent';
		$this->view['targetpage'] = $targetpage = 'product/backend/list_product';
		
		$page = $this->request->getParam('page');
		$this->view['page'] = $page = (empty($page))?1:$page;
		
		$limit = $this->request->getParam('limit');
		$this->view['limit'] = $limit = (empty($limit))?$this->perpageProduct:$limit;
		
		$q = $this->request->getParam('q');
		$this->view['type'] = $type = $this->request->getParam('type');
		$this->view['cat'] = $cat = $this->request->getParam('cat');
		
		$targetpage = 'product/backend/list_product/type/'.$type.'/cat/'.$cat.'/limit/'.$limit;
		list($this->view['paginaion'],$this->view['page_description'],$this->view['listProduct']) = $this->model->listProduct($targetpage,$page,$limit,$q,$type,$cat);
		$this->layout->view('/backend/list_product', $this->view);
	}
	public function add_product(){
	
		$this->view['listAllLang'] = $this->bflibs->listAllLang();
		$this->view['listCategories'] = $this->model->listCategories(0,0);
		if($data = $this->input->post()){
		print_r($data);
			$this->model->setValue($data);
			$product_id = $this->model->addProduct();			
			$this->bflibs->addLog('log_add_product',$data['product_name'],DIR_ROOT.'product/backend/edit_product/id/'.$product_id);
			
			if(isset($data['file_upload'])){
				$this->model->upload($data['file_upload'],$product_id);
			}
			$this->view['redirect']="
			<script>
				window.parent.displayNotify('".lang('web_save_success')."','success','#showWarning'); 
				setTimeout(function(){
					window.parent.location='".DIR_ROOT."product/backend/index';
				},3000);
			</script>";
		}else{
			$this->model->clearTmpImages();
		}
		$this->layout->view('/backend/add_product', $this->view);
	}
	public function edit_product(){
	
		$product_id = $this->request->getParam('id');
		$this->view['listAllLang'] = $this->bflibs->listAllLang();
		$this->view['listCategories'] = $this->model->listCategories(0,0);
		$this->view['listEditProduct'] = $listEditProduct = $this->model->listEditProduct($product_id);

		if($data = $this->input->post()){
			
			$this->model->setValue($data);
			$product_id = $this->model->editProduct();
			$this->bflibs->addLog('log_edit_product',$data['product_name'],DIR_ROOT.'product/backend/edit_product/id/'.$product_id);
			
			if(isset($data['file_upload'])){
				$this->model->upload($data['file_upload'],$product_id);
			}
			if(isset($data['FileCancel'])){
				$this->model->file_cancel($data['FileCancel'],$product_id);
			}
			$this->view['redirect']="
			<script>
				window.parent.displayNotify('".lang('web_save_success')."','success','#showWarning');
				setTimeout(function(){
					window.parent.location='".DIR_ROOT."product/backend/index';
				},3000);
			</script>";
		}else{
			$this->model->clearTmpImages();
		}
		$this->layout->view('/backend/edit_product', $this->view);
	}
	public function delete_product(){
	
		$this->layout->disableLayout();
		$Array_id=array();
		if($data = $this->input->post()){
			$Array_id = explode(',',$data['id']);
		}else{
			$Array_id[0] = $this->request->getParam('id');
		}
		
		for($i=0;$i<count($Array_id);$i++){
			$this->model->deleteProduct($Array_id[$i]);
		}
	}
	public function up_product(){
	
		$this->layout->disableLayout();
		$id = $this->request->getParam('id');
		$seq = $this->request->getParam('seq');
		$this->bflibs->upMenuDesc('product','product_id',$id,'product_seq',$seq);
	}
	public function down_product(){
	
		$this->layout->disableLayout();
		$id = $this->request->getParam('id');
		$seq = $this->request->getParam('seq');
		$this->bflibs->downMenuDesc('product','product_id',$id,'product_seq',$seq);
	}
	public function publish_product(){
	
		$this->layout->disableLayout();
		$status = $this->request->getParam('status');
		
		$Array_id=array();
		if($data = $this->input->post()){
			$Array_id = explode(',',$data['id']);
		}else{
			$Array_id[0] = $this->request->getParam('id');
		}
		
		for($i=0;$i<count($Array_id);$i++){
			$this->bflibs->publish('product','product_id',$Array_id[$i],'product_publish',$status);
		}
	}
	public function pin_product(){
	
		$this->layout->disableLayout();
		$status = $this->request->getParam('status');
		
		$Array_id=array();
		if($data = $this->input->post()){
			$Array_id = explode(',',$data['id']);
		}else{
			$Array_id[0] = $this->request->getParam('id');
		}
		
		for($i=0;$i<count($Array_id);$i++){
			$this->bflibs->publish('product','product_id',$Array_id[$i],'product_pin',$status);
		}
	}
	public function hot_product(){
	
		$this->layout->disableLayout();
		$status = $this->request->getParam('status');
		
		$Array_id=array();
		if($data = $this->input->post()){
			$Array_id = explode(',',$data['id']);
		}else{
			$Array_id[0] = $this->request->getParam('id');
		}
		
		for($i=0;$i<count($Array_id);$i++){
			$this->bflibs->publish('product','product_id',$Array_id[$i],'product_hot',$status);
		}
	}
	public function rec_product(){
	
		$this->layout->disableLayout();
		$status = $this->request->getParam('status');
		
		$Array_id=array();
		if($data = $this->input->post()){
			$Array_id = explode(',',$data['id']);
		}else{
			$Array_id[0] = $this->request->getParam('id');
		}
		
		for($i=0;$i<count($Array_id);$i++){
			$this->bflibs->publish('product','product_id',$Array_id[$i],'product_rec',$status);
		}
	}
	public function pro_product(){
	
		$this->layout->disableLayout();
		$status = $this->request->getParam('status');
		
		$Array_id=array();
		if($data = $this->input->post()){
			$Array_id = explode(',',$data['id']);
		}else{
			$Array_id[0] = $this->request->getParam('id');
		}
		
		for($i=0;$i<count($Array_id);$i++){
			$this->bflibs->publish('product','product_id',$Array_id[$i],'product_pro',$status);
		}
	}
	public function sale_product(){
	
		$this->layout->disableLayout();
		$status = $this->request->getParam('status');
		
		$Array_id=array();
		if($data = $this->input->post()){
			$Array_id = explode(',',$data['id']);
		}else{
			$Array_id[0] = $this->request->getParam('id');
		}
		
		for($i=0;$i<count($Array_id);$i++){
			$this->bflibs->publish('product','product_id',$Array_id[$i],'product_sale',$status);
		}
	}
	
	
	
	/*  CATEGORIES
	-------------------------------------------------------------------------------------------------------*/


	public function index_categories(){
	
		$this->view['targetpage'] = $targetpage = 'product/backend/list_categories';
		$this->view['perPage'] = $this->perpageProduct;
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
	
		$this->view['targetpage'] = $targetpage = 'product/backend/list_categories_hot';
		$this->view['perPage'] = $this->perpageProduct;
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
	
		$this->view['listAllLang'] = $this->bflibs->listAllLang();
		$this->view['listCategoriesParent'] = $this->model->listCategoriesParent(0,0,'');
		if($data = $this->input->post()){
		
			$this->model->setValue($data);
			$product_categories_id = $this->model->addCategories();
			//$this->bflibs->addLog('log_add_product_categories',$data['product_categories_name'],DIR_ROOT.'product/backend/edit_categories/id/'.$product_categories_id);
			
			if($data['image_path_home']!=''){
				$this->model->upload_categories($data['image_path_home'],$product_categories_id,'home');
			}
			if($data['image_path_banner']!=''){
				$this->model->upload_categories($data['image_path_banner'],$product_categories_id,'banner');
			}
			
			$this->view['redirect']="
			<script>
				window.parent.displayNotify('".lang('web_save_success')."','success','#showWarning');
				setTimeout(function(){
					window.parent.location='".DIR_ROOT."product/backend/index_categories';
				},3000);
			</script>";//parent.document.getElementById('product_categories_form').reset();
		}else{
			$this->model->clearTmpImages();
		}
		$this->layout->view('/backend/add_categories', $this->view);
	}
	public function edit_categories(){
	
		$product_categories_id = $this->request->getParam('id');
		$this->view['listAllLang'] = $this->bflibs->listAllLang();
		$this->view['listEditCategories'] = $listEditCategories = $this->model->listEditCategories($product_categories_id);
		$this->view['listCategoriesParent'] = $this->model->listCategoriesParent(0,0,$product_categories_id);
		
		/////////////////////////////////// No data //////////////////////////////////////////
		if(empty($listEditCategories)){
			$this->view['redirect']='<div class="nodata">No data</a>';
		}
		/////////////////////////////////// No data //////////////////////////////////////////
		
		if($data = $this->input->post()){
		
			$this->model->setValue($data);
			$this->model->editCategories();
			$product_categories_id = $data['product_categories_id'];
			//$this->bflibs->addLog('log_edit_product_categories',$data['product_categories_name'],DIR_ROOT.'product/backend/edit_categories/id/'.$product_categories_id);

			if($data['image_path_home']!=''){
				$this->model->upload_categories($data['image_path_home'],$product_categories_id,'home');
			}
			if($data['image_path_banner']!=''){
				$this->model->upload_categories($data['image_path_banner'],$product_categories_id,'banner');
			}
			
			$this->view['redirect']="
			<script>
				window.parent.displayNotify('".lang('web_save_success')."','success','#showWarning');
				setTimeout(function(){
					window.parent.location='".DIR_ROOT."product/backend/index_categories';
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
		$this->bflibs->upMenuWithParent('product_categories','product_categories_id',$id,'product_categories_seq',$seq,'product_categories_parent_id',$parent_id);
	}
	public function down_categories(){
	
		$this->layout->disableLayout();
		$id = $this->request->getParam('id');
		$seq = $this->request->getParam('seq');
		$parent_id = $this->request->getParam('parent_id');
		$this->bflibs->downMenuWithParent('product_categories','product_categories_id',$id,'product_categories_seq',$seq,'product_categories_parent_id',$parent_id);
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
			$this->bflibs->publish('product_categories','product_categories_id',$Array_id[$i],'product_categories_publish',$status);
		}
	}
	
	
	/*  PROMOTION
	-------------------------------------------------------------------------------------------------------*/
	
	public function index_promotion()
	{
		$this->view['targetpage'] = $targetpage = 'product/backend/list_promotion';
		$this->view['perPage'] = $this->perpageProduct;
		$this->layout->view('/backend/index_promotion', $this->view);
	}
	public function list_promotion()
	{
		$this->layout->setLayout('ajax');
		$this->view['module'] = $this->request->getModuleName();
		$this->view['param'] = '';
		$this->view['target'] = '#boxContent';
		$this->view['targetpage'] = $targetpage = 'product/backend/list_promotion';
		
		$page = $this->request->getParam('page');
		$this->view['page'] = $page = (empty($page))?1:$page;
		
		$limit = $this->request->getParam('limit');
		$this->view['limit'] = $limit = (empty($limit))?$this->perpageProduct:$limit;
		
		$q = $this->request->getParam('q');
		$categories_id = $this->request->getParam('categories_id');
		
		$targetpage = 'product/backend/list_promotion/limit/'.$limit;
		list($this->view['paginaion'],$this->view['page_description'],$this->view['listPromotion']) = $this->model->listPromotion($targetpage,$page,$limit,$q,$categories_id);
		$this->layout->view('/backend/list_promotion', $this->view);
	}
	public function add_promotion()
	{
		$this->view['listProduct'] = $this->model->listAllProduct();
		if($data = $this->input->post()){
		
			$this->model->setValue($data);
			$product_promotion_id = $this->model->addPromotion();			
			$this->bflibs->addLog('log_add_promotion',$data['product_promotion_name'],DIR_ROOT.'product/backend/edit_promotion/id/'.$product_promotion_id);
			
			$this->view['redirect']="
			<script>
				window.parent.displayNotify('".lang('web_save_success')."','success','#showWarning'); 
				setTimeout(function(){
					window.parent.location='".DIR_ROOT."product/backend/add_promotion';
				},3000);
			</script>";
		}
		$this->layout->view('/backend/add_promotion', $this->view);
	}
	public function edit_promotion()
	{
		$product_promotion_id = $this->request->getParam('id');
		$this->view['listProduct'] = $this->model->listAllProduct();
		$this->view['listEditPromotion'] = $listEditPromotion = $this->model->listEditPromotion($product_promotion_id);

		if($data = $this->input->post()){
			
			$this->model->setValue($data);
			$product_promotion_id = $this->model->editPromotion();
			$this->bflibs->addLog('log_edit_promotion',$data['product_promotion_name'],DIR_ROOT.'product/backend/edit_promotion/id/'.$product_promotion_id);
			
			$this->view['redirect']="
			<script>
				window.parent.displayNotify('".lang('web_save_success')."','success','#showWarning');
				setTimeout(function(){
					window.parent.location='".DIR_ROOT."product/backend/index_promotion';
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
		$this->bflibs->upMenuDesc('product_promotion','product_promotion_id',$id,'product_promotion_seq',$seq);
	}
	public function down_promotion()
	{
		$this->layout->disableLayout();
		$id = $this->request->getParam('id');
		$seq = $this->request->getParam('seq');
		$this->bflibs->downMenuDesc('product_promotion','product_promotion_id',$id,'product_promotion_seq',$seq);
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
			$this->bflibs->publish('product_promotion','product_promotion_id',$Array_id[$i],'product_promotion_publish',$status);
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
			$this->bflibs->publish('product_promotion','product_promotion_id',$Array_id[$i],'product_promotion_pin',$status);
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
			$product_id = $this->request->getParam('id');
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