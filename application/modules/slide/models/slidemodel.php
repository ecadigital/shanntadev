<?php
class Slidemodel extends CI_Model {
	private $tbl_admin_cfg = 'admin_cfg';
	private $tbl_slide = 'slide';
	private $tbl_slide_lang = 'slide_lang';
	
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
	

	/*  SLIDE
	-------------------------------------------------------------------------------------------------------*/

	public function listSlide($targetpage,$page,$limit,$sData=""){
	
		$select = $this->db->select(array(	"$this->tbl_slide.*",
											"$this->tbl_slide_lang.slide_keyhead",
											"$this->tbl_slide_lang.slide_keymessage"))
				->from($this->tbl_slide)
				->join($this->tbl_slide_lang,"$this->tbl_slide.slide_id=$this->tbl_slide_lang.slide_id","left")
				->where("$this->tbl_slide_lang.language_id",$this->defaultlang)
				->order_by("$this->tbl_slide.slide_pin",'desc')
				->order_by("$this->tbl_slide.slide_seq",'desc')
				->order_by("$this->tbl_slide.slide_date_added",'desc')
				->group_by("$this->tbl_slide.slide_id");
				
		if(!empty($sData)){
			$sData = urlDecode($sData);
			$where = "(($this->tbl_slide.slide_name like '%".$sData."%'))";
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
	public function listEditSlide($id){
		
		$select = $this->db->select()
				->from($this->tbl_slide)
				->where('slide_id',$id);
		$query = $this->db->get();
		$result = $query->row_array();
		
		$select = $this->db->select()
				->from($this->tbl_slide_lang)
				->where("slide_id",$id);
		$queryLang = $this->db->get();
		$resultLang = $queryLang->result_array();
		
		foreach($resultLang as $res){
			$result['slide_keyhead'][$res['language_id']] 		= $res['slide_keyhead'];
			$result['slide_keymessage'][$res['language_id']] 		= $res['slide_keymessage'];
		}
		return $result;
	}
	public function addSlide(){
		
		$val = $this->getValue();
		if($val['captcha']=='')
		{
			$slide_id = $this->bflibs->getLastID($this->tbl_slide,'slide_id');
			$slide_seq = $this->bflibs->getLastID($this->tbl_slide,'slide_seq');
			$date = date('Y-m-d H:i:s');
			$slide_publish = (isset($val['slide_publish']))?$val['slide_publish']:0;
			$slide_pin = (isset($val['slide_pin']))?$val['slide_pin']:0;
			$data = array(
					"slide_id"=>$slide_id,
					//"slide_name"=>$val['slide_name'],
					"slide_position"=>$val['slide_position'],
					"slide_date_added"=>$date,
					"slide_last_modified"=>$date,
					"slide_seq"=>$slide_seq,
					"slide_publish"=>1
			);
			$this->db->insert($this->tbl_slide,$data);
			
			foreach($val['slide_keyhead'] as $lang=>$slide_keyhead){
				$dataLang = array(
					"slide_id"=>$slide_id,
					"language_id"=>$lang,
					"slide_keyhead"=>$slide_keyhead,
					"slide_keymessage"=>htmlspecialchars($val['slide_keymessage'][$lang], ENT_QUOTES)
				);
				$this->db->insert($this->tbl_slide_lang,$dataLang);
			}
			return $slide_id;
		}
	}
	public function editSlide(){
		
		$val = $this->getValue();

		if($val['captcha']=='')
		{
			$slide_id = $val["slide_id"];
			$date = date('Y-m-d H:i:s');
			$slide_publish = (isset($val['slide_publish']))?$val['slide_publish']:0;
			$slide_pin = (isset($val['slide_pin']))?$val['slide_pin']:0;
			$data = array(
					"slide_position"=>$val['slide_position'],
					"slide_last_modified"=>$date
			);
			$this->db->where('slide_id',$slide_id);
			$this->db->update($this->tbl_slide,$data);
			
			foreach($val['slide_keyhead'] as $lang=>$slide_keyhead){
				$dataLang = array(
					"slide_keyhead"=>$slide_keyhead,
					"slide_keymessage"=>htmlspecialchars($val['slide_keymessage'][$lang], ENT_QUOTES)
				);
				
				$chkLang = $this->chkLangSlide($slide_id,$lang);
				if($chkLang==0){
					$dataLang["slide_id"]=$slide_id;
					$dataLang["language_id"]=$lang;
					$this->db->insert($this->tbl_slide_lang,$dataLang);
				}else{
					$this->db->where("slide_id",$slide_id);
					$this->db->where("language_id",$lang);
					$this->db->update($this->tbl_slide_lang,$dataLang);
				}
			}
			return $val['slide_id'];
		}
	}
	public function chkLangSlide($slide_id,$lang_id){ 
		$select = $this->db->select()
				->from($this->tbl_slide_lang)
				->where("slide_id",$slide_id)
				->where("language_id",$lang_id);

		return $this->db->count_all_results();
	}
	public function deleteSlide($id){
		
		$select = $this->db->select()
				->from($this->tbl_slide);
		$this->db->where("slide_id",$id);
		$query = $this->db->get();
		$res = $query->row_array();

		if(!empty($res)){
			if($res['slide_file'] != ''){
				$file_name = basename($res['slide_image']);
				$path_thumb = 'public/upload/slide/'.$file_name;
				$file_thumb = DIR_FILE.$path_thumb;
				
				if(file_exists($file_thumb)){
					unlink($file_thumb);
				}
			}
		}
		$this->db->where('slide_id',$id);
		$this->db->delete($this->tbl_slide);
	}
	
	/* UPLOAD
	-----------------------------------------------------------------------------------------------------------*/
	public function clearTmpImages(){
		$this->bflibs->remove_dir(DIR_FILE.'public/upload/'.$this->request->getModuleName().'/temp/'.$this->ip.'/',true);
	}
	public function movefile(){
		$module = $this->request->getModuleName();
		$temp = DIR_FILE.'/public/upload/'.$module.'/temp/';
		if(!file_exists($temp)){mkdir($temp);}
		$path = 'public/upload/'.$module.'/temp/'.$this->ip.'/';
		$dir_file = DIR_FILE.$path;
		
		//$path = 'public/upload/'.$this->request->getModuleName();
		//$dir_file = DIR_FILE.$path;
		if(!file_exists($dir_file)){mkdir($dir_file);}

		$config['upload_path'] = $dir_file;
		$config['allowed_types'] = 'gif|jpg|png|jpeg|tiff|pdf';
		$config['max_size']	= '5120';
		$config['overwrite']  = TRUE;
		$config['file_name'] = "slide_".md5(date('Ymdhis'));
		
		$this->load->library('upload', $config);
		
		if ( ! $this->upload->do_upload('Filedata'))
		{
			$error = array('error' => $this->upload->display_errors("<span>","</span>"));
			echo "";
		}
		else
		{
			$data = $this->upload->data();
			//$this->imagesResize($data['full_path']);
			$path = $path."/".$data['file_name'];
			echo $path;
		}
	}
	public function upload($file,$slide_id)
	{
		if(!empty($file)){
			$dir_file = DIR_FILE.'public/upload/'.$this->request->getModuleName().'/original/';
			if(!file_exists($dir_file)){mkdir($dir_file);}
			
			$ext = $this->bflibs->getExt($file);
			$file_name = 'slide_'.$slide_id."_".md5($key.date("mdhis")).".".$ext;
			$__dest = $dir_file.$file_name;
			$source = DIR_FILE.$file;

			copy($source, $__dest);
			unlink($source);
			//$this->updatePath('public/upload/'.$this->request->getModuleName().'/'.$file_name,$slide_id);
			if($this->imagesResize($__dest))$file = $this->updatePath('public/upload/'.$this->request->getModuleName().'/thumbnails/'.$file_name,$slide_id);

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
		$config['width'] = 300;
		$config['height'] = 300;

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
	public function updatePath($path,$id){
		$this->deletePath($id);
		
		$data = array("slide_image"=>$path);
		$this->db->where('slide_id',$id);
		$this->db->update($this->tbl_slide,$data);
	}
	public function deletePath($id){

		$query = $this->db->select("slide_image")
				->from($this->tbl_slide)
				->where('slide_id',$id);				
		$query = $this->db->get();
		$result = $query->row_array();
		if(!empty($result)){
			$path = DIR_FILE.$result['slide_image'];
			if(file_exists($path)) unlink($path);
		}
	}
	public function delete_image()
	{
		$val = $this->getValue();
		if($val['image_path'] != ''){
			$path = DIR_FILE.$val['image_path'];
			unlink($path);
		}
	}
	/* END UPLOAD
	-----------------------------------------------------------------------------------------------------------*/

}
?>