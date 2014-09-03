<?php
class Membermodel extends CI_Model {
	private $tbl_admin_cfg = 'admin_cfg';
	private $tbl_member = 'member';
	private $tbl_member_point = 'member_point';
	private $tbl_member_occupation = 'member_occupation';
	private $tbl_member_income = 'member_income';
	private $tbl_province = 'province';
	private $tbl_sp_order = 'sp_order';
	private $tbl_sp_order_item = 'sp_order_item';
	private $tbl_team = "team";
	private $tbl_main = 'main';
	
	private $member;
	private $defaultlang;
	//public $param;
	
	public function setValue($val){
		$this->value = $val;
	}
	
	private function getValue(){
		return $this->value;
	}
	
	public function __construct(){
	
        parent::__construct();
        $admin = $this->session->userdata('admin');
		$this->member= $this->session->userdata('member');
		@$this->admin_id = $admin->admin_id;
		$this->ip = $this->bflibs->getIP();
		$this->defaultlang = $this->bflibs->getDefaultLangId();
	}
	

	/*  MEMBER
	-------------------------------------------------------------------------------------------------------*/

	public function listMember($targetpage,$page,$limit,$sData=""){
	
		$select = $this->db->select()
				->from($this->tbl_member)
				->where("$this->tbl_member.parent_id",0)
				->order_by("$this->tbl_member.member_date_added",'desc')
				->group_by("$this->tbl_member.member_id");
				
		if(!empty($sData)){
			$sData = urlDecode($sData);
			$where = "(($this->tbl_member.member_first_name like '%".$sData."%') or ($this->tbl_member.member_last_name like '%".$sData."%'))";
			$this->db->where($where);
		}
		
		$this->db->get();
		$config['query'] = $this->db->last_query();
		$config['targetpage'] = $targetpage;
		$config['target'] = '#boxContent';
		$config['limit'] = $limit;
		$config['page'] = $page;
		
		$this->load->library('bfpagination', $config);
		return list($paginaion,$page_description,$result) = $this->bfpagination->select_pagination();
	}
	public function listEditMember($id){
		
		$select = $this->db->select()
				->from($this->tbl_member)
				->where("member_id",$id);		
		$query = $this->db->get();
		$result = $query->row_array();
		
		return $result;
	}
	public function addMember(){
		
		$val = $this->getValue();
		if($val['captcha']=='')
		{
			$member_id = $this->bflibs->getLastID($this->tbl_member,'member_id');
			$date = date('Y-m-d H:i:s');
			$member_publish = (isset($val['member_publish']))?$val['member_publish']:1;
			$parent_id = (isset($val['parent_id'])) ? $val['parent_id'] : 0;
			$parent_id = ($val['member_type']==0) ? $parent_id : 0;
			
			$data = array(
					"member_id"=>$member_id,
					"member_pass"=>base64_encode($val['member_password']),//md5($val['member_pass']),
					//"member_code"=>$val['member_code'],
					"member_first_name"=>$val['member_first_name'],
					"member_last_name"=>$val['member_last_name'],
					"member_email"=>$val['member_email'],
					"member_iden"=>$val['member_iden'],
					"member_birth_day"=>$val['member_birth_day'],
					"member_birth_month"=>$val['member_birth_month'],
					"member_birth_year"=>$val['member_birth_year'],
					"member_address"=>$val['member_address'],
					"member_tel"=>$val['member_tel'],
					"member_type"=>$val['member_type'],
					"member_discount"=>$val['member_discount'],
					"parent_id"=>$parent_id,
					//"member_occupation"=>$val['member_occupation'],
					//"member_income"=>$val['member_income'],
					"member_date_added"=>$date,
					"member_publish"=>$member_publish
			);
			$this->db->insert($this->tbl_member,$data);			
			return $member_id;
		}
	}
	public function editMember(){
		
		$val = $this->getValue();

		if($val['captcha']=='')
		{
			$member_id = $val["member_id"];
			$parent_id = (isset($val['parent_id'])) ? $val['parent_id'] : 0;
			$parent_id = ($val['member_type']==0) ? $parent_id : 0;
			
			$data = array(
					//"member_code"=>$val['member_code'],
					"member_first_name"=>$val['member_first_name'],
					"member_last_name"=>$val['member_last_name'],
					//"member_email"=>$val['member_email'],
					"member_iden"=>$val['member_iden'],
					"member_birth_day"=>$val['member_birth_day'],
					"member_birth_month"=>$val['member_birth_month'],
					"member_birth_year"=>$val['member_birth_year'],
					"member_address"=>$val['member_address'],
					"member_tel"=>$val['member_tel'],
					"member_type"=>$val['member_type'],
					"member_discount"=>$val['member_discount'],
					"parent_id"=>$parent_id
					//"member_occupation"=>$val['member_occupation'],
					//"member_income"=>$val['member_income']
			);
			if($val["member_newpass"]!=''){
				$data['member_pass'] = base64_encode($val["member_newpass"]);
			}

			$this->db->where('member_id',$member_id);
			$this->db->update($this->tbl_member,$data);
			return $val['member_id'];
		}
	}
	public function deleteMember($id){
		$this->db->where('member_id',$id);
		$this->db->delete($this->tbl_member);
		$this->db->where('member_id',$id);
		$this->db->delete($this->tbl_member_point);
	}
	public function listParent(){
	
		$select = $this->db->select()
				->from($this->tbl_member)
				->where("parent_id",0)
				->where("member_type",1)
				->order_by("member_first_name",'asc')
				->order_by("member_last_name",'asc');	
		$query = $this->db->get();
		$result = $query->result_array();
		
		return $result;
	}
	
	
	/*  TEAM
	-------------------------------------------------------------------------------------------------------*/

