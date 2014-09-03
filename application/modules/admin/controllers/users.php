<?php 
class Users extends CI_Controller{
	private $view;
	private $param;
	
	public function __construct()
    {
		parent::__construct();
   	 	$this->bflibs->check_login_admin();
		$admin= $this->session->userdata('admin');
   		if(empty($admin->admin_id)){
        	redirect('/admin/admin/login', 'refresh');
        }
		$layout = ($this->request->getParam('layout') == "")?'admin':$this->request->getParam('layout');
		$this->layout->setLayout($layout);
		$this->bflibs->setStack('admin');
		$actions = $this->bflibs->insertActionStack();
    	foreach($actions as $action)
		{
			$this->layout->setActionStack($action["name"],$action["view"]);
		}
		$this->model = $this->load->model('admin/Adminmodel');
		$menu = $this->request->getParam('menu');
		$this->param = $this->view['param'] = '/menu/'.$menu;
    }
	public function index()
	{
		$this->view['p'] = $p = $this->request->getParam('p');
		$this->view['listAllUser'] = $this->model->listAllUser($p);
		$this->view['listGroupUserName'] = $this->model->listGroupUserName();
		$this->layout->view('/users/index', $this->view);
	}
	/* GROUP
	-----------------------------------------------------------------------------------------------------------*/
	public function list_group()
	{
		$this->view['listGroupUser'] = $this->model->listGroupUser();
		$this->layout->view('/users/list_group', $this->view);
	}
	public function addGroup()
	{
		if($data = $this->input->post()){
			$this->model->setValue($data);
			$this->model->addGroup();
			$this->view['redirect']="<script>window.parent.location='".DIR_ROOT."admin/users/index/tab/2".$this->param."'</script>";
		}
		$this->layout->view('/users/add_group', $this->view);
	}
	public function editGroup()
	{
		$id = $this->request->getParam('id');
		$this->view['listEditGroup'] = $this->model->listEditGroup($id);
		if($data = $this->input->post()){
			$this->model->setValue($data);
			$this->model->editGroup();
			$this->view['redirect']="<script>window.parent.location='".DIR_ROOT."admin/users/index/tab/2".$this->param."'</script>";
		}
		$this->layout->view('/users/edit_group', $this->view);
	}
	public function deleteGroup()
	{
		$this->layout->disableLayout();
		$id = $this->request->getParam('id');
		$this->model->deleteGroup($id);
	}
	public function chk_bfdelete()
	{
		$this->layout->disableLayout();
		$group_id = $this->request->getParam('group_id');
		$this->view['valid'] = $this->model->chk_bfdelete($group_id);
		$this->layout->view('/users/chk_valid',$this->view);
	}
	
	
	/* ADMIN
	-----------------------------------------------------------------------------------------------------------*/
	public function list_admin()
	{
		$this->view['listAllUser'] = $this->model->listAllUser();
		$this->view['listGroupUserName'] = $this->model->listGroupUserName();
		$this->layout->view('/users/list_admin', $this->view);
	}
	public function add()
	{
		$this->view['p'] = $this->request->getParam('p');
		$this->view['listGroupUser'] = $this->model->listGroupUser();
		if($data = $this->input->post()){
			$success=true;
			$detail='';
			if($_FILES['userfile']['name']!=""){
				
				$id = $this->bflibs->getLastID('admin','admin_id');
				list($success,$detail) = $this->upload($id);
			}
			if($success){
				$this->model->setValue($data);
				$this->model->add();
				(!empty($detail))?$this->model->updatePath($detail,$id):'';
				$this->view['redirect']="<script>window.parent.location='".DIR_ROOT."admin/users/index/p/".$data['admin_group_id'].$this->param."'</script>";
			}else{
				$this->view['error']="<script>window.parent.displayNotify('".$detail['error']."','error','#showWarning')</script>";
			}
		}
		$this->layout->view('/users/add', $this->view);
	}
	public function edit()
	{
		$id = $this->request->getParam('id');
		$this->view['listEdit'] = $this->model->listEdit($id);
		//$this->view['listGroupUser'] = $this->model->listGroupUser();
		if($data = $this->input->post()){
			$this->model->setValue($data);
			$this->model->edit();
			$this->view['redirect']="<script>window.parent.location='".DIR_ROOT."admin/users/index/p/".$data['admin_group_id'].$this->param."'</script>";
		}
		$this->layout->view('/users/edit', $this->view);
	}
	public function delete()
	{
		$this->layout->disableLayout();
		$id = $this->request->getParam('id');
		$p = $this->request->getParam('p');
		$this->model->delete($id);
		echo "<script>window.parent.location='".DIR_ROOT."admin/users/index/p/".$p.$this->param."'</script>";
		/*if($data = $this->input->post()){
			$id = $data['id'];
			$this->model->delete($id);
		}*/
	}
	public function delete_image()
	{
		$this->layout->disableLayout();
		$id = $this->request->getParam('id');
		$this->model->delete_image($id);
	}
	public function publish()
	{
		$this->layout->disableLayout();
		$id = $this->request->getParam('id');
		$status = $this->request->getParam('status');
		$this->model->publish($id,$status);
	}
	public function chk_username()
	{
		$this->layout->disableLayout();
		$username = $this->input->get('admin_user');
		$id = $this->request->getParam('id');
		$this->view['valid'] = $this->model->chkUserName($username,$id);
		$this->layout->view('/users/chk_valid',$this->view);
	}
	
	public function chk_email()
	{
		$this->layout->disableLayout();
		$email = $this->input->get('admin_email');
		$id = $this->request->getParam('id');
		$this->view['valid'] = $this->model->chkEmail($email,$id);
		$this->layout->view('/users/chk_valid',$this->view);
	}
	
	/* UPLOAD
	-----------------------------------------------------------------------------------------------------------*/
	public function upload($id)
	{
		$folder = DIR_FILE.DS.'public'.DS.'upload'.DS.$this->request->getModuleName();
		if(!file_exists($folder)){mkdir($folder);}
		
		$path = 'public/upload/'.$this->request->getModuleName().'/';
		$config['upload_path'] = DIR_FILE.$path;
		$config['allowed_types'] = 'gif|jpg|png';
		$config['max_size']	= '1024';
		$config['max_width']  = '600';
		$config['max_height']  = '600';
		$config['overwrite']  = TRUE;
		$config['file_name'] = "profile_".$id."m".md5(date('Ymdhis'));
		
		$this->load->library('upload', $config);
	
		if ( ! $this->upload->do_upload())
		{
			$error = array('error' => $this->upload->display_errors('<span>','</span>'));
			return array(false,$error);
		}
		else
		{
			$data = $this->upload->data();
			$this->imagesResize($data['full_path']);
			return array(true,$path.$data['file_name']);
		}
	}
	public function imagesResize($pathImages)
	{
		$config['image_library'] = 'gd2';
		$config['source_image'] = $pathImages;
		$config['create_thumb'] = FALSE;
		$config['maintain_ratio'] = TRUE;
		$config['width'] = 180;
		$config['height'] = 180;
		
		$this->load->library('image_lib', $config);
		if ( ! $this->image_lib->resize())
		{
			$error = $this->image_lib->display_errors();
		}
	}
}
?>