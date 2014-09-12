<?php
class Productmodel extends CI_Model {
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
		$Array_ip = explode('.',$this->bflibs->getIP());
		$this->ip = implode('_',$Array_ip);
		$this->defaultlang = $this->bflibs->getDefaultLangId();
	}
	

	/*  PRODUCT
	-------------------------------------------------------------------------------------------------------*/

	public function listProduct($targetpage,$page,$limit,$sData="",$type="",$cat=""){
		$select = $this->db->select(array(
						"$this->tbl_product.product_id",
						"$this->tbl_product.product_categories_id",
						"$this->tbl_product.product_price",
						"$this->tbl_product.product_discount",
						"$this->tbl_product.product_rec",
						"$this->tbl_product.product_hot",
						"$this->tbl_product.product_last_modified",
						"$this->tbl_product.product_publish",
						"$this->tbl_product.product_seq",
						"$this->tbl_product_lang.product_name",
						"$this->tbl_product_lang.product_detail",
						"$this->tbl_product_categories_lang.product_categories_name"))
				->from($this->tbl_product)
				->join($this->tbl_product_lang,"$this->tbl_product.product_id=$this->tbl_product_lang.product_id","left")
				->join($this->tbl_product_categories_lang,"$this->tbl_product.product_categories_id=$this->tbl_product_categories_lang.product_categories_id","left")
				->where("$this->tbl_product_lang.language_id",$this->defaultlang)
				->where("$this->tbl_product_categories_lang.language_id",$this->defaultlang)
				->group_by("$this->tbl_product.product_id");
				
		if(!empty($sData)){
			$sData = urlDecode($sData);
			$where = "(($this->tbl_product_lang.product_name like '%".$sData."%') or ($this->tbl_product_lang.product_detail like '%".$sData."%') or ($this->tbl_product_categories_lang.product_categories_name like '%".$sData."%'))";
			$this->db->where($where);
		}

		if($type==''){
			$this->db->order_by("$this->tbl_product.product_pin",'desc');
			$this->db->order_by("$this->tbl_product.product_seq",'desc');
			//$this->db->order_by("$this->tbl_product.product_date_added",'desc');
		}else{
			if($type=='-'){
				$this->db->order_by("$this->tbl_product.product_seq",'desc');
				//$this->db->order_by("$this->tbl_product.product_date_added",'desc');
			}
			else if($type=='hot'){
				$this->db->order_by("$this->tbl_product.product_seq",'desc');
				//$this->db->order_by("$this->tbl_product.product_date_added",'desc');
				$this->db->where("$this->tbl_product.product_hot",1);
			}
			else if($type=='rec'){
				$this->db->order_by("$this->tbl_product.product_seq",'desc');
				//$this->db->order_by("$this->tbl_product.product_date_added",'desc');
				$this->db->where("$this->tbl_product.product_rec",1);
			}
			else if($type=='pro'){
				$this->db->order_by("$this->tbl_product.product_seq",'desc');
				//$this->db->order_by("$this->tbl_product.product_date_added",'desc');
				$this->db->where("$this->tbl_product.product_pro",1);
			}
			else if($type=='sale'){
				$this->db->order_by("$this->tbl_product.product_seq",'desc');
				//$this->db->order_by("$this->tbl_product.product_date_added",'desc');
				$this->db->where("$this->tbl_product.product_sale",1);
			}
			else{
				$this->db->order_by("$this->tbl_product.product_seq",'desc');
			}
		}
		if($cat!=''){
			$this->db->where("$this->tbl_product.product_categories_id",$cat);
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
	public function listEditProduct($id,$member_id=''){
		
		$select = $this->db->select()
				->from($this->tbl_product)
				->where("product_id",$id);		
		$query = $this->db->get();
		$result = $query->row_array();
		
		if(!empty($result)){
			$select = $this->db	->select(array("product_images_id","product_images_path"))
										->from($this->tbl_product_images)
										->where("product_id",$id)
										->order_by("product_images_seq","asc");
			$query_images = $this->db->get();
			$result['product_images'] = $query_images->result_array();
		}
		
		$select = $this->db->select()
				->from($this->tbl_product_lang)
				->where("product_id",$id);
		$queryLang = $this->db->get();
		$resultLang = $queryLang->result_array();
		
		foreach($resultLang as $res){
			$result['product_name'][$res['language_id']] = $res['product_name'];
			$result['product_detail'][$res['language_id']] = $res['product_detail'];
		}
		return $result;
	}
	public function addProduct(){
		
		$val = $this->getValue();
		if($val['captcha']=='')
		{
			$product_id = $this->bflibs->getLastID($this->tbl_product,'product_id');
			$product_seq = $this->bflibs->getLastID($this->tbl_product,'product_seq');
			$date = date('Y-m-d H:i:s');
			
			list($discount,$dis_type) = $this->bflibs->getDiscount($val['product_discount']);
			
			$data = array(
					"product_id"=>$product_id,
					"product_categories_id"=>$val['product_categories_id'],
					//"product_name"=>$val['product_name'],
					//"product_short_detail"=>$val['product_short_detail'],
					//"product_detail"=>$val['product_detail'],
					"product_price"=>$this->bflibs->cutNumberSeparate($val['product_price']),
					"product_discount"=>($dis_type==1) ? $val['product_discount'] : $this->bflibs->cutNumberSeparate($discount),
					"product_newprice"=>$this->bflibs->cutNumberSeparate($val['product_newprice']),
					"product_date_added"=>$date,
					"product_last_modified"=>$date,
					"product_publish"=>1,
					"product_seq"=>$product_seq
			);
			$this->db->insert($this->tbl_product,$data);
			
			foreach($val['product_name'] as $lang=>$product_name){
				$dataLang = array(
					"product_id"=>$product_id,
					"language_id"=>$lang,
					"product_name"=>$product_name,
					//"product_short_detail"=>htmlspecialchars($val['product_short_detail'][$lang], ENT_QUOTES),
					"product_detail"=>htmlspecialchars($val['product_detail'][$lang], ENT_QUOTES)
				);
				$this->db->insert($this->tbl_product_lang,$dataLang);
			}
			
			return $product_id;
		}
	}
	public function editProduct(){
		
		$val = $this->getValue();

		if($val['captcha']=='')
		{
			$product_id = $val["product_id"];
			$date = date('Y-m-d H:i:s');
			$product_publish = (isset($val['product_publish']))?$val['product_publish']:0;
			$product_pin = (isset($val['product_pin']))?$val['product_pin']:0;
			$data = array(
					"product_categories_id"=>$val['product_categories_id'],
					//"product_name"=>$val['product_name'],
					//"product_short_detail"=>$val['product_short_detail'],
					//"product_detail"=>$val['product_detail'],
					"product_price"=>$this->bflibs->cutNumberSeparate($val['product_price']),
					"product_discount"=>($dis_type==1) ? $val['product_discount'] : $this->bflibs->cutNumberSeparate($discount),
					"product_newprice"=>$this->bflibs->cutNumberSeparate($val['product_newprice']),
					"product_last_modified"=>$date
			);

			$this->db->where('product_id',$product_id);
			$this->db->update($this->tbl_product,$data);
			
			foreach($val['product_name'] as $lang=>$product_name){
				$dataLang = array(
					"product_name"=>$product_name,
					"product_detail"=>htmlspecialchars($val['product_detail'][$lang], ENT_QUOTES)
				);
				
				$chkLang = $this->chkLang($val["product_id"],$lang);
				if($chkLang==0){
					$dataLang["product_id"]=$val["product_id"];
					$dataLang["language_id"]=$lang;
					$this->db->insert($this->tbl_product_lang,$dataLang);
				}else{
					$this->db->where("product_id",$val["product_id"]);
					$this->db->where("language_id",$lang);
					$this->db->update($this->tbl_product_lang,$dataLang);
				}
			}
			return $val['product_id'];
		}
	}
	public function deleteProduct($id){
		
		$select = $this->db->select()
				->from($this->tbl_product_images);
		if($member_id!=''){
			$this->db	->join($this->tbl_product,"$this->tbl_product.product_id=$this->tbl_product_images.product_id","left")
							->where("$this->tbl_product.member_id",$member_id);
		}
		$this->db->where("$this->tbl_product_images.product_id",$id);
		$query = $this->db->get();
		$result = $query->result_array();

		if(!empty($result)){
			foreach($result as $res){
				if($res['product_images_path'] != ''){
					$file_name = basename($res['product_images_path']);
					$path_thumb = 'public/upload/product/thumbnails/'.$file_name;
					$path_origin = 'public/upload/product/original/'.$file_name;
					
					$file_thumb = DIR_FILE.$path_thumb;
					$file_origin = DIR_FILE.$path_origin;
					
					if(file_exists($file_thumb)){
						unlink($file_thumb);
					}
					if(file_exists($file_origin)){
						unlink($file_origin);
					}
				}
			}
		}
		$this->db->where('product_id',$id);
		$this->db->delete($this->tbl_product);
		$this->db->where('product_id',$id);
		$this->db->delete($this->tbl_product_lang);
		$this->db->where('product_id',$id);
		$this->db->delete($this->tbl_product_images);
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
	
	public function chkLang($product_id,$lang_id){ 
		$select = $this->db->select()
				->from($this->tbl_product_lang)
				->where("product_id",$product_id)
				->where("language_id",$lang_id);

		return $this->db->count_all_results();
	}
	
	
	/*  CATEGORIES
	-------------------------------------------------------------------------------------------------------*/

	public function listCategories($parent_id, $space){
	
		$select = $this->db->select(array(
												"$this->tbl_product_categories.product_categories_id",
												"$this->tbl_product_categories.product_categories_parent_id",
												"$this->tbl_product_categories.product_categories_home_path",
												"$this->tbl_product_categories.product_categories_banner_path",
												"$this->tbl_product_categories.product_categories_publish",
												"$this->tbl_product_categories.product_categories_seq",
												"$this->tbl_product_categories_lang.product_categories_name"))
				->from($this->tbl_product_categories)
				->join($this->tbl_product_categories_lang,"$this->tbl_product_categories.product_categories_id=$this->tbl_product_categories_lang.product_categories_id","left")
				->where("$this->tbl_product_categories_lang.language_id",$this->defaultlang)
				->where("$this->tbl_product_categories.product_categories_parent_id",$parent_id)
				->order_by("$this->tbl_product_categories.product_categories_seq",'asc');
		$query = $this->db->get();
		$result = $query->result_array();
		if(!empty($result)){
			foreach($result as $res){
				
				$res['product_categories_name'] = $this->mkSpace($space).$res['product_categories_name'];
				$this->listCategories[] = $res;
				$this->listCategories($res['product_categories_id'], $space+4);
			}
		}
		return $this->listCategories;
	}
	public function listCategoriesParent($parent_id, $space, $id=''){
	
		$select = $this->db->select(array(
												"$this->tbl_product_categories.product_categories_id",
												"$this->tbl_product_categories_lang.product_categories_name"))
				->from($this->tbl_product_categories)
				->join($this->tbl_product_categories_lang,"$this->tbl_product_categories.product_categories_id=$this->tbl_product_categories_lang.product_categories_id","left")
				->where("$this->tbl_product_categories.product_categories_publish",1)
				->where("$this->tbl_product_categories.product_categories_parent_id",$parent_id)
				->where("$this->tbl_product_categories_lang.language_id",$this->defaultlang)
				->order_by("$this->tbl_product_categories.product_categories_seq",'asc');
		if($id != ''){
			$this->db->where("$this->tbl_product_categories.product_categories_id !=",$id);
		}
		$query = $this->db->get();
		$result = $query->result_array();
		if(!empty($result)){
			foreach($result as $res){
				
				$this->listCategoriesParent[] = array('product_categories_id'=>$res['product_categories_id'],'product_categories_name'=>$this->mkSpace($space).$res['product_categories_name']);
				$this->listCategoriesParent($res['product_categories_id'], $space+2, $id);
			}
		}
		return $this->listCategoriesParent;
	}
	public function mkSpace($space){
	
		$str = "";
		if($space > 0){
			for($i = 0;$i < $space; $i++){
				$str .="&nbsp;";
			}
			$str .="| -- ";
		}
		return $str;
	}
	public function listEditCategories($id){
		
		$select = $this->db->select()
				->from($this->tbl_product_categories)
				->where('product_categories_id',$id);
		$query = $this->db->get();
		$result = $query->row_array();
		
		$select = $this->db->select()
				->from($this->tbl_product_categories_lang)
				->where("product_categories_id",$id);
		$queryLang = $this->db->get();
		$resultLang = $queryLang->result_array();
		
		foreach($resultLang as $res){
			$result['product_categories_name'][$res['language_id']] 				= $res['product_categories_name'];
			$result['product_categories_home_keyhead'][$res['language_id']] 		= $res['product_categories_home_keyhead'];
			$result['product_categories_home_keymessage'][$res['language_id']] 		= $res['product_categories_home_keymessage'];
			$result['product_categories_banner_keyhead'][$res['language_id']] 		= $res['product_categories_banner_keyhead'];
			$result['product_categories_banner_keymessage'][$res['language_id']] 	= $res['product_categories_banner_keymessage'];
		}
		return $result;
	}
	public function addCategories(){
		
		$val = $this->getValue();
		if($val['captcha']=='')
		{
			$product_categories_id = $this->bflibs->getLastID($this->tbl_product_categories,'product_categories_id');
			$product_categories_seq = $this->bflibs->getLastID($this->tbl_product_categories,'product_categories_seq');
			$data = array("product_categories_id"=>$product_categories_id,
					"product_categories_parent_id"=>(isset($val['product_categories_parent_id'])) ? $val['product_categories_parent_id'] : 0,
					//"product_categories_name"=>$val['product_categories_name'],
					//"product_categories_home_keyhead"=>$val['product_categories_home_keyhead'],
					//"product_categories_home_keymessage"=>$val['product_categories_home_keymessage'],
					"product_categories_home_position"=>$val['product_categories_home_position'],
					//"product_categories_banner_keyhead"=>$val['product_categories_banner_keyhead'],
					//"product_categories_banner_keymessage"=>$val['product_categories_banner_keymessage'],
					"product_categories_banner_position"=>$val['product_categories_banner_position'],
					"product_categories_publish"=>1,
					"product_categories_seq"=>$product_categories_seq
			);
			$this->db->insert($this->tbl_product_categories,$data);
			
			foreach($val['product_categories_name'] as $lang=>$product_categories_name){
				$dataLang = array(
					"product_categories_id"=>$product_categories_id,
					"language_id"=>$lang,
					"product_categories_name"=>$product_categories_name,
					"product_categories_home_keyhead"=>$val['product_categories_home_keyhead'][$lang],
					"product_categories_home_keymessage"=>htmlspecialchars($val['product_categories_home_keymessage'][$lang], ENT_QUOTES),
					"product_categories_banner_keyhead"=>$val['product_categories_banner_keyhead'][$lang],
					"product_categories_banner_keymessage"=>htmlspecialchars($val['product_categories_banner_keymessage'][$lang], ENT_QUOTES)
				);
				$this->db->insert($this->tbl_product_categories_lang,$dataLang);
			}
			return $product_categories_id;
		}
	}
	public function editCategories(){
		
		$val = $this->getValue();
		if($val['captcha']=='')
		{
			$product_categories_id = $val['product_categories_id'];
			$data = array(
					"product_categories_parent_id"=>(isset($val['product_categories_parent_id'])) ? $val['product_categories_parent_id'] : 0,
					//"product_categories_name"=>$val['product_categories_name'],
					//"product_categories_home_keyhead"=>$val['product_categories_home_keyhead'],
					//"product_categories_home_keymessage"=>$val['product_categories_home_keymessage'],
					"product_categories_home_position"=>$val['product_categories_home_position'],
					//"product_categories_banner_keyhead"=>$val['product_categories_banner_keyhead'],
					//"product_categories_banner_keymessage"=>$val['product_categories_banner_keymessage'],
					"product_categories_banner_position"=>$val['product_categories_banner_position']
			);
			
			$this->db->where('product_categories_id',$product_categories_id);
			$this->db->update($this->tbl_product_categories,$data);
			
			foreach($val['product_categories_name'] as $lang=>$product_categories_name){
				$dataLang = array(
					"product_categories_name"=>$product_categories_name,
					"product_categories_home_keyhead"=>$val['product_categories_home_keyhead'][$lang],
					"product_categories_home_keymessage"=>htmlspecialchars($val['product_categories_home_keymessage'][$lang], ENT_QUOTES),
					"product_categories_banner_keyhead"=>$val['product_categories_banner_keyhead'][$lang],
					"product_categories_banner_keymessage"=>htmlspecialchars($val['product_categories_banner_keymessage'][$lang], ENT_QUOTES)
				);
				
				$chkLang = $this->chkLangCategories($product_categories_id,$lang);
				if($chkLang==0){
					$dataLang["product_categories_id"]=$product_categories_id;
					$dataLang["language_id"]=$lang;
					$this->db->insert($this->tbl_product_categories_lang,$dataLang);
				}else{
					$this->db->where("product_categories_id",$product_categories_id);
					$this->db->where("language_id",$lang);
					$this->db->update($this->tbl_product_categories_lang,$dataLang);
				}
			}
			return $product_categories_id;
		}
	}
	public function chkLangCategories($product_categories_id,$lang_id){ 
		$select = $this->db->select()
				->from($this->tbl_product_categories_lang)
				->where("product_categories_id",$product_categories_id)
				->where("language_id",$lang_id);

		return $this->db->count_all_results();
	}
	public function deleteCategories($id){
	
		$select = $this->db->select()
				->from($this->tbl_product_categories);
		$this->db->where("product_categories_id",$id);
		$query = $this->db->get();
		$res = $query->row_array();

		if(!empty($res)){
			if($res['product_categories_home_path'] != ''){
				$file_name = basename($res['product_categories_home_path']);
				
				$path_thumb = 'public/upload/product/thumbnails/'.$file_name;
				$file_thumb = DIR_FILE.$path_thumb;
				if(file_exists($file_thumb)){
					unlink($file_thumb);
				}
				$path_ori = 'public/upload/product/original/'.$file_name;
				$file_ori = DIR_FILE.$path_ori;				
				if(file_exists($file_ori)){
					unlink($file_ori);
				}
			}
			if($res['product_categories_banner_path'] != ''){
				$file_name = basename($res['product_categories_banner_path']);
				
				$path_thumb = 'public/upload/product/thumbnails/'.$file_name;
				$file_thumb = DIR_FILE.$path_thumb;
				if(file_exists($file_thumb)){
					unlink($file_thumb);
				}
				$path_ori = 'public/upload/product/original/'.$file_name;
				$file_ori = DIR_FILE.$path_ori;				
				if(file_exists($file_ori)){
					unlink($file_ori);
				}
			}
		}
		$this->db->where('product_categories_id',$id);
		$this->db->delete($this->tbl_product_categories);
		$this->db->where('product_categories_id',$id);
		$this->db->delete($this->tbl_product_categories_lang);
	}
	public function chkHasData($categories_id){
	
		$select = $this->db->select("product_id")
				->from($this->tbl_product)
				->where('product_categories_id',$categories_id);
		$query = $this->db->get();
		$result = $query->result_array();
		if(empty($result)){
			return 'false'; // ไม่มีสินค้าในหมวดหมู่นี้แล้ว
		}else{
			return 'true';
		}
	}

	
	/*  PROMOTION
	-------------------------------------------------------------------------------------------------------*/

	public function listAllProduct(){
	
		$select = $this->db->select()
				->from($this->tbl_product)
				->order_by("product_name",'asc');
		$query = $this->db->get();
		$result = $query->result_array();
		return $result;
	}
	public function listPromotion($targetpage,$page,$limit,$sData="",$categories_id="",$pin=""){
	
		$select = $this->db->select(array("$this->tbl_product_promotion.*","$this->tbl_product.product_name","$this->tbl_product_categories.product_categories_name"))
				->from($this->tbl_product_promotion)
				->join($this->tbl_product,"$this->tbl_product.product_id=$this->tbl_product_promotion.product_id","left")
				->join($this->tbl_product_categories,"$this->tbl_product.product_categories_id=$this->tbl_product_categories.product_categories_id")
				->order_by("$this->tbl_product_promotion.product_promotion_pin",'desc')
				->order_by("$this->tbl_product_promotion.product_promotion_seq",'desc')
				->group_by("$this->tbl_product_promotion.product_promotion_id");
				
		if(!empty($sData)){
			$sData = urlDecode($sData);
			$where = "(($this->tbl_product.product_name like '%".$sData."%') or ($this->tbl_product.product_detail like '%".$sData."%') or ($this->tbl_product_promotion.product_promotion_name like '%".$sData."%'))";
			$this->db->where($where);
		}

		if($categories_id!=''){
			$this->db->where("$this->tbl_product.product_categories_id", $categories_id);
		}
		if($pin!=''){
			$this->db->where("$this->tbl_product_promotion.product_promotion_pin",$pin);
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
	public function listEditPromotion($id){
		
		$select = $this->db->select()
				->from($this->tbl_product_promotion)
				->where("product_promotion_id",$id);		
		$query = $this->db->get();
		$result = $query->row_array();
		return $result;
	}
	public function addPromotion(){
		
		$val = $this->getValue();
		if($val['captcha']=='')
		{
			$product_promotion_id = $this->bflibs->getLastID($this->tbl_product_promotion,'product_promotion_id');
			$product_promotion_seq = $this->bflibs->getLastID($this->tbl_product_promotion,'product_promotion_seq');
			$date = date('Y-m-d H:i:s');
			$product_promotion_publish = (isset($val['product_promotion_publish']))?$val['product_promotion_publish']:0;
			$product_promotion_pin = (isset($val['product_promotion_pin']))?$val['product_promotion_pin']:0;
			$data = array(
					"product_promotion_id"=>$product_promotion_id,
					"product_id"=>$val['product_id'],
					"product_promotion_name"=>$val['product_promotion_name'],
					"product_price"=>$val['product_price'],
					"product_discount"=>$val['product_discount'],
					"product_promotion_date_added"=>$date,
					"product_promotion_last_modified"=>$date,
					"product_promotion_pin"=>$product_promotion_pin,
					"product_promotion_publish"=>$product_promotion_publish,
					"product_promotion_seq"=>$product_promotion_seq
			);
			$this->db->insert($this->tbl_product_promotion,$data);		
			
			$data = array(
					"product_price"=>$val['product_price'],
					"product_discount"=>$val['product_discount'],
					"product_last_modified"=>$date
			);
			$this->db->where('product_id',$val['product_id']);
			$this->db->update($this->tbl_product,$data);
				
			return $product_promotion_id;
		}
	}
	public function editPromotion(){
		
		$val = $this->getValue();

		if($val['captcha']=='')
		{
			$product_promotion_id = $val["product_promotion_id"];
			$date = date('Y-m-d H:i:s');
			$product_promotion_publish = (isset($val['product_promotion_publish']))?$val['product_promotion_publish']:0;
			$product_promotion_pin = (isset($val['product_promotion_pin']))?$val['product_promotion_pin']:0;
			$data = array(
					"product_promotion_name"=>$val['product_promotion_name'],
					"product_price"=>$val['product_price'],
					"product_discount"=>$val['product_discount'],
					"product_promotion_last_modified"=>$date,
					"product_promotion_publish"=>$product_promotion_pin,
					"product_promotion_publish"=>$product_promotion_publish
			);

			$this->db->where('product_promotion_id',$product_promotion_id);
			$this->db->update($this->tbl_product_promotion,$data);		
			
			$data = array(
					"product_price"=>$val['product_price'],
					"product_discount"=>$val['product_discount'],
					"product_last_modified"=>$date
			);
			$this->db->where('product_id',$val['product_id']);
			$this->db->update($this->tbl_product,$data);
			
			return $product_promotion_id;
		}
	}
	public function deletePromotion($id){
		
		$this->db->where('product_promotion_id',$id);
		$this->db->delete($this->tbl_product_promotion);
	}
	
	
	
	/* UPLOAD
	-----------------------------------------------------------------------------------------------------------*/
	public function clearTmpImages(){
		$this->bflibs->remove_dir(DIR_FILE.'public/upload/'.$this->request->getModuleName().'/temp/'.$this->ip.'/',true);
	}
	public function movefile_single(){
	
		$module = $this->request->getModuleName();
		$dir_root = DIR_FILE.'/public/upload/'.$module.'/';
		if(!file_exists($dir_root)){mkdir($dir_root);}
		$temp = $dir_root.'temp/';
		if(!file_exists($temp)){mkdir($temp);}
		//$path = 'public/upload/'.$module.'/temp/'.$this->ip.'/';
		$dir_file = $temp.$this->ip.'/';
		if(!file_exists($dir_file)){mkdir($dir_file);}
		
		$config['upload_path'] = $dir_file;
		$config['allowed_types'] = 'gif|jpg|png';
		$config['max_size']	= '5120';
		$config['overwrite']  = TRUE;
		
		$this->load->library('upload', $config);
	
		if ( ! $this->upload->do_upload('Filedata'))
		{
			$error = array('error' => $this->upload->display_errors("<span>","</span>"));
			echo "";
		}
		else
		{
			$data = $this->upload->data();
			$path = 'public/upload/'.$module.'/temp/'.$this->ip.'/'.$data['file_name'];
			echo $path;
		}
	}
	public function movefile(){
	
		$module = $this->request->getModuleName();
		$dir_root = DIR_FILE.'/public/upload/'.$module.'/';
		if(!file_exists($dir_root)){mkdir($dir_root);}
		$temp = $dir_root.'temp/';
		if(!file_exists($temp)){mkdir($temp);}
		//$path = 'public/upload/'.$module.'/temp/'.$this->ip.'/';
		echo $dir_file = $temp.$this->ip.'/';
		if(!file_exists($dir_file)){mkdir($dir_file,0755,true);}
		
		$config['upload_path'] = $dir_file;
		$config['allowed_types'] = 'gif|jpg|png';
		$config['max_size']	= '5120';
		$config['overwrite']  = TRUE;
		
		$this->load->library('upload', $config);
	
		if ( ! $this->upload->do_upload('Filedata'))
		{
			$error = array('error' => $this->upload->display_errors("<span>","</span>"));
			echo "";
		}
		else
		{
			$data = $this->upload->data();
			$path = $data['file_name'];
			echo $path;
		}
	}
	public function upload($files,$product_id){
	
		if(!empty($files)){
			$dir_file = DIR_FILE.'public/upload/'.$this->request->getModuleName().'/original/';
			if(!file_exists($dir_file)){mkdir($dir_file);}
			$tmb_file = DIR_FILE.'public/upload/'.$this->request->getModuleName().'/thumbnails/';
			if(!file_exists($tmb_file)){mkdir($tmb_file);}
			foreach($files as $key=>$file){
				$k = explode('_',$key);
				if($k[0] == 'SWFUpload'){
					$ext = $this->bflibs->getExt($file);
					$file_name = 'product_'.$product_id."_".md5($key.date("mdhis")).".".$ext;
					$__dest = $dir_file.$file_name;
					$source = DIR_FILE.'public/upload/'.$this->request->getModuleName().'/temp/'.$this->ip.'/'.$file;
	
					copy($source, $__dest);
					unlink($source);
					if($this->imagesResize($__dest))$files[$key] = $this->updatePath('public/upload/'.$this->request->getModuleName().'/thumbnails/'.$file_name,$product_id);

					//copy($source, $__dest);
					//$this->imagesResize($__dest,'original',400,400,FALSE);
					//if($this->imagesResize($__dest,'thumbnails'))$files[$key] = $this->updatePath('public/upload/'.$this->request->getModuleName().'/thumbnails/'.$file_name,$product_id);
					//unlink($source);
				}
			}
			$this->updateOrder($files);
		}
	}
	public function upload_categories($file,$product_categories_id,$type){
	
		if(!empty($file)){
			$dir_file = DIR_FILE.'public/upload/'.$this->request->getModuleName().'/original/';
			if(!file_exists($dir_file)){mkdir($dir_file);}
			$tmb_file = DIR_FILE.'public/upload/'.$this->request->getModuleName().'/thumbnails/';
			if(!file_exists($tmb_file)){mkdir($tmb_file);}
			
			$ext = $this->bflibs->getExt($file);
			$file_name = 'categories_'.$type.'_'.$product_categories_id."_".md5(date("mdhis")).".".$ext;
			$__dest = $dir_file.$file_name;
			$source = DIR_FILE.$file;

			copy($source, $__dest);
			if($this->imagesResize($__dest,'thumbnails'))$file = $this->updatePath_categories('public/upload/'.$this->request->getModuleName().'/thumbnails/'.$file_name,$product_categories_id,$type);
			unlink($source);
		}
	}
	private function imagesResize($pathImages,$folder='thumbnails',$width=300,$height=300,$ratio=TRUE){
	
		$thump_path = 'public/upload/'.$this->request->getModuleName().'/thumbnails/';
		$dir_file = DIR_FILE.$thump_path;
		if(!file_exists($dir_file)){mkdir($dir_file);}
		$config['image_library'] = 'gd2';
		$config['source_image'] = $pathImages;
		$config['create_thumb'] = FALSE;
		$config['maintain_ratio'] = $ratio;
		$config['new_image'] = DIR_FILE.$thump_path;
		$config['width'] = $width;
		$config['height'] = $height;

		$this->load->library('image_lib');
		$this->image_lib->initialize($config);
		if ( ! $this->image_lib->resize())
		{
			$error = $this->image_lib->display_errors();
			$status = false;
		}else{
			$status = true;
		}
		$this->image_lib->clear();
		return $status;
	}
	
	private function updatePath($path,$product_id){
	
		$product_images_id = $this->bflibs->getLastID($this->tbl_product_images,'product_images_id');
		$product_images_seq = $this->bflibs->getLastIdWithGroup($this->tbl_product_images,'product_images_seq','product_id',$product_id);
		$data = array("product_images_id"=>$product_images_id,"product_id"=>$product_id,"product_images_path"=>$path,"product_images_seq"=>$product_images_seq);
		$this->db->insert($this->tbl_product_images,$data);
		return $product_images_id;
	}	
	private function updatePath_categories($path,$product_categories_id,$type){

		$data = array("product_categories_".$type."_path"=>$path);
		$this->db->where('product_categories_id',$product_categories_id);
		$this->db->update($this->tbl_product_categories,$data);
		return $product_categories_id;
	}
	
	public function file_cancel($files,$product_id){
		if(!empty($files)){
			foreach($files as $key=>$id){
				if($id != 'undefined'){
					$query = $this->db->select('product_images_path')
							->from($this->tbl_product_images)
							->where('product_id',$product_id)
							->where('product_images_id',$id);
					$query = $this->db->get();
					$result = $query->row_array();
					if(!empty($result)){
						if($result['product_images_path'] != ''){
							
							$file_name = basename($result['product_images_path']);
							$path_thumb = DIR_FILE.'public/upload/'.$this->request->getModuleName().'/thumbnails/'.$file_name;
							$path_origin = DIR_FILE.'public/upload/'.$this->request->getModuleName().'/original/'.$file_name;
							unlink($path_thumb);
							unlink($path_origin);
							$this->db->where('product_id',$product_id);
							$this->db->where('product_images_id',$id);
							$this->db->delete($this->tbl_product_images);
						}
					}
				}
			}
		}
	}
	public function remove_file($file){ // ลบรูปออกจาก temp
		$path = DIR_FILE.'public/upload/'.$this->request->getModuleName().'/temp/'.$this->ip.'/'.$file;
		if(file_exists($path)){
			unlink($path);
		}
	}
	public function updateOrder($files){
		$i = 1;
		foreach($files as $id){
			$data = array('product_images_seq'=>$i++);
			$this->db->where('product_images_id',$id);
			$this->db->update($this->tbl_product_images,$data);
		}
	}
	
	public function delete_image($image_path){
	
		$val = $this->getValue();
		if($val[$image_path] != ''){
			$path = DIR_FILE.$val[$image_path];
			unlink($path);
		}
	}
	
	/* END UPLOAD
	-----------------------------------------------------------------------------------------------------------*/

}
?>