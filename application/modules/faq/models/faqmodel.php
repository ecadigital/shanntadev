<?php
class Faqmodel extends CI_Model {
	private $tbl_admin_cfg = 'admin_cfg';
	private $tbl_faq = 'faq';
	private $tbl_faq_lang = 'faq_lang';
	private $tbl_faq_images = 'faq_images';
	
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

	public function listFaq($targetpage,$page,$limit,$sData=""){
	
		$select = $this->db->select(array(
						"$this->tbl_faq.faq_id",
						"$this->tbl_faq.faq_last_modified",
						"$this->tbl_faq.faq_publish",
						"$this->tbl_faq.faq_seq",
						"$this->tbl_faq.faq_pin",
						"$this->tbl_faq_lang.faq_question",
						"$this->tbl_faq_lang.faq_answer"))
				->from($this->tbl_faq)
				->join($this->tbl_faq_lang,"$this->tbl_faq.faq_id=$this->tbl_faq_lang.faq_id","left")
				->where("$this->tbl_faq_lang.language_id",$this->defaultlang)
				->order_by("$this->tbl_faq.faq_pin",'desc')
				->order_by("$this->tbl_faq.faq_seq",'desc')
				->order_by("$this->tbl_faq.faq_date_added",'desc')
				->group_by("$this->tbl_faq.faq_id");
				
		if(!empty($sData)){
			$sData = urlDecode($sData);
			$where = "(($this->tbl_faq_lang.faq_question like '%".$sData."%') or ($this->tbl_faq_lang.faq_answer like '%".$sData."%'))";
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
	public function listEditFaq($id,$member_id=''){
		
		$select = $this->db->select()
				->from($this->tbl_faq)
				->where("faq_id",$id);		
		$query = $this->db->get();
		$result = $query->row_array();
		
		$select = $this->db->select()
				->from($this->tbl_faq_lang)
				->where("faq_id",$id);
		$queryLang = $this->db->get();
		$resultLang = $queryLang->result_array();
		
		foreach($resultLang as $res){
			$result['faq_question'][$res['language_id']] = $res['faq_question'];
			$result['faq_answer'][$res['language_id']] = $res['faq_answer'];
		}
		
		return $result;
	}
	public function addFaq(){
		
		$val = $this->getValue();
		if($val['captcha']=='')
		{
			$faq_id = $this->bflibs->getLastID($this->tbl_faq,'faq_id');
			$faq_seq = $this->bflibs->getLastID($this->tbl_faq,'faq_seq');
			$date = date('Y-m-d H:i:s');
			//$faq_publish = (isset($val['faq_publish']))?$val['faq_publish']:0;
			//$faq_pin = (isset($val['faq_pin']))?$val['faq_pin']:0;
			$data = array(
					"faq_id"=>$faq_id,
					//"faq_question"=>$val['faq_question'],
					//"faq_answer"=>htmlspecialchars($val['faq_answer'], ENT_QUOTES),
					"faq_date_added"=>$date,
					"faq_last_modified"=>$date,
					"faq_seq"=>$faq_seq,
					"faq_publish"=>1
			);
			$this->db->insert($this->tbl_faq,$data);
			
			foreach($val['faq_question'] as $lang=>$faq_question){
				$dataLang = array(
					"faq_id"=>$faq_id,
					"language_id"=>$lang,
					"faq_question"=>$faq_question,
					"faq_answer"=>htmlspecialchars($val['faq_answer'][$lang], ENT_QUOTES)
				);
				$this->db->insert($this->tbl_faq_lang,$dataLang);
			}		
			return $faq_id;
		}
	}
	public function editFaq(){
		
		$val = $this->getValue();

		if($val['captcha']=='')
		{
			$faq_id = $val["faq_id"];
			$date = date('Y-m-d H:i:s');
			$data = array(
					//"faq_question"=>$val['faq_question'],
					//"faq_answer"=>htmlspecialchars($val['faq_answer'], ENT_QUOTES),
					"faq_last_modified"=>$date
			);

			$this->db->where('faq_id',$faq_id);
			$this->db->update($this->tbl_faq,$data);
			
			foreach($val['faq_question'] as $lang=>$faq_question){
				$dataLang = array(
					"faq_question"=>$faq_question,
					"faq_answer"=>htmlspecialchars($val['faq_answer'][$lang], ENT_QUOTES)
				);
				
				$chkLang = $this->chkLang($val["faq_id"],$lang);
				if($chkLang==0){
					$dataLang["faq_id"]=$val["faq_id"];
					$dataLang["language_id"]=$lang;
					$this->db->insert($this->tbl_faq_lang,$dataLang);
				}else{
					$this->db->where("faq_id",$val["faq_id"]);
					$this->db->where("language_id",$lang);
					$this->db->update($this->tbl_faq_lang,$dataLang);
				}
			}
			return $val['faq_id'];
		}
	}
	public function deleteFaq($id){
		
		$select = $this->db->select()
				->from($this->tbl_faq_images);
		if($member_id!=''){
			$this->db	->join($this->tbl_faq,"$this->tbl_faq.faq_id=$this->tbl_faq_images.faq_id","left")
							->where("$this->tbl_faq.member_id",$member_id);
		}
		$this->db->where("$this->tbl_faq_images.faq_id",$id);
		$query = $this->db->get();
		$result = $query->result_array();

		if(!empty($result)){
			foreach($result as $res){
				if($res['faq_images_path'] != ''){
					$file_name = basename($res['faq_images_path']);
					$path_thumb = 'public/upload/faq/thumbnails/'.$file_name;
					$path_origin = 'public/upload/faq/original/'.$file_name;
					
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
		$this->db->where('faq_id',$id);
		$this->db->delete($this->tbl_faq);
		$this->db->where('faq_id',$id);
		$this->db->delete($this->tbl_faq_lang);
		$this->db->where('faq_id',$id);
		$this->db->delete($this->tbl_faq_images);
	}
	public function getFirstFaqImage($faq_id){
		
		$select = $this->db	->select(array("faq_images_id","faq_images_path"))
									->from($this->tbl_faq_images)
									->where("faq_id",$faq_id)
									->order_by("faq_images_seq","asc");
		$query = $this->db->get();
		$query_images = $query->row_array();
		$result['faq_images'] = (empty($query_images)) ? '' : $query_images['faq_images_path'];
		return $result['faq_images'];
	}
	
	public function chkLang($faq_id,$lang_id){ 
		$select = $this->db->select()
				->from($this->tbl_faq_lang)
				->where("faq_id",$faq_id)
				->where("language_id",$lang_id);

		return $this->db->count_all_results();
	}
	
	
	

}
?>