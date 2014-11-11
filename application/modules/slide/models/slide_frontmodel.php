<?php
class Slide_frontmodel extends CI_Model {
	private $tbl_admin_cfg = 'admin_cfg';
	private $tbl_slide = 'slide';
	private $tbl_slide_lang = 'slide_lang';
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
	

	/*  PRODUCT
	-------------------------------------------------------------------------------------------------------*/

	public function listSlide($lang_id){
		
		$select = $this->db->select(array("$this->tbl_slide.slide_id",
										"$this->tbl_slide.slide_image",
										"$this->tbl_slide.slide_position",
										"$this->tbl_slide_lang.slide_keyhead",
										"$this->tbl_slide_lang.slide_keymessage"))
				->from($this->tbl_slide_lang)
				->join($this->tbl_slide,"$this->tbl_slide.slide_id=$this->tbl_slide_lang.slide_id","left")
				->where("$this->tbl_slide_lang.language_id",$lang_id);
		$query = $this->db->get();
		$result = $query->result_array();
		
		return $result;
	}
}
?>