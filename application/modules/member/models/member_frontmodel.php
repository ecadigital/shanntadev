<?php
class Member_frontmodel extends CI_Model {
	private $tbl_member = "member";
	private $tbl_team = "team";
	private $tbl_sp_order = 'sp_order';
	private $tbl_sp_order_item = 'sp_order_item';
	private $tbl_sp_order_confirm = 'sp_order_confirm';
	private $tbl_main = 'main';
	//private $defaultLang;
	
	public function setValue($val){
		$this->value = $val;
	}
	
	private function getValue(){
		return $this->value;
	}
	
	public function __construct(){
	
        parent::__construct();
		$this->ip = $this->bflibs->getIP();
	}
	
	
	
	/* FRONTEND
	------------------------------------------------------------------------------------*/
	public function checkLogin(){
		$val = $this->getValue();
		$username = (isset($val['widget_username'])) ? $val['widget_username'] : $val['username'];
		$password = (isset($val['widget_password'])) ? $val['widget_password'] : $val['password'];
		$where = "($this->tbl_member.member_email='".$username."')";
		$select = $this->db->select(array("$this->tbl_member.member_id","$this->tbl_member.member_email","$this->tbl_member.member_first_name","$this->tbl_member.member_last_name"))
				->from($this->tbl_member)
				->where($where)
				->where("$this->tbl_member.member_pass",base64_encode($password))//md5($password))
				//->where("$this->tbl_member.member_activate",'Y')
				->where("$this->tbl_member.member_publish",1);
		$query = $this->db->get();
		$result = $query->row_array();
		return (!empty($result))? $result:'';
	}
	
	public function register(){
	
		$val = $this->getValue();
		$member_id = $this->bflibs->getLastID($this->tbl_member,'member_id');
		$date = date('Y-m-d H:i:s');

		$data = array(
				"member_id"=>$member_id,
				"member_pass"=>base64_encode($val['member_password']),//md5($member_pass),
				"member_title"=>$val['member_title'],
				"member_first_name"=>$val['member_fname'],
				"member_last_name"=>$val['member_lname'],
				"member_birth_day"=>$val['member_bday'],
				"member_birth_month"=>$val['member_bmonth'],
				"member_birth_year"=>$val['member_byear'],
				"member_email"=>$val['member_email'],
				//"member_address"=>$val['member_address'],
				//"member_city"=>$val['member_city'],
				//"member_postcode"=>$val['member_postcode'],
				//"member_prephone"=>$val['member_prephone'],
				//"member_phone"=>$val['member_phone'],
				"member_publish"=>1,
				"member_date_added"=>$date
		);
		$this->db->insert($this->tbl_member,$data);
		return $member_id;
	}
	public function editProfile($member_id){
		
		$val = $this->getValue();

		if($val['captcha']=='')
		{
			$member_occupation = ($val['member_occupation']=='-') ? $val['member_occupation_other'] : $val['member_occupation'];
			$data = array(
					"member_first_name"=>$val['member_first_name'],
					"member_last_name"=>$val['member_last_name'],
					//"member_email"=>$val['member_email'],
					"member_iden"=>$val['member_iden'],
					"member_birth_day"=>$val['member_birth_day'],
					"member_birth_month"=>$val['member_birth_month'],
					"member_birth_year"=>$val['member_birth_year'],
					"member_address"=>$val['member_address'],
					"province_id"=>$val['province_id'],
					"member_postcode"=>$val['member_postcode'],
					"member_tel"=>$val['member_tel'],
					"member_occupation"=>$member_occupation,
					"member_income"=>$val['member_income']
			);

			$this->db->where('member_id',$member_id);
			$this->db->update($this->tbl_member,$data);
			return $member_id;
		}
	}
	public function change_password($member_id){
	
		$val = $this->getValue();
		
		$data['member_pass'] = base64_encode($val['member_new_pass']);//md5($val['member_new_pass']);
		$this->db->where('member_id',$member_id);
		$this->db->update($this->tbl_member,$data);
		return true;
	}
	public function update_forgot_password($member_pass){
	
		$val = $this->getValue();
		
		$data['member_pass'] = base64_encode($member_pass);//md5($member_pass);
		$this->db->where('member_email',$val['member_email']);
		$this->db->update($this->tbl_member,$data);
	}
	public function chkPassword($pass, $member_id){
	
		$query = $this->db->select('member_pass')
				->from($this->tbl_member)
				->where('member_pass',base64_encode($pass))//md5($pass))
				->where('member_id',$member_id);
		$query = $this->db->get();
		$result = $query->row_array();
		return (empty($result))?'false':'true';
	}
	