	public function listEditTeam($id){
		
		$select = $this->db->select()
				->from($this->tbl_team)
				->where("team_id",$id);		
		$query = $this->db->get();
		$result = $query->row_array();
		
		return $result;
	}
	public function countTeam($member_id){
	
		$select = $this->db->select()
				->from($this->tbl_team)
				->where("member_id",$member_id)
				->order_by("team_name",'asc');	
		$num = $this->db->count_all_results();
		
		return $num;
	}
	public function listTeam($member_id){
	
		$select = $this->db->select()
				->from($this->tbl_member)
				->where("parent_id",$member_id)
				->order_by("member_first_name",'asc')
				->order_by("member_last_name",'asc');	
		$query = $this->db->get();
		$result = $query->result_array();
		
		return $result;
	}
	public function listTeamOrder($team_id){
	
		$query = $this->db->select()
				->from($this->tbl_sp_order_item)
				->join($this->tbl_sp_order,"$this->tbl_sp_order.order_id=$this->tbl_sp_order_item.order_id","left")
				->where("$this->tbl_sp_order_item.team_id",$team_id);
		$query = $this->db->get();
		$result = $query->result_array();
		return $result;
	}
	public function addTeam(){
		
		$val = $this->getValue();
		if($val['captcha']=='')
		{
			$member_id = $this->bflibs->getLastID($this->tbl_member,'member_id');
			$date = date('Y-m-d H:i:s');
			$member_publish = (isset($val['member_publish']))?$val['member_publish']:1;
			$parent_id = (isset($val['parent_id'])) ? $val['parent_id'] : 0;
			$parent_id = ($val['member_type']==0) ? $parent_id : 0;
			
			$data = array(
					"member_id"=>$member_id,
					"member_pass"=>base64_encode($val['member_password']),
					"member_first_name"=>$val['member_first_name'],
					"member_last_name"=>$val['member_last_name'],
					"member_email"=>$val['member_email'],
					"member_iden"=>$val['member_iden'],
					"member_birth_day"=>$val['member_birth_day'],
					"member_birth_month"=>$val['member_birth_month'],
					"member_birth_year"=>$val['member_birth_year'],
					"member_address"=>$val['member_address'],
					"member_tel"=>$val['member_tel'],
					"member_type"=>0,//$val['member_type'],
					"parent_id"=>$parent_id,
					"member_date_added"=>$date,
					"member_publish"=>$member_publish
			);
			$this->db->insert($this->tbl_member,$data);			
			return $member_id;
		}
	}
	public function editTeam(){
		
		$val = $this->getValue();

		if($val['captcha']=='')
		{
			$member_id = $val["member_id"];
			$parent_id = (isset($val['parent_id'])) ? $val['parent_id'] : 0;
			$parent_id = ($val['member_type']==0) ? $parent_id : 0;
			
			$data = array(
					"member_first_name"=>$val['member_first_name'],
					"member_last_name"=>$val['member_last_name'],
					"member_iden"=>$val['member_iden'],
					"member_birth_day"=>$val['member_birth_day'],
					"member_birth_month"=>$val['member_birth_month'],
					"member_birth_year"=>$val['member_birth_year'],
					"member_address"=>$val['member_address'],
					"member_tel"=>$val['member_tel'],
					"member_discount"=>$val['member_discount'],
					"member_type"=>$val['member_type'],
					"parent_id"=>$parent_id
			);
			if($val["member_newpass"]!=''){
				$data['member_pass'] = base64_encode($val["member_newpass"]);
			}

			$this->db->where('member_id',$member_id);
			$this->db->update($this->tbl_member,$data);
			return $val['member_id'];
		}
	}
	public function listHistory($targetpage,$page,$limit,$sData="",$member_id=0){
	
		$select = $this->db->select(array("$this->tbl_sp_order.order_date","$this->tbl_sp_order.order_payment","$this->tbl_sp_order_item.*"))
				->from($this->tbl_sp_order_item)
				->join($this->tbl_sp_order,"$this->tbl_sp_order.order_id=$this->tbl_sp_order_item.order_id","left")
				->where("$this->tbl_sp_order.member_id",$member_id);
				
		if(!empty($sData)){
			$sData = urlDecode($sData);
			$where = "(($this->tbl_sp_order_item.product_name like '%".$sData."%'))";
			$this->db->where($where);
		}
		
		$this->db->get();
		$config['query'] = $this->db->last_query();
		$config['targetpage'] = $targetpage;
		$config['target'] = '#boxContent';
		$config['limit'] = $limit;
		$config['page'] = $page;
		
		$this->load->library('bfpagination', $config);
		return list($paginaion,$page_description,$result) = $this->bfpagination->do_pagination();
	}
	
