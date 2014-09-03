<?php 
class Backend extends CI_Controller{
	private $view;
	public $perpageOrder=10;
	
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
		$this->model = $this->load->model('shoppingcart/Shoppingcartmodel');
    }

	/*  ORDER
	-------------------------------------------------------------------------------------------------------*/	
	public function index()
	{
		$this->view['targetpage'] = $targetpage = 'shoppingcart/backend/list_order';
		$this->view['perPage'] = $this->perpageOrder;
		$this->layout->view('/backend/index', $this->view);
	}
	public function list_order()
	{
		$this->layout->setLayout('ajax');
		$this->view['module'] = $this->request->getModuleName();
		$this->view['param'] = '';
		$this->view['target'] = '#boxContent';
		$this->view['targetpage'] = $targetpage = 'shoppingcart/backend/list_order';
		
		$page = $this->request->getParam('page');
		$this->view['page'] = $page = (empty($page))?1:$page;
		
		$limit = $this->request->getParam('limit');
		$this->view['limit'] = $limit = (empty($limit))?$this->perpageOrder:$limit;
		
		$q = $this->request->getParam('q');
		
		$targetpage = 'shoppingcart/backend/list_order/limit/'.$limit;
		list($this->view['paginaion'],$this->view['page_description'],$this->view['listOrder']) = $this->model->listOrder($targetpage,$page,$limit,$q);
		$this->layout->view('/backend/list_order', $this->view);
	}	
	public function add_order()
	{	
		$this->view['listProduct'] = $this->model->listAllProduct();
		$this->view['listMember'] = $this->model->listAllMember();
		
		if($data = $this->input->post()){
			$this->model->setValue($data);
			$this->model->addOrder();
			$this->view['redirect']="
			<script>
				window.parent.displayNotify('".lang('web_save_success')."','success','#showWarning'); 
				setTimeout(function(){
					window.parent.location='".DIR_ROOT."shoppingcart/backend/index';
				},3000);
			</script>";
		}
		$this->layout->view('/backend/add_order', $this->view);
	}
	public function edit_order()
	{
		$order_id = $this->request->getParam('id');
		$this->view['listEditOrder'] = $listEditOrder = $this->model->listEditOrder($order_id);
		$this->view['listProduct'] = $this->model->listAllProduct();
		$this->view['listMember'] = $this->model->listAllMember();

		if($data = $this->input->post()){
			
			$this->model->setValue($data);
			$product_id = $this->model->editOrder();
			$this->view['redirect']="
			<script>
				window.parent.displayNotify('".lang('web_save_success')."','success','#showWarning');
				setTimeout(function(){
					window.parent.location='".DIR_ROOT."shoppingcart/backend/index';
				},3000);
			</script>";
		}
		$this->layout->view('/backend/edit_order', $this->view);
	}
	
	public function view_order()
	{
		$order_id = $this->request->getParam('id');
		$this->view['listEditOrder'] = $listEditOrder = $this->model->listEditOrder($order_id);
		$this->view['listProduct'] = $this->model->listAllProduct();
		$this->view['listMember'] = $this->model->listAllMember();
		$this->layout->view('/backend/view_order', $this->view);
	}

	public function delete_order()
	{
		$this->layout->disableLayout();
		$Array_id=array();
		if($data = $this->input->post()){
			$Array_id = explode(',',$data['id']);
		}else{
			$Array_id[0] = $this->request->getParam('id');
		}
		
		for($i=0;$i<count($Array_id);$i++){
			$this->model->deleteOrder($Array_id[$i]);
		}
	}
	public function change_status()
	{
		$this->layout->disableLayout();
		if($data = $this->input->post()){
			$this->model->setValue($data);
			
			$order_id = $data['order_id'];
			$status = $data['status'];

			$this->model->change_status($order_id,$status);
			//$this->model->sendmail_dispute($order_id,$product_id,$status);
		}
	}
	public function change_tracking()
	{
		$this->layout->disableLayout();
		if($data = $this->input->post()){
			$this->model->setValue($data);
			
			$order_id = $data['order_id'];
			$tracking = $data['tracking'];

			$this->model->change_tracking($order_id,$tracking);
			//$this->model->sendmail_dispute($order_id,$product_id,$status);
		}
	}
	

	/*  CONFIRM
	-------------------------------------------------------------------------------------------------------*/	
	public function index_confirm()
	{
		$this->view['targetpage'] = $targetpage = 'shoppingcart/backend/list_confirm';
		$this->view['perPage'] = $this->perpageOrder;
		$this->layout->view('/backend/index_confirm', $this->view);
	}
	public function list_confirm()
	{
		$this->layout->setLayout('ajax');
		$this->view['module'] = $this->request->getModuleName();
		$this->view['param'] = '';
		$this->view['target'] = '#boxContent';
		$this->view['targetpage'] = $targetpage = 'shoppingcart/backend/list_confirm';
		
		$page = $this->request->getParam('page');
		$this->view['page'] = $page = (empty($page))?1:$page;
		
		$limit = $this->request->getParam('limit');
		$this->view['limit'] = $limit = (empty($limit))?$this->perpageOrder:$limit;
		
		$q = $this->request->getParam('q');
		
		$targetpage = 'shoppingcart/backend/list_confirm/limit/'.$limit;
		list($this->view['paginaion'],$this->view['page_description'],$this->view['listConfirm']) = $this->model->listConfirm($targetpage,$page,$limit,$q);
		$this->layout->view('/backend/list_confirm', $this->view);
	}
	public function delete_confirm()
	{
		$this->layout->disableLayout();
		$Array_id=array();
		if($data = $this->input->post()){
			$Array_id = explode(',',$data['id']);
		}else{
			$Array_id[0] = $this->request->getParam('id');
		}
		
		for($i=0;$i<count($Array_id);$i++){
			$this->model->deleteConfirm($Array_id[$i]);
		}
	}	
	

	/*  BANK
	-------------------------------------------------------------------------------------------------------*/	
	public function index_bank()
	{
		$this->view['targetpage'] = $targetpage = 'shoppingcart/backend/list_bank';
		$this->view['perPage'] = $this->perpageOrder;
		$this->layout->view('/backend/index_bank', $this->view);
	}
	public function list_bank()
	{
		$this->layout->setLayout('ajax');
		$this->view['module'] = $this->request->getModuleName();
		$this->view['param'] = '';
		$this->view['target'] = '#boxContent';
		$this->view['targetpage'] = $targetpage = 'shoppingcart/backend/list_bank';
		
		$page = $this->request->getParam('page');
		$this->view['page'] = $page = (empty($page))?1:$page;
		
		$limit = $this->request->getParam('limit');
		$this->view['limit'] = $limit = (empty($limit))?$this->perpageOrder:$limit;
		
		$q = $this->request->getParam('q');
		
		$targetpage = 'shoppingcart/backend/list_bank/limit/'.$limit;
		list($this->view['paginaion'],$this->view['page_description'],$this->view['listBank']) = $this->model->listBank($targetpage,$page,$limit,$q);
		$this->layout->view('/backend/list_bank', $this->view);
	}	
	public function add_bank()
	{
		if($data = $this->input->post()){
		
			$this->model->setValue($data);
			$bank_id = $this->model->addBank();
			
			if($data['image_path']!=''){
				$this->model->upload($data['image_path'],$bank_id);
			}
			$this->view['redirect']="
			<script>
				window.parent.displayNotify('".lang('web_save_success')."','success','#showWarning'); 
				setTimeout(function(){
					window.parent.location='".DIR_ROOT."shoppingcart/backend/add_bank';
				},3000);
			</script>";
		}else{
			$this->model->clearTmpImages();
		}
		$this->layout->view('/backend/add_bank', $this->view);
	}
	public function edit_bank()
	{
		$bank_id = $this->request->getParam('id');
		$this->view['listEditBank'] = $listEditBank = $this->model->listEditBank($bank_id);

		if($data = $this->input->post()){
			
			$this->model->setValue($data);
			$bank_id = $this->model->editBank();
			
			if($data['image_path']!=''){
				$this->model->upload($data['image_path'],$bank_id);
			}
			$this->view['redirect']="
			<script>
				window.parent.displayNotify('".lang('web_save_success')."','success','#showWarning');
				setTimeout(function(){
					window.parent.location='".DIR_ROOT."shoppingcart/backend/index_bank';
				},3000);
			</script>";
		}else{
			$this->model->clearTmpImages();
		}
		$this->layout->view('/backend/edit_bank', $this->view);
	}
	public function delete_bank()
	{
		$this->layout->disableLayout();
		$Array_id=array();
		if($data = $this->input->post()){
			$Array_id = explode(',',$data['id']);
		}else{
			$Array_id[0] = $this->request->getParam('id');
		}
		
		for($i=0;$i<count($Array_id);$i++){
			$this->model->deleteBank($Array_id[$i]);
		}
	}
	public function up_bank()
	{
		$this->layout->disableLayout();
		$id = $this->request->getParam('id');
		$seq = $this->request->getParam('seq');
		$this->bflibs->upMenu('sp_order_bank','bank_id',$id,'bank_seq',$seq);
	}
	public function down_bank()
	{
		$this->layout->disableLayout();
		$id = $this->request->getParam('id');
		$seq = $this->request->getParam('seq');
		$this->bflibs->downMenu('sp_order_bank','bank_id',$id,'bank_seq',$seq);
	}
	public function publish_bank()
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
			$this->bflibs->publish('sp_order_bank','bank_id',$Array_id[$i],'bank_publish',$status);
		}
	}
	public function pin_bank()
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
			$this->bflibs->publish('sp_order_bank','bank_id',$Array_id[$i],'bank_pin',$status);
		}
	}
	

	/*  AJAX
	-------------------------------------------------------------------------------------------------------*/	
	public function showAjax(){
		$this->layout->setLayout('ajax');
		$val = $this->request->getParam('val');
		$content = '';
		
		if($val=='addList'){			
			$id = $this->request->getParam('id');
			$num = $this->request->getParam('num') + 1;			
			$tbl = $this->model->getProduct($id);
			
			$price=$tbl['product_price'];
			$name = $tbl['product_name'];
			if(!empty($tbl)){
				$content = $this->model->rowList($num,$id,$name,1,$price,$tbl['product_point']);
			}
		}
		
		echo $content;
		//$this->layout->view(.'/backend/ajax', $this->view);
	}
	

	/*  UPLOAD
	-------------------------------------------------------------------------------------------------------*/	
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
			$bank_id = $this->request->getParam('id');
			$this->model->movefile();
		}
	}
}
?>