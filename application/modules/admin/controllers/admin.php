<?php 
class Admin extends CI_Controller{
	private $view;
	private $actions;
	
	public function __construct()
    {
		parent::__construct();
		$this->model = $this->load->model('admin/Adminmodel');
		$this->actions = $this->bflibs->insertActionStack();
    }
	
	public function index()
	{
		$this->bflibs->check_login_admin();
		$admin= $this->session->userdata('admin');
		$layout = ($this->request->getParam('layout') == "")?'admin':$this->request->getParam('layout');
		$this->layout->setLayout($layout);
		if(empty($admin->admin_id)){
        	redirect('/admin/admin/login', 'refresh');
        }
		foreach($this->actions as $action)
		{
			$this->layout->setActionStack($action["name"],$action["view"]);
		}
		$this->layout->view('/admin/dashboard', $this->view);
	}
	public function dashboard()
	{
		$this->layout->disableLayout();
		
		$path = './application/modules/admin/views/admin/config';
		$config = $this->model->read_xml('ga',$path);

		$this->view['ga_enable'] = $ga_enable = $config['ga_enable'];
		if($ga_enable=='true'){

			$params = array('username'=>$config['ga_username'],'password'=>$config['ga_password'],'site_id'=>$config['ga_site_id']);
			$ga = $this->load->library('gaapi',$params);
			$limit = 14;
			$limitPage = 5;
			$to=date("Y-m-d");
			$from=date('Y-m-d', strtotime('-'.$limit.' days'));
			
			$this->view['visits'] = $ga->getVisits($from,$to,$limit);
			$this->view['summery'] = $ga->getSummery($from,$to);
			$this->view['topCountries'] = $ga->getTopCountry($from,$to,$limitPage);
			$this->view['topPages'] = $ga->getTopPage($from,$to,$limitPage);
			$this->view['allTimeSummery'] = $ga->getAllTimeSummery();
			$this->output->cache(1440); // 60*24
		}
		
		// -----------------------------------------------
		
		$this->layout->view('/admin/dashboard', $this->view);
	}
	public function login()
	{
		$session_name = 'admin';
		$this->layout->setLayout('login');
		$this->bflibs->check_login_admin();
		$admin= $this->session->userdata($session_name);
		
		if(empty($admin->admin_id)){
			
			if($data = $this->input->post())
			{
				$this->model->setValue($data);
				$return = $this->model->checkLogin();
				if(!empty($return))
				{
					$array = new stdClass();
					$array->admin_id = $return['admin_id'];
					$array->admin_user = $return['admin_user'];
					//$array->admin_name = $return['admin_name'];
					$array->admin_image = $return['admin_image'];
					$array->admin_group = $return['admin_group_id'];
					$array->admin_lang_id = $return['language_id'];
					$array->admin_language = $return['language_name'];
	
					$session_array = array(
	                   'admin'  => $array
	               	);
					if($data['remember'][0]=='1' || $data['remember'][0]=='on')
					{
						$name = SITE.'_admin_id';
						$value = $return['admin_id'];
						$current = SITE."_current";
						$this->bflibs->set_cookie($name, $value);
						$this->bflibs->set_cookie($current, $value);
					}
					else{
						$this->session->sess_expiration = 1800; //half hours
					}
					$this->session->set_userdata($session_array);
				}else{
					$this->layout->disableLayout();
					$this->view['error']="exist";
				}
			}else{
				$current = SITE."_current";
				$current_id = $this->bflibs->fetch_cookie($current);
				if(!empty($current_id)){
					$this->view['last_current'] = $this->model->getCurrent($current_id);
				}
			}
			$this->layout->view('/admin/login', $this->view);
		}else{
			redirect('/product/backend/index', 'refresh');
		}
    }
	public function showlogin()
	{
		$this->layout->view('/admin/showlogin', $this->view);
	}
	public function logout()
	{
    	$this->layout->disableLayout();
		
		$admin= $this->session->userdata('admin');
		// del User online //
		$this->model->delOnlineUser($admin->admin_user);
		// del User online //
		
    	$this->session->unset_userdata("admin");
    	$this->bflibs->remove_cookie(SITE.'_admin_id');
		
		redirect('/admin/admin/login', 'refresh');
    }
    public function profile()
    {
    	$this->bflibs->check_login_admin();
		$admin= $this->session->userdata('admin');
   		if(empty($admin->admin_id)){
        	redirect('/admin/admin/login', 'refresh');
        }
        $id = $admin->admin_id;
		$layout = ($this->request->getParam('layout') == "")?'admin':$this->request->getParam('layout');
		$this->layout->setLayout($layout);
		$this->bflibs->setStack('admin');
		$actions = $this->bflibs->insertActionStack();
    	foreach($actions as $action)
		{
			$this->layout->setActionStack($action["name"],$action["view"]);
		}

		$this->view['listEdit'] = $this->model->listEdit($id);
		$this->view['listLanguage'] = $this->model->listLanguage();
		if($data = $this->input->post())
		{
			$success=true;
			$detail='';
			if(isset($_FILES['userfile']['name']) && $_FILES['userfile']['name']!="")
			{
				list($success,$detail) = $this->upload($data['admin_id']);
			}
			if($success)
			{
				$this->model->setValue($data);
				$id = $this->model->editProfile();
				if(!empty($detail))
				{
					$this->model->updatePath($detail,$id);
					$this->bflibs->updateSession('admin','admin_image',$detail);
				}
				$this->view['redirect']="<script>window.parent.displayNotify('แก้ไขข้อมูลเรียบร้อยแล้ว','success','#showWarning')</script>";
				/*$this->view['redirect']="<script>window.location='".DIR_ROOT."admin/admin/index';</script>";*/
			}else{
				$this->view['redirect']="<script>window.parent.displayNotify('".$detail['error']."','error','#showWarning')</script>";
			}
		}
		$this->layout->view('/admin/profile', $this->view);
    }
	public function chk_password()
	{
		$this->layout->disableLayout();
		$pass = $this->input->get('old_admin_pass');
		$id = $this->request->getParam('id');
		$this->view['valid'] = $this->model->chkPassword($pass,$id);
		$this->layout->view('/admin/chk_valid',$this->view);
	}
	public function delete_image(){
	
		$this->layout->disableLayout();
		$id = $this->request->getParam('id');
		$this->model->delete_image($id);
		$this->bflibs->updateSession('admin_image','');
	}
	public function upload($id)
	{
		$path = 'public/upload/admin/';
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
		$config['width'] = 180;
		$config['height'] = 180;

		$this->load->library('image_lib', $config);
		if ( ! $this->image_lib->resize())
		{
			$error = $this->image_lib->display_errors();
		}
	}
	public function setting()
	{
		$this->bflibs->check_login_admin();
		$admin= $this->session->userdata('admin');
   		if(empty($admin->admin_id)){
        	redirect('/admin/admin/login', 'refresh');
        }
		$layout = ($this->request->getParam('layout') == "")?'admin':$this->request->getParam('layout');
		$this->layout->setLayout($layout);
		$this->bflibs->setStack('admin');
    	foreach($this->actions as $action)
		{
			$this->layout->setActionStack($action["name"],$action["view"]);
		}
		$this->view['listEditSetting'] = $this->model->listEditSetting();
		if($data = $this->input->post()){
		
			$this->model->setValue($data);
			$this->model->editSetting();
			$this->view['success']="<script>window.parent.displayNotify('".lang('web_save_success')."','success','#showWarning');</script>";
		}
		$this->layout->view('/admin/setting',$this->view);
	}
}
?>