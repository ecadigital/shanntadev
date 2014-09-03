<?php
class Adminmodel extends CI_Model {
	private $tbl_admin_cfg = 'admin_cfg';
	private $tbl_admin = "admin";
	private $tbl_admin_group = "admin_group";
	private $tbl_admin_language = "admin_language";
	private $tbl_admin_useronline = "admin_useronline";
	
	public function setValue($val){
		$this->value = $val;
	}
	
	private function getValue(){
		return $this->value;
	}
	
	public function __construct(){
	
        parent::__construct();
        $admin = $this->session->userdata('admin');
		@$this->admin_id = $admin->admin_id;
		@$this->admin_group_id = $admin->admin_group;
	}
	
	/* SETTING
	------------------------------------------------------------------------------------------------------------*/
	public function listEditSetting(){
		
		$select = $this->db->select()
				->from($this->tbl_admin_cfg)
				->where('admin_cfg_status','1');
		$query = $this->db->get();
		$result = $query->result_array();
		return $result;
	}
	
	public function editSetting(){
		
		$val = $this->getValue();
		if($val['captcha']=='')
		{
			foreach($val['cfg'] as $id=>$cfg){
				$data = array("admin_cfg_value"=>$cfg);
				$this->db->where('admin_cfg_id',$id);
				$this->db->update($this->tbl_admin_cfg,$data);
			}
		}
	}
	
	/* ADMIN
	------------------------------------------------------------------------------------------------------------*/
	public function checkLogin()
	{
		$val = $this->getValue();
		$where = "($this->tbl_admin.admin_user='".$val['username']."' OR $this->tbl_admin.admin_email='".$val['username']."')";
		$select = $this->db->select(array("$this->tbl_admin.admin_id","$this->tbl_admin.admin_user","$this->tbl_admin.admin_image","$this->tbl_admin.admin_group_id","$this->tbl_admin_language.language_id","$this->tbl_admin_language.language_name","$this->tbl_admin_language.language_id"))
				->from($this->tbl_admin)
				->join($this->tbl_admin_language,"$this->tbl_admin.admin_language=$this->tbl_admin_language.language_id","left")
				->where($where)
				->where("$this->tbl_admin.admin_pass",md5($val['password']))
				->where("$this->tbl_admin.admin_block",1);
		
		$query = $this->db->get();
		$num_rows = $query->num_rows();
		
		return (!empty($num_rows))? $query->row_array():'';
	}
	public function chk_update($chk)
	{
		$this->load->helper('file');
		$path = './public/tmp/update/'.$chk.'.txt';
		$lastUpdate = read_file($path);
		$now = date('dmY');
		$set_uri = 'http://'.$_SERVER['HTTP_HOST'].DIR_ROOT.'admin/admin/dashboard/layout/ajax';
		
		if($now !=$lastUpdate)
		{
			$this->clear_cache($set_uri);
			write_file($path, $now, 'w+');
		}
	}
	function clear_cache($set_uri = NULL){
		$filepath = realpath(APPPATH).'/cache/'.md5($set_uri);
		if(file_exists($filepath))
		{
			@unlink($filepath);
		} else {
			return FALSE;
		}
	}

