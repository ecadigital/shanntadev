<?php 
class Backend extends CI_Controller{
	private $view;
	private $perpageVoucher = 10;
	
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
		$this->model = $this->load->model('voucher/Vouchermodel');
    }

	
	
	/*  VOUCHER
	-------------------------------------------------------------------------------------------------------*/


	public function index_voucher()
	{
		$id = $this->request->getParam('id');
		$this->view['targetpage'] = $targetpage = 'voucher/backend/list_voucher';
		$this->view['perPage'] = $this->perpageVoucher;
		$this->layout->view('/backend/index_voucher', $this->view);
	}
	public function list_voucher()
	{
		$this->layout->setLayout('ajax');
		$this->view['module'] = $this->request->getModuleName();
		$this->view['param'] = '';
		$this->view['target'] = '#boxContent';
		
		$id = $this->request->getParam('id');
		$this->view['listVoucher'] = $this->model->listVoucher();
		$this->layout->view('/backend/list_voucher', $this->view);
	}
	public function add_voucher()
	{
		if($data = $this->input->post()){
		
			$this->model->setValue($data);
			$voucher_id = $this->model->addVoucher();
			$this->bflibs->addLog('log_add_voucher',$data['voucher_name'],DIR_ROOT.'voucher/backend/edit_voucher/id/'.$voucher_id);
				
			$this->view['redirect']="
			<script>
				window.parent.displayNotify('".lang('web_save_success')."','success','#showWarning');
				setTimeout(function(){
					window.parent.location='".DIR_ROOT."voucher/backend/index_voucher';
				},3000);
			</script>";
		}
		$this->layout->view('/backend/add_voucher', $this->view);
	}
	public function edit_voucher()
	{
		$voucher_id = $this->request->getParam('id');
		$this->view['listEditVoucher'] = $listEditVoucher = $this->model->listEditVoucher($voucher_id);
		$this->view['listPackage'] = $this->model->listAllPackage();;
		
		/////////////////////////////////// No data //////////////////////////////////////////
		if(empty($listEditVoucher)){
			$this->view['redirect']='<div class="nodata">No data</a>';
		}
		/////////////////////////////////// No data //////////////////////////////////////////
		
		if($data = $this->input->post()){
		
			$this->model->setValue($data);
			$this->model->editVoucher();
			$voucher_id = $data['voucher_id'];
			
			$this->view['redirect']="
			<script>
				window.parent.displayNotify('".lang('web_save_success')."','success','#showWarning');
				setTimeout(function(){
					window.parent.location='".DIR_ROOT."voucher/backend/index_voucher';
				},3000);
			</script>";
		}
		$this->layout->view('/backend/edit_voucher', $this->view);
	}
	public function delete_voucher()
	{
		$this->layout->disableLayout();
		$Array_id=array();
		if($data = $this->input->post()){
			$Array_id = explode(',',$data['id']);
		}else{
			$Array_id[0] = $this->request->getParam('id');
		}
		
		for($i=0;$i<count($Array_id);$i++){

			$this->model->deleteVoucher($Array_id[$i]);
		}
	}
	public function publish_voucher()
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
			$this->bflibs->publish('voucher','voucher_id',$Array_id[$i],'voucher_publish',$status);
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