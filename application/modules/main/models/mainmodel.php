<?php
class Mainmodel extends CI_Model {
	private $tbl_admin_cfg = 'admin_cfg';
	private $tbl_main = 'main';
	
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
	

	/*  MAIN
	-------------------------------------------------------------------------------------------------------*/
	public function listEditMain(){
		
		$select = $this->db->select()
				->from($this->tbl_main)
				->where("main_id",1);		
		$query = $this->db->get();
		$result = $query->row_array();
		return $result;
	}
	public function editMain(){
		
		$val = $this->getValue();

		if($val['captcha']=='')
		{
			$date = date('Y-m-d H:i:s');
			$data["main_last_modified"] = $date;
			
			if(isset($val['main_contact']))					$data["main_contact"]=$val['main_contact'];
			if(isset($val['main_latitude']))				$data["main_latitude"]=$val['main_latitude'];
			if(isset($val['main_longitude']))				$data["main_longitude"]=$val['main_longitude'];
			if(isset($val['main_intro']))					$data["main_intro"]=$val['main_intro'];
			if(isset($val['main_intro_show']))				$data["main_intro_show"]=$val['main_intro_show'];

			$this->db->where('main_id',1);
			$this->db->update($this->tbl_main,$data);
		}
	}

	public function editIntro(){
		
		$val = $this->getValue();

		if($val['captcha']=='')
		{
			$date = date('Y-m-d H:i:s');
			$data["main_last_modified"] = $date;
			
			$data=array();
			$data["main_intro"]=(isset($val['main_intro'])) ? $val["main_intro"] : '';
			$data["main_intro_show"]=(isset($val['main_intro_show'])) ? $val["main_intro_show"] : 0;

			$this->db->where('main_id',1);
			$this->db->update($this->tbl_main,$data);
		}
	}
	
	
	public function editContact(){
		
		$val = $this->getValue();

		if($val['captcha']=='')
		{
			$date = date('Y-m-d H:i:s');
			$data["main_last_modified"] = $date;
			
			$data=array();
			$data["main_email"]=(isset($val['main_email'])) ? $val["main_email"] : '';
			$data["main_tel"]=(isset($val['main_tel'])) ? $val["main_tel"] : '';
			$data["main_facebook"]=(isset($val['main_facebook'])) ? $val["main_facebook"] : '';
			$data["main_twitter"]=(isset($val['main_twitter'])) ? $val["main_twitter"] : '';

			$this->db->where('main_id',1);
			$this->db->update($this->tbl_main,$data);
		}
	}
	
	
	public function listEditMainLang(){
		
		$select = $this->db->select()
				->from($this->tbl_main);
		$queryLang = $this->db->get();
		$resultLang = $queryLang->result_array();
		
		foreach($resultLang as $res){
			$result['main_policy'][$res['language_id']] = $res['main_policy'];
			$result['main_shipping'][$res['language_id']] = $res['main_shipping'];
		}
		
		return $result;
	}
	public function editMainLang($lang_id){
		
		$val = $this->getValue();

		if($val['captcha']=='')
		{
			$date = date('Y-m-d H:i:s');
			$data["main_last_modified"] = $date;
			
			$data= array();
			if(isset($val['main_policy'][$lang_id]))				$data["main_policy"]=$val['main_policy'][$lang_id];
			if(isset($val['main_shipping'][$lang_id]))				$data["main_shipping"]=$val['main_shipping'][$lang_id];

			$this->db->where('language_id',$lang_id);
			$this->db->update($this->tbl_main,$data);
		}
	}
	public function upload_lookbook($file,$lang_id){
	
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
			if($this->imagesResize($__dest,'thumbnails'))$file = $this->updatePath_lookbook('public/upload/'.$this->request->getModuleName().'/thumbnails/'.$file_name,$lang_id);
			unlink($source);
		}
	}
	private function updatePath_lookbook($path,$lang_id){

		$data = array("main_lookbook_path"=>$path);
		$this->db->where('language_id',$lang_id);
		$this->db->update($this->tbl_main,$data);
		return 1;
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
		
		if(!file_exists($dir_file)){mkdir($dir_file);}

		$config['upload_path'] = $dir_file;
		$config['allowed_types'] = 'gif|jpg|png|jpeg|tiff|pdf';
		$config['max_size']	= '5120';
		$config['overwrite']  = TRUE;
		$config['file_name'] = "bank_".md5(date('Ymdhis'));
		
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
			$path = $path.$data['file_name'];
			echo $path;
		}
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
	public function upload($file,$p)
	{
		/*$dir_file = DIR_FILE.'public/upload/'.$this->request->getModuleName().'/';
		echo $source = $dir_file.'temp/'.$file;//$file["name"];
		
		if(move_uploaded_file($file["tmp_name"],$source))
		{
			$ext = $this->bflibs->getExt($source);
			$file_name = 'bank_'.md5(date("mdhis")).".".$ext;
			$__dest = $dir_file.'original/'.$file_name;

			copy($source, $__dest);
			if($this->imagesResize($__dest,'thumbnails'))$file = $this->updatePath('public/upload/'.$this->request->getModuleName().'/thumbnails/'.$file_name);
			unlink($source);
		}*/
		
		if(!empty($file)){
			$dir_file = DIR_FILE.'public/upload/'.$this->request->getModuleName().'/original/';
			if(!file_exists($dir_file)){mkdir($dir_file);}
			
			$ext = $this->bflibs->getExt($file);
			$file_name = 'bank_'.md5(date("mdhis")).".".$ext;
			$__dest = $dir_file.$file_name;
			$source = DIR_FILE.$file;

			copy($source, $__dest);
			unlink($source);
			//$this->updatePath('public/upload/'.$this->request->getModuleName().'/'.$file_name,$slide_id);
			if($this->imagesResize($__dest))$file = $this->updatePath('public/upload/'.$this->request->getModuleName().'/thumbnails/'.$file_name,$p);

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
	public function updatePath($path,$p=''){
		$this->deletePath($p);
		
		if($p==9)			$field="main_bank_path";
		else if($p==10)	$field="main_howto_payment";
		
		$data = array($field=>$path);
		$this->db->where('main_id',1);
		$this->db->update($this->tbl_main,$data);
	}
	public function deletePath($p=''){

		if($p==9)			$field="main_bank_path";
		else if($p==10)	$field="main_howto_payment";
		
		$query = $this->db->select($field)
				->from($this->tbl_main)
				->where('main_id',1);				
		$query = $this->db->get();
		$result = $query->row_array();
		if(!empty($result)){
			$path = DIR_FILE.$result[$field];
			if(file_exists($path)) unlink($path);
		}
	}
	public function delete_image()
	{
		$val = $this->getValue();
		
		if($val['p']==9)			$field="main_bank_path";
		else if($val['p']==10)	$field="main_howto_payment";
		
		if($val[$field] != ''){
			$path = DIR_FILE.$val[$field];
			unlink($path);
		}
	}
	/* END UPLOAD
	-----------------------------------------------------------------------------------------------------------*/
}
?>