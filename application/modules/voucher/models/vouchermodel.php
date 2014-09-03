<?php
class Vouchermodel extends CI_Model {
	private $tbl_admin_cfg = 'admin_cfg';
	private $tbl_voucher = 'voucher';
	private $tbl_member = 'member';
	
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

	public function listVoucher(){
	
		$select = $this->db->select()
				->from($this->tbl_voucher)
				->order_by("voucher_id",'desc');
		$query = $this->db->get();
		$result = $query->result_array();
		
		return $result;
	}
	public function addVoucher(){
		
		$val = $this->getValue();
		if($val['captcha']=='')
		{
			$voucher_id = $this->bflibs->getLastID($this->tbl_voucher,'voucher_id');
			
			$data = array("voucher_id"=>$voucher_id,
					"voucher_no"=>$val['voucher_no'],
					"voucher_tel"=>$val['voucher_tel'],
					"voucher_point"=>$val['voucher_point'],
					"voucher_status"=>1
			);
			$this->db->insert($this->tbl_voucher,$data);
			
			return $voucher_id;
		}
	}
	public function editVoucher(){
		
		$val = $this->getValue();
		if($val['captcha']=='')
		{
			$voucher_id = $val['voucher_id'];
			
			$data = array(
					"categories_id"=>$val['categories_id'],
					"voucher_name"=>$val['voucher_name'],
					"voucher_discount"=>$val['voucher_discount'],
			);
			
			$this->db->where('voucher_id',$voucher_id);
			$this->db->update($this->tbl_voucher,$data);
		}
	}
	public function listEditVoucher($id){
		
		$select = $this->db->select()
				->from($this->tbl_voucher)
				->where('voucher_id',$id);
		$query = $this->db->get();
		$result = $query->row_array();
		
		return $result;
	}
	public function deleteVoucher($id)
	{
		$this->db->where('voucher_id',$id);
		$this->db->delete($this->tbl_voucher);
	}
}