	/*  POINT
	-------------------------------------------------------------------------------------------------------*/

	public function listPoint($targetpage,$page,$limit,$sData="",$member_id="",$type=1,$beg='',$end=''){
		if($type==1){
			$select = $this->db->select()
					->from($this->tbl_member_point)
					->order_by("$this->tbl_member_point.member_point_date",'desc');
					
			if(!empty($sData)){
				$sData = urlDecode($sData);
				$where = "(($this->tbl_member_point.member_point_reason like '%".$sData."%'))";
				$this->db->where($where);
			}
			if($member_id!=''&&$member_id!='0'){
				$where = $this->db->where("member_id",$member_id);
			}	
			if($beg!=''){
				$beg_date = $this->bflibs->dateToDb($beg,'date');
				$where = $this->db->where("$this->tbl_member_point.member_point_date >=",$beg_date);
			}
			if($end!=''){
				$end_date = $this->bflibs->dateToDb($end,'date');
				$where = $this->db->where("$this->tbl_member_point.member_point_date <=",$end_date.' 23:59');
			}
			
		}
		else{
			$select = $this->db->select()
					->from($this->tbl_sp_order)
					->where("member_id",$member_id)
					->where("order_point_summary !=",0)
					->order_by("order_date",'desc');
		}
		 /*else{
			$select = $this->db->query("$this->tbl_member_point.* FROM $this->tbl_member_point 
												ORDER BY $this->tbl_member_point.member_point_date DESC 
												UNION 
												$this->tbl_sp_order.* FROM $this->tbl_sp_order
												WHERE $this->tbl_sp_order.order_point_summary!='0'
												ORDER BY $this->tbl_sp_order.order_date DESC");
		}*/
		
		$this->db->get();
		$config['query'] = $this->db->last_query();
		$config['targetpage'] = $targetpage;
		$config['target'] = '#boxContent';
		$config['limit'] = $limit;
		$config['page'] = $page;
		
		$this->load->library('bfpagination', $config);
		return list($paginaion,$page_description,$result) = $this->bfpagination->select_pagination();
	}
	public function addPoint(){
		
		$val = $this->getValue();
		if($val['captcha']=='')
		{
			$member_point_id = $this->bflibs->getLastID($this->tbl_member_point,'member_point_id');
			$member_id = $val['member_id'];
			$date = date('Y-m-d H:i:s');
			$data = array(
					"member_point_id"=>$member_point_id,
					"member_id"=>$member_id,
					"member_point_type"=>$val['member_point_type'],
					"member_point_reason"=>$val['member_point_reason'],
					"member_point_val"=>$val['member_point_val'],
					"member_point_date"=>$date
			);
			$this->db->insert($this->tbl_member_point,$data);	
			
			$old_point = $this->bflibs->getMemberPoint($member_id);
			$new_point = ($val['member_point_type']==1) ? $old_point+$val['member_point_val'] : $old_point-$val['member_point_val'];
			$this->bflibs->updateMemberPoint($member_id,$new_point);
					
			return $member_point_id;
		}
	}
	public function deletePoint($id){	
		
		$select = $this->db->select()
				->from($this->tbl_member_point)
				->where("member_point_id",$id);
		$query = $this->db->get();
		$result = $query->row_array();
		
		if(!empty($result)){
			$member_id=$result['member_id'];
			$old_point = $this->bflibs->getMemberPoint($member_id);
			// ทำตรงกันข้าม เพราะเป็นการเอาออกจากฐานข้อมูล //
			$new_point = ($result['member_point_type']==1) ? $old_point-$result['member_point_val'] : $old_point+$result['member_point_val'];
			$this->bflibs->updateMemberPoint($member_id,$new_point);
		}
		
		$this->db->where('member_point_id',$id);
		$this->db->delete($this->tbl_member_point);
	}
	public function listAllPoint($limit=10){
		
		$select = $this->db->select(array("$this->tbl_member_point.*","$this->tbl_member.member_first_name","$this->tbl_member.member_last_name"))
				->from($this->tbl_member_point)
				->join($this->tbl_member,"$this->tbl_member.member_id=$this->tbl_member_point.member_id","left")
				->order_by("member_point_date",'desc')
				->limit($limit);
				
		$query = $this->db->get();
		$result = $query->result_array();
		return $result;
	}
	public function sumPoint($type=1,$beg='',$end='',$member_id=''){
		
		$select = $this->db->select(array("SUM(member_point_val) AS sum_point"))
				->from($this->tbl_member_point)
				->where("member_point_type",$type);
		if($beg!=''){
			$beg_date = $this->bflibs->dateToDb($beg,'date');
			$where = $this->db->where("$this->tbl_member_point.member_point_date >=",$beg_date);
		}
		if($end!=''){
			$end_date = $this->bflibs->dateToDb($end,'date');
			$where = $this->db->where("$this->tbl_member_point.member_point_date <=",$end_date.' 23:59');
		}
		if($member_id!=''&&$member_id!='0'){
			$where = $this->db->where("$this->tbl_member_point.member_id",$member_id);
		}
		$this->db->order_by("member_point_date",'desc');
				
		$query = $this->db->get();
		$result = $query->row_array();
		return (empty($result)) ? 0 : $result['sum_point'];
	}
	

