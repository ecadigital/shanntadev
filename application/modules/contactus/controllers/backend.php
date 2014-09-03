<?php 
class Backend extends CI_Controller{
	private $view;
	private $perpageContact = 20;
	
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
		$this->model = $this->load->model('contactus/Contactusmodel');
    }
	public function index()
	{
		$this->view['targetpage'] = $targetpage = 'contactus/backend/list_contact';
		$this->view['perPage'] = $this->perpageContact;
		$this->layout->view('/backend/index', $this->view);
	}
	public function list_contact()
	{
		$this->layout->setLayout('ajax');
		$this->view['module'] = $this->request->getModuleName();
		$this->view['param'] = '';
		$this->view['target'] = '#boxContent';
		$this->view['targetpage'] = $targetpage = 'contactus/backend/list_contact';
		
		$page = $this->request->getParam('page');
		$this->view['page'] = $page = (empty($page))?1:$page;
		
		$limit = $this->request->getParam('limit');
		$this->view['limit'] = $limit = (empty($limit))?$this->perpageContact:$limit;
		
		$q = $this->request->getParam('q');
		
		$targetpage = 'contactus/backend/list_contact/limit/'.$limit;
		list($this->view['paginaion'],$this->view['page_description'],$this->view['listContact']) = $this->model->listContact($targetpage,$page,$limit,$q);
		$this->layout->view('/backend/list_contact', $this->view);
	}
	public function contact_detail()
	{
		$this->layout->disableLayout();
		$this->view['listEdit'] = $this->model->listEdit();
		if($data = $this->input->post()){
		
			$this->model->setValue($data);
			$this->model->addContactDetail();
			
			$success=true;
			$detail='';
			if($_FILES['file_upload']['name']!=""){
				list($success,$detail) = $this->upload_contact();
			}

			if($success){
				($detail!='')?$this->model->updatePath_contact($detail):'';
			}else{
				$detai=$data['image_path'];
			}
			$this->view['success']="<script>window.parent.displayNotify('success !!','success','#showWarning');parent.document.getElementById('wrap-image').innerHTML='<img src=\"".DIR_ROOT.$detail."\" />';</script>";
		}
		$this->layout->view('/backend/contact_detail', $this->view);
	}
	public function delete_contact()
	{
		$this->layout->disableLayout();
		$id = $this->request->getParam('id');
		$this->model->deleteContact($id);
	}
	
	/* UPLOAD
	-----------------------------------------------------------------------------------------------------------*/
	public function upload_contact()
	{
		//check upload directory in public
		$params = array('module'=>'map','controller'=>'','action'=>'');
		$cm = $this->load->library('createfolder',$params);
		$cm->make();
		
		$path = 'public/upload/map/';
		$config['upload_path'] = DIR_FILE.$path;
		$config['allowed_types'] = 'gif|jpg|png';
		$config['max_size']	= '1024';
		$config['max_width']  = '2000';
		$config['max_height']  = '2000';
		$config['overwrite']  = TRUE;
		$config['file_name'] = "map_".time();
		
		$this->load->library('upload', $config);
	
		if ( ! $this->upload->do_upload('file_upload'))
		{
			$error = array('error' => $this->upload->display_errors());
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
		$config['width'] = 440;
		$config['height'] = 290;
		
		$this->load->library('image_lib', $config);
		if ( ! $this->image_lib->resize())
		{
			$error = $this->image_lib->display_errors();
		}
	}
}
?>