	public function listEdit($id)
	{
		$query = $this->db->select()
				->from($this->tbl_admin)
				->where('admin_id',$id);
		$query = $this->db->get();
		$result = $query->row_array();
		return $result;
	}
	public function getCurrent($id)
	{
		$query = $this->db->select(array("admin_user","admin_image"))
				->from($this->tbl_admin)
				->where('admin_id',$id);
		$query = $this->db->get();
		$result = $query->row_array();
		return $result;
	}
	public function editProfile()
	{
		$val = $this->getValue();
		$data = array();
		$data['admin_name'] = $val['admin_name'];
		$data['admin_email'] = $val['admin_email'];
		if($val['admin_pass']!='' && $val['admin_pass_cf']!='')
		{
			$data['admin_pass'] = md5($val['admin_pass']);
		}
		//$admin_language = ($val['admin_language']==0)?$this->adminLangID():$val['admin_language'];
		//$language_name = ($val['admin_language']==0)?$this->adminLang():$this->adminLangName($val['admin_language']);
		//$data['admin_language'] = $admin_language;
		//$this->bflibs->updateSession('admin','admin_lang_id',$admin_language);
		//$this->bflibs->updateSession('admin','admin_language',$language_name);
		$this->bflibs->updateSession('admin','admin_name',$val['admin_name']);
		$this->db->where('admin_id',$val['admin_id']);
		$this->db->update($this->tbl_admin,$data);
		return $val['admin_id'];
	}
	public function updatePath($path,$id){
	
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
		$data = array("admin_image"=>$path);
		$this->db->where('admin_id',$id);
		$this->db->update($this->tbl_admin,$data);
	}
	public function delete_image($id)
	{
		$query = $this->db->select('admin_image')
				->from($this->tbl_admin)
				->where('admin_id',$id);
		$query = $this->db->get();
		$result = $query->row_array();
	
		if($result['admin_image'] != ''){
			
			$path = DIR_FILE.$result['admin_image'];
			unlink($path);
		}
		
		$data = array("admin_image"=>"");
		$this->db->where('admin_id',$id);
		$this->db->update($this->tbl_admin,$data);
	}
	public function listEditConfig(){
	
		$path = './application/modules/admin/views/admin/config';
		return $this->read_xml('ga',$path);
	}
	public function addConfig(){
	
		$val = $this->getValue();
		$path = './application/modules/admin/views/admin/config';
		$data['google']['ga'] = array("ga_enable"=>$val['ga_enable'],
				"ga_username"=>$val['ga_username'],
				"ga_password"=>$val['ga_password'],
				"ga_site_id"=>$val['ga_site_id']
		);
		$set_uri = 'http://'.$_SERVER['HTTP_HOST'].DIR_ROOT.'admin/admin/dashboard/layout/ajax';
		$this->clear_cache($set_uri);
		$this->write_xml($path, $data);
	}
	public function read_xml($chk, $path)
	{
		$this->load->library('xml');
		if ($this->xml->load($path))
		{
			$arrayXml = $this->xml->parse();
		  	foreach($arrayXml as $xml)
		  	{
			  	foreach($xml as $key=>$node)
			  	{
			  		if($key==$chk)
				  	{
					  	return $node;
				  	}
				  	return false;
			  	}
		  	}
		}
	}
	
	public function write_xml($path, $data)
	{
		$this->load->library('xml');
		
		if ($this->xml->load($path))
		{
			$arrayXml = $this->xml->parse();
			$newArr = $this->bflibs->MergeArrays($arrayXml, $data);
			$xmlStr = '<?xml version="1.0" encoding="UTF-8"?>'."\r\n";
			foreach($newArr as $keyParent=>$xml){
				$xmlStr.='<'.$keyParent.'>'."\r\n";
				foreach($xml as $key=>$node)
			  	{
			  		$xmlStr.='<'.$key.'>'."\r\n";
				  	foreach($node as $k=>$val)
				  	{
				  		$xmlStr.='<'.$k.'>';
				  		$xmlStr.=$val;
				  		$xmlStr.='</'.$k.'>'."\r\n";
				  	}
			  		$xmlStr.='</'.$key.'>'."\r\n";
			  	}
			  	$xmlStr.='</'.$keyParent.'>'."\r\n";
			}
			$this->load->helper('file');
			$path = './application/modules/admin/views/admin/config.xml';
			write_file($path, $xmlStr, 'w+');
		}
	}
	
