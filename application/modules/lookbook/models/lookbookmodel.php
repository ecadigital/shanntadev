<?php
class Lookbookmodel extends CI_Model {
	private $tbl_admin_cfg = 'admin_cfg';
	private $tbl_lookbook = 'lookbook';
	private $tbl_lookbook_lang = 'lookbook_lang';
	private $tbl_lookbook_images = 'lookbook_images';
	
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

	public function listLookbook($targetpage,$page,$limit,$sData=""){
	
		$select = $this->db->select(array(
						"$this->tbl_lookbook.lookbook_id",
						"$this->tbl_lookbook.lookbook_last_modified",
						"$this->tbl_lookbook.lookbook_publish",
						"$this->tbl_lookbook.lookbook_seq",
						"$this->tbl_lookbook_lang.lookbook_path"))
				->from($this->tbl_lookbook)
				->join($this->tbl_lookbook_lang,"$this->tbl_lookbook.lookbook_id=$this->tbl_lookbook_lang.lookbook_id","left")
				->where("$this->tbl_lookbook_lang.language_id",$this->defaultlang)
				->order_by("$this->tbl_lookbook.lookbook_seq",'desc')
				->order_by("$this->tbl_lookbook.lookbook_date_added",'desc')
				->group_by("$this->tbl_lookbook.lookbook_id");
				
		if(!empty($sData)){
			$sData = urlDecode($sData);
			//$where = "(($this->tbl_lookbook_lang.lookbook_path like '%".$sData."%') or ($this->tbl_lookbook_lang.lookbook_answer like '%".$sData."%'))";
			//$this->db->where($where);
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
	public function listEditLookbook($id,$member_id=''){
		
		$select = $this->db->select()
				->from($this->tbl_lookbook)
				->where("lookbook_id",$id);		
		$query = $this->db->get();
		$result = $query->row_array();
		
		$select = $this->db->select()
				->from($this->tbl_lookbook_lang)
				->where("lookbook_id",$id);
		$queryLang = $this->db->get();
		$resultLang = $queryLang->result_array();
		
		foreach($resultLang as $res){
			$result['lookbook_path'][$res['language_id']] = $res['lookbook_path'];
		}
		
		return $result;
	}
	public function addLookbook(){
		
		$val = $this->getValue();
		if($val['captcha']=='')
		{
			$lookbook_id = $this->bflibs->getLastID($this->tbl_lookbook,'lookbook_id');
			$lookbook_seq = $this->bflibs->getLastID($this->tbl_lookbook,'lookbook_seq');
			$date = date('Y-m-d H:i:s');
			//$lookbook_publish = (isset($val['lookbook_publish']))?$val['lookbook_publish']:0;
			$data = array(
					"lookbook_id"=>$lookbook_id,
					"lookbook_date_added"=>$date,
					"lookbook_last_modified"=>$date,
					"lookbook_seq"=>$lookbook_seq,
					"lookbook_publish"=>1
			);
			$this->db->insert($this->tbl_lookbook,$data);
			/*
			foreach($val['image_path'] as $lang=>$lookbook_path){
				$dataLang = array(
					"lookbook_id"=>$lookbook_id,
					"language_id"=>$lang
				);
				$this->db->insert($this->tbl_lookbook_lang,$dataLang);
				
				if($lookbook_path!=''){
					$this->upload_lookbook($lookbook_path,$lang);
				}
			}	*/	
			return $lookbook_id;
		}
	}
	public function editLookbook(){
		
		$val = $this->getValue();

		if($val['captcha']=='')
		{
			$lookbook_id = $val["lookbook_id"];
			$date = date('Y-m-d H:i:s');
			$data = array(
					"lookbook_last_modified"=>$date
			);

			$this->db->where('lookbook_id',$lookbook_id);
			$this->db->update($this->tbl_lookbook,$data);
			/*
			foreach($val['image_path'] as $lang=>$lookbook_path){
			
				if($data['image_path_'.$lang_id]!=''){
					$this->model->upload_lookbook($data['image_path_'.$lang_id],$lang_id);
				}
				
				$dataLang = array();				
				
				$chkLang = $this->chkLang($val["lookbook_id"],$lang);
				if($chkLang==0){
					$dataLang["lookbook_id"]=$val["lookbook_id"];
					$dataLang["language_id"]=$lang;
					$this->db->insert($this->tbl_lookbook_lang,$dataLang);
				}else{
					$this->db->where("lookbook_id",$val["lookbook_id"]);
					$this->db->where("language_id",$lang);
					$this->db->update($this->tbl_lookbook_lang,$dataLang);
				}
			}*/
			return $val['lookbook_id'];
		}
	}
	public function deleteLookbook($id){
		
		$select = $this->db->select()
				->from($this->tbl_lookbook_lang)
				->where("$this->tbl_lookbook_lang.lookbook_id",$id);
		$query = $this->db->get();
		$result = $query->result_array();

		if(!empty($result)){
			foreach($result as $res){
				if($res['lookbook_path'] != ''){
					$file_name = basename($res['lookbook_path']);
					$path_thumb = 'public/upload/lookbook/thumbnails/'.$file_name;
					$path_origin = 'public/upload/lookbook/original/'.$file_name;
					
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
		$this->db->where('lookbook_id',$id);
		$this->db->delete($this->tbl_lookbook);
		$this->db->where('lookbook_id',$id);
		$this->db->delete($this->tbl_lookbook_lang);
	}
	
	public function chkLang($lookbook_id,$lang_id){ 
		$select = $this->db->select()
				->from($this->tbl_lookbook_lang)
				->where("lookbook_id",$lookbook_id)
				->where("language_id",$lang_id);

		return $this->db->count_all_results();
	}
	
	
	
	/* UPLOAD
	-----------------------------------------------------------------------------------------------------------*/
	public function clearTmpImages(){
		$this->bflibs->remove_dir(DIR_FILE.'public/upload/'.$this->request->getModuleName().'/temp/'.$this->ip.'/',true);
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
			$path = 'public/upload/'.$module.'/temp/'.$this->ip.'/'.$data['file_name'];
			echo $path;
		}
	}
	public function upload_lookbook($file,$lookbook_id,$lang_id){
	
		if(!empty($file)){
			$dir_file = DIR_FILE.'public/upload/'.$this->request->getModuleName().'/original/';
			if(!file_exists($dir_file)){mkdir($dir_file);}
			$tmb_file = DIR_FILE.'public/upload/'.$this->request->getModuleName().'/thumbnails/';
			if(!file_exists($tmb_file)){mkdir($tmb_file);}
			
			$ext = $this->bflibs->getExt($file);
			$file_name = 'lookbook'.$lang_id.'_'.md5(date("mdhis")).".".$ext;
			$__dest = $dir_file.$file_name;
			$source = DIR_FILE.$file;

			copy($source, $__dest);
			if($this->imagesResize($__dest,'thumbnails'))$file = $this->updatePath_lookbook('public/upload/'.$this->request->getModuleName().'/thumbnails/'.$file_name,$lookbook_id,$lang_id);
			unlink($source);
		}
	}
	private function updatePath_lookbook($path,$lookbook_id,$lang_id){

		$data = array("lookbook_path"=>$path);
		
		$chkLang = $this->chkLang($lookbook_id,$lang_id);
		if($chkLang==0){
			$dataLang["lookbook_id"]=$lookbook_id;
			$dataLang["language_id"]=$lang_id;
			$this->db->insert($this->tbl_lookbook_lang,$dataLang);
		}else{
			$this->db->where("lookbook_id",$lookbook_id);
			$this->db->where("language_id",$lang_id);
			$this->db->update($this->tbl_lookbook_lang,$dataLang);
		}
		
		$this->db->where('language_id',$lang_id);
		$this->db->update($this->tbl_lookbook_lang,$data);
		return 1;
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

}
?>