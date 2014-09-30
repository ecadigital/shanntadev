<?php 
class Frontend extends CI_Controller{
	private $view;	
	
	public function __construct()
    {
        parent::__construct();
        
    	$layout = ($this->request->getParam('layout') == "")?'default':$this->request->getParam('layout');
		$this->layout->setLayout($layout);
		//$this->layout->disableLayout($layout);
   	 	$this->model = $this->load->model('member/Member_frontmodel');
    }
	
	public function login()
	{
    	$this->layout->disableLayout();
		if($data = $this->input->post())
		{
			$this->model->setValue($data);
			$return = $this->model->checkLogin();//print_r($data);
			if(!empty($return))
			{
				$array = array();
				$_SESSION['member_id'] = $return['member_id'];
				$_SESSION['member_user'] = $return['member_email'];
				$_SESSION['member_name'] = $return['member_first_name'].' '.$return['member_last_name'];
				$_SESSION['member_language'] = 1;
				
				if(isset($data['remember']) && ($data['remember']=='1' || $data['remember']=='on'))
				{
					$name = SITE.'_member_id';
					$value = $return['member_id'];
					$this->bflibs->set_cookie($name, $value);
				}
				else{
					$this->session->sess_expiration = 1800; //half hours
				}
				if(isset($data['widget'])){
					//echo '<script>window.parent.location="'.DIR_ROOT.$data['redirect'].'";</script>';
				}else{
					//echo '<script>window.parent.location.reload();</script>';
				}
			}else{
				echo '0';
				//echo '<script>window.parent.alert("รหัสผ่านไม่ถูกต้อง");</script>';
			}
		}
	}
	public function chkLogin()
	{
    	$this->layout->disableLayout();
    	$this->session->unset_userdata("member");
    	$this->bflibs->remove_cookie(SITE.'_member_id');
		redirect('/', 'refresh');
    }
	public function logout()
	{
    	$this->layout->disableLayout();
    	unset($_SESSION['member_id']);
    	unset($_SESSION['member_user']);
    	unset($_SESSION['member_name']);
    	unset($_SESSION['member_language']);
    	//echo '<script>window.location="'.DIR_ROOT.'";</script>';
    }
    
	
	public function member_login()
	{
    	$this->layout->disableLayout();
		$this->layout->view('/frontend/login',$this->view);
	}
	
	public function register()
	{
		$this->layout->disableLayout();
		if($data = $this->input->post()){
			$this->model->setValue($data);
			
			//$member_pass = $data['member_password'];//rand(100000,999999);
			
			$member_id = $this->model->chkDuplicateEmail($data['member_email']);
			
			if($member_id==''){				
				
				echo $member_id = $this->model->register();//($member_pass);
				//$this->model->sendmail($member_id);
				//$this->model->sendmail($member_id,$member_pass);
				
				/*echo "
				<script>
					alert('สมัครสมาชิกสำเร็จ กรุณรรอการติดต่อกลับภายใน 1-2 วันค่ะ');
					window.parent.location='".DIR_ROOT."index.php';
				</script>";*/
				
				$_SESSION['member_id'] = $member_id;
				$_SESSION['member_user'] = $data['member_email'];
				$_SESSION['member_name'] = $data['member_fname'].' '.$data['member_lname'];
				$_SESSION['member_title'] = $data['member_title'];
				$_SESSION['member_fname'] = $data['member_fname'];
				$_SESSION['member_lname'] = $data['member_lname'];
				$_SESSION['member_language'] = 1;
				
				if(isset($data['remember']) && ($data['remember']=='1' || $data['remember']=='on'))
				{
					$name = SITE.'_member_id';
					$value = $return['member_id'];
					$this->bflibs->set_cookie($name, $value);
				}
				else{
					$this->session->sess_expiration = 1800; //half hours
				}
				
				if(isset($data['member_type'])) $_SESSION['order']['member_type']='member';
				if(isset($data['member_id'])) $_SESSION['order']['member_id']=$member_id;
				if(isset($data['member_title'])) $_SESSION['order']['member_title']=$data['member_title'];
				if(isset($data['member_fname'])) $_SESSION['order']['member_fname']=$data['member_fname'];
				if(isset($data['member_lname'])) $_SESSION['order']['member_lname']=$data['member_lname'];
				if(isset($data['member_bday'])) $_SESSION['order']['member_bday']=$data['member_bday'];
				if(isset($data['member_bmonth'])) $_SESSION['order']['member_bmonth']=$data['member_bmonth'];
				if(isset($data['member_byear'])) $_SESSION['order']['member_byear']=$data['member_byear'];
			}else{
				echo '';
			}
		}
		//$this->layout->view('/frontend/register',$this->view);
    }
	public function edit_profile()
	{
    	$this->layout->disableLayout();
		if($data = $this->input->post()){
			
			$this->model->setValue($data);
			$member_id = $this->model->editProfile($_SESSION['member_id']);
			
			echo "
			<script>
				window.parent.showWarning();
			</script>";/*
				window.parent.displayNotify('เปลี่ยนข้อมูลส่วนตัวเรียบร้อยแล้ว','success_front','#showWarning_profile');
				setTimeout(function(){
					//window.parent.location='".DIR_ROOT."member.php';
				},3000);*/
		}
	}
    public function change_password()
    {
    	$this->layout->disableLayout();
		if($data = $this->input->post())
		{
			$this->model->setValue($data);
			$this->model->change_password($_SESSION['member_id']);
			$this->model->sendmail_changepass($_SESSION['member_id'],$val['member_new_pass']);

			echo "
			<script>
				alert('เปลี่ยนรหัสผ่านเรียบร้อยแล้ว');
				window.parent.location='".DIR_ROOT."member.php';
			</script>";
				/*window.parent.displayNotify('เปลี่ยนรหัสผ่านเรียบร้อยแล้ว','success_front','#showWarning');
				setTimeout(function(){
					window.parent.location='".DIR_ROOT."member.php';
				},3000);*/
		}
    }

