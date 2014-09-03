<?php 
class Index extends CI_Controller{
	private $view;
	
	public function __construct()
    {
		parent::__construct();
		$this->model = $this->load->model('module/Modulemodel');
		$layout = ($this->request->getParam('layout') == "")?'admin':$this->request->getParam('layout');
		$this->layout->setLayout($layout);
		$this->bflibs->setStack('admin');
    }
	
	public function index()
	{
		$this->view['listModule'] = $this->model->listModule();
		$this->layout->view('/index/index', $this->view);
	}
	public function add()
	{
		$this->layout->disableLayout();
		$this->view['listExtensionModule'] = $this->model->listExtensionModule();
		if($data = $this->input->post())
		{
			$this->model->setValue($data);
			$results = $this->model->add();
			
			if($results){
				$this->view['redirect']="<script>window.parent.loadAjax('".DIR_ROOT."module/index/index','#','');</script>";
			}
			else{
				$this->view['error']="<script>window.parent.displayNotify('".lang('web_module_warning2')."','error','#showWarning')</script>";
			}
		}
		$this->layout->view('/index/add', $this->view);
	}
	public function delete()
	{
		$this->layout->disableLayout();
		$id = $this->request->getParam('id');
		$this->model->delete($id);
	}
	public function chk_modulename()
	{
		$this->layout->disableLayout();
		$module_name = $this->input->get('module_name');
		$this->view['valid'] = $this->model->chk_modulename($module_name);
		$this->layout->view('/index/chk_valid',$this->view);
	}
}
?>