<?php
class Collectionmodel extends CI_Model {
	private $tbl_admin_cfg = 'admin_cfg';
	private $tbl_collection = 'collection';
	private $tbl_collection_images = 'collection_images';
	private $tbl_collection_categories = 'collection_categories';
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

	public function listCollection($targetpage,$page,$limit,$sData="",$type="",$cat=""){
		$select = $this->db->select()
				->from($this->tbl_collection)
				->join($this->tbl_collection_categories,"$this->tbl_collection.collection_categories_id=$this->tbl_collection_categories.collection_categories_id","left")
				->group_by("$this->tbl_collection.collection_id");
				
		if(!empty($sData)){
			$sData = urlDecode($sData);
			$where = "(($this->tbl_collection.collection_name like '%".$sData."%') or ($this->tbl_collection.collection_detail like '%".$sData."%') or ($this->tbl_collection_categories.collection_categories_name like '%".$sData."%'))";
			$this->db->where($where);
		}

		if($type==''){
			$this->db->order_by("$this->tbl_collection.collection_pin",'desc');
			$this->db->order_by("$this->tbl_collection.collection_seq",'desc');
			//$this->db->order_by("$this->tbl_collection.collection_date_added",'desc');
		}else{
			if($type=='-'){
				$this->db->order_by("$this->tbl_collection.collection_seq",'desc');
				//$this->db->order_by("$this->tbl_collection.collection_date_added",'desc');
			}
			else if($type=='hot'){
				$this->db->order_by("$this->tbl_collection.collection_seq",'desc');
				//$this->db->order_by("$this->tbl_collection.collection_date_added",'desc');
				$this->db->where("$this->tbl_collection.collection_hot",1);
			}
			else if($type=='rec'){
				$this->db->order_by("$this->tbl_collection.collection_seq",'desc');
				//$this->db->order_by("$this->tbl_collection.collection_date_added",'desc');
				$this->db->where("$this->tbl_collection.collection_rec",1);
			}
			else if($type=='pro'){
				$this->db->order_by("$this->tbl_collection.collection_seq",'desc');
				//$this->db->order_by("$this->tbl_collection.collection_date_added",'desc');
				$this->db->where("$this->tbl_collection.collection_pro",1);
			}
			else if($type=='sale'){
				$this->db->order_by("$this->tbl_collection.collection_seq",'desc');
				//$this->db->order_by("$this->tbl_collection.collection_date_added",'desc');
				$this->db->where("$this->tbl_collection.collection_sale",1);
			}
			else{
				$this->db->order_by("$this->tbl_collection.collection_seq",'desc');
			}
		}
		if($cat!=''){
			$this->db->where("$this->tbl_collection.collection_categories_id",$cat);
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
	public function listEditCollection($id,$member_id=''){
		
		$select = $this->db->select()
				->from($this->tbl_collection)
				->where("collection_id",$id);		
		$query = $this->db->get();
		$result = $query->row_array();
		
		if(!empty($result)){
			$select = $this->db	->select(array("collection_images_id","collection_images_path"))
										->from($this->tbl_collection_images)
										->where("collection_id",$id)
										->order_by("collection_images_seq","asc");
			$query_images = $this->db->get();
			$result['collection_images'] = $query_images->result_array();
		}
		return $result;
	}
	public function addCollection(){
		
		$val = $this->getValue();
		if($val['captcha']=='')
		{
			$collection_id = $this->bflibs->getLastID($this->tbl_collection,'collection_id');
			$collection_seq = $this->bflibs->getLastID($this->tbl_collection,'collection_seq');
			$date = date('Y-m-d H:i:s');
			
			list($discount,$dis_type) = $this->bflibs->getDiscount($val['collection_discount']);
			
			$data = array(
					"collection_id"=>$collection_id,
					"collection_categories_id"=>$val['collection_categories_id'],
					"collection_name"=>$val['collection_name'],
					//"collection_short_detail"=>$val['collection_short_detail'],
					"collection_detail"=>$val['collection_detail'],
					"collection_price"=>$this->bflibs->cutNumberSeparate($val['collection_price']),
					"collection_discount"=>($dis_type==1) ? $val['collection_discount'] : $this->bflibs->cutNumberSeparate($discount),
					"collection_newprice"=>$this->bflibs->cutNumberSeparate($val['collection_newprice']),
					"collection_date_added"=>$date,
					"collection_last_modified"=>$date,
					"collection_publish"=>1,
					"collection_seq"=>$collection_seq
			);
			$this->db->insert($this->tbl_collection,$data);			
			return $collection_id;
		}
	}
	public function editCollection(){
		
		$val = $this->getValue();

		if($val['captcha']=='')
		{
			$collection_id = $val["collection_id"];
			$date = date('Y-m-d H:i:s');
			$collection_publish = (isset($val['collection_publish']))?$val['collection_publish']:0;
			$collection_pin = (isset($val['collection_pin']))?$val['collection_pin']:0;
			$data = array(
					"collection_categories_id"=>$val['collection_categories_id'],
					"collection_name"=>$val['collection_name'],
					//"collection_short_detail"=>$val['collection_short_detail'],
					"collection_detail"=>$val['collection_detail'],
					"collection_price"=>$this->bflibs->cutNumberSeparate($val['collection_price']),
					"collection_discount"=>($dis_type==1) ? $val['collection_discount'] : $this->bflibs->cutNumberSeparate($discount),
					"collection_newprice"=>$this->bflibs->cutNumberSeparate($val['collection_newprice']),
					"collection_last_modified"=>$date
			);

			$this->db->where('collection_id',$collection_id);
			$this->db->update($this->tbl_collection,$data);
			return $val['collection_id'];
		}
	}
	public function deleteCollection($id){
		
		$select = $this->db->select()
				->from($this->tbl_collection_images);
		if($member_id!=''){
			$this->db	->join($this->tbl_collection,"$this->tbl_collection.collection_id=$this->tbl_collection_images.collection_id","left")
							->where("$this->tbl_collection.member_id",$member_id);
		}
		$this->db->where("$this->tbl_collection_images.collection_id",$id);
		$query = $this->db->get();
		$result = $query->result_array();

		if(!empty($result)){
			foreach($result as $res){
				if($res['collection_images_path'] != ''){
					$file_name = basename($res['collection_images_path']);
					$path_thumb = 'public/upload/collection/thumbnails/'.$file_name;
					$path_origin = 'public/upload/collection/original/'.$file_name;
					
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
		$this->db->where('collection_id',$id);
		$this->db->delete($this->tbl_collection);
		$this->db->where('collection_id',$id);
		$this->db->delete($this->tbl_collection_images);
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

	
	/*  CATEGORIES
	-------------------------------------------------------------------------------------------------------*/

	public function listCategories($parent_id, $space){
	
		$select = $this->db->select()
				->from($this->tbl_collection_categories)
				->where("collection_categories_parent_id",$parent_id)
				->order_by("collection_categories_seq",'asc');
		$query = $this->db->get();
		$result = $query->result_array();
		if(!empty($result)){
			foreach($result as $res){
				
				$res['collection_categories_name'] = $this->mkSpace($space).$res['collection_categories_name'];
				$this->listCategories[] = $res;
				$this->listCategories($res['collection_categories_id'], $space+4);
			}
		}
		return $this->listCategories;
	}
	public function listCategoriesParent($parent_id, $space, $id=''){
	
		$select = $this->db->select()
				->from($this->tbl_collection_categories)
				->where("collection_categories_publish",1)
				->where("collection_categories_parent_id",$parent_id)
				->order_by("collection_categories_seq",'asc');
		if($id != ''){
			$this->db->where("collection_categories_id !=",$id);
		}
		$query = $this->db->get();
		$result = $query->result_array();
		if(!empty($result)){
			foreach($result as $res){
				
				$this->listCategoriesParent[] = array('collection_categories_id'=>$res['collection_categories_id'],'collection_categories_name'=>$this->mkSpace($space).$res['collection_categories_name']);
				$this->listCategoriesParent($res['collection_categories_id'], $space+2, $id);
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
				->from($this->tbl_collection_categories)
				->where('collection_categories_id',$id);
		$query = $this->db->get();
		$result = $query->row_array();
		return $result;
	}
	public function addCategories(){
		
		$val = $this->getValue();
		if($val['captcha']=='')
		{
			$collection_categories_id = $this->bflibs->getLastID($this->tbl_collection_categories,'collection_categories_id');
			$collection_categories_seq = $this->bflibs->getLastID($this->tbl_collection_categories,'collection_categories_seq');
			$data = array("collection_categories_id"=>$collection_categories_id,
					"collection_categories_parent_id"=>(isset($val['collection_categories_parent_id'])) ? $val['collection_categories_parent_id'] : 0,
					"collection_categories_name"=>$val['collection_categories_name'],
					"collection_categories_home_keyhead"=>$val['collection_categories_home_keyhead'],
					"collection_categories_home_keymessage"=>$val['collection_categories_home_keymessage'],
					"collection_categories_home_position"=>$val['collection_categories_home_position'],
					"collection_categories_banner_keyhead"=>$val['collection_categories_banner_keyhead'],
					"collection_categories_banner_keymessage"=>$val['collection_categories_banner_keymessage'],
					"collection_categories_banner_position"=>$val['collection_categories_banner_position'],
					"collection_categories_publish"=>1,
					"collection_categories_seq"=>$collection_categories_seq
			);
			$this->db->insert($this->tbl_collection_categories,$data);
			
			return $collection_categories_id;
		}
	}
	public function editCategories(){
		
		$val = $this->getValue();
		if($val['captcha']=='')
		{
			$collection_categories_id = $val['collection_categories_id'];
			$data = array(
					"collection_categories_parent_id"=>(isset($val['collection_categories_parent_id'])) ? $val['collection_categories_parent_id'] : 0,
					"collection_categories_name"=>$val['collection_categories_name'],
					"collection_categories_home_keyhead"=>$val['collection_categories_home_keyhead'],
					"collection_categories_home_keymessage"=>$val['collection_categories_home_keymessage'],
					"collection_categories_home_position"=>$val['collection_categories_home_position'],
					"collection_categories_banner_keyhead"=>$val['collection_categories_banner_keyhead'],
					"collection_categories_banner_keymessage"=>$val['collection_categories_banner_keymessage'],
					"collection_categories_banner_position"=>$val['collection_categories_banner_position']
			);
			
			$this->db->where('collection_categories_id',$collection_categories_id);
			$this->db->update($this->tbl_collection_categories,$data);
		}
	}
	public function deleteCategories($id){
	
		$select = $this->db->select()
				->from($this->tbl_collection_categories);
		$this->db->where("collection_categories_id",$id);
		$query = $this->db->get();
		$res = $query->row_array();

		if(!empty($res)){
			if($res['collection_categories_home_path'] != ''){
				$file_name = basename($res['collection_categories_home_path']);
				
				$path_thumb = 'public/upload/collection/thumbnails/'.$file_name;
				$file_thumb = DIR_FILE.$path_thumb;
				if(file_exists($file_thumb)){
					unlink($file_thumb);
				}
				$path_ori = 'public/upload/collection/original/'.$file_name;
				$file_ori = DIR_FILE.$path_ori;				
				if(file_exists($file_ori)){
					unlink($file_ori);
				}
			}
			if($res['collection_categories_banner_path'] != ''){
				$file_name = basename($res['collection_categories_banner_path']);
				
				$path_thumb = 'public/upload/collection/thumbnails/'.$file_name;
				$file_thumb = DIR_FILE.$path_thumb;
				if(file_exists($file_thumb)){
					unlink($file_thumb);
				}
				$path_ori = 'public/upload/collection/original/'.$file_name;
				$file_ori = DIR_FILE.$path_ori;				
				if(file_exists($file_ori)){
					unlink($file_ori);
				}
			}
		}
		$this->db->where('collection_categories_id',$id);
		$this->db->delete($this->tbl_collection_categories);
	}
	public function chkHasData($categories_id){
	
		$select = $this->db->select("collection_id")
				->from($this->tbl_collection)
				->where('collection_categories_id',$categories_id);
		$query = $this->db->get();
		$result = $query->result_array();
		if(empty($result)){
			return 'false'; // ไม่มีคอลเลคชั่นในหมวดหมู่นี้แล้ว
		}else{
			return 'true';
		}
	}

	
	/*  PROMOTION
	-------------------------------------------------------------------------------------------------------*/

	public function listAllCollection(){
	
		$select = $this->db->select()
				->from($this->tbl_collection)
				->order_by("collection_name",'asc');
		$query = $this->db->get();
		$result = $query->result_array();
		return $result;
	}
	public function listPromotion($targetpage,$page,$limit,$sData="",$categories_id="",$pin=""){
	
		$select = $this->db->select(array("$this->tbl_collection_promotion.*","$this->tbl_collection.collection_name","$this->tbl_collection_categories.collection_categories_name"))
				->from($this->tbl_collection_promotion)
				->join($this->tbl_collection,"$this->tbl_collection.collection_id=$this->tbl_collection_promotion.collection_id","left")
				->join($this->tbl_collection_categories,"$this->tbl_collection.collection_categories_id=$this->tbl_collection_categories.collection_categories_id")
				->order_by("$this->tbl_collection_promotion.collection_promotion_pin",'desc')
				->order_by("$this->tbl_collection_promotion.collection_promotion_seq",'desc')
				->group_by("$this->tbl_collection_promotion.collection_promotion_id");
				
		if(!empty($sData)){
			$sData = urlDecode($sData);
			$where = "(($this->tbl_collection.collection_name like '%".$sData."%') or ($this->tbl_collection.collection_detail like '%".$sData."%') or ($this->tbl_collection_promotion.collection_promotion_name like '%".$sData."%'))";
			$this->db->where($where);
		}

		if($categories_id!=''){
			$this->db->where("$this->tbl_collection.collection_categories_id", $categories_id);
		}
		if($pin!=''){
			$this->db->where("$this->tbl_collection_promotion.collection_promotion_pin",$pin);
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
				->from($this->tbl_collection_promotion)
				->where("collection_promotion_id",$id);		
		$query = $this->db->get();
		$result = $query->row_array();
		return $result;
	}
	public function addPromotion(){
		
		$val = $this->getValue();
		if($val['captcha']=='')
		{
			$collection_promotion_id = $this->bflibs->getLastID($this->tbl_collection_promotion,'collection_promotion_id');
			$collection_promotion_seq = $this->bflibs->getLastID($this->tbl_collection_promotion,'collection_promotion_seq');
			$date = date('Y-m-d H:i:s');
			$collection_promotion_publish = (isset($val['collection_promotion_publish']))?$val['collection_promotion_publish']:0;
			$collection_promotion_pin = (isset($val['collection_promotion_pin']))?$val['collection_promotion_pin']:0;
			$data = array(
					"collection_promotion_id"=>$collection_promotion_id,
					"collection_id"=>$val['collection_id'],
					"collection_promotion_name"=>$val['collection_promotion_name'],
					"collection_price"=>$val['collection_price'],
					"collection_discount"=>$val['collection_discount'],
					"collection_promotion_date_added"=>$date,
					"collection_promotion_last_modified"=>$date,
					"collection_promotion_pin"=>$collection_promotion_pin,
					"collection_promotion_publish"=>$collection_promotion_publish,
					"collection_promotion_seq"=>$collection_promotion_seq
			);
			$this->db->insert($this->tbl_collection_promotion,$data);		
			
			$data = array(
					"collection_price"=>$val['collection_price'],
					"collection_discount"=>$val['collection_discount'],
					"collection_last_modified"=>$date
			);
			$this->db->where('collection_id',$val['collection_id']);
			$this->db->update($this->tbl_collection,$data);
				
			return $collection_promotion_id;
		}
	}
	public function editPromotion(){
		
		$val = $this->getValue();

		if($val['captcha']=='')
		{
			$collection_promotion_id = $val["collection_promotion_id"];
			$date = date('Y-m-d H:i:s');
			$collection_promotion_publish = (isset($val['collection_promotion_publish']))?$val['collection_promotion_publish']:0;
			$collection_promotion_pin = (isset($val['collection_promotion_pin']))?$val['collection_promotion_pin']:0;
			$data = array(
					"collection_promotion_name"=>$val['collection_promotion_name'],
					"collection_price"=>$val['collection_price'],
					"collection_discount"=>$val['collection_discount'],
					"collection_promotion_last_modified"=>$date,
					"collection_promotion_publish"=>$collection_promotion_pin,
					"collection_promotion_publish"=>$collection_promotion_publish
			);

			$this->db->where('collection_promotion_id',$collection_promotion_id);
			$this->db->update($this->tbl_collection_promotion,$data);		
			
			$data = array(
					"collection_price"=>$val['collection_price'],
					"collection_discount"=>$val['collection_discount'],
					"collection_last_modified"=>$date
			);
			$this->db->where('collection_id',$val['collection_id']);
			$this->db->update($this->tbl_collection,$data);
			
			return $collection_promotion_id;
		}
	}
	public function deletePromotion($id){
		
		$this->db->where('collection_promotion_id',$id);
		$this->db->delete($this->tbl_collection_promotion);
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
			$path = $data['file_name'];
			echo $path;
		}
	}
	public function upload($files,$collection_id){
	
		if(!empty($files)){
			$dir_file = DIR_FILE.'public/upload/'.$this->request->getModuleName().'/original/';
			if(!file_exists($dir_file)){mkdir($dir_file);}
			$tmb_file = DIR_FILE.'public/upload/'.$this->request->getModuleName().'/thumbnails/';
			if(!file_exists($tmb_file)){mkdir($tmb_file);}
			foreach($files as $key=>$file){
				$k = explode('_',$key);
				if($k[0] == 'SWFUpload'){
					$ext = $this->bflibs->getExt($file);
					$file_name = 'collection_'.$collection_id."_".md5($key.date("mdhis")).".".$ext;
					$__dest = $dir_file.$file_name;
					$source = DIR_FILE.'public/upload/'.$this->request->getModuleName().'/temp/'.$this->ip.'/'.$file;
	
					copy($source, $__dest);
					unlink($source);
					if($this->imagesResize($__dest))$files[$key] = $this->updatePath('public/upload/'.$this->request->getModuleName().'/thumbnails/'.$file_name,$collection_id);

					//copy($source, $__dest);
					//$this->imagesResize($__dest,'original',400,400,FALSE);
					//if($this->imagesResize($__dest,'thumbnails'))$files[$key] = $this->updatePath('public/upload/'.$this->request->getModuleName().'/thumbnails/'.$file_name,$collection_id);
					//unlink($source);
				}
			}
			$this->updateOrder($files);
		}
	}
	public function upload_categories($file,$collection_categories_id,$type){
	
		if(!empty($file)){
			$dir_file = DIR_FILE.'public/upload/'.$this->request->getModuleName().'/original/';
			if(!file_exists($dir_file)){mkdir($dir_file);}
			$tmb_file = DIR_FILE.'public/upload/'.$this->request->getModuleName().'/thumbnails/';
			if(!file_exists($tmb_file)){mkdir($tmb_file);}
			
			$ext = $this->bflibs->getExt($file);
			$file_name = 'categories_'.$type.'_'.$collection_categories_id."_".md5(date("mdhis")).".".$ext;
			$__dest = $dir_file.$file_name;
			$source = DIR_FILE.$file;

			copy($source, $__dest);
			if($this->imagesResize($__dest,'thumbnails'))$file = $this->updatePath_categories('public/upload/'.$this->request->getModuleName().'/thumbnails/'.$file_name,$collection_categories_id,$type);
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
	
	private function updatePath($path,$collection_id){
	
		$collection_images_id = $this->bflibs->getLastID($this->tbl_collection_images,'collection_images_id');
		$collection_images_seq = $this->bflibs->getLastIdWithGroup($this->tbl_collection_images,'collection_images_seq','collection_id',$collection_id);
		$data = array("collection_images_id"=>$collection_images_id,"collection_id"=>$collection_id,"collection_images_path"=>$path,"collection_images_seq"=>$collection_images_seq);
		$this->db->insert($this->tbl_collection_images,$data);
		return $collection_images_id;
	}	
	private function updatePath_categories($path,$collection_categories_id,$type){

		$data = array("collection_categories_".$type."_path"=>$path);
		$this->db->where('collection_categories_id',$collection_categories_id);
		$this->db->update($this->tbl_collection_categories,$data);
		return $collection_categories_id;
	}
	
	public function file_cancel($files,$collection_id){
		if(!empty($files)){
			foreach($files as $key=>$id){
				if($id != 'undefined'){
					$query = $this->db->select('collection_images_path')
							->from($this->tbl_collection_images)
							->where('collection_id',$collection_id)
							->where('collection_images_id',$id);
					$query = $this->db->get();
					$result = $query->row_array();
					if(!empty($result)){
						if($result['collection_images_path'] != ''){
							
							$file_name = basename($result['collection_images_path']);
							$path_thumb = DIR_FILE.'public/upload/'.$this->request->getModuleName().'/thumbnails/'.$file_name;
							$path_origin = DIR_FILE.'public/upload/'.$this->request->getModuleName().'/original/'.$file_name;
							unlink($path_thumb);
							unlink($path_origin);
							$this->db->where('collection_id',$collection_id);
							$this->db->where('collection_images_id',$id);
							$this->db->delete($this->tbl_collection_images);
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
			$data = array('collection_images_seq'=>$i++);
			$this->db->where('collection_images_id',$id);
			$this->db->update($this->tbl_collection_images,$data);
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