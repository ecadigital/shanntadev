<?php
class Newsmodel extends CI_Model {
	private $tbl_admin_cfg = 'admin_cfg';
	private $tbl_news = 'news';
	private $tbl_news_lang = 'news_lang';
	private $tbl_news_images = 'news_images';
	
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

	public function listNews($targetpage,$page,$limit,$sData=""){
	
		$select = $this->db->select(array(
						"$this->tbl_news.news_id",
						"$this->tbl_news.news_last_modified",
						"$this->tbl_news.news_publish",
						"$this->tbl_news.news_seq",
						"$this->tbl_news.news_pin",
						"$this->tbl_news_lang.news_name",
						"$this->tbl_news_lang.news_detail"))
				->from($this->tbl_news)
				->join($this->tbl_news_lang,"$this->tbl_news.news_id=$this->tbl_news_lang.news_id","left")
				->where("$this->tbl_news_lang.language_id",$this->defaultlang)
				->order_by("$this->tbl_news.news_pin",'desc')
				->order_by("$this->tbl_news.news_seq",'desc')
				->order_by("$this->tbl_news.news_date_added",'desc')
				->group_by("$this->tbl_news.news_id");
				
		if(!empty($sData)){
			$sData = urlDecode($sData);
			$where = "(($this->tbl_news_lang.news_name like '%".$sData."%') or ($this->tbl_news_lang.news_detail like '%".$sData."%'))";
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
	public function listEditNews($id,$member_id=''){
		
		$select = $this->db->select()
				->from($this->tbl_news)
				->where("news_id",$id);		
		$query = $this->db->get();
		$result = $query->row_array();
		
		if(!empty($result)){
			$select = $this->db	->select(array("news_images_id","news_images_path"))
										->from($this->tbl_news_images)
										->where("news_id",$id)
										->order_by("news_images_seq","asc");
			$query_images = $this->db->get();
			$result['news_images'] = $query_images->result_array();
		}
		
		$select = $this->db->select()
				->from($this->tbl_news_lang)
				->where("news_id",$id);
		$queryLang = $this->db->get();
		$resultLang = $queryLang->result_array();
		
		foreach($resultLang as $res){
			$result['news_name'][$res['language_id']] = $res['news_name'];
			$result['news_detail'][$res['language_id']] = $res['news_detail'];
		}
		return $result;
	}
	public function addNews(){
		
		$val = $this->getValue();
		if($val['captcha']=='')
		{
			$news_id = $this->bflibs->getLastID($this->tbl_news,'news_id');
			$news_seq = $this->bflibs->getLastID($this->tbl_news,'news_seq');
			$date = date('Y-m-d H:i:s');
			//$news_publish = (isset($val['news_publish']))?$val['news_publish']:0;
			//$news_pin = (isset($val['news_pin']))?$val['news_pin']:0;
			$data = array(
					"news_id"=>$news_id,
					//"news_name"=>$val['news_name'],
					//"news_detail"=>htmlspecialchars($val['news_detail'], ENT_QUOTES),
					"news_date_added"=>$date,
					"news_last_modified"=>$date,
					"news_seq"=>$news_seq,
					"news_publish"=>1
			);
			$this->db->insert($this->tbl_news,$data);	
			
			foreach($val['news_name'] as $lang=>$news_name){
				$dataLang = array(
					"news_id"=>$news_id,
					"language_id"=>$lang,
					"news_name"=>$news_name,
					"news_detail"=>htmlspecialchars($val['news_detail'][$lang], ENT_QUOTES)
				);
				$this->db->insert($this->tbl_news_lang,$dataLang);
			}					
			return $news_id;
		}
	}
	public function editNews(){
		
		$val = $this->getValue();

		if($val['captcha']=='')
		{
			$news_id = $val["news_id"];
			$date = date('Y-m-d H:i:s');
			$data = array(
					//"news_name"=>$val['news_name'],
					//"news_detail"=>htmlspecialchars($val['news_detail'], ENT_QUOTES),
					"news_last_modified"=>$date
			);

			$this->db->where('news_id',$news_id);
			$this->db->update($this->tbl_news,$data);
			
			foreach($val['news_name'] as $lang=>$news_name){
				$dataLang = array(
					"news_name"=>$news_name,
					"news_detail"=>htmlspecialchars($val['news_detail'][$lang], ENT_QUOTES)
				);
				
				$chkLang = $this->chkLang($val["news_id"],$lang);
				if($chkLang==0){
					$dataLang["news_id"]=$val["news_id"];
					$dataLang["language_id"]=$lang;
					$this->db->insert($this->tbl_news_lang,$dataLang);
				}else{
					$this->db->where("news_id",$val["news_id"]);
					$this->db->where("language_id",$lang);
					$this->db->update($this->tbl_news_lang,$dataLang);
				}
			}
			return $val['news_id'];
		}
	}
	public function deleteNews($id){
		
		$select = $this->db->select()
				->from($this->tbl_news_images);
		if($member_id!=''){
			$this->db	->join($this->tbl_news,"$this->tbl_news.news_id=$this->tbl_news_images.news_id","left")
							->where("$this->tbl_news.member_id",$member_id);
		}
		$this->db->where("$this->tbl_news_images.news_id",$id);
		$query = $this->db->get();
		$result = $query->result_array();

		if(!empty($result)){
			foreach($result as $res){
				if($res['news_images_path'] != ''){
					$file_name = basename($res['news_images_path']);
					$path_thumb = 'public/upload/news/thumbnails/'.$file_name;
					$path_origin = 'public/upload/news/original/'.$file_name;
					
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
		$this->db->where('news_id',$id);
		$this->db->delete($this->tbl_news);
		$this->db->where('news_id',$id);
		$this->db->delete($this->tbl_news_lang);
		$this->db->where('news_id',$id);
		$this->db->delete($this->tbl_news_images);
	}
	public function getFirstNewsImage($news_id){
		
		$select = $this->db	->select(array("news_images_id","news_images_path"))
									->from($this->tbl_news_images)
									->where("news_id",$news_id)
									->order_by("news_images_seq","asc");
		$query = $this->db->get();
		$query_images = $query->row_array();
		$result['news_images'] = (empty($query_images)) ? '' : $query_images['news_images_path'];
		return $result['news_images'];
	}
	
	public function chkLang($news_id,$lang_id){ 
		$select = $this->db->select()
				->from($this->tbl_news_lang)
				->where("news_id",$news_id)
				->where("language_id",$lang_id);

		return $this->db->count_all_results();
	}
	
	
	/* CATEGORIES
	-----------------------------------------------------------------------------------------------------------*/
	/*public function listNewsCategories(){
		
		$select = $this->db->select()
				->from($this->tbl_news_categories);
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
		$news_id = $this->bflibs->getLastID($this->tbl_news,'news_id');
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
	public function upload($files,$news_id)
	{
		if(!empty($files)){
			$dir_file = DIR_FILE.'public/upload/'.$this->request->getModuleName().'/original/';
			if(!file_exists($dir_file)){mkdir($dir_file);}
			foreach($files as $key=>$file){
				$k = explode('_',$key);
				if($k[0] == 'SWFUpload'){
					$ext = $this->bflibs->getExt($file);
					$file_name = 'news'.$news_id."D".md5($key.date("mdhis")).".".$ext;
					$__dest = $dir_file.$file_name;
					$source = DIR_FILE.'public/upload/'.$this->request->getModuleName().'/temp/'.$this->ip.'/'.$file;
	
					copy($source, $__dest);
					unlink($source);
					if($this->imagesResize($__dest))$files[$key] = $this->updatePath('public/upload/'.$this->request->getModuleName().'/thumbnails/'.$file_name,$news_id);
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
	private function updatePath($path,$news_id){
	
		$news_images_id = $this->bflibs->getLastID($this->tbl_news_images,'news_images_id');
		$news_images_seq = $this->bflibs->getLastIdWithGroup($this->tbl_news_images,'news_images_seq','news_id',$news_id);
		$data = array("news_images_id"=>$news_images_id,"news_id"=>$news_id,"news_images_path"=>$path,"news_images_seq"=>$news_images_seq);
		$this->db->insert($this->tbl_news_images,$data);
		return $news_images_id;
	}
	
	public function file_cancel($files,$news_id)
	{
		if(!empty($files)){
			foreach($files as $key=>$id){
				if($id != 'undefined'){
					$query = $this->db->select('news_images_path')
							->from($this->tbl_news_images)
							->where('news_id',$news_id)
							->where('news_images_id',$id);
					$query = $this->db->get();
					$result = $query->row_array();
					if(!empty($result)){
						if($result['news_images_path'] != ''){
							
							$file_name = basename($result['news_images_path']);
							$path_thumb = DIR_FILE.'public/upload/'.$this->request->getModuleName().'/thumbnails/'.$file_name;
							$path_origin = DIR_FILE.'public/upload/'.$this->request->getModuleName().'/original/'.$file_name;
							unlink($path_thumb);
							unlink($path_origin);
							$this->db->where('news_id',$news_id);
							$this->db->where('news_images_id',$id);
							$this->db->delete($this->tbl_news_images);
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
			$data = array('news_images_seq'=>$i++);
			$this->db->where('news_images_id',$id);
			$this->db->update($this->tbl_news_images,$data);
		}
	}
	/* END UPLOAD
	-----------------------------------------------------------------------------------------------------------*/

}
?>