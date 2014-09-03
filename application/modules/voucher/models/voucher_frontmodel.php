<?php
class Voucher_frontmodel extends CI_Model {
	private $tbl_admin_cfg = 'admin_cfg';
	private $tbl_voucher = 'voucher';
	private $tbl_member = 'member';
	private $tbl_member_point = 'member_point';
	
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
	


	
	
	
	/*  VOUCHER
	-------------------------------------------------------------------------------------------------------*/

	public function addPoint($member_id){
		
		$val = $this->getValue();
		if($val['captcha']=='')
		{
			
			$select = $this->db->select()
					->from($this->tbl_voucher)
					->where("voucher_tel",$val['voucher_tel'])
					->where("voucher_no",$val['voucher_no'])
					->where("voucher_status",1);
			$query = $this->db->get();
			$result = $query->row_array();
			
			$member_point_id='';
			
			if(!empty($result)){
				$member_point_id = $this->bflibs->getLastID($this->tbl_member_point,'member_point_id');
				$date = date('Y-m-d H:i:s');
				$data = array(
						"member_point_id"=>$member_point_id,
						"member_id"=>$member_id,
						"member_point_type"=>1,
						"member_point_reason"=>"ได้รับแต้มจาก Voucher",
						"member_point_val"=>$result['voucher_point'],
						"member_point_date"=>$date
				);
				$this->db->insert($this->tbl_member_point,$data);	
				
				$old_point = $this->bflibs->getMemberPoint($member_id);
				$new_point = $old_point+$result['voucher_point'];
				$this->bflibs->updateMemberPoint($member_id,$new_point);
				
				$data = array(
						"voucher_status"=>0
				);
				
				$this->db->where("voucher_tel",$val['voucher_tel']);
				$this->db->where("voucher_no",$val['voucher_no']);
				$this->db->update($this->tbl_voucher,$data);
				
			}
					
			return $member_point_id;
		}
	}
}