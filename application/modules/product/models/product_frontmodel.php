<?php
class Product_frontmodel extends CI_Model {
	private $tbl_admin_cfg = 'admin_cfg';
	private $tbl_product = 'product';
	private $tbl_product_lang = 'product_lang';
	private $tbl_product_images = 'product_images';
	private $tbl_product_categories = 'product_categories';
	private $tbl_product_categories_lang = 'product_categories_lang';
	private $tbl_product_promotion = 'product_promotion';
	private $tbl_member = 'member';
	
	private $tbl_sp_order = 'sp_order';
	private $tbl_sp_order_item = 'sp_order_item';
	private $tbl_sp_order_status = 'sp_order_status';
	
	private $listCategoriesParent=array();
	private $listCategories=array();
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
	

	/*  PRODUCT
	-------------------------------------------------------------------------------------------------------*/

	public function listProduct($lang_id,$product_categories_id=''){
		
		$select = $this->db->select(array("product.product_id",
										"product.product_price",
										"product_lang.product_name",
										"product_lang.product_detail"))
				->from($this->tbl_product_lang)
				->join($this->tbl_product,"$this->tbl_product.product_id=$this->tbl_product_lang.product_id","left")
				->where("$this->tbl_product_lang.language_id",$lang_id);
		if($product_categories_id!=''){
			$this->db->where("$this->tbl_product.product_categories_id",$product_categories_id);
		}
		$this->db->order_by("$this->tbl_product.product_seq","DESC");
		$query = $this->db->get();
		$result = $query->result_array();
		
		return $result;
	}
	
	public function listProductImages($product_id){
		
		$select = $this->db->select()
				->from($this->tbl_product_images)
				->where("product_id",$product_id);
		$this->db->order_by("product_images_seq","ASC");
		$query = $this->db->get();
		$result = $query->result_array();
		
		return $result;
	}
	public function getFirstProductImage($product_id){
		
		$select = $this->db	->select(array("product_images_id","product_images_path"))
									->from($this->tbl_product_images)
									->where("product_id",$product_id)
									->order_by("product_images_seq","asc");
		$query = $this->db->get();
		$query_images = $query->row_array();
		$result['product_images'] = (empty($query_images)) ? '' : $query_images['product_images_path'];
		return $result['product_images'];
	}

	
	
	public function listCategories($lang_id){
		
		$select = $this->db->select(array("product_categories.product_categories_id",
										"product_categories.product_categories_home_path",
										"product_categories.product_categories_home_position",
										"product_categories_lang.product_categories_name",
										"product_categories_lang.product_categories_home_keyhead",
										"product_categories_lang.product_categories_home_keymessage"))
				->from($this->tbl_product_categories_lang)
				->join($this->tbl_product_categories,"$this->tbl_product_categories.product_categories_id=$this->tbl_product_categories_lang.product_categories_id","left")
				->where("$this->tbl_product_categories_lang.language_id",$lang_id);
		$this->db->order_by("$this->tbl_product_categories.product_categories_seq","ASC");
		$query = $this->db->get();
		$result = $query->result_array();
		
		return $result;
	}
	public function getCategories($lang_id,$product_categories_id){
		
		$select = $this->db->select(array("product_categories.product_categories_id",
										"product_categories.product_categories_banner_path",
										"product_categories.product_categories_banner_position",
										"product_categories_lang.product_categories_name",
										"product_categories_lang.product_categories_banner_keyhead",
										"product_categories_lang.product_categories_banner_keymessage"))
				->from($this->tbl_product_categories_lang)
				->join($this->tbl_product_categories,"$this->tbl_product_categories.product_categories_id=$this->tbl_product_categories_lang.product_categories_id","left")
				->where("$this->tbl_product_categories_lang.language_id",$lang_id)
				->where("$this->tbl_product_categories.product_categories_id",$product_categories_id)
				->limit(1);
		$query = $this->db->get();
		$result = $query->row_array();
		
		return $result;
	}
}
?>