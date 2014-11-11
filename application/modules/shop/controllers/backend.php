<?php 
class Backend extends CI_Controller{
	private $view;
	private $perpageShop = 10;
	
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
		$this->model = $this->load->model('shop/Shopmodel');
    }
	
	
	/*  SHOP
	-------------------------------------------------------------------------------------------------------*/
	
	public function index()
	{
		$this->view['targetpage'] = $targetpage = 'shop/backend/list_shop';
		$this->view['perPage'] = $this->perpageShop;
		$this->layout->view('/backend/index', $this->view);
	}
	public function list_shop()
	{
		$this->layout->setLayout('ajax');
		$this->view['type'] = $type = $this->request->getParam('type');
		$this->view['module'] = $this->request->getModuleName();
		$this->view['param'] = '/type/'.$type;
		$this->view['target'] = '#boxContent';
		$this->view['targetpage'] = $targetpage = 'shop/backend/list_shop';
		
		$page = $this->request->getParam('page');
		$this->view['page'] = $page = (empty($page))?1:$page;
		
		$limit = $this->request->getParam('limit');
		$this->view['limit'] = $limit = (empty($limit))?$this->perpageShop+10:$limit;
		
		$q = $this->request->getParam('q');
		
		$targetpage = 'shop/backend/list_shop/type/'.$type.'/limit/'.$limit;
		list($this->view['paginaion'],$this->view['page_description'],$this->view['listShop']) = $this->model->listShop($targetpage,$page,$limit,$q,$type);
		$this->layout->view('/backend/list_shop', $this->view);
	}
	public function add_shop()
	{
		$this->view['listAllLang'] = $this->bflibs->listAllLang();
		if($data = $this->input->post()){

			$this->model->setValue($data);
			$shop_id = $this->model->addShop();		
			$this->bflibs->addLog('log_add_shop',$data['shop_name'],DIR_ROOT.'shop/backend/edit_shop/id/'.$shop_id);
				
			if($data['image_path']!=''){
				$this->model->uploadCover($data['image_path'],$shop_id);
			}
			for($no=1;$no<=$data['ref_no'];$no++){
				if(isset($data['image_path_'.$no])){echo $data['image_path_'.$no];
					$this->model->uploadRef($data['image_path_'.$no],$data['image_detail_'.$no],$data['image_detail2_'.$no],$shop_id,$no);
				}
			}
			$this->view['redirect']="
			<script>
				window.parent.displayNotify('".lang('web_save_success')."','success','#showWarning'); 
				setTimeout(function(){
					window.parent.location='".DIR_ROOT."shop/backend/index';
				},3000);
			</script>";
		}else{
			$this->model->clearTmpImages();
		}
		$this->layout->view('/backend/add_shop', $this->view);
	}
	public function edit_shop()
	{
		$shop_id = $this->request->getParam('id');
		$this->view['listAllLang'] = $this->bflibs->listAllLang();
		$this->view['listEditShop'] = $listEditShop = $this->model->listEditShop($shop_id);

		if($data = $this->input->post()){
			print_r($_POST);
			$this->model->setValue($data);
			$shop_id = $this->model->editShop();
			$this->bflibs->addLog('log_edit_shop',$data['shop_name'],DIR_ROOT.'shop/backend/edit_shop/id/'.$shop_id);
				
			if($data['image_path']!=''){
				$this->model->uploadCover($data['image_path'],$shop_id);
			}
			for($no=1;$no<=$data['ref_no'];$no++){
				if(isset($data['image_path_'.$no])){
					if($data['image_path_'.$no]!=''){
						//echo 'musssssssssssssssssss';
						$this->model->uploadRef($data['image_path_'.$no],$data['image_detail_'.$no],$data['image_detail2_'.$no],$data['image_id_'.$no],$shop_id,$no);
					}else{
						//echo 'daeeeeeeeeeeeeeeeeeeee';
						$this->model->updateShopImages($shop_id,$data['image_id_'.$no],$data['image_detail_'.$no],$data['image_detail2_'.$no]);
					}
				}
			}
			//$this->model->updateShopImages($shop_id);
			
			$this->view['redirect']="
			<script>
				window.parent.displayNotify('".lang('web_save_success')."','success','#showWarning');
				setTimeout(function(){
					window.parent.location='".DIR_ROOT."shop/backend/index';
				},3000);
			</script>";
		}else{
			$this->model->clearTmpImages();
		}
		$this->layout->view('/backend/edit_shop', $this->view);
	}
	public function list_reference()
	{
		$this->layout->disableLayout();
		$this->view['no'] = $no =  $this->input->post('no');
		$this->view['img'] = $img =  $this->input->post('img');
		$this->view['detail'] = $detail =  $this->input->post('detail');
		$this->view['detail2'] = $detail2 =  $this->input->post('detail2');
		$this->view['img_id'] = $img_id =  $this->input->post('img_id');
		$this->layout->view('/backend/list_reference', $this->view);
	}
	public function delete_shop()
	{
		$this->layout->disableLayout();
		$Array_id=array();
		if($data = $this->input->post()){
			$Array_id = explode(',',$data['id']);
		}else{
			$Array_id[0] = $this->request->getParam('id');
		}
		
		for($i=0;$i<count($Array_id);$i++){
			$this->model->deleteShop($Array_id[$i]);
		}
	}
	public function up_shop()
	{
		$this->layout->disableLayout();
		$id = $this->request->getParam('id');
		$seq = $this->request->getParam('seq');
		$this->bflibs->upMenu('shop','shop_id',$id,'shop_seq',$seq);
	}
	public function down_shop()
	{
		$this->layout->disableLayout();
		$id = $this->request->getParam('id');
		$seq = $this->request->getParam('seq');
		$this->bflibs->downMenu('shop','shop_id',$id,'shop_seq',$seq);
	}
	public function publish_shop()
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
			$this->bflibs->publish('shop','shop_id',$Array_id[$i],'shop_publish',$status);
		}
	}
	public function pin_shop()
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
			$this->bflibs->publish('shop','shop_id',$Array_id[$i],'shop_pin',$status);
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
	
	public function delete_image_single()
	{
		$this->layout->disableLayout();
		$lang_id = $this->request->getParam('lang');
		if($data = $this->input->post())
		{
			$this->model->setValue($data);
			$this->model->delete_image($lang_id);
		}
	}
	public function upload_image_single()
	{
		$this->layout->disableLayout();
		if (!empty($_FILES)) {
			$slide_id = $this->request->getParam('id');
			$lang_id = $this->request->getParam('lang');
			$this->model->movefile($lang_id);
		}
	}
	public function upload_image()
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