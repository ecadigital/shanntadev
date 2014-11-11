<?php
class Collection_frontmodel extends CI_Model {
	private $tbl_admin_cfg = 'admin_cfg';
	private $tbl_collection = 'collection';
	private $tbl_collection_lang = 'collection_lang';
	private $tbl_collection_images = 'collection_images';
	private $tbl_collection_categories = 'collection_categories';
	private $tbl_collection_categories_lang = 'collection_categories_lang';
	private $tbl_collection_promotion = 'collection_promotion';
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

	public function listCollection($lang_id,$collection_categories_id=''){
		
		$select = $this->db->select(array("collection.collection_id",
										"collection.collection_price",
										"collection_lang.collection_name",
										"collection_lang.collection_detail"))
				->from($this->tbl_collection_lang)
				->join($this->tbl_collection,"$this->tbl_collection.collection_id=$this->tbl_collection_lang.collection_id","left")
				->where("$this->tbl_collection_lang.language_id",$lang_id);
		if($collection_categories_id!=''){
			$this->db->where("$this->tbl_collection.collection_categories_id",$collection_categories_id);
		}
		$this->db->order_by("$this->tbl_collection.collection_seq","DESC");
		$query = $this->db->get();
		$result = $query->result_array();
		
		return $result;
	}
	
	public function listCollectionImages($collection_id){
		
		$select = $this->db->select()
				->from($this->tbl_collection_images)
				->where("collection_id",$collection_id);
		$this->db->order_by("collection_images_seq","ASC");
		$query = $this->db->get();
		$result = $query->result_array();
		
		return $result;
	}
	public function getFirstCollectionImage($collection_id){
		
		$select = $this->db	->select(array("collection_images_id","collection_images_path"))
									->from($this->tbl_collection_images)
									->where("collection_id",$collection_id)
									->order_by("collection_images_seq","asc");
		$query = $this->db->get();
		$query_images = $query->row_array();
		$result['collection_images'] = (empty($query_images)) ? '' : $query_images['collection_images_path'];
		return $result['collection_images'];
	}

	public function getCollection($lang_id,$collection_id){
		
		$select = $this->db->select(array("$this->tbl_collection.collection_id",
										"$this->tbl_collection.collection_price",
										"$this->tbl_collection_lang.collection_name",
										"$this->tbl_collection_lang.collection_detail"))
				->from($this->tbl_collection_lang)
				->join($this->tbl_collection,"$this->tbl_collection.collection_id=$this->tbl_collection_lang.collection_id","left")
				->where("$this->tbl_collection_lang.language_id",$lang_id)
				->where("$this->tbl_collection.collection_id",$collection_id)
				->limit(1);
		$query = $this->db->get();
		$result = $query->row_array();
		
		return $result;
	}
	
	public function listAllCategories($lang_id){
		
		$select = $this->db->select(array("$this->tbl_collection_categories.collection_categories_id",
											"$this->tbl_collection_categories_lang.collection_categories_banner_path"))
				->from($this->tbl_collection_categories)
				->join($this->tbl_collection_categories_lang,"$this->tbl_collection_categories_lang.collection_categories_id=$this->tbl_collection_categories.collection_categories_id","left")
				->where("$this->tbl_collection_categories.collection_categories_publish",1)
				->where("$this->tbl_collection_categories_lang.language_id",$lang_id)
				->order_by("$this->tbl_collection_categories.collection_categories_seq",'asc');		
		$query = $this->db->get();
		$result = $query->result_array();
		
		return $result;
	}
	public function getFirstCategories($lang_id){
		
		$select = $this->db->select(array("$this->tbl_collection_categories.collection_categories_id",
											"$this->tbl_collection_categories_lang.collection_categories_home_keyhead",
											"$this->tbl_collection_categories_lang.collection_categories_home_keymessage",
											"$this->tbl_collection_categories.collection_categories_home_path"))
				->from($this->tbl_collection_categories)
				->join($this->tbl_collection_categories_lang,"$this->tbl_collection_categories_lang.collection_categories_id=$this->tbl_collection_categories.collection_categories_id","left")
				->where("$this->tbl_collection_categories.collection_categories_publish",1)
				->where("$this->tbl_collection_categories_lang.language_id",$lang_id)
				->order_by("$this->tbl_collection_categories.collection_categories_seq",'asc')
				->limit(1);
		$query = $this->db->get();
		$result = $query->row_array();
		
		return $result;
	}
	public function getCategories($lang_id,$collection_categories_id){
		
		$select = $this->db->select(array("collection_categories.collection_categories_id",
										"collection_categories_lang.collection_categories_banner_path"))
				->from($this->tbl_collection_categories_lang)
				->join($this->tbl_collection_categories,"$this->tbl_collection_categories.collection_categories_id=$this->tbl_collection_categories_lang.collection_categories_id","left")
				->where("$this->tbl_collection_categories_lang.language_id",$lang_id)
				->where("$this->tbl_collection_categories.collection_categories_id",$collection_categories_id)
				->limit(1);
		$query = $this->db->get();
		$result = $query->row_array();
		
		return $result;
	}
}
?>