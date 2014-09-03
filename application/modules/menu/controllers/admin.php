<?php 
class Admin extends CI_Controller{
	private $view;
	private $cachefile = "menu";
	
	public function __construct()
    {
        parent::__construct();
        $this->bflibs->check_login_admin();
		$admin= $this->session->userdata('admin');
   		if(empty($admin->admin_id)){
        	redirect('/admin/admin/login', 'refresh');
        }
		$this->model = $this->load->model('menu/Menumodel');
		$layout = ($this->request->getParam('layout') == "")?'admin':$this->request->getParam('layout');
		$this->layout->setLayout($layout);
		$this->bflibs->setStack('admin');
		$actions = $this->bflibs->insertActionStack();
    	foreach($actions as $action)
		{
			$this->layout->setActionStack($action["name"],$action["view"]);
		}
    }
	
	public function index()
	{
		$this->view['menu'] = $this->request->getParam('menu');
		$this->view['listMenu'] = $this->model->listMenu(0,0);
		$this->view['listGroupUserName'] = $this->model->listGroupUserName();
		$this->layout->view('/admin/index', $this->view);
	}
	public function add()
	{
		$this->view['listMenuParent'] = $this->model->listMenuParent(0,0);
		$this->view['listGroupUser'] = $this->model->listGroupUser();
		$this->view['listModule'] = $this->model->listModule();
		if($data = $this->input->post())
		{
			$success=true;
			$detail='';
			if($_FILES['userfile']['name']!="")
			{
				$id = $this->bflibs->getLastID('admin_menu','menu_id');
				list($success,$detail) = $this->upload($id);
			}
			if($success)
			{
				$this->model->setValue($data);
				$id = $this->model->add();
				(!empty($detail))?$this->model->updatePath($detail,$id):'';
				$GroupUser = $this->model->listGroupUser();
				foreach($GroupUser as $group){
					$this->model->updateCache($this->cachefile,$group['admin_group_id']);
				}
				$this->view['redirect']="<script>window.location='".DIR_ROOT."menu/admin/index'</script>";
			}else{
				$this->view['error']="<script>window.parent.showError('".$detail['error']."','error','#showWarning')</script>";
			}
		}
		$this->layout->view('/admin/add', $this->view);
	}
	public function edit()
	{
		$id = $this->request->getParam('id');
		$this->view['listEdit'] = $this->model->listEdit($id);
		$this->view['listMenuParent'] = $this->model->listMenuParentEdit(0,0,$id);
		$this->view['listGroupUser'] = $this->model->listGroupUser();
		$this->view['listModule'] = $this->model->listModule();
		if($data = $this->input->post())
		{
			$success=true;
			$detail='';
			if($_FILES['userfile']['name']!="")
			{
				list($success,$detail) = $this->upload($data['menu_id']);
			}
			if($success)
			{
				$this->model->setValue($data);
				$id = $this->model->edit();
				(!empty($detail))?$this->model->updatePath($detail,$id):'';
				$GroupUser = $this->model->listGroupUser();
				foreach($GroupUser as $group){
		
					$this->model->updateCache($this->cachefile,$group['admin_group_id']);
				}
				$this->view['redirect']="<script>window.location='".DIR_ROOT."menu/admin/index'</script>";
			}else{
				$this->view['error']="<script>window.showError('".$detail['error']."','error','#showWarning')</script>";
			}
		}
		$this->layout->view('/admin/edit', $this->view);
	}
	
	public function delete()
	{
		$this->layout->disableLayout();
		$id = $this->request->getParam('id');
		$this->model->delete($id);
		$GroupUser = $this->model->listGroupUser();
		foreach($GroupUser as $group){

			$this->model->updateCache($this->cachefile,$group['admin_group_id']);
		}
	}
	public function delete_image(){
	
		$this->layout->disableLayout();
		$id = $this->request->getParam('id');
		$this->model->delete_image($id);
		$GroupUser = $this->model->listGroupUser();
		foreach($GroupUser as $group){

			$this->model->updateCache($this->cachefile,$group['admin_group_id']);
		}
	}
	public function up()
	{
		$this->layout->disableLayout();
		$id = $this->request->getParam('id');
		$seq = $this->request->getParam('seq');
		$parent_id = $this->request->getParam('parent_id');
		$this->model->upMenu($id,$seq,$parent_id);
		$GroupUser = $this->model->listGroupUser();
		foreach($GroupUser as $group){

			$this->model->updateCache($this->cachefile,$group['admin_group_id']);
		}
	}
	public function down()
	{
		$this->layout->disableLayout();
		$id = $this->request->getParam('id');
		$seq = $this->request->getParam('seq');
		$parent_id = $this->request->getParam('parent_id');
		$this->model->downMenu($id,$seq,$parent_id);
		$GroupUser = $this->model->listGroupUser();
		foreach($GroupUser as $group){

			$this->model->updateCache($this->cachefile,$group['admin_group_id']);
		}
	}
	public function publish()
	{
		$this->layout->disableLayout();
		$id = $this->request->getParam('id');
		$status = $this->request->getParam('status');
		$this->model->publish($id,$status);
		$GroupUser = $this->model->listGroupUser();
		foreach($GroupUser as $group){

			$this->model->updateCache($this->cachefile,$group['admin_group_id']);
		}
	}
	public function upload($id)
	{
		//check upload directory in public
		$params = array('module'=>$this->request->getModuleName(),'controller'=>$this->request->getControllerName(),'action'=>$this->request->getActionName());
		$cm = $this->load->library('createfolder',$params);
		$cm->make();
		
		$path = 'public/upload/'.$this->request->getModuleName().'/'.$this->request->getControllerName().'/';
		$config['upload_path'] = DIR_FILE.$path;
		$config['allowed_types'] = 'gif|jpg|png';
		$config['max_size']	= '1024';
		$config['max_width']  = '600';
		$config['max_height']  = '600';
		$config['overwrite']  = TRUE;
		$config['file_name'] = "icon_".$id;
		
		$this->load->library('upload', $config);
	
		if ( ! $this->upload->do_upload())
		{
			$error = array('error' => $this->upload->display_errors());
			return array(false,$error);
		}
		else
		{
			$data = $this->upload->data();
			//$this->imagesResize($data['full_path']);
			return array(true,$path.$data['file_name']);
		}
	}
	public function imagesResize($pathImages)
	{
		$config['image_library'] = 'gd2';
		$config['source_image'] = $pathImages;
		$config['create_thumb'] = FALSE;
		$config['maintain_ratio'] = TRUE;
		$config['width'] = 16;
		$config['height'] = 16;

		$this->load->library('image_lib', $config);
		
		if ( ! $this->image_lib->resize())
		{
			$error = $this->image_lib->display_errors();
		}
	}
}
?>