	public function forgot_password()
	{
    	$this->layout->disableLayout();
		if($data = $this->input->post())		{
			$this->model->setValue($data);
			
			$member_id = $this->model->chkDuplicateEmail($data['member_email']);
			if($member_id==''){
				echo '0';
			}else{
				$member_pass = rand(100000,999999);
				
				$this->model->update_forgot_password($member_pass);
				$this->model->sendmail_pass($data['member_email'],$member_pass);
			}
			
			/*echo "
			<script>
				alert('รหัสผ่านได้ส่งไปที่อีเมล์ที่คุณใช้สมัครแล้ว');
				window.parent.location='".DIR_ROOT."index.php';
			</script>";*/
		}
		//$this->layout->view('/frontend/forgot_password', $this->view);
    }
	
	public function chkPassword()
	{
		$this->layout->disableLayout();
		$pass = $this->input->get('member_pass');
		echo $this->model->chkPassword($pass,$_SESSION['member_id']);
	}
	public function chkDuplicateEmail()
	{
		$this->layout->disableLayout();
		$email = $this->input->get('member_email');
		$member_id = $this->model->chkDuplicateEmail(urldecode($email));

		if(isset($_SESSION['member_id'])){
			if($member_id==''){
				echo 'true';
			}else{
				echo ($_SESSION['member_id']==$member_id) ? 'true' : 'false';
			}
		}else{
			$this_member_id = $this->request->getParam('id');
			echo ($member_id=='' || $member_id==$this_member_id) ? 'true' : 'false';
		}
	}
	public function chkEmailDB()
	{
		$this->layout->disableLayout();
		$email = $this->input->get('member_email');
		$member_id = $this->model->chkDuplicateEmail(urldecode($email));
		echo ($member_id=='') ? 'false' : 'true';
	}
	
	/* TEAM	
	-------------------------------------------------------------------------------*/
	
	public function add_team()
	{
    	$this->layout->disableLayout();
		if($data = $this->input->post()){
			
			$this->model->setValue($data);
			$team_id = $this->model->addTeam();
			
			echo "
			<script>
				window.parent.showWarning_team();
			</script>";/*
				window.parent.displayNotify('เปลี่ยนข้อมูลส่วนตัวเรียบร้อยแล้ว','success_front','#showWarning_profile');
				setTimeout(function(){
					//window.parent.location='".DIR_ROOT."member.php';
				},3000);*/
		}
	}
	public function edit_team()
	{
    	$this->layout->disableLayout();
		$team_id = $this->request->getParam('id');
		$team_name = $this->request->getParam('name');
		$this->model->editTeam($team_id,$team_name);
	}
	public function delete_team()
	{
    	$this->layout->disableLayout();
		$team_id = $this->request->getParam('id');
		$this->model->deleteTeam($team_id);
	}
	
	
	
	public function history()
	{
    	$this->layout->disableLayout();
		$member_id = $this->request->getParam('id');
		$member_id = (($member_id==0||$member_id=='')&&isset($_SESSION['member_id'])) ? $_SESSION['member_id'] : $member_id;
		$this->view['listOrder'] = $listOrder = $this->model->listOrder($member_id);
		$this->layout->view('/frontend/history', $this->view);
	}
	
	public function payment_confirmation()
	{
		$this->layout->disableLayout();
		if($data = $this->input->post()){
			$this->model->setValue($data);
			$order_id = $this->model->addPayment();
			echo "
			<script>
				window.parent.showWarning();
				setTimeout(function(){
					window.parent.location='".DIR_ROOT."point.php';//history.php?order=".$order_id."';
				},1000);
			</script>";	
		}
		$this->layout->view('/frontend/checkout', $this->view);
	}
}
?>