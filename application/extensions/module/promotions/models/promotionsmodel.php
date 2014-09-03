<?php
class Promotionsmodel extends CI_Model {
	private $tbl_promotions = 'promotions';
	private $tbl_promotions_lang = 'promotions_lang';
	private $defaultlang;
	
	public function setValue($val){
		$this->value = $val;
	}
	
	private function getValue(){
		return $this->value;
	}
	
	public function __construct(){
	
        parent::__construct();
        $this->defaultlang = $this->bflibs->getDefaultLangId();
	}
	
	/* Backend
	-----------------------------------------------------------------------------------------------------------*/
	public function listPromotions($targetpage,$page,$limit,$sData=""){

		$query = $this->db->select("$this->tbl_promotions.promotions_id,$this->tbl_promotions_lang.promotions_name,$this->tbl_promotions.promotions_create_date,
				$this->tbl_promotions.promotions_publish,$this->tbl_promotions.promotions_seq")
				->from($this->tbl_promotions)
				->join($this->tbl_promotions_lang,"$this->tbl_promotions.promotions_id=$this->tbl_promotions_lang.promotions_id")
				->where("$this->tbl_promotions_lang.language_id",$this->defaultlang)
				->order_by("$this->tbl_promotions.promotions_seq","desc");
				
		if(!empty($sData)){
			$sData = urlDecode($sData);
			$where = "(($this->tbl_promotions_lang.promotions_name like '%".$sData."%'))";
			$this->db->where($where);
		}
		$this->db->get();
		$config['query'] = $this->db->last_query();
		$config['targetpage'] = $targetpage;
		$config['target'] = '#contenttab-2';
		$config['limit'] = $limit;
		$config['page'] = $page;
		
		$this->load->library('bfpagination', $config);
		return list($paginaion,$page_description,$result) = $this->bfpagination->do_pagination();
	}
	public function listEditPromotions($id){
		
		$select = $this->db->select(array("promotions_id","promotions_publish"))
				->from($this->tbl_promotions)
				->where("promotions_id",$id);
		$query = $this->db->get();
		$result = $query->row_array();
		
		$select = $this->db->select()
				->from($this->tbl_promotions_lang)
				->where("promotions_id",$id);
		$queryLang = $this->db->get();
		$resultLang = $queryLang->result_array();
		
		foreach($resultLang as $res){
			$result['promotions_name'][$res['language_id']] = $res['promotions_name'];
			$result['promotions_detail'][$res['language_id']] = $res['promotions_detail'];
			$result['promotions_image'][$res['language_id']] = $res['promotions_image'];
		}
		return $result;
	}
	
	public function addPromotions(){
		
		$val = $this->getValue();
		if($val['captcha']=='')
		{
			$success1=true;
			$success2=true;
			$detail = array();
			$detail1='';
			$detail2='';
			$promotions_id = $this->bflibs->getLastID($this->tbl_promotions,'promotions_id');
			$promotions_seq = $this->bflibs->getLastID($this->tbl_promotions,'promotions_seq');

			if($_FILES['userfile1']['name']!="" || $_FILES['userfile2']['name']!=""){
				if($_FILES['userfile1']['name']!=""){
					list($success1,$detail1) = $this->model->upload($promotions_id.'-1','userfile1');
				}
				if($_FILES['userfile2']['name']!=""){
					list($success2,$detail2) = $this->model->upload($promotions_id.'-2','userfile2');
				}
				$detail = $this->bflibs->MergeArrays($detail1,$detail1);
			}
			if($success1 && $success2){
				$data = array(
						"promotions_id"=>$promotions_id,
						"promotions_publish"=>$val['promotions_publish'],
						"promotions_seq"=>$promotions_seq
				);
				$this->db->insert($this->tbl_promotions,$data);
				foreach($val['promotions_name'] as $lang=>$promotions_name){
					$dataLang = array(
						"promotions_id"=>$promotions_id,
						"language_id"=>$lang,
						"promotions_name"=>$promotions_name,
						"promotions_detail"=>$val['promotions_detail'][$lang]
					);
					$this->db->insert($this->tbl_promotions_lang,$dataLang);
				}
				if(!empty($detail1)){
					$this->model->updatePath($detail1,$promotions_id,1);
				}
				if(!empty($detail2)){
					$this->model->updatePath($detail2,$promotions_id,2);
				}
				
				return array(true,$detail);
			}else{
				return array(false,$detail);
			}
		}
	}
	
	public function editPromotions(){
		
		$val = $this->getValue();
		if($val['captcha']=='')
		{
			$success1=true;
			$success2=true;
			$detail = array();
			$detail1='';
			$detail2='';
			$promotions_id = $val['promotions_id'];

			if($_FILES['userfile1']['name']!="" || $_FILES['userfile2']['name']!=""){
				if($_FILES['userfile1']['name']!=""){
					list($success1,$detail1) = $this->model->upload($promotions_id.'-1','userfile1');
				}
				if($_FILES['userfile2']['name']!=""){
					list($success2,$detail2) = $this->model->upload($promotions_id.'-2','userfile2');
				}
				$detail = $this->bflibs->MergeArrays($detail1,$detail1);
			}
			
			if($success1 && $success2){
				$data = array(
						"promotions_publish"=>$val['promotions_publish']
				);
				$this->db->where('promotions_id',$promotions_id);
				$this->db->update($this->tbl_promotions,$data);
				foreach($val['promotions_name'] as $lang=>$promotions_name){
					$dataLang = array(
						"promotions_name"=>$promotions_name,
						"promotions_detail"=>$val['promotions_detail'][$lang]
					);
					$this->db->where('promotions_id',$promotions_id);
					$this->db->where('language_id',$lang);
					$this->db->update($this->tbl_promotions_lang,$dataLang);
				}
				if(!empty($detail1)){
					$this->model->updatePath($detail1,$promotions_id,1);
				}
				if(!empty($detail2)){
					$this->model->updatePath($detail2,$promotions_id,2);
				}
				
				return array(true,$detail);
			}else{
				return array(false,$detail);
			}
		}
	}
	
	public function deletePromotions($id)
	{
		$listAllLang = $this->bflibs->listAllLang();
		foreach($listAllLang as $lang){
			$this->delete_image($id,$lang['language_id']);
		}
		$this->db->where('promotions_id',$id);
		$this->db->delete($this->tbl_promotions);
		$this->db->where('promotions_id',$id);
		$this->db->delete($this->tbl_promotions_lang);
	}
	public function delete_image($id,$lang){
	
		$query = $this->db->select('promotions_image')
				->from($this->tbl_promotions_lang)
				->where('promotions_id',$id)
				->where('language_id',$lang);
		$query = $this->db->get();
		$result = $query->row_array();
	
		if($result['promotions_image'] != ''){
			
			$path = DIR_FILE.$result['promotions_image'];
			unlink($path);
		}
		
		$data = array("promotions_image"=>"");
		$this->db->where('promotions_id',$id);
		$this->db->where('language_id',$lang);
		$this->db->update($this->tbl_promotions_lang,$data);
	}
	/* Frontend
	-----------------------------------------------------------------------------------------------------------*/
	public function listPromotionsFront($targetpage,$page,$limit,$sData="")
	{
		$query = $this->db->select(array("$this->tbl_promotions.promotions_id","$this->tbl_promotions_lang.promotions_name","$this->tbl_promotions_lang.promotions_image"))
				->from($this->tbl_promotions)
				->join($this->tbl_promotions_lang,"$this->tbl_promotions.promotions_id=$this->tbl_promotions_lang.promotions_id")
				->where("$this->tbl_promotions_lang.language_id",$this->defaultlang)
				->where("$this->tbl_promotions.promotions_publish",1)
				->order_by("$this->tbl_promotions.promotions_seq","desc");
				
		if(!empty($sData)){
			$sData = urlDecode($sData);
			$where = "(($this->tbl_promotions_lang.promotions_name like '%".$sData."%'))";
			$this->db->where($where);
		}
		$this->db->get();
		$config['query'] = $this->db->last_query();
		$config['targetpage'] = $targetpage;
		$config['target'] = '#boxContent';
		$config['limit'] = $limit;
		$config['page'] = $page;
		$config['loadpage'] = 'normal';
		
		$this->load->library('bfpagination', $config);
		return list($paginaion,$page_description,$result) = $this->bfpagination->do_pagination();
	}
	public function listDetailPromotions($id){
		
		$query = $this->db->select(array("$this->tbl_promotions_lang.promotions_name","$this->tbl_promotions_lang.promotions_detail","$this->tbl_promotions_lang.promotions_image"))
				->from($this->tbl_promotions)
				->join($this->tbl_promotions_lang,"$this->tbl_promotions.promotions_id=$this->tbl_promotions_lang.promotions_id")
				->where("$this->tbl_promotions_lang.language_id",$this->defaultlang)
				->where("$this->tbl_promotions.promotions_id",$id);
		$query = $this->db->get();
		$result = $query->row_array();
		
		return $result;
	}
	
	/* UPLOAD
	-----------------------------------------------------------------------------------------------------------*/
	public function upload($id,$field_name)
	{
		$path = 'public/upload/'.$this->request->getModuleName().'/original/';
		$dir_file = DIR_FILE.$path;
		if(!file_exists($dir_file)){mkdir($dir_file);}
	
		$config['upload_path'] = $dir_file;
		$config['allowed_types'] = 'gif|jpg|png';
		$config['max_size']	= '1024';
		$config['overwrite']  = TRUE;
		$config['file_name'] = "promotion_".$id."D".md5(date("mdhis"));
		
		$this->load->library('upload', $config);
		$this->upload->initialize($config);
	
		if ( ! $this->upload->do_upload($field_name))
		{
			$error = array('error' => $this->upload->display_errors('<span>','</span>'));
			return array(false,$error);
		}
		else
		{
			$data = $this->upload->data();
			$this->imagesResize($data['full_path']);
			return array(true,$path.$data['file_name']);
		}
		
	}
	private function imagesResize($pathImages)
	{
		$config['image_library'] = 'gd2';
		$config['source_image'] = $pathImages;
		$config['create_thumb'] = FALSE;
		$config['maintain_ratio'] = TRUE;
		$config['width'] = 700;
		$config['height'] = 700;

		$this->load->library('image_lib');
		$this->image_lib->initialize($config);
		if ( ! $this->image_lib->resize())
		{
			$error = $this->image_lib->display_errors();
		}
		$this->image_lib->clear();
	}
	public function updatePath($path,$id,$lang){
	
		$val = $this->getValue();
		if(isset($val["image_path"])){
			$oldext = $this->bflibs->getExt($val["image_path"]);
			$ext = $this->bflibs->getExt($path);
			// กรณีที่นามสกุลเก่าและ นามสกุลไฟล์ที่อัพเข้ามาไม่เหมือนกันจะทำการลบไฟล์เดิมทิ้ง
			if($oldext != $ext){
				$pathImage = DIR_FILE.$val["image_path"];
				unlink($pathImage);
			}
		}
		$data = array("promotions_image"=>$path);
		$this->db->where('promotions_id',$id);
		$this->db->where('language_id',$lang);
		$this->db->update($this->tbl_promotions_lang,$data);
	}
}
?>