	public function chkDuplicateEmail($email){
	
		$query = $this->db->select('member_id')
				->from($this->tbl_member)
				->where('member_email',$email);
		$query = $this->db->get();
		$result = $query->row_array();
		return (empty($result)) ? '' : $result['member_id'];
	}
	
	
	
	public function getMember($member_id){
	
		$query = $this->db->select()
				->from($this->tbl_member)
				->where("member_id",$member_id);
		$query = $this->db->get();
		$result = $query->row_array();
		return $result;
	}
	public function getMain(){
	
		$query = $this->db->select()
				->from($this->tbl_main)
				->where("$this->tbl_main.main_id",1);
		$query = $this->db->get();
		$result = $query->row_array();
		return $result;
	}
	
	
	public function addPayment(){
	
		$val = $this->getValue();
		$order_confirm_id = $this->bflibs->getLastID($this->tbl_sp_order_confirm,'order_confirm_id');
		$date = date('Y-m-d H:i:s');

		$data = array(
				"order_confirm_id"=>$order_confirm_id,
				"order_confirm_name"=>$val['form_confirm_tranfer_name'],
				"order_confirm_surname"=>$val['form_confirm_tranfer_lname'],
				"order_confirm_tel"=>$val['form_confirm_tranfer_phoneNumber'],
				"order_confirm_bank"=>$val['form_confirm_tranfer_bank'],
				"order_confirm_total"=>$val['form_confirm_tranfer_amount'],
				"order_confirm_transfer_date"=>$val['form_confirm_tranfer_time'],
				"order_confirm_path"=>'',//$val['order_path'],
				"order_confirm_note"=>$val['form_confirm_tranfer_detail'],
				"order_confirm_status"=>1,
				"order_confirm_date_added"=>$date
		);
		$this->db->insert($this->tbl_sp_order_confirm,$data);
		
		
		$data = array( "order_status_id" => 2 );
		$this->db->where("order_id",$val['order_id']);
		$this->db->update($this->tbl_sp_order,$data);
		
		
		return $val['order_id'];
	}
	