	/* USER
	------------------------------------------------------------------------------------*/
	public function listAllUser($admin_group_id=2)
	{
		$admin= $this->session->userdata('admin');
		$query = $this->db->select()
				->from($this->tbl_admin)
				->order_by("admin_seq","asc")
				->where("admin_group_id >=",$admin_group_id);//$admin->admin_group);

		$query = $this->db->get();
		$result = $query->result_array();
		return $result;
	}
	public function add()
	{
		$val = $this->getValue();
		$admin_id = $this->bflibs->getLastID($this->tbl_admin,'admin_id');
		$admin_seq = $this->bflibs->getLastID($this->tbl_admin,'admin_seq');
		$defaultLang = $this->adminLangID();
		
		$data = array("admin_id"=>$admin_id,
				"admin_name"=>$val['admin_name'],
				"admin_user"=>$val['admin_user'],
				"admin_email"=>$val['admin_email'],
				"admin_pass"=>md5($val['admin_pass']),
				"admin_group_id"=>$val['admin_group_id'],
				"admin_block "=>1,//$val['admin_block'],
				"admin_language "=>$defaultLang,
				"admin_seq"=>$admin_seq,
		);
		$this->db->insert($this->tbl_admin,$data);
	}
	public function adminLangID()
	{
		$query = $this->db->select("language_id")
					->from($this->tbl_admin_language)
					->where("language_admin",1);
		$query = $this->db->get();
		$result = $query->row_array();
		return $result['language_id'];
	}
	public function adminLang()
	{
		$query = $this->db->select("language_name")
					->from($this->tbl_admin_language)
					->where("language_admin",1);
		$query = $this->db->get();
		$result = $query->row_array();
		return $result['language_name'];
	}
	public function adminLangName($language_id)
	{
		$query = $this->db->select("language_name")
					->from($this->tbl_admin_language)
					->where("language_id",$language_id);
		$query = $this->db->get();
		$result = $query->row_array();
		return $result['language_name'];
	}
	public function edit()
	{
		$val = $this->getValue();
		$data = array(
				"admin_name"=>$val['admin_name'],
				"admin_user"=>$val['admin_user'],
				"admin_email"=>$val['admin_email'],
				"admin_group_id"=>$val['admin_group_id']/*,
				"admin_block "=>$val['admin_block']*/
		);
		if($val['admin_new_pass']!='' && $val['admin_con_pass']!='')
		{
			$data['admin_pass'] = md5($val['admin_new_pass']);
		}
		$this->db->where('admin_id',$val['admin_id']);
		$this->db->update($this->tbl_admin,$data);
		return $val['admin_id'];
	}
	public function delete($ids)
	{
		if(!empty($ids)){
			$ids = explode(',',$ids);
			foreach($ids as $id){
				$query = $this->db->select('admin_image')
						->from($this->tbl_admin)
						->where('admin_id',$id);
				$query = $this->db->get();
				$result = $query->row_array();
			
				if($result['admin_image'] != ''){
					
					$path = DIR_FILE.$result['admin_image'];
					unlink($path);
				}
				
				$this->db->where('admin_id',$id);
				$this->db->delete($this->tbl_admin);
			}
		}
	}
	public function publish($id,$status)
	{
		$data = array("admin_block"=>2-($status+1));
		$this->db->where('admin_id',$id);
		$this->db->update($this->tbl_admin,$data);
	}
	