	/*  SETTING
	-------------------------------------------------------------------------------------------------------*/

	
	public function editSetting(){
		
		$val = $this->getValue();

		if($val['captcha']=='')
		{
			//$member_occupation_id = $val["member_occupation_id"];
			$data = array(
					"main_email"=>$val['main_email']
			);

			$this->db->where('main_id',1);
			$this->db->update($this->tbl_main,$data);
		}
	}
	public function getMain(){
	
		$query = $this->db->select()
				->from($this->tbl_main)
				->where("$this->tbl_main.main_id",1);
		$query = $this->db->get();
		$result = $query->row_array();
		return $result;
	}
	
	
	/*  OTHER
	-------------------------------------------------------------------------------------------------------*/
	public function listProvince(){
		
		$select = $this->db->select(array('province_id','province_name_th'))
				->from($this->tbl_province)
				->order_by("province_name_th","asc");
		$query = $this->db->get();
		$result = $query->result_array();
		return $result;
	}
	public function listAllMember(){
		
		$select = $this->db->select(array('member_id','member_code','member_first_name','member_last_name'))
				->from($this->tbl_member)
				->order_by("member_first_name","asc")
				->order_by("member_last_name","asc");
		$query = $this->db->get();
		$result = $query->result_array();
		return $result;
	}
	
	
	/* SEND MAIL
	-----------------------------------------------------------------------------------------------------------*/
	private $websiteName = 'HAVEREWARD.COM';
	private $websiteDir = DIR_HOST;
	public function sendmail($member_id){//,$member_pass,$member_code=''){
	
		$query = $this->db->select(array("member_first_name","member_last_name","member_email"))
				->from($this->tbl_member)
				->where('member_id',$member_id);
		$query = $this->db->get();
		$result = $query->row_array();
		
		$getMain = $this->getMain();
			echo $getMain['main_email'];
		if(!empty($getMain) && $getMain['main_email']!="")
		{
			$member_name = $result['member_first_name'].' '.$result['member_last_name'];
			$to_email = $result["main_email"];
			$subject = '['.$this->websiteName.'] สมาชิกคุณ '.$member_name.' ได้สมัครสมาชิก วันที่ '.date("d/m/Y H:i").' น.';
			
			$str='ข้อมูลสมาชิกที่ทำการสมัครสมาชิก
			<br/><strong>ชื่อ - นามสกุล</strong> :  '.$member_name.'
			<br/><strong>เบอร์โทรศัพท์</strong> :  '.$member_name.'
			<br/><strong>ชื่อผู้ใช้</strong> :  '.$result['member_email'].'
			<br/><strong>รหัสผ่าน</strong> :  '.base64_decode($result['member_pass']).'
			<br/><br/>ต้องการแก้ไขข้อมูลอื่นๆ <a href="http://www.havereward.com/member/backend/edit_member/id/'.$member_id.'" target="_blank">คลิกที่นี่</a>';
			echo $str;
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
	public function sendmail_code($member_id,$member_code=''){
	
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
			$str='สวัสดีค่ะ ตามที่คุณได้สมัครสมาชิกกับเว็บไซต์ '.$this->websiteName.' ไว้ ทางร้านได้อัพเดตข้อมูลให้คุณค่ะ <br>';
			
				if($member_code!='') $str.='<br>รหัสสมาชิก คือ '.$member_code.'<br><br>';
				
			$str.='ขอขอบคุณที่ให้ความไว้วางใจค่ะ <br><br>';
			
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
}
?>