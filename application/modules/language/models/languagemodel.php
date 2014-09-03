<?php
class Languagemodel extends CI_Model {
	private $value;
	private $tbl_admin_language = 'admin_language';
	
	public function setValue($val){
		$this->value = $val;
	}
	
	private function getValue(){
		return $this->value;
	}

	public function listLanguage()
	{
		$query = $this->db->select()
				->from($this->tbl_admin_language)
				->order_by("language_seq","asc");
		$query = $this->db->get();
		$result = $query->result_array();
		return $result;
	}
	public function listEdit($id)
	{
		$query = $this->db->select()
				->from($this->tbl_admin_language)
				->where('language_id',$id);
		$query = $this->db->get();
		$result = $query->row_array();
		return $result;
	}
	public function listLanguageFront()
	{
		$query = $this->db->select(array("language_id","language_name","language_icon"))
				->from($this->tbl_admin_language)
				->order_by("language_seq","asc");
		$query = $this->db->get();
		$result = $query->result_array();
		return $result;
	}
	public function add()
	{
		$val = $this->getValue();
		if($val['captcha']=='')
		{
			$language_id = $this->bflibs->getLastID($this->tbl_admin_language,'language_id');
			$language_seq = $this->bflibs->getLastID($this->tbl_admin_language,'language_seq');
			$data = array("language_id"=>$language_id,
					"language_alias"=>$val['language_alias'],
					"language_name"=>$val['language_name'],
					"language_desc"=>$val['language_desc'],
					"language_seq"=>$language_seq,
			);
			$this->db->insert($this->tbl_admin_language,$data);
			return $language_id;
		}
	}
	public function edit()
	{
		$val = $this->getValue();
		if($val['captcha']=='')
		{
			$data = array("language_name"=>$val['language_name'],
					"language_alias"=>$val['language_alias'],
					"language_desc"=>$val['language_desc']
			);
			$this->db->where('language_id',$val['language_id']);
			$this->db->update($this->tbl_admin_language,$data);
		}
	}
	public function upMenu($id,$seq)
	{
		$query = $this->db->select()
				->from($this->tbl_admin_language)
				->where("language_seq <",$seq)
				->order_by("language_seq","desc");
		$query = $this->db->get();
		$newer = $query->row_array();
		if(!empty($newer))
		{
			$oldSeq = array("language_seq"=>$seq);
			$newSeq = array("language_seq"=>$newer["language_seq"]);
		
			if($newer!=null)
			{
				$this->db->where('language_id',$id);
				$this->db->update($this->tbl_admin_language,$newSeq);
				$this->db->where('language_id',$newer["language_id"]);
				$this->db->update($this->tbl_admin_language,$oldSeq);
			}
		}
	}
	public function downMenu($id,$seq)
	{
		$query = $this->db->select()
				->from($this->tbl_admin_language)
				->where("language_seq >",$seq)
				->order_by("language_seq","asc");
		$query = $this->db->get();
		$newer = $query->row_array();
		if(!empty($newer))
		{
			$oldSeq = array("language_seq"=>$seq);
			$newSeq = array("language_seq"=>$newer["language_seq"]);
		
			if($newer!=null)
			{
				$this->db->where('language_id',$id);
				$this->db->update($this->tbl_admin_language,$newSeq);
				$this->db->where('language_id',$newer["language_id"]);
				$this->db->update($this->tbl_admin_language,$oldSeq);
			}
		}
	}
	public function delete($id,$default)
	{
		if($default!=1)
		{
			$this->delete_image($id);
			$this->db->where('language_id',$id);
			$this->db->delete($this->tbl_admin_language);
		}
	}
	public function defaultadmin($id)
	{
		$query = $this->db->select('language_id')
				->from($this->tbl_admin_language)
				->where("language_admin",'1');
		$query = $this->db->get();
		$result = $query->row_array();
		if($result['language_id'] != $id)
		{
			$dataOld = array("language_admin"=>0);
			$this->db->where('language_id',$result['language_id']);
			$this->db->update($this->tbl_admin_language,$dataOld);
			
			$dataNew = array("language_admin"=>1);
			$this->db->where('language_id',$id);
			$this->db->update($this->tbl_admin_language,$dataNew);
		}
	}
	public function defaultfront($id)
	{
		$query = $this->db->select('language_id')
				->from($this->tbl_admin_language)
				->where("language_front",'1');
		$query = $this->db->get();
		$result = $query->row_array();
		if($result['language_id'] != $id)
		{
			$dataOld = array("language_front"=>0);
			$this->db->where('language_id',$result['language_id']);
			$this->db->update($this->tbl_admin_language,$dataOld);
			
			$dataNew = array("language_front"=>1);
			$this->db->where('language_id',$id);
			$this->db->update($this->tbl_admin_language,$dataNew);
		}
	}
	public function upload($id)
	{
		$path = 'public/upload/'.$this->request->getModuleName().'/';
		$config['upload_path'] = DIR_FILE.$path;
		$config['allowed_types'] = 'gif|jpg|png';
		$config['max_size']	= '1024';
		$config['max_width']  = '48';
		$config['max_height']  = '48';
		$config['overwrite']  = TRUE;
		$config['file_name'] = "lang_".$id;
		
		$this->load->library('upload', $config);
	
		if ( ! $this->upload->do_upload())
		{
			$error = array('error' => $this->upload->display_errors());
			return array(false,$error);
		}
		else
		{
			$data = $this->upload->data();
			if($this->imagesResize($path.$data['file_name']))$this->updatepath('public/upload/'.$this->request->getModuleName().'/thumbnails/'.$data['file_name'],$id);
			return array(true,$path.$data['file_name']);
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
		$config['width'] = 16;
		$config['height'] = 16;

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
	private function updatepath($path,$language_id)
	{
		if($path != '')
		{
			$data = array("language_icon"=>$path);
			$this->db->where('language_id',$language_id);
			$this->db->update($this->tbl_admin_language,$data);
		}
	}
	public function delete_image($id)
	{
		$query = $this->db->select('language_icon')
				->from($this->tbl_admin_language)
				->where('language_id',$id);
		$query = $this->db->get();
		$result = $query->row_array();
	
		if($result['language_icon'] != ''){
			
			$path = DIR_FILE.$result['language_icon'];
			unlink($path);
		}
		
		$data = array("language_icon"=>"");
		$this->db->where('language_id',$id);
		$this->db->update($this->tbl_admin_language,$data);
	}
}
?>