	public function chkUserName($username,$id)
	{
		$query = $this->db->select('admin_user')
				->from($this->tbl_admin)
				->where('admin_user',$username);
		if($id!='')
		{
			$this->db->where('admin_id !=',$id);
		}
		$query = $this->db->get();
		$result = $query->row_array();
		return (!empty($result))?'false':'true';
	}
	public function chkEmail($email,$id)
	{
		$query = $this->db->select('admin_user')
				->from($this->tbl_admin)
				->where('admin_email',$email);
		if($id!='')
		{
			$this->db->where('admin_id !=',$id);
		}
		$query = $this->db->get();
		$result = $query->row_array();
		return (!empty($result))?'false':'true';
	}
	public function chkPassword($pass,$id)
	{
		$query = $this->db->select('admin_user')
				->from($this->tbl_admin)
				->where('admin_id',$id)
				->where('admin_pass',md5($pass));
		$query = $this->db->get();
		$result = $query->row_array();
		return (!empty($result))?'true':'false';
	}
	/* GROUP
	------------------------------------------------------------------------------------*/	
	public function listGroupUser()
	{
		$query = $this->db->select()
				->from($this->tbl_admin_group)
				->where('admin_group_id !=',1)
				->order_by("admin_group_seq","asc");
		$query = $this->db->get();
		$result = $query->result_array();
		return $result;
	}
	public function listGroupUserName()
	{
		$query = $this->db->select()
				->from($this->tbl_admin_group)
				->order_by("admin_group_seq","asc");
		$query = $this->db->get();
		$result = $query->result_array();
		$return=array();
		foreach($result as $res){
			$return[$res['admin_group_id']] = $res['admin_group_desc'];
		}
		return $return;
	}
	public function listEditGroup($id)
	{
		$query = $this->db->select()
				->from($this->tbl_admin_group)
				->where('admin_group_id',$id);
		$query = $this->db->get();
		$result = $query->row_array();
		return $result;
	}
	public function addGroup()
	{
		$val = $this->getValue();
		$admin_group_id = $this->bflibs->getLastID($this->tbl_admin_group,'admin_group_id');
		$admin_group_seq = $this->bflibs->getLastID($this->tbl_admin_group,'admin_group_seq');
		$data = array("admin_group_id"=>$admin_group_id,
				"admin_group_desc"=>$val['admin_group_desc'],
				"admin_group_seq"=>$admin_group_seq,
		);
		$this->db->insert($this->tbl_admin_group,$data);
	}
	public function editGroup()
	{
		$val = $this->getValue();
		$data = array("admin_group_desc"=>$val['admin_group_desc']);
		$this->db->where('admin_group_id',$val['admin_group_id']);
		$this->db->update($this->tbl_admin_group,$data);
	}
	public function deleteGroup($id)
	{
		$this->db->where('admin_group_id',$id);
		$this->db->delete($this->tbl_admin_group);
	}
	public function chk_bfdelete($group_id)
	{
		$query = $this->db->select('admin_id')
				->from($this->tbl_admin)
				->where('admin_group_id',$group_id);
		$query = $this->db->get();
		$result = $query->row_array();
		return (!empty($result))?'false':'true'; // ถ้าหากไม่มีสมาชิกในกลุ่มแล้วจะคืนค่า true ถึงจะสามารถลบกลุ่มที่เลือกได้
	}
	public function listLanguage()
	{
		$query = $this->db->select()
				->from($this->tbl_admin_language)
				->where('language_admin_publish',1)
				->order_by("language_seq","asc");
		$query = $this->db->get();
		$result = $query->result_array();
		return $result;
	}
	
	
	/* USER ONLINE
	------------------------------------------------------------------------------------*/	
	public function listOnlineUser()
	{
		$admin= $this->session->userdata('admin');
		
		$this->db	->select(array("$this->tbl_admin.admin_user","$this->tbl_admin.admin_image","$this->tbl_admin_group.admin_group_desc"))
						->from($this->tbl_admin)
						->join("$this->tbl_admin_group","$this->tbl_admin.admin_group_id = $this->tbl_admin_group.admin_group_id","left")
						->where("$this->tbl_admin.admin_group_id >=",$admin->admin_group)
						->order_by("$this->tbl_admin.admin_seq","asc");
		
		$query = $this->db->get();
		$result = $query->result_array();
		return $result;
	}
	public function checkOnlineUser($user)
	{
		$date = time()-1200;
		$query = $this->db->select()
				->from($this->tbl_admin_useronline)
				->where("online_user",$user)
				->where("online_date >",$date);
		$query = $this->db->get();
		$result = $query->row_array();
		return $result;
	}
	public function addOnlineUser($user)
	{
		$data = array("online_user"=>$user,
							"online_date"=>time()
		);
		$this->db->insert($this->tbl_admin_useronline,$data);
	}
	public function updateOnlineUser($user)
	{
		$query = $this->db->select()
				->from($this->tbl_admin_useronline)
				->where("online_user",$user);
		$num = $this->db->count_all_results();
		
		if($num	> 0){
					
			$data = array("online_date"=>time()
			);
			$this->db->where("online_user",$user);
			$this->db->update($this->tbl_admin_useronline,$data);
		}else{
			$this->addOnlineUser($user);
		}
	}
	
	public function delOnlineUser($user)
	{
		$this->db->where("online_user",$user);
		$this->db->delete($this->tbl_admin_useronline);
	}
}
?>