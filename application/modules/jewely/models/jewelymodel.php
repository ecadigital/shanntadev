<?php
class Jewelymodel extends CI_Model {
	private $tbl_admin_cfg = 'admin_cfg';
	private $tbl_jewely = 'jewely';
	private $tbl_jewely_lang = 'jewely_lang';
	private $tbl_jewely_images = 'jewely_images';
	
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

	public function listJewely($targetpage,$page,$limit,$sData=""){
	
		$select = $this->db->select(array(
						"$this->tbl_jewely.jewely_id",
						"$this->tbl_jewely.jewely_last_modified",
						"$this->tbl_jewely.jewely_publish",
						"$this->tbl_jewely.jewely_seq",
						"$this->tbl_jewely.jewely_pin",
						"$this->tbl_jewely_lang.jewely_name",
						"$this->tbl_jewely_lang.jewely_detail"))
				->from($this->tbl_jewely)
				->join($this->tbl_jewely_lang,"$this->tbl_jewely.jewely_id=$this->tbl_jewely_lang.jewely_id","left")
				->where("$this->tbl_jewely_lang.language_id",$this->defaultlang)
				->order_by("$this->tbl_jewely.jewely_pin",'desc')
				->order_by("$this->tbl_jewely.jewely_seq",'desc')
				->order_by("$this->tbl_jewely.jewely_date_added",'desc')
				->group_by("$this->tbl_jewely.jewely_id");
				
		if(!empty($sData)){
			$sData = urlDecode($sData);
			$where = "(($this->tbl_jewely_lang.jewely_name like '%".$sData."%') or ($this->tbl_jewely_lang.jewely_detail like '%".$sData."%'))";
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
	public function listEditJewely($id,$member_id=''){
		
		$select = $this->db->select()
				->from($this->tbl_jewely)
				->where("jewely_id",$id);		
		$query = $this->db->get();
		$result = $query->row_array();
		
		if(!empty($result)){
			$select = $this->db	->select(array("jewely_images_id","jewely_images_path"))
										->from($this->tbl_jewely_images)
										->where("jewely_id",$id)
										->order_by("jewely_images_seq","asc");
			$query_images = $this->db->get();
			$result['jewely_images'] = $query_images->result_array();
		}
		
		$select = $this->db->select()
				->from($this->tbl_jewely_lang)
				->where("jewely_id",$id);
		$queryLang = $this->db->get();
		$resultLang = $queryLang->result_array();
		
		foreach($resultLang as $res){
			$result['jewely_name'][$res['language_id']] = $res['jewely_name'];
			$result['jewely_detail'][$res['language_id']] = $res['jewely_detail'];
		}
		return $result;
	}
	public function addJewely(){
		
		$val = $this->getValue();
		if($val['captcha']=='')
		{
			$jewely_id = $this->bflibs->getLastID($this->tbl_jewely,'jewely_id');
			$jewely_seq = $this->bflibs->getLastID($this->tbl_jewely,'jewely_seq');
			$date = date('Y-m-d H:i:s');
			//$jewely_publish = (isset($val['jewely_publish']))?$val['jewely_publish']:0;
			//$jewely_pin = (isset($val['jewely_pin']))?$val['jewely_pin']:0;
			$data = array(
					"jewely_id"=>$jewely_id,
					//"jewely_name"=>$val['jewely_name'],
					//"jewely_detail"=>$val['jewely_detail'],
					"jewely_date_added"=>$date,
					"jewely_last_modified"=>$date,
					"jewely_seq"=>$jewely_seq,
					"jewely_publish"=>1
			);
			$this->db->insert($this->tbl_jewely,$data);	
			
			foreach($val['jewely_name'] as $lang=>$jewely_name){
				$dataLang = array(
					"jewely_id"=>$jewely_id,
					"language_id"=>$lang,
					"jewely_name"=>$jewely_name,
					"jewely_detail"=>htmlspecialchars($val['jewely_detail'][$lang], ENT_QUOTES)
				);
				$this->db->insert($this->tbl_jewely_lang,$dataLang);
			}
			
			return $jewely_id;
		}
	}
	public function editJewely(){
		
		$val = $this->getValue();

		if($val['captcha']=='')
		{
			$jewely_id = $val["jewely_id"];
			$date = date('Y-m-d H:i:s');
			$data = array(
					//"jewely_name"=>$val['jewely_name'],
					//"jewely_detail"=>$val['jewely_detail'],
					"jewely_last_modified"=>$date
			);

			$this->db->where('jewely_id',$jewely_id);
			$this->db->update($this->tbl_jewely,$data);
			
			foreach($val['jewely_name'] as $lang=>$jewely_name){
				$dataLang = array(
					"jewely_name"=>$jewely_name,
					"jewely_detail"=>htmlspecialchars($val['jewely_detail'][$lang], ENT_QUOTES)
				);
				
				$chkLang = $this->chkLang($val["jewely_id"],$lang);
				if($chkLang==0){
					$dataLang["jewely_id"]=$val["jewely_id"];
					$dataLang["language_id"]=$lang;
					$this->db->insert($this->tbl_jewely_lang,$dataLang);
				}else{
					$this->db->where("jewely_id",$val["jewely_id"]);
					$this->db->where("language_id",$lang);
					$this->db->update($this->tbl_jewely_lang,$dataLang);
				}
			}
			return $val['jewely_id'];
		}
	}
	public function deleteJewely($id){
		
		$select = $this->db->select()
				->from($this->tbl_jewely_images);
		if($member_id!=''){
			$this->db	->join($this->tbl_jewely,"$this->tbl_jewely.jewely_id=$this->tbl_jewely_images.jewely_id","left")
							->where("$this->tbl_jewely.member_id",$member_id);
		}
		$this->db->where("$this->tbl_jewely_images.jewely_id",$id);
		$query = $this->db->get();
		$result = $query->result_array();

		if(!empty($result)){
			foreach($result as $res){
				if($res['jewely_images_path'] != ''){
					$file_name = basename($res['jewely_images_path']);
					$path_thumb = 'public/upload/jewely/thumbnails/'.$file_name;
					$path_origin = 'public/upload/jewely/original/'.$file_name;
					
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
		$this->db->where('jewely_id',$id);
		$this->db->delete($this->tbl_jewely);
		$this->db->where('jewely_id',$id);
		$this->db->delete($this->tbl_jewely_lang);
		$this->db->where('jewely_id',$id);
		$this->db->delete($this->tbl_jewely_images);
	}
	public function getFirstJewelyImage($jewely_id){
		
		$select = $this->db	->select(array("jewely_images_id","jewely_images_path"))
									->from($this->tbl_jewely_images)
									->where("jewely_id",$jewely_id)
									->order_by("jewely_images_seq","asc");
		$query = $this->db->get();
		$query_images = $query->row_array();
		$result['jewely_images'] = (empty($query_images)) ? '' : $query_images['jewely_images_path'];
		return $result['jewely_images'];
	}
	
	public function chkLang($jewely_id,$lang_id){ 
		$select = $this->db->select()
				->from($this->tbl_jewely_lang)
				->where("jewely_id",$jewely_id)
				->where("language_id",$lang_id);

		return $this->db->count_all_results();
	}
	
	
	
	public function getJewely($id,$lang_id){
		
		$select = $this->db->select()
				->from($this->tbl_jewely)
				->join($this->tbl_jewely_lang,"$this->tbl_jewely_lang.jewely_id=$this->tbl_jewely.jewely_id","left")
				->where("$this->tbl_jewely.jewely_publish",1)
				->where("$this->tbl_jewely_lang.language_id",$lang_id)
				->order_by("$this->tbl_jewely.jewely_pin","desc")
				->order_by("$this->tbl_jewely.jewely_seq","desc");
		if($id!='first') $this->db->where("$this->tbl_jewely.jewely_id",$id);	
		
		$query = $this->db->get();
		$result = $query->row_array();
		
		return $result;
	}	
	public function listAllJewely($lang_id,$except_id){
		
		$select = $this->db->select(array("$this->tbl_jewely.jewely_id","$this->tbl_jewely_lang.jewely_name"))
				->from($this->tbl_jewely)
				->join($this->tbl_jewely_lang,"$this->tbl_jewely_lang.jewely_id=$this->tbl_jewely.jewely_id","left")
				->where("$this->tbl_jewely.jewely_publish",1)
				->where("$this->tbl_jewely_lang.language_id",$lang_id)
				->where("$this->tbl_jewely.jewely_id !=",$except_id)
				->order_by("$this->tbl_jewely.jewely_seq",'asc');
		$query = $this->db->get();
		$result = $query->result_array();
		
		return $result;
	}
	
	
	
	/* CATEGORIES
	-----------------------------------------------------------------------------------------------------------*/
	/*public function listJewelyCategories(){
		
		$select = $this->db->select()
				->from($this->tbl_jewely_categories);
		$query = $this->db->get();
		$result = $query->result_array();
		return $result;
	}*/
	
	
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
		$jewely_id = $this->bflibs->getLastID($this->tbl_jewely,'jewely_id');
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
			echo $data['file_name'];
		}
	}
	public function upload($files,$jewely_id)
	{
		if(!empty($files)){
			$dir_file = DIR_FILE.'public/upload/'.$this->request->getModuleName().'/original/';
			if(!file_exists($dir_file)){mkdir($dir_file);}
			foreach($files as $key=>$file){
				$k = explode('_',$key);
				if($k[0] == 'SWFUpload'){
					$ext = $this->bflibs->getExt($file);
					$file_name = 'jewely'.$jewely_id."D".md5($key.date("mdhis")).".".$ext;
					$__dest = $dir_file.$file_name;
					$source = DIR_FILE.'public/upload/'.$this->request->getModuleName().'/temp/'.$this->ip.'/'.$file;
	
					copy($source, $__dest);
					unlink($source);
					if($this->imagesResize($__dest))$files[$key] = $this->updatePath('public/upload/'.$this->request->getModuleName().'/thumbnails/'.$file_name,$jewely_id);
				}
			}
			$this->updateOrder($files);
		}
	}
	private function imagesResize($pathImages)
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
	}
	private function updatePath($path,$jewely_id){
	
		$jewely_images_id = $this->bflibs->getLastID($this->tbl_jewely_images,'jewely_images_id');
		$jewely_images_seq = $this->bflibs->getLastIdWithGroup($this->tbl_jewely_images,'jewely_images_seq','jewely_id',$jewely_id);
		$data = array("jewely_images_id"=>$jewely_images_id,"jewely_id"=>$jewely_id,"jewely_images_path"=>$path,"jewely_images_seq"=>$jewely_images_seq);
		$this->db->insert($this->tbl_jewely_images,$data);
		return $jewely_images_id;
	}
	
	public function file_cancel($files,$jewely_id)
	{
		if(!empty($files)){
			foreach($files as $key=>$id){
				if($id != 'undefined'){
					$query = $this->db->select('jewely_images_path')
							->from($this->tbl_jewely_images)
							->where('jewely_id',$jewely_id)
							->where('jewely_images_id',$id);
					$query = $this->db->get();
					$result = $query->row_array();
					if(!empty($result)){
						if($result['jewely_images_path'] != ''){
							
							$file_name = basename($result['jewely_images_path']);
							$path_thumb = DIR_FILE.'public/upload/'.$this->request->getModuleName().'/thumbnails/'.$file_name;
							$path_origin = DIR_FILE.'public/upload/'.$this->request->getModuleName().'/original/'.$file_name;
							unlink($path_thumb);
							unlink($path_origin);
							$this->db->where('jewely_id',$jewely_id);
							$this->db->where('jewely_images_id',$id);
							$this->db->delete($this->tbl_jewely_images);
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
			$data = array('jewely_images_seq'=>$i++);
			$this->db->where('jewely_images_id',$id);
			$this->db->update($this->tbl_jewely_images,$data);
		}
	}
	/* END UPLOAD
	-----------------------------------------------------------------------------------------------------------*/

}
?>