	/* SEND MAIL
	-----------------------------------------------------------------------------------------------------------*/
	private $websiteName = 'SHANNTA';
	private $websiteDir = DIR_HOST;
	public function sendmail($member_id){//,$member_pass,$member_code=''){
	
		$query = $this->db->select(array("member_first_name","member_last_name","member_email","member_pass"))
				->from($this->tbl_member)
				->where('member_id',$member_id);
		$query = $this->db->get();
		$result = $query->row_array();
		
		$getMain = $this->getMain();
			//echo $getMain['main_email'];
		//if(!empty($getMain) && $getMain['main_email']!="")
		if($result['member_email']!="")
		{
			$member_name = $result['member_first_name'].' '.$result['member_last_name'];
			$to_email = $result['member_email'];//$getMain["main_email"];
			$subject = '['.$this->websiteName.'] MEMBER REGISTRY COMPLETE';
			
			$str='ข้อมูลสมาชิกที่ทำการสมัครสมาชิก<br/>
			<br/><strong>ชื่อ - นามสกุล</strong> :  '.$member_name.'
			<br/><strong>ชื่อผู้ใช้</strong> :  '.$result['member_email'].'
			<br/><strong>รหัสผ่าน</strong> :  '.base64_decode($result['member_pass']).'';
			//<br/><br/>ต้องการแก้ไขข้อมูลอื่นๆ <a href="http://www.havereward.com/member/backend/edit_member/id/'.$member_id.'" target="_blank">คลิกที่นี่</a>';
			echo $str;
			$this->load->library('email');
			$config['mailtype'] = 'html';
			$this->email->initialize($config);
			 
			$this->email->from('no-reply@'.$this->websiteName, $this->websiteName);
			$this->email->to($to_email);
			
			$this->email->subject($subject);
			$this->email->message($str );
			$this->email->send();
		}
	}
	/*private $websiteName = 'Have Reward';
	private $websiteDir = DIR_HOST;
	public function sendmail($member_id,$member_pass){
	
		$query = $this->db->select(array("member_first_name","member_last_name","member_email"))
				->from($this->tbl_member)
				->where('member_id',$member_id);
		$query = $this->db->get();
		$result = $query->row_array();
			
		if(isset($result) && $result['member_email']!="")
		{
			$to_email = $result["member_email"];
			$subject = '['.$this->websiteName.'] Registration completely';
			$name = $result['member_first_name'].' '.$result['member_last_name'];
			$str='สวัสดีค่ะ E-mail นี้ส่งจากระบบอัตโนมัติของ '.$this->websiteName.'<br><br>ตามที่ ได้สมัครสมาชิกกับเว็บไซต์ '.$this->websiteName.'<br>
				ข้อมูลสำหรับเข้าไปจัดการข้อมูลส่วนตัวคือ<br><br>

				    Username: '.$to_email.'<br>
				    Password: '.$member_pass.'<br><br>
					
			ขอขอบคุณที่ให้ความไว้วางใจค่ะ <br><br>';
			
			$this->load->library('email');
			$config['mailtype'] = 'html';
			$this->email->initialize($config);
			 
			$this->email->from('no-reply@'.$this->websiteName, $this->websiteName);
			$this->email->to($to_email);
			
			$this->email->subject($subject);
			$this->email->message( $this->bflibs->emailTemplate($subject,$name,$str) );
			$this->email->send();
		}
	}*/
	public function sendmail_pass($member_email,$member_pass){
	
		$query = $this->db->select(array("member_first_name","member_last_name"))
				->from($this->tbl_member)
				->where('member_email',$member_email);
		$query = $this->db->get();
		$result = $query->row_array();
			
		if(isset($result) && $member_email!="")
		{
			$to_email = $member_email;
			$subject = '['.$this->websiteName.'] Forgot password';
			$name = $result['member_first_name'].' '.$result['member_last_name'];
			$str='สวัสดีค่ะ E-mail นี้ส่งจากระบบอัตโนมัติของ '.$this->websiteName.'<br><br>ตามที่ คุณแจ้งลืมรหัสผ่านไว้  ทาง '.$this->websiteName.' ได้เปลี่ยนรหัสผ่านให้คุณ<br>
				ข้อมูลสำหรับเข้าไปจัดการข้อมูลส่วนตัวคือ<br><br>

				    Username: '.$to_email.'<br>
				    Password: '.$member_pass.'<br><br>
					
			ขอขอบคุณที่ให้ความไว้วางใจค่ะ <br><br>';
			
			$this->load->library('email');
			$config['mailtype'] = 'html';
			$this->email->initialize($config);
			 
			$this->email->from('no-reply@'.$this->websiteName, $this->websiteName);
			$this->email->to($to_email);
			
			$this->email->subject($subject);
			$this->email->message( $this->bflibs->emailTemplate($subject,$name,$str) );
			$this->email->send();
		}
	}
	public function sendmail_changepass($member_id,$member_pass){
	
		$query = $this->db->select(array("member_first_name","member_last_name","member_email"))
				->from($this->tbl_member)
				->where('member_id',$member_id);
		$query = $this->db->get();
		$result = $query->row_array();
			
		if(isset($result) && $member_email!="")
		{
			$to_email = $member_email;
			$subject = '['.$this->websiteName.'] Change password';
			$name = $result['member_first_name'].' '.$result['member_last_name'];
			$str='สวัสดีค่ะ E-mail นี้ส่งจากระบบอัตโนมัติของ '.$this->websiteName.'<br><br>ตามที่ คุณได้เปลี่ยนรหัสผ่านกับทางเว็บไซต์<br>
				ข้อมูลสำหรับเข้าไปจัดการข้อมูลส่วนตัวคือ<br><br>

				    Username: '.$to_email.'<br>
				    Password: '.$member_pass.'<br><br>
					
			ขอขอบคุณที่ให้ความไว้วางใจค่ะ <br><br>';
			
			$this->load->library('email');
			$config['mailtype'] = 'html';
			$this->email->initialize($config);
			 
			$this->email->from('no-reply@'.$this->websiteName, $this->websiteName);
			$this->email->to($to_email);
			
			$this->email->subject($subject);
			$this->email->message( $this->bflibs->emailTemplate($subject,$name,$str) );
			$this->email->send();
		}
	}
	
	
	
	
	public function listOrder($member_id){
	
		$query = $this->db->select()
				->from($this->tbl_sp_order)
				->where("member_id",$member_id)
				->order_by("order_id","desc");
		$query = $this->db->get();
		$result = $query->result_array();
		return $result;
	}
	public function listOrderItem($order_id){
	
		$query = $this->db->select()
				->from($this->tbl_sp_order_item)
				->where("order_id",$order_id);
		$query = $this->db->get();
		$result = $query->result_array();
		return $result;
	}
	public function countOrderConfirm($order_id){
	
		$query = $this->db->select()
				->from($this->tbl_sp_order_confirm)
				->where("order_id",$order_id);
		$num = $this->db->count_all_results();
		return $num;
	}
}