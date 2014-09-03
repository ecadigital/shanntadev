<?php 
class Index extends CI_Controller{
	private $view;
	
	public function __construct()
    {
		parent::__construct();
		$this->model = $this->load->model('language/Languagemodel');
		$layout = ($this->request->getParam('layout') == "")?'admin':$this->request->getParam('layout');
		$this->layout->setLayout($layout);
		$this->bflibs->setStack('admin');
    }
	
	public function index()
	{
		$this->view['listLanguage'] = $this->model->listLanguage();
		$this->layout->view('/index/index', $this->view);
	}
	public function add()
	{
		$this->layout->disableLayout();
		if($data = $this->input->post())
		{
			$success=true;
			$detail='';
			if($_FILES['userfile']['name']!="")
			{
				$language_id = $this->bflibs->getLastID('admin_language','language_id');
				list($success,$detail) = $this->model->upload($language_id);
			}
			if($success)
			{
				$this->model->setValue($data);
				$language_id = $this->model->add();
				$this->view['redirect']="<script>window.parent.loadAjax('".DIR_ROOT."language/index/index','#','');</script>";
			}else{
				$this->view['error']="<script>window.parent.showError('".$detail['error']."','error','#showWarning')</script>";
			}
		}
		$this->layout->view('/index/add', $this->view);
	}
	public function edit()
	{
		$this->layout->disableLayout();
		$id = $this->request->getParam('id');
		$this->view['listEdit']=$this->model->listEdit($id);
		if($data = $this->input->post())
		{
			$success=true;
			$detail='';
			if($_FILES['userfile']['name']!="")
			{
				list($success,$detail) = $this->model->upload($data['language_id']);
			}
			if($success)
			{
				$this->model->setValue($data);
				$this->model->edit();
				$this->view['redirect']="<script>window.parent.loadAjax('".DIR_ROOT."language/index/index','#','');</script>";
			}else{
				$this->view['error']="<script>window.parent.showError('".$detail['error']."','error','#showWarning')</script>";
			}
		}
		$this->layout->view('/index/edit', $this->view);
	}
	public function up()
	{
		$this->layout->disableLayout();
		$id = $this->request->getParam('id');
		$seq = $this->request->getParam('seq');
		$this->model->upMenu($id,$seq);
	}
	public function down()
	{
		$this->layout->disableLayout();
		$id = $this->request->getParam('id');
		$seq = $this->request->getParam('seq');
		$this->model->downMenu($id,$seq);
	}
	public function delete()
	{
		$this->layout->disableLayout();
		$id = $this->request->getParam('id');
		$default = $this->request->getParam('default');
		$this->model->delete($id,$default);
	}
	public function delete_image(){
	
		$this->layout->disableLayout();
		$id = $this->request->getParam('id');
		$this->model->delete_image($id);
	}
	public function defaultadmin()
	{
		$this->layout->disableLayout();
		$id = $this->request->getParam('id');
		$this->model->defaultadmin($id);
	}
	public function defaultfront()
	{
		$this->layout->disableLayout();
		$id = $this->request->getParam('id');
		$this->model->defaultfront($id);
	}
}
?>