<?php
class Contactusmodel extends CI_Model {
	private $tbl_contactus = 'contactus';
	private $tbl_contactus_detail = 'contactus_detail';
	private $tbl_main = 'main';
	
	private $defaultlang;
	
	public function setValue($val){
		$this->value = $val;
	}
	
	private function getValue(){
		return $this->value;
	}
	
	public function __construct(){
	
        parent::__construct();
        $admin = $this->session->userdata('admin');
		@$this->admin_id = $admin->admin_id;
		$this->ip = $this->bflibs->getIP();
		$this->defaultlang = $this->bflibs->getDefaultLangId();
	}
	

	/*  CONTACTUS
	-------------------------------------------------------------------------------------------------------*/

	public function listContact($targetpage,$page,$limit,$sData=""){
	
		$select = $this->db->select()
				->from($this->tbl_contactus)
				->order_by("contactus_date",'desc');
				
		if(!empty($sData)){
			$sData = urlDecode($sData);
			$where = "((contactus_name like '%".$sData."%') OR (contactus_detail like '%".$sData."%'))";
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
	
	public function addContact(){
	
		$val = $this->getValue();
		$contactus_id = $this->bflibs->getLastID($this->tbl_contactus,'contactus_id');
		$date = date('Y-m-d H:i:s');

		$data = array(
				"contactus_id"=>$contact_id,
				"contactus_name"=>$val['c_name'],
				"contactus_email"=>$val['c_email'],
				"contactus_tel"=>$val['c_phone'],
				"contactus_topic"=>"",
				"contactus_detail"=>$val['c_message'],
				"contactus_date"=>$date
		);
		$this->db->insert($this->tbl_contactus,$data);
		return $contactus_id;
	}
	public function deleteContact($id){
		$this->db->where('contactus_id',$id);
		$this->db->delete($this->tbl_contactus);
	}
	public function getMain(){
	
		$query = $this->db->select()
				->from($this->tbl_main)
				->where("$this->tbl_main.main_id",1);
		$query = $this->db->get();
		$result = $query->row_array();
		return $result;
	}
	
	
	/* SEND MAIL
	-----------------------------------------------------------------------------------------------------------*/
	private $websiteName = 'SHANNTA';
	private $websiteDir = DIR_HOST;
	
	public function sendmail()
	{	
		$val = $this->getValue();
		$getMain = $this->getMain();		
					
		if(!empty($getMain) && $getMain['main_email']!="")
		{
			$to_email = 'jiwakoo@gmail.com';//$getMain['main_email'];
			$subject = '['.$this->websiteName.'] ติดต่อเรา';
			$name = $result['contact_name'];
			$str='สวัสดีค่ะ E-mail นี้ส่งจากระบบอัตโนมัติของ '.$this->websiteName.'<br><br>ข้อมูลที่ลูกค้าส่งมาให้ มีดังนี้<br><br>

				    ชื่อ : '.$val['c_name'].'<br>
				    อีเมล์ : '.$val['c_email'].'<br>
				    เบอร์โทรศัพท์ : '.$val['c_phone'].'<br>
				    ข้อความ : '.$val['c_message'].'<br><br>';
					
			//ขอขอบคุณที่ให้ความไว้วางใจค่ะ <br><br>';
			
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