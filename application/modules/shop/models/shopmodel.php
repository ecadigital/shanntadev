<?php
class Shopmodel extends CI_Model {
	private $tbl_admin_cfg = 'admin_cfg';
	private $tbl_shop = 'shop';
	private $tbl_shop_lang = 'shop_lang';
	
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
	

	/*  SHOP
	-------------------------------------------------------------------------------------------------------*/

	public function listShop($targetpage,$page,$limit,$sData=""){
	
		$select = $this->db->select(array(
						"$this->tbl_shop.shop_id",
						"$this->tbl_shop.shop_image",
						"$this->tbl_shop.shop_last_modified",
						"$this->tbl_shop.shop_publish",
						"$this->tbl_shop.shop_seq",
						"$this->tbl_shop_lang.shop_name",
						"$this->tbl_shop_lang.shop_detail"))
				->from($this->tbl_shop)
				->join($this->tbl_shop_lang,"$this->tbl_shop.shop_id=$this->tbl_shop_lang.shop_id","left")
				->where("$this->tbl_shop_lang.language_id",$this->defaultlang)
				->group_by("$this->tbl_shop.shop_id");
				
		/**/if(!empty($sData)){
			$sData = urlDecode($sData);
			$where = "(($this->tbl_shop_lang.shop_name like '%".$sData."%') or ($this->tbl_shop_lang.shop_detail like '%".$sData."%'))";
			$this->db->where($where);
		}
		$this->db->order_by("$this->tbl_shop.shop_seq","asc");
		
		$this->db->get();
		$config['query'] = $this->db->last_query();
		$config['targetpage'] = $targetpage;
		$config['target'] = '#boxContent';
		$config['limit'] = $limit;
		$config['page'] = $page;
		
		$this->load->library('bfpagination', $config);
		return list($paginaion,$page_description,$result) = $this->bfpagination->do_pagination();
	}
	public function listEditShop($id,$member_id=''){
		
		$select = $this->db->select()
				->from($this->tbl_shop)
				->where("shop_id",$id);		
		$query = $this->db->get();
		$result = $query->row_array();
				
		$select = $this->db->select()
				->from($this->tbl_shop_lang)
				->where("shop_id",$id);
		$queryLang = $this->db->get();
		$resultLang = $queryLang->result_array();
		
		foreach($resultLang as $res){
			$result['shop_name'][$res['language_id']] = $res['shop_name'];
			$result['shop_detail'][$res['language_id']] = $res['shop_detail'];
		}
		
		return $result;
	}
	public function addShop(){
		
		$val = $this->getValue();
		if($val['captcha']=='')
		{
			$shop_id = $this->bflibs->getLastID($this->tbl_shop,'shop_id');
			$shop_seq = $this->bflibs->getLastID($this->tbl_shop,'shop_seq');
			$date = date('Y-m-d H:i:s');
			$shop_publish = (isset($val['shop_publish']))?$val['shop_publish']:0;
			$data = array(
					"shop_id"=>$shop_id,
					"shop_date_added"=>$date,
					"shop_last_modified"=>$date,
					"shop_publish"=>1,
					"shop_seq"=>$shop_seq
			);
			$this->db->insert($this->tbl_shop,$data);	
			
			foreach($val['shop_name'] as $lang=>$shop_name){
				$dataLang = array(
					"shop_id"=>$shop_id,
					"language_id"=>$lang,
					"shop_name"=>$shop_name,
					"shop_detail"=>htmlspecialchars($val['shop_detail'][$lang], ENT_QUOTES)
				);
				$this->db->insert($this->tbl_shop_lang,$dataLang);
			}			
			return $shop_id;
		}
	}
	public function editShop(){
		
		$val = $this->getValue();
		if($val['captcha']=='')
		{
			$shop_id = $val["shop_id"];
			$date = date('Y-m-d H:i:s');
			$data = array(
					"shop_last_modified"=>$date
			);

			$this->db->where('shop_id',$shop_id);
			$this->db->update($this->tbl_shop,$data);	
			
			foreach($val['shop_name'] as $lang=>$shop_name){
				$dataLang = array(
					"shop_name"=>$shop_name,
					"shop_detail"=>htmlspecialchars($val['shop_detail'][$lang], ENT_QUOTES)
				);
				
				$chkLang = $this->chkLang($val["shop_id"],$lang);
				if($chkLang==0){
					$dataLang["shop_id"]=$val["shop_id"];
					$dataLang["language_id"]=$lang;
					$this->db->insert($this->tbl_shop_lang,$dataLang);
				}else{
					$this->db->where("shop_id",$val["shop_id"]);
					$this->db->where("language_id",$lang);
					$this->db->update($this->tbl_shop_lang,$dataLang);
				}
			}
			return $val['shop_id'];
		}
	}
	public function chkLang($shop_id,$lang_id){ 
		$select = $this->db->select()
				->from($this->tbl_shop_lang)
				->where("shop_id",$shop_id)
				->where("language_id",$lang_id);

		return $this->db->count_all_results();
	}
	public function updateShopImages($shop_id,$shop_images_id,$detail,$detail2){
		
		$data = array(
				"shop_images_detail"=>$detail,
				"shop_images_detail2"=>$detail2
		);

		$this->db->where('shop_id',$shop_id);
		$this->db->where('shop_images_id',$shop_images_id);
		$this->db->update($this->tbl_shop_images,$data);
	}
	public function deleteShop($id){
		
		$this->db->where('shop_id',$id);
		$this->db->delete($this->tbl_shop);
		$this->db->where('shop_id',$id);
		$this->db->delete($this->tbl_shop_lang);
	}
	public function getFirstShopImage($shop_id){
		
		$select = $this->db	->select(array("shop_images_id","shop_images_path"))
									->from($this->tbl_shop_images)
									->where("shop_id",$shop_id)
									->order_by("shop_images_seq","asc");
		$query = $this->db->get();
		$query_images = $query->row_array();
		$result['shop_images'] = (empty($query_images)) ? '' : $query_images['shop_images_path'];
		return $result['shop_images'];
	}
	public function getDiscount($discount){
		$dis_type=2;
		
		$Array_discount=str_split($discount);
		if($Array_discount[count($Array_discount)-1]=='%'){
			$discount=str_replace("%","",$discount);
			$dis_type=1;
		}
		
		return array($discount,$dis_type);
	}
	
	
	public function listAllShop($lang_id){
		
		$select = $this->db->select(array("$this->tbl_shop.shop_id",
											"$this->tbl_shop.shop_image",
											"$this->tbl_shop_lang.shop_name",
											"$this->tbl_shop_lang.shop_detail",
											"$this->tbl_shop.shop_date_added"))
				->from($this->tbl_shop)
				->join($this->tbl_shop_lang,"$this->tbl_shop_lang.shop_id=$this->tbl_shop.shop_id","left")
				->where("$this->tbl_shop.shop_publish",1)
				->where("$this->tbl_shop_lang.language_id",$lang_id)
				->order_by("$this->tbl_shop.shop_seq",'asc')
				->order_by("$this->tbl_shop.shop_date_added",'asc');		
		$query = $this->db->get();
		$result = $query->result_array();
		
		return $result;
	}
	
	
	
	
	/* UPLOAD
	-----------------------------------------------------------------------------------------------------------*/
	public function clearTmpImages(){
		$this->bflibs->remove_dir(DIR_FILE.'public/upload/'.$this->request->getModuleName().'/temp/'.$this->ip.'/',true);
	}
	public function movefile()
	{
		$module = $this->request->getModuleName();
		$temp = DIR_FILE.'/public/upload/'.$module.'/temp/';
		if(!file_exists($temp)){mkdir($temp);}
		$path = 'public/upload/'.$module.'/temp/'.$this->ip.'/';
		$dir_file = DIR_FILE.$path;
		if(!file_exists($dir_file)){mkdir($dir_file);}
		$shop_id = $this->bflibs->getLastID($this->tbl_shop,'shop_id');
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
			echo $path = $path."/".$data['file_name'];
		}
	}
	public function upload($files,$shop_id)
	{
		if(!empty($files)){
			$dir_file = DIR_FILE.'public/upload/'.$this->request->getModuleName().'/original/';
			if(!file_exists($dir_file)){mkdir($dir_file);}
			foreach($files as $key=>$file){
				$k = explode('_',$key);
				if($k[0] == 'SWFUpload'){
					$ext = $this->bflibs->getExt($file);
					$file_name = 'shop'.$shop_id."D".md5($key.date("mdhis")).".".$ext;
					$__dest = $dir_file.$file_name;
					$source = DIR_FILE.'public/upload/'.$this->request->getModuleName().'/temp/'.$this->ip.'/'.$file;
	
					copy($source, $__dest);
					unlink($source);
					if($this->imagesResize($__dest,'thumbnails'))$files[$key] = $this->updatePath('public/upload/'.$this->request->getModuleName().'/thumbnails/'.$file_name,$shop_id);
					
					//$this->imagesCrop(DIR_FILE.'public/upload/'.$this->request->getModuleName().'/thumbnails/'.$file_name,'crop',250,250);
				}
			}
			$this->updateOrder($files);
		}
	}
	
	private function imagesResize($pathImages,$folder,$width=300,$height=300,$ratio=TRUE)
	{
		$thump_path = 'public/upload/'.$this->request->getModuleName().'/'.$folder.'/';
		$dir_file = DIR_FILE.$thump_path;
		if(!file_exists($dir_file)){mkdir($dir_file);}
		/*list($img_width, $img_height) = getimagesize($pathImages);
		if($img_width>$img_height){
			$config_width = '';
			$config_height = $height;
		}else{
			$config_height = '';
			$config_width = $width;
		}*/
		
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
	private function imagesCrop($pathImages,$folder,$width=300,$height=300)
	{
		$thump_path = 'public/upload/'.$this->request->getModuleName().'/'.$folder.'/';
		$dir_file = DIR_FILE.$thump_path;
		if(!file_exists($dir_file)){mkdir($dir_file);}
		$config['image_library'] = 'gd2';
		$config['source_image'] = $pathImages;
		$config['new_image'] = DIR_FILE.$thump_path;
		$config['maintain_ratio'] = FALSE;
		$config['width'] = $width;
		$config['height'] = $height;
		$config['y_axis'] = 0;//($size['height']==$height) ? 0 : round(($size['height'] - $height) / 2);
        $config['x_axis'] = 0;

		$this->load->library('image_lib');
		$this->image_lib->initialize($config);
		if ( ! $this->image_lib->crop())
		{
			$error = $this->image_lib->display_errors();
			$status = false;
		}else{
			$status = true;
		}
		$this->image_lib->clear();
		return $status;
	}
	/*private function imagesResize($pathImages)
	{
		$thump_path = 'public/upload/'.$this->request->getModuleName().'/thumbnails/';
		$dir_file = DIR_FILE.$thump_path;
		if(!file_exists($dir_file)){mkdir($dir_file);}
		$config['image_library'] = 'gd2';
		$config['source_image'] = $pathImages;
		$config['create_thumb'] = FALSE;
		$config['maintain_ratio'] = TRUE;
		$config['new_image'] = DIR_FILE.$thump_path;
		$config['width'] = 250;
		$config['height'] = 250;

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
	}*/
	private function updatePath($path,$shop_id){
	
		$shop_images_id = $this->bflibs->getLastID($this->tbl_shop_images,'shop_images_id');
		$shop_images_seq = $this->bflibs->getLastIdWithGroup($this->tbl_shop_images,'shop_images_seq','shop_id',$shop_id);
		$data = array("shop_images_id"=>$shop_images_id,"shop_id"=>$shop_id,"shop_images_path"=>$path,"shop_images_seq"=>$shop_images_seq);
		$this->db->insert($this->tbl_shop_images,$data);
		return $shop_images_id;
	}
	
	public function file_cancel($files,$shop_id)
	{
		if(!empty($files)){
			foreach($files as $key=>$id){
				if($id != 'undefined'){
					$query = $this->db->select('shop_images_path')
							->from($this->tbl_shop_images)
							->where('shop_id',$shop_id)
							->where('shop_images_id',$id);
					$query = $this->db->get();
					$result = $query->row_array();
					if(!empty($result)){
						if($result['shop_images_path'] != ''){
							
							$file_name = basename($result['shop_images_path']);
							$path_thumb = DIR_FILE.'public/upload/'.$this->request->getModuleName().'/thumbnails/'.$file_name;
							$path_origin = DIR_FILE.'public/upload/'.$this->request->getModuleName().'/original/'.$file_name;
							unlink($path_thumb);
							unlink($path_origin);
							$this->db->where('shop_id',$shop_id);
							$this->db->where('shop_images_id',$id);
							$this->db->delete($this->tbl_shop_images);
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
			$data = array('shop_images_seq'=>$i++);
			$this->db->where('shop_images_id',$id);
			$this->db->update($this->tbl_shop_images,$data);
		}
	}
	
	public function uploadCover($file,$shop_id)
	{
		if(!empty($file)){
			$dir_file = DIR_FILE.'public/upload/'.$this->request->getModuleName().'/original/';
			if(!file_exists($dir_file)){mkdir($dir_file);}
			
			$ext = $this->bflibs->getExt($file);
			$file_name = 'shop_'.$shop_id."_".md5(date("mdhis")).".".$ext;
			$__dest = $dir_file.$file_name;
			$source = DIR_FILE.$file;

			copy($source, $__dest);
			$this->imagesResize($__dest,'original',962,583,FALSE);
			//$this->updatePath('public/upload/'.$this->request->getModuleName().'/'.$file_name,$shop_id);
			if($this->imagesResize($__dest,'thumbnails'))$file = $this->updatePath_cover('public/upload/'.$this->request->getModuleName().'/thumbnails/'.$file_name,$shop_id);
			unlink($source);

		}
	}
	public function updatePath_cover($path,$id){
		
		$query = $this->db->select("shop_image")
				->from($this->tbl_shop)
				->where('shop_id',$id);				
		$query = $this->db->get();
		$result = $query->row_array();
		
		if(empty($result)){
			$data = array(
					"shop_id"=>$id,
					"shop_image"=>$path
			);
			$this->db->insert($this->tbl_shop,$data);			
		}else{
			$this->deletePath_cover($id);
			$data = array("shop_image"=>$path);
			$this->db->where('shop_id',$id);
			$this->db->update($this->tbl_shop,$data);
		}
	}
	public function deletePath_cover($id){

		$query = $this->db->select("shop_image")
				->from($this->tbl_shop)
				->where('shop_id',$id);				
		$query = $this->db->get();
		$result = $query->row_array();
		if(!empty($result)){
			if($result['shop_image']!=''){
				$path = DIR_FILE.$result['shop_image'];
				if(file_exists($path)) unlink($path);
			}
		}
	}
	
	
	/* END UPLOAD
	-----------------------------------------------------------------------------------------------------------*/

}
?>