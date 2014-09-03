<?php  
if (!defined('BASEPATH')) exit('No direct script access allowed');

class Bflibs
{
	private $db_lib;
	private $ci;
	private $stack;
	
	public function Bflibs()
	{
		$this->ci = $CI =& get_instance();
		$this->db_lib = $CI->load->database('default', TRUE);
		$this->session = $CI->load->library('session');
	}
	public function setStack($val){
		$this->stack = $val;
	}
	private function getStack(){
		return $this->stack;
	}
	public function getLastID($tablename,$field)
	{
		$query = $this->db_lib->select_max($field)
				->from($tablename);
		$query = $this->db_lib->get();
		$result = $query->row();
		return $result->$field+1;
	}
	public function getLastIdWithGroup($tablename,$field,$group_field,$group_id)
	{ 
		$query = $this->db_lib->select_max($field)
				->from($tablename)
				->where("$group_field",$group_id);
		$query = $this->db_lib->get();
		$result = $query->row();
		return $result->$field+1;
	}
	public function getLastIdWithGroup2($tablename,$field,$group_field,$group_id,$group_field2,$group_id2)
	{ 
		$query = $this->db_lib->select_max($field)
				->from($tablename)
				->where("$group_field",$group_id)
				->where("$group_field2",$group_id2);

		$query = $this->db_lib->get();
		$result = $query->row();
		return $result->$field+1;
	}
	public function getOne($tablename,$field,$where_field,$where_id)
	{
		$query = $this->db_lib->select($field)
				->from($tablename)
				->where("$where_field",$where_id);
		$query = $this->db_lib->get();
		$result = $query->row_array();
		return (!empty($result))?$result[$field]:'';
	}
	public function getRow($tablename,$field,$where_field,$where_id)
	{
		$query = $this->db_lib->select($field)
				->from($tablename)
				->where("$where_field",$where_id);
		$query = $this->db_lib->get();
		$result = $query->row_array();
		return $result;
	}
	public function getResult($tablename,$field,$where_field,$where_id)
	{
		$query = $this->db_lib->select($field)
				->from($tablename)
				->where("$where_field",$where_id);
		$query = $this->db_lib->get();
		$result = $query->result_array();
		return $result;
	}
	public function getIP(){
		if(!empty($_SERVER['HTTP_CLIENT_IP'])){
			$ip=$_SERVER['HTTP_CLIENT_IP'];  
	    }else{
	    	$ip=$_SERVER['REMOTE_ADDR'];
	    }
	    return $ip;
	 }

	/*
	 * name ชื่อของ action stack
	 * view : module/function(action)
	*/
	public function insertActionStack()
	{
		$actions[] = array("name"=>"showlogin","view"=>"admin/admin/showlogin");
		/*$actions[] = array("name"=>"left_sidebar","view"=>"menu/index/index");*/
		$actions[] = array("name"=>"top_menu","view"=>"menu/index/top_menu");
		$this->setStack('admin');
		return $actions;
	}
	public function insertActionStackFront()
	{
		$actions = array();
		//$actions[] = array("name"=>"switchlang","view"=>"language/frontend/widget");
		//$actions[] = array("name"=>"frontmenu","view"=>"frontmenu/frontend/widget");
		//$actions[] = array("name"=>"sitemap","view"=>"frontmenu/frontend/sitemap");
		//$actions[] = array("name"=>"reference","view"=>"reference/frontend/widget");
		//$actions[] = array("name"=>"news","view"=>"news/frontend/widget");
	//	$actions[] = array("name"=>"slide","view"=>"slide/frontend/widget");
		$this->setStack('site');
		return $actions;
	}

	// คืนค่านามสกุลของไฟล์
	public function getExt($filename)
	{
		return pathinfo($filename, PATHINFO_EXTENSION);
	}
	public function menuAuth($module)
	{
		$admin = $this->session->userdata('admin');
		$admin_group = $admin->admin_group;
		
		if($module != 'allusers')
		{
			// Do something
		}else{
			if($admin_group == 1) // 1: root All
			{
				$type_1 = array('allusers');
				if(in_array($module,$type_1))
				{
					return true;
				}else{
					return false;
				}
			}
			if($admin_group == 2) // 2: admin
			{
				return false;
			}
		}
	}
	public function timeString($datetime,$format=''){
		
		$newDate = '';
		if($datetime != '' && $datetime != '0000-00-00 00:00:00' && $datetime != '0000-00-00'){
			$this->ci->lang->load('calendar');
			
			$lang = $this->ci->config->item('language');
			$dt = explode(' ',$datetime);
			$date = (isset($dt[0]))?$dt[0]:'';
			$time = (isset($dt[1]))?$dt[1]:'';
			switch($lang){
				case 'thai':{
					
					if($date!='' && ($format=='' || $format=='date')){
						list($yy,$mm,$dd) = explode("-",$date);
						$year = (int)$yy+543;
						$month = date('M',mktime(0,0,0,$mm,$dd,$yy));
						$newDate = $dd." ".$this->ci->lang->line('cal_'.strtolower($month))." ".$year;
					}
					if($time!='' && ($format=='' || $format=='time')){
						list($h,$i,$s) = explode(":",$time);
						$newTime = ", ".$h.":".$i." น.";
						$newDate .=$newTime;
					}
					break;
				}
				case 'english':{
				
					if($date!='' && ($format=='' || $format=='date')){
						list($yy,$mm,$dd) = explode("-",$date);
						$month = date('M',mktime(0,0,0,$mm,$dd,$yy));
						$newDate = $dd." ".$this->ci->lang->line('cal_'.strtolower($month))." ".$yy;
					}
					if($time!='' && ($format=='' || $format=='time')){
						list($h,$i,$s) = explode(":",$time);
						$newTime = ", ".$h.":".$i.date("a", mktime($h, $i, 0, 0, 0, 0));
						$newDate .=$newTime;
					}
					break;
				}
			}
		}
		return $newDate;
	}
	public function dateToDb($datetime,$format='datetime'){
		
		$newDate = '';
		if($datetime != '' && $datetime != '0000-00-00 00:00:00' && $datetime != '0000-00-00'){
		if($format == 'date'){
				list($dd,$mm,$yy) = explode("/",$datetime);
				$newDate = $yy."-".$mm."-".$dd;
			}else{ // datetime
				$dt = explode(' ',$datetime);
				$date = (isset($dt[0]))?$dt[0]:'';
				$time = (isset($dt[1]))?$dt[1]:'';
				list($dd,$mm,$yy) = explode("/",$date);
				$newDate = $yy."-".$mm."-".$dd." ".$time.":00";
			}
		}
		return $newDate;
	}
	public function dateToShow($datetime,$format='datetime'){
		
		$newDate = '';
		if($datetime != '' && $datetime != '0000-00-00 00:00:00' && $datetime != '0000-00-00'){
			if($format == 'date'){
				list($yy,$mm,$dd) = explode("-",$datetime);
				$newDate = $dd."/".$mm."/".$yy;
			}else{ // datetime
				list($date,$time) = explode(' ',$datetime);
				list($yy,$mm,$dd) = explode("-",$date);
				list($h,$i,$s) = explode(":",$time);
				$newDate = $dd."/".$mm."/".$yy." ".$h.":".$i;
			}
		}
		return $newDate;
	}
	public function getShortLang($lang='')
	{
		$lang = ($lang=='') ? $this->getDefaultLang() : $lang;
		
		$select = $this->db_lib->select("language_alias")
										->from("admin_language")
										->where("language_id",$lang)
										->limit(1);
		$query = $this->db_lib->get();
		$result = $query->row_array();
		$shortLang = $result['language_alias'];
		return $shortLang;
	}
	
	public function getDefaultLang()
	{
		$defaultLang = '';
		switch ($this->stack){
			case 'admin':{
				$admin = $this->session->userdata('admin');
				if(!empty($admin))
				{
					$defaultLang = $admin->admin_language;
				}
				if(empty($defaultLang))
				{
					$select = $this->db_lib->select("language_name")
							->from("admin_language")
							->where("language_admin",1);
					$query = $this->db_lib->get();
					$result = $query->row_array();
					$defaultLang = $result['language_name'];
				}
				break;
			}
			case 'site':{
				$lang_id = $this->getDefaultLangId();
				$defaultLang = $this->getLang($lang_id);
			}
		}
		return $defaultLang;
	}
	
	public function getDefaultLangId()
	{
		$defaultLang = '';
		switch ($this->stack){
			case 'admin':{
			
				$admin = $this->session->userdata('admin');
				if(!empty($admin))
				{
					$defaultLang = $admin->admin_lang_id;
				}
				if(empty($defaultLang))
				{
					$select = $this->db_lib->select("language_id")
							->from("admin_language")
							->where("language_admin",1);
					$query = $this->db_lib->get();
					$result = $query->row_array();
					$defaultLang = $result['language_id'];
				}
				
				break;
			}
			case 'site':{
				
				$name = SITE.'_lang_id';
				$lang_id = $this->fetch_cookie($name);
				if(empty($_SESSION[SITE.'_lang_id']) && !empty($lang_id)){
					$_SESSION[SITE.'_lang_id'] = $lang_id;
				}else if(empty($_SESSION[SITE.'_lang_id']) && empty($lang_id)){
					$select = $this->db_lib->select("language_id")
							->from("admin_language")
							->where("language_front",1);
					$query = $this->db_lib->get();
					$result = $query->row_array();
					$_SESSION[SITE.'_lang_id'] = $result['language_id'];
				}
				$defaultLang = $_SESSION[SITE.'_lang_id'];
				break;
			}
		}
		return $defaultLang;
	}
	
	public function listAllLang()
	{
		$select = $this->db_lib->select(array("language_id","language_desc","language_icon"))
				->from("admin_language")
				->order_by("language_seq","asc");
		$query = $this->db_lib->get();
		$result = $query->result_array();
		return $result;
	}
	
	public function updateSession($session="",$field,$data)
	{
		$session = ($session == '')?'admin':$session;
		$admin = $this->session->userdata($session);
		$admin->$field = $data;
		$this->session->set_userdata($session, $admin);
	}
	
	public function replacePathSlash($path){
	
		$search = array('../../../../../../../../../../../../public/','../../../../../../../../../../../public/','../../../../../../../../../../public/','../../../../../../../../../public/',
		'../../../../../../../../public/','../../../../../../../public/','../../../../../../public/','../../../../../public/','../../../../public/','../../../public/','../../public/','../public/');
		$str = str_replace($search,DIR_PUBLIC,$path);
		$new_search = array('src=\'public/','src="public/');
		return str_replace($new_search,'src="'.DIR_PUBLIC,$str);
	}
	
	public function MergeArrays($Arr1, $Arr2)
	{
	  foreach($Arr2 as $key => $Value)
	  {
	    if(array_key_exists($key, $Arr1) && is_array($Value))
	      $Arr1[$key] = $this->MergeArrays($Arr1[$key], $Arr2[$key]);
	
	    else
	      $Arr1[$key] = $Value;
	  }
	  return $Arr1;
	}
	
	public function web_tool($type,$module,$option,$action='',$param='',$redirectaction='',$target='',$pagination=false){
	
		$tool='';
		$action = ($action=='')?$type:$action;
		$redirectaction = ($redirectaction=='')?'index':$redirectaction;
		$target = ($target=='')?'#':$target;
		if(!$pagination){
			switch($type){
				case 'edit':{
					$tool = '<a class="edit" title="'.lang('web_edit').'" href="'.DIR_ROOT.$module.'/backend/'.$action.'/id/'.$option['id'].$param.'" ></a>';
					break;
				}
				case 'delete':{
					$tool = '<a class="delete" title="'.lang('web_delete').'" href="javascript:void(0);" onclick="myConfirm(\''.lang('web_cf_delete').'\',\'\',\'\',\''.lang('web_ok').'\',\''.lang('web_cancel').'\',\'loadAjax(\\\''.DIR_ROOT.$module.'/backend/'.$action.'/id/'.$option['id'].'\\\',\\\'\\\',\\\'loadAjax(\\\\\\\''.DIR_ROOT.$module.'/backend/'.$redirectaction.$param.'\\\\\\\',\\\\\\\''.$target.'\\\\\\\',\\\\\\\'\\\\\\\')\\\')\' )" ></a>';
					break;
				}
				case 'up':{
					$tool = '<a class="up" title="'.lang('web_up').'" href="javascript:void(0);" onclick="loadAjax(\''.DIR_ROOT.$module.'/backend/'.$action.'/id/'.$option['id'].'/seq/'.$option['seq'].'\',\'\',\'loadAjax(\\\''.DIR_ROOT.$module.'/backend/'.$redirectaction.$param.'\\\',\\\''.$target.'\\\',\\\'\\\')\')" ></a>';
					break;
				}
				case 'down':{
					$tool = '<a class="down" title="'.lang('web_down').'" href="javascript:void(0);" onclick="loadAjax(\''.DIR_ROOT.$module.'/backend/'.$action.'/id/'.$option['id'].'/seq/'.$option['seq'].'\',\'\',\'loadAjax(\\\''.DIR_ROOT.$module.'/backend/'.$redirectaction.$param.'\\\',\\\''.$target.'\\\',\\\'\\\')\')" ></a>';
					break;
				}
				case 'up_parent':{
					$tool = '<a class="up" title="'.lang('web_up').'" href="javascript:void(0);" onclick="loadAjax(\''.DIR_ROOT.$module.'/backend/'.$action.'/id/'.$option['id'].'/seq/'.$option['seq'].'/parent_id/'.$option['parent_id'].'\',\'\',\'loadAjax(\\\''.DIR_ROOT.$module.'/backend/'.$redirectaction.$param.'\\\',\\\''.$target.'\\\',\\\'\\\')\')" ></a>';
					break;
				}
				case 'down_parent':{
					$tool = '<a class="down" title="'.lang('web_down').'" href="javascript:void(0);" onclick="loadAjax(\''.DIR_ROOT.$module.'/backend/'.$action.'/id/'.$option['id'].'/seq/'.$option['seq'].'/parent_id/'.$option['parent_id'].'\',\'\',\'loadAjax(\\\''.DIR_ROOT.$module.'/backend/'.$redirectaction.$param.'\\\',\\\''.$target.'\\\',\\\'\\\')\')" ></a>';
					break;
				}
				case 'publish':{
					if($option['status']==1){
						$class = 'publish';
						$title = lang('web_publish');
					}
					else if($option['status']==0){
						$class = 'unpublish';
						$title = lang('web_unpublish');
					}
					$tool = '<a class="'.$class.'" title="'.$title.'" href="javascript:void(0);" onclick="loadAjax(\''.DIR_ROOT.$module.'/backend/'.$action.'/id/'.$option['id'].'/status/'.$option['status'].'\',\'\',\'loadAjax(\\\''.DIR_ROOT.$module.'/backend/'.$redirectaction.$param.'\\\',\\\''.$target.'\\\',\\\'\\\')\')" ></a>';
					break;
				}
				case 'hidden':{
					if($option['status']==1){
						$class = 'publish';
						$title = 'normal';
					}
					else if($option['status']==0){
						$class = 'unpublish';
						$title = 'hidden';
					}
					$tool = '<a class="'.$class.'" title="'.$title.'" href="javascript:void(0);" onclick="loadAjax(\''.DIR_ROOT.$module.'/backend/'.$action.'/id/'.$option['id'].'/status/'.$option['status'].'\',\'\',\'loadAjax(\\\''.DIR_ROOT.$module.'/backend/'.$redirectaction.$param.'\\\',\\\''.$target.'\\\',\\\'\\\')\')" ></a>';
					break;
				}
				case 'read':{
				
					if($option['status']==1){
						$class = 'read';
						$title = lang('web_read');
					}
					else if($option['status']==0){
						$class = 'unread';
						$title = lang('web_unread');
					}
					$tool = '<a class="'.$class.'" title="'.$title.'" href="javascript:void(0);" onclick="loadAjax(\''.DIR_ROOT.$module.'/backend/'.$action.'/id/'.$option['id'].'/status/'.$option['status'].'\',\'\',\'loadAjax(\\\''.DIR_ROOT.$module.'/backend/'.$redirectaction.$param.'\\\',\\\''.$target.'\\\',\\\'\\\')\')" ></a>';
					break;
				}
				case 'pin':{
				
					if($option['status']==1){
						$class = 'pin';
						$title = lang('web_unpin');
					}
					else if($option['status']==0){
						$class = 'unpin';
						$title = lang('web_pin');
					}
					$tool = '<a class="'.$class.'" title="'.$title.'" href="javascript:void(0);" onclick="loadAjax(\''.DIR_ROOT.$module.'/backend/'.$action.'/id/'.$option['id'].'/status/'.$option['status'].'\',\'\',\'loadAjax(\\\''.DIR_ROOT.$module.'/backend/'.$redirectaction.$param.'\\\',\\\''.$target.'\\\',\\\'\\\')\')" ></a>';
					break;
				}
				case 'lock':{
				
					if($option['status']==1){
						$class = 'lock';
						$title = lang('web_lock');
					}
					else if($option['status']==0){
						$class = 'unlock';
						$title = lang('web_unlock');
					}
					$tool = '<a class="'.$class.'" title="'.$title.'" href="javascript:void(0);" onclick="loadAjax(\''.DIR_ROOT.$module.'/backend/'.$action.'/id/'.$option['id'].'/status/'.$option['status'].'\',\'\',\'loadAjax(\\\''.DIR_ROOT.$module.'/backend/'.$redirectaction.$param.'\\\',\\\''.$target.'\\\',\\\'\\\')\')" ></a>';
					break;
				}
				case 'hot':{
				
					if($option['status']==1){
						$class = 'hot';
						$title = 'สินค้ายอดนิยม';
					}
					else if($option['status']==0){
						$class = 'unhot';
						$title = 'สินค้ายอดนิยม';
					}
					$tool = '<a class="'.$class.'" title="'.$title.'" href="javascript:void(0);" onclick="loadAjax(\''.DIR_ROOT.$module.'/backend/'.$action.'/id/'.$option['id'].'/status/'.$option['status'].'\',\'\',\'loadAjax(\\\''.DIR_ROOT.$module.'/backend/'.$redirectaction.$param.'\\\',\\\''.$target.'\\\',\\\'\\\')\')" ></a>';
					break;
				}
				case 'rec':{
				
					if($option['status']==1){
						$class = 'rec';
						$title = 'สินค้าแนะนำ';
					}
					else if($option['status']==0){
						$class = 'unrec';
						$title = 'สินค้าแนะนำ';
					}
					$tool = '<a class="'.$class.'" title="'.$title.'" href="javascript:void(0);" onclick="loadAjax(\''.DIR_ROOT.$module.'/backend/'.$action.'/id/'.$option['id'].'/status/'.$option['status'].'\',\'\',\'loadAjax(\\\''.DIR_ROOT.$module.'/backend/'.$redirectaction.$param.'\\\',\\\''.$target.'\\\',\\\'\\\')\')" ></a>';
					break;
				}
				case 'pro':{
				
					if($option['status']==1){
						$class = 'pro';
						$title = 'สินค้าโปรโมชั่น';
					}
					else if($option['status']==0){
						$class = 'unpro';
						$title = 'สินค้าโปรโมชั่น';
					}
					$tool = '<a class="'.$class.'" title="'.$title.'" href="javascript:void(0);" onclick="loadAjax(\''.DIR_ROOT.$module.'/backend/'.$action.'/id/'.$option['id'].'/status/'.$option['status'].'\',\'\',\'loadAjax(\\\''.DIR_ROOT.$module.'/backend/'.$redirectaction.$param.'\\\',\\\''.$target.'\\\',\\\'\\\')\')" ></a>';
					break;
				}
				case 'sale':{
				
					if($option['status']==1){
						$class = 'sale';
						$title = 'สินค้าลดราคา';
					}
					else if($option['status']==0){
						$class = 'unsale';
						$title = 'สินค้าลดราคา';
					}
					$tool = '<a class="'.$class.'" title="'.$title.'" href="javascript:void(0);" onclick="loadAjax(\''.DIR_ROOT.$module.'/backend/'.$action.'/id/'.$option['id'].'/status/'.$option['status'].'\',\'\',\'loadAjax(\\\''.DIR_ROOT.$module.'/backend/'.$redirectaction.$param.'\\\',\\\''.$target.'\\\',\\\'\\\')\')" ></a>';
					break;
				}
			}
		}else{
			switch($type){
				case 'edit':{
					$tool = '<a class="edit" title="'.lang('web_edit').'" href="'.DIR_ROOT.$module.'/backend/'.$action.'/id/'.$option['id'].$param.'" ></a>';
					break;
				}
				case 'delete':{
					$tool = '<a class="delete" title="'.lang('web_delete').'" href="javascript:void(0);" onclick="myConfirm(\''.lang('web_cf_delete').'\',\'\',\'\',\''.lang('web_ok').'\',\''.lang('web_cancel').'\',\'loadAjax(\\\''.DIR_ROOT.$module.'/backend/'.$action.'/id/'.$option['id'].'\\\',\\\'\\\',\\\'loadAjax(\\\\\\\''.DIR_ROOT.$module.'/backend/'.$redirectaction.$param.'\\\\\\\',\\\\\\\''.$target.'\\\\\\\',\\\\\\\'\\\\\\\')\\\')\' )" ></a>';//(\''.lang('web_cf_delete').'\',\'loadAjax(\\\''.DIR_ROOT.$module.'/backend/'.$action.'/id/'.$option['id'].'\\\',\\\'\\\',\\\'loadPage(\\\\\\\''.DIR_ROOT.$module.'/backend/'.$redirectaction.$param.'\\\\\\\',\\\\\\\''.$target.'\\\\\\\')\\\')\',\''.lang('web_ok').'\',\''.lang('web_cancel').'\')" 
					break;
				}
				case 'up':{
					$tool = '<a class="up" title="'.lang('web_up').'" href="javascript:void(0);" onclick="loadAjax(\''.DIR_ROOT.$module.'/backend/'.$action.'/id/'.$option['id'].'/seq/'.$option['seq'].'\',\'\',\'loadPage(\\\''.DIR_ROOT.$module.'/backend/'.$redirectaction.$param.'\\\',\\\''.$target.'\\\')\')" ></a>';
					break;
				}
				case 'down':{
					$tool = '<a class="down" title="'.lang('web_down').'" href="javascript:void(0);" onclick="loadAjax(\''.DIR_ROOT.$module.'/backend/'.$action.'/id/'.$option['id'].'/seq/'.$option['seq'].'\',\'\',\'loadPage(\\\''.DIR_ROOT.$module.'/backend/'.$redirectaction.$param.'\\\',\\\''.$target.'\\\')\')" ></a>';
					break;
				}
				case 'up_parent':{
					$tool = '<a class="up" title="'.lang('web_up').'" href="javascript:void(0);" onclick="loadAjax(\''.DIR_ROOT.$module.'/backend/'.$action.'/id/'.$option['id'].'/seq/'.$option['seq'].'/parent_id/'.$option['parent_id'].'\',\'\',\'loadPage(\\\''.DIR_ROOT.$module.'/backend/'.$redirectaction.$param.'\\\',\\\''.$target.'\\\')\')" ></a>';
					break;
				}
				case 'down_parent':{
					$tool = '<a class="down" title="'.lang('web_down').'" href="javascript:void(0);" onclick="loadAjax(\''.DIR_ROOT.$module.'/backend/'.$action.'/id/'.$option['id'].'/seq/'.$option['seq'].'/parent_id/'.$option['parent_id'].'\',\'\',\'loadPage(\\\''.DIR_ROOT.$module.'/backend/'.$redirectaction.$param.'\\\',\\\''.$target.'\\\')\')" ></a>';
					break;
				}
				case 'publish':{
					if($option['status']==1){
						$class = 'publish';
						$title = lang('web_publish');
					}
					else if($option['status']==0){
						$class = 'unpublish';
						$title = lang('web_unpublish');
					}
					$tool = '<a class="'.$class.'" title="'.$title.'" href="javascript:void(0);" onclick="loadAjax(\''.DIR_ROOT.$module.'/backend/'.$action.'/id/'.$option['id'].'/status/'.$option['status'].'\',\'\',\'loadPage(\\\''.DIR_ROOT.$module.'/backend/'.$redirectaction.$param.'\\\',\\\''.$target.'\\\')\')" ></a>';
					break;
				}
				case 'hidden':{
					if($option['status']==1){
						$class = 'publish';
						$title = 'normal';
					}
					else if($option['status']==0){
						$class = 'unpublish';
						$title = 'hidden';
					}
					$tool = '<a class="'.$class.'" title="'.$title.'" href="javascript:void(0);" onclick="loadAjax(\''.DIR_ROOT.$module.'/backend/'.$action.'/id/'.$option['id'].'/status/'.$option['status'].'\',\'\',\'loadPage(\\\''.DIR_ROOT.$module.'/backend/'.$redirectaction.$param.'\\\',\\\''.$target.'\\\')\')" ></a>';
					break;
				}
				case 'read':{
				
					if($option['status']==1){
						$class = 'read';
						$title = lang('web_read');
					}
					else if($option['status']==0){
						$class = 'unread';
						$title = lang('web_unread');
					}
					$tool = '<a class="'.$class.'" title="'.$title.'" href="javascript:void(0);" onclick="loadAjax(\''.DIR_ROOT.$module.'/backend/'.$action.'/id/'.$option['id'].'/status/'.$option['status'].'\',\'\',\'loadPage(\\\''.DIR_ROOT.$module.'/backend/'.$redirectaction.$param.'\\\',\\\''.$target.'\\\')\')" ></a>';
					break;
				}
				case 'pin':{
				
					if($option['status']==1){
						$class = 'pin';
						$title = lang('web_unpin');
					}
					else if($option['status']==0){
						$class = 'unpin';
						$title = lang('web_pin');
					}
					$tool = '<a class="'.$class.'" title="'.$title.'" href="javascript:void(0);" onclick="loadAjax(\''.DIR_ROOT.$module.'/backend/'.$action.'/id/'.$option['id'].'/status/'.$option['status'].'\',\'\',\'loadPage(\\\''.DIR_ROOT.$module.'/backend/'.$redirectaction.$param.'\\\',\\\''.$target.'\\\')\')" ></a>';
					break;
				}
				case 'hot':{
				
					if($option['status']==1){
						$class = 'hot';
						$title = 'สินค้ายอดนิยม';
					}
					else if($option['status']==0){
						$class = 'unhot';
						$title = 'สินค้ายอดนิยม';
					}
					$tool = '<a class="'.$class.'" title="'.$title.'" href="javascript:void(0);" onclick="loadAjax(\''.DIR_ROOT.$module.'/backend/'.$action.'/id/'.$option['id'].'/status/'.$option['status'].'\',\'\',\'loadPage(\\\''.DIR_ROOT.$module.'/backend/'.$redirectaction.$param.'\\\',\\\''.$target.'\\\')\')" ></a>';
					break;
				}
				case 'rec':{
				
					if($option['status']==1){
						$class = 'rec';
						$title = 'สินค้าแนะนำ';
					}
					else if($option['status']==0){
						$class = 'unrec';
						$title = 'สินค้าแนะนำ';
					}
					$tool = '<a class="'.$class.'" title="'.$title.'" href="javascript:void(0);" onclick="loadAjax(\''.DIR_ROOT.$module.'/backend/'.$action.'/id/'.$option['id'].'/status/'.$option['status'].'\',\'\',\'loadPage(\\\''.DIR_ROOT.$module.'/backend/'.$redirectaction.$param.'\\\',\\\''.$target.'\\\')\')" ></a>';
					break;
				}
				case 'pro':{
				
					if($option['status']==1){
						$class = 'pro';
						$title = 'สินค้าโปรโมชั่น';
					}
					else if($option['status']==0){
						$class = 'unpro';
						$title = 'สินค้าโปรโมชั่น';
					}
					$tool = '<a class="'.$class.'" title="'.$title.'" href="javascript:void(0);" onclick="loadAjax(\''.DIR_ROOT.$module.'/backend/'.$action.'/id/'.$option['id'].'/status/'.$option['status'].'\',\'\',\'loadPage(\\\''.DIR_ROOT.$module.'/backend/'.$redirectaction.$param.'\\\',\\\''.$target.'\\\')\')" ></a>';
					break;
				}
				case 'sale':{
				
					if($option['status']==1){
						$class = 'sale';
						$title = 'สินค้าลดราคา';
					}
					else if($option['status']==0){
						$class = 'unsale';
						$title = 'สินค้าลดราคา';
					}
					$tool = '<a class="'.$class.'" title="'.$title.'" href="javascript:void(0);" onclick="loadAjax(\''.DIR_ROOT.$module.'/backend/'.$action.'/id/'.$option['id'].'/status/'.$option['status'].'\',\'\',\'loadPage(\\\''.DIR_ROOT.$module.'/backend/'.$redirectaction.$param.'\\\',\\\''.$target.'\\\')\')" ></a>';
					break;
				}
				case 'lock':{
				
					if($option['status']==1){
						$class = 'lock';
						$title = lang('web_lock');
					}
					else if($option['status']==0){
						$class = 'unlock';
						$title = lang('web_unlock');
					}
					$tool = '<a class="'.$class.'" title="'.$title.'" href="javascript:void(0);" onclick="loadAjax(\''.DIR_ROOT.$module.'/backend/'.$action.'/id/'.$option['id'].'/status/'.$option['status'].'\',\'\',\'loadPage(\\\''.DIR_ROOT.$module.'/backend/'.$redirectaction.$param.'\\\',\\\''.$target.'\\\')\')" ></a>';
					break;
				}
				case 'view_detail':{
					$tool = '<a class="view" title="'.lang('sp_detail').'" href="javascript:void(0);" onclick="loadPage(\''.DIR_ROOT.$module.'/backend/'.$action.'/id/'.$option['id'].$param.'\',\''.$target.'\')" ></a>';
					break;
				}
				case 'view_custom':{
					$tool = '<a class="user" title="'.lang('sp_custom').'" href="javascript:void(0);" onclick="loadAjax(\''.DIR_ROOT.$module.'/backend/'.$action.'/id/'.$option['id'].$param.'\',\''.$target.'\')" ></a>';
					break;
				}
			}
		}
		return $tool;
	}
	public function upMenu($table,$fieldId,$id,$fieldSeq,$seq)
	{
		$select = $this->db_lib->select()
				->from($table)
				->where("$fieldSeq <",$seq)
				->order_by($fieldSeq,"desc");
		$query = $this->db_lib->get();
		$newer = $query->row_array();
		if(!empty($newer))
		{
			$oldSeq = array($fieldSeq=>$seq);
			$newSeq = array($fieldSeq=>$newer[$fieldSeq]);
		
			if($newer!=null)
			{
				$this->db_lib->where($fieldId,$id);
				$this->db_lib->update($table,$newSeq);
				$this->db_lib->where($fieldId,$newer[$fieldId]);
				$this->db_lib->update($table,$oldSeq);
			}
		}
	}
	public function downMenu($table,$fieldId,$id,$fieldSeq,$seq)
	{
		$select = $this->db_lib->select()
				->from($table)
				->where("$fieldSeq >",$seq)
				->order_by($fieldSeq,"asc");
		$query = $this->db_lib->get();
		$newer = $query->row_array();
		if(!empty($newer))
		{
			$oldSeq = array($fieldSeq=>$seq);
			$newSeq = array($fieldSeq=>$newer[$fieldSeq]);
		
			if($newer!=null)
			{
				$this->db_lib->where($fieldId,$id);
				$this->db_lib->update($table,$newSeq);
				$this->db_lib->where($fieldId,$newer[$fieldId]);
				$this->db_lib->update($table,$oldSeq);
			}
		}
	}
	public function upMenuDesc($table,$fieldId,$id,$fieldSeq,$seq)
	{
		$select = $this->db_lib->select()
				->from($table)
				->where("$fieldSeq >",$seq)
				->order_by($fieldSeq,"asc");
		$query = $this->db_lib->get();
		$newer = $query->row_array();
		if(!empty($newer))
		{
			$oldSeq = array($fieldSeq=>$seq);
			$newSeq = array($fieldSeq=>$newer[$fieldSeq]);
		
			if($newer!=null)
			{
				$this->db_lib->where($fieldId,$id);
				$this->db_lib->update($table,$newSeq);
				$this->db_lib->where($fieldId,$newer[$fieldId]);
				$this->db_lib->update($table,$oldSeq);
			}
		}
	}
	public function downMenuDesc($table,$fieldId,$id,$fieldSeq,$seq)
	{
		$select = $this->db_lib->select()
				->from($table)
				->where("$fieldSeq <",$seq)
				->order_by($fieldSeq,"desc");
		$query = $this->db_lib->get();
		$newer = $query->row_array();
		if(!empty($newer))
		{
			$oldSeq = array($fieldSeq=>$seq);
			$newSeq = array($fieldSeq=>$newer[$fieldSeq]);
		
			if($newer!=null)
			{
				$this->db_lib->where($fieldId,$id);
				$this->db_lib->update($table,$newSeq);
				$this->db_lib->where($fieldId,$newer[$fieldId]);
				$this->db_lib->update($table,$oldSeq);
			}
		}
	}
	public function upMenuWithParent($table,$fieldId,$id,$fieldSeq,$seq,$fieldParent,$parent_id)
	{
		$select = $this->db_lib->select()
				->from($table)
				->where("$fieldSeq <",$seq)
				->where($fieldParent,$parent_id)
				->order_by($fieldSeq,"desc");
		$query = $this->db_lib->get();
		$newer = $query->row_array();
		if(!empty($newer))
		{
			$oldSeq = array($fieldSeq=>$seq);
			$newSeq = array($fieldSeq=>$newer[$fieldSeq]);
		
			if($newer!=null)
			{
				$this->db_lib->where($fieldId,$id);
				$this->db_lib->update($table,$newSeq);
				$this->db_lib->where($fieldId,$newer[$fieldId]);
				$this->db_lib->update($table,$oldSeq);
			}
		}
	}
	public function downMenuWithParent($table,$fieldId,$id,$fieldSeq,$seq,$fieldParent,$parent_id)
	{
		$select = $this->db_lib->select()
				->from($table)
				->where("$fieldSeq >",$seq)
				->where($fieldParent,$parent_id)
				->order_by($fieldSeq,"asc");
		$query = $this->db_lib->get();
		$newer = $query->row_array();
		if(!empty($newer))
		{
			$oldSeq = array($fieldSeq=>$seq);
			$newSeq = array($fieldSeq=>$newer[$fieldSeq]);
		
			if($newer!=null)
			{
				$this->db_lib->where($fieldId,$id);
				$this->db_lib->update($table,$newSeq);
				$this->db_lib->where($fieldId,$newer[$fieldId]);
				$this->db_lib->update($table,$oldSeq);
			}
		}
	}
	public function publish($table,$fieldId,$id,$fieldStatus,$status)
	{
		$data = array($fieldStatus=>2-($status+1));
		$this->db_lib->where($fieldId,$id);
		$this->db_lib->update($table,$data);
	}
	
	public function getSubString($str,$len){
	
		$c = strlen($str);
		$e = 0;
		$t = 0;
		$len_new = 0;
        for ($i = 0; $i < $c; ++$i){
        	if(ord($str[$i])==224){
        		$t = $t+1;
        	}else{
        		if(ord($str[$i])<=127){
        			$e = $e+1;
        		}
        	}
        	//เช็คว่าเกินจำนวนที่ต้องการหรือไม่
        	$len_now = ($t*3)+$e;
        	if($len_now<=$len){ //ถ้าจำนวนความยาวยังไม่มากกว่าที่กำหนด
        		$len_new = $len_now; //ปรับค่าความยาวใหม่ให้เท่ากับความยาวที่คำนวนได้
        	}else{ //ถ้าความยาวเกินที่กำหนด ให้ออกจากลูป
        		break;
        	}
        }
        $new_str = substr($str,0,$len_new);
        return $new_str;
	}
	public function checkString($str){ //ฟังก์ชันสำหรับตรวจสอบ string ที่ส่งมาว่ามีภาษาไทยปนอยู่ไหม ถ้ามีอยู่จะส่ง true กลับไป
	
		$th = false;
		$c = strlen($str);
        for ($i = 0; $i < $c; ++$i)
        {
        	if(ord($str[$i])==224){
        		$th = true;
        		break;
        	}
        }
        return $th;
	}

	function format_money($number, $fractional=true) {
	    
		$n = trim(preg_replace('/([^0-9\.])/i', '', $number));
		if ($fractional) {
	        $number = number_format($n, 2, '.', ',');
	    }else{
	    	$number = number_format($n);
	    }
	    return $number;
	}
	
	public function mkSelect($type,$target='',$targetpage,$default=''){
		
		$targetRep = ($target != '' && $target != '#content')?str_replace('#','_',$target):"";
		switch ($type){
			case 'perPage':{
				$data = array('10','20','50','100');
				$txt = '<p style="float:left;line-height: 2.2;">'.lang('web_page_show');
				$txt .= '&nbsp;<select name="perPage'.$targetRep.'" id="perPage'.$targetRep.'" style="width:70px;" onchange="loadPage(\''.DIR_ROOT.$targetpage.'\',\''.$target.'\')">';
				foreach($data as $data){
					$select = ($data == $default)?'selected="selected"':'';
					$txt .= '<option value="'.$data.'" '.$select.'>'.$data.'</option>';
				}
				$txt .= '</select>&nbsp;';
				$txt .= lang('web_page_record').'</p>';
				break;
			}
			case 'searchData':{
				$txt = '<p style="float:right;">'.lang('web_search').' : <input type="text" id="searchData'.$targetRep.'" name="searchData'.$targetRep.'" onkeyup="loadPage(\''.DIR_ROOT.$targetpage.'\',\''.$target.'\')" style="width:200px;"></p>';
				break;
			}
			case 'pointType':{
				$data = array('1','2');
				$txt = '<p style="float:left;line-height: 2.2; margin-left:30px;">'.lang('member_point_type_select');
				$txt .= '&nbsp;<select name="type'.$targetRep.'" id="type'.$targetRep.'" style="width:200px;" onchange="loadPage(\''.DIR_ROOT.$targetpage.'/type/\'+this.value,\''.$target.'\')">';
				$txt.='<option value="1" selected="selected">ได้รับจากผู้ดูแลระบบโดยตรง</option>';
				$txt.='<option value="2">ได้รับจากการซื้อสินค้า</option>';
				$txt .= '</select>&nbsp;</p>';
				break;
			}
			case 'productType':{
				$data = array('1','2');
				$txt = '<p style="float:left;line-height: 2.2; margin-left:30px;">'.lang('product_type_select');
				$txt .= '&nbsp;<select name="type'.$targetRep.'" id="type'.$targetRep.'" style="width:200px;" onchange="loadPage(\''.DIR_ROOT.$targetpage.'/type/\'+this.value,\''.$target.'\')">';
				$txt.='<option value="" selected="selected">สินค้าทั้งหมด</option>';
				$txt.='<option value="1">สินค้ามาใหม่</option>';
				$txt.='<option value="2">สินค้ายอดนิยม</option>';
				$txt.='<option value="3">สินค้าแนะนำ</option>';
				$txt.='<option value="4">สินค้าโปรโมชั่น</option>';
				$txt.='<option value="5">สินค้าลดราคา</option>';
				$txt .= '</select>&nbsp;</p>';
				break;
			}
		}
	  	return $txt;
	}
	public function mkSelectCate($data,$target,$targetpage,$default=''){
		
		$targetRep = ($target != '' && $target != '#content')?str_replace('#','_',$target):"";
		$txt = '<p style="float:left; margin-left: 30px;margin-right: 6px;">';
		$txt.='<select name="product_categories'.$targetRep.'" id="product_categories'.$targetRep.'" style="width:70px;" onchange="loadPage(\''.DIR_ROOT.$targetpage.'/categories_id/\'+this.value,\''.$target.'\')">';
		$txt.='<option value="">'.lang('products_select_categories').'</option>';
		if(!empty($data)){foreach($data as $data){
			$selected = ($default == $data['product_categories_id'])?'selected="selected"':'';
			$txt.='<option value="'.$data['product_categories_id'].'" '.$selected.'>'.$data['product_categories_name'].'</option>';
		}}
		$txt.='</select>';
		$txt.='</p>';
	  	return $txt;
	}
	public function mkSelectZone($data,$target,$targetpage,$default=''){
		
		$targetRep = ($target != '' && $target != '#content')?str_replace('#','_',$target):"";
		$txt = '<p style="float:left; margin-left: 30px;margin-right: 6px;">';
		$txt.='<select name="zone_id'.$targetRep.'" id="zone_id'.$targetRep.'" style="width:70px;" onchange="loadPage(\''.DIR_ROOT.$targetpage.'/zone_id/\'+this.value,\''.$target.'\')">';
		$txt.='<option value="">'.lang('web_select').'</option>';
		if(!empty($data)){foreach($data as $data){
			$selected = ($default == $data['zone_id'])?'selected="selected"':'';
			$txt.='<option value="'.$data['zone_id'].'" '.$selected.'>'.$data['zone_name'].'</option>';
		}}
		$txt.='</select>';
		$txt.='</p>';
	  	return $txt;
	}
	/* delfolder=> true(ลบโฟลเดอร์ที่กำหนดด้วย) or false(ลบเฉพาะไฟล์ที่อยู่ในโฟลเดอร์ )*/
	function remove_dir($dir, $delfolder=true){
		if(is_dir($dir)){
		    $dir = (substr($dir, -1) != "/")? $dir."/":$dir;
		    $openDir = opendir($dir);
		    
		    while(($file = readdir($openDir)) !== false){
		      if(!in_array($file, array(".", ".."))){
		        if(!is_dir($dir.$file)){
		          @unlink($dir.$file);
		        }else{
		          $this->remove_dir($dir.$file);
		        }
		      }
		    }
		    closedir($openDir);
		    if($delfolder)@rmdir($dir);
		}
	}
	
	public function setLang($lang_id,$url){
		$lang_id = intval($lang_id);
		
		if(!empty($lang_id)){
			$_SESSION[SITE.'_lang_id'] = $lang_id;
			$name = SITE.'_lang_id';
			$cookie_lang_id = intval($this->fetch_cookie($name));
			if($cookie_lang_id != $lang_id || empty($cookie_lang_id) && $cookie_lang_id != 'public'){
				$this->set_cookie($name, $lang_id);
			}
			$this->ci->config->set_item('language', $this->getLang($lang_id));
		}
		if(!empty($url)){
		
			if(stripslashes(DIR_ROOT) != "" && DIR_ROOT != '/'){
				$cUrl=explode(DIR_ROOT,$url);
			}else{
				$cUrl[1] = substr($url,1);
			}
			$langcUrl=explode('/lang/',$cUrl[1]);
			
			if(!empty($langcUrl[1])){
				$_SESSION['currenturl'] = $langcUrl[0];
			}else{
				$_SESSION['currenturl'] = $cUrl[1];
			}
		}
	}
	private function getLang($lang_id){
		if(!empty($lang_id)){
			$select = $this->db_lib->select("language_name")
						->from("admin_language")
						->where("language_id",$lang_id);
			$query = $this->db_lib->get();
			$result = $query->row_array();
			return $result["language_name"];
		}
	}
	
	/* Check login remember me
	---------------------------------------------------------------------*/
	public function check_login_admin() {
    				
		$admin_id = $this->fetch_cookie(SITE.'_admin_id');
		$admin= $this->session->userdata('admin');
		if(!empty($admin_id) && empty($admin->admin_id)){
		
			$this->tbl_admin = "admin";
			$this->tbl_admin_language = "admin_language";
			$select = $this->db_lib->select(array("$this->tbl_admin.admin_id","$this->tbl_admin.admin_user","$this->tbl_admin.admin_image","$this->tbl_admin.admin_group_id","$this->tbl_admin_language.language_id","$this->tbl_admin_language.language_name"))
					->from($this->tbl_admin)
					->join($this->tbl_admin_language,"$this->tbl_admin.admin_language=$this->tbl_admin_language.language_id","left")
					->where("$this->tbl_admin.admin_id",$admin_id)
					->where("$this->tbl_admin.admin_block",1);
		
			$query = $this->db_lib->get();
			$result = $query->row_array();
		
			$array = new stdClass();
				$array->admin_id = $result['admin_id'];
				$array->admin_user = $result['admin_user'];
				$array->admin_image = $result['admin_image'];
				$array->admin_group = $result['admin_group_id'];
				$array->admin_lang_id = $result['language_id'];
				$array->admin_language = $result['language_name'];

				$session_array = array(
	                   'admin'  => $array
				);
			$this->session->set_userdata($session_array);
		}
    }
	public function check_login() {
    				
		$member_id = $this->fetch_cookie(SITE.'_member_id');
		$member= $this->session->userdata('member');
		if(!empty($member_id) && empty($member->member_id)){
		
			$this->tbl_member = "member";
			$this->tbl_admin_language = "admin_language";
			$select = $this->db_lib->select(array("$this->tbl_member.member_id","$this->tbl_member.member_user","$this->tbl_member.member_image"))
					->from($this->tbl_member)
					->where("$this->tbl_member.member_id",$member_id)
					->where("$this->tbl_member.member_activate",'Y')
					->where("$this->tbl_member.member_block",1);
		
			$query = $this->db_lib->get();
			$result = $query->row_array();
			if(!empty($result)){
				$array = new stdClass();
				$array->member_id = $result['member_id'];
				$array->member_user = $result['member_user'];
				$array->member_image = $result['member_image'];
				$array->member_lang_id = $this->getDefaultLangId();
				$array->member_language = $this->getDefaultLang();
				$session_array = array(
					'member'  => $array
				);
			}
			$this->session->set_userdata($session_array);
		}
    }
    
	public function set_cookie($name, $value, $expire='', $path='', $domain='', $secure='') {
		
		$value = base64_encode(serialize($value));
		$expire = (empty($expire))?time()+(60*60*24*365):$expire; // 1 year
		$path = (empty($path))?'/':$path;
		$domain = (empty($domain))?(isset( $_SERVER['HTTP_HOST'] ) ? ( ( substr( $_SERVER['HTTP_HOST'], 0, 4 ) == 'www.' ) ? substr( $_SERVER['HTTP_HOST'], 3 ) : '.' . $_SERVER['HTTP_HOST'] ) : ''):$domain;
		$secure = (empty($secure))?false:$secure;
    	setcookie($name, $value, $expire, $path, $domain, $secure, true);
    }
    
	public function fetch_cookie($name) {
    	return ( isset( $_COOKIE[$name] ) ) ? unserialize( base64_decode( $_COOKIE[$name] ) ) : NULL;
    }
    
	public function remove_cookie($name,$domain='',$path='/',$secure=false) {
	
		if ( isset( $_COOKIE[$name] ) ) {
			$domain = ($domain == '')?isset( $_SERVER['HTTP_HOST'] ) ? ( ( substr( $_SERVER['HTTP_HOST'], 0, 4 ) == 'www.' ) ? substr( $_SERVER['HTTP_HOST'], 3 ) : '.' . $_SERVER['HTTP_HOST'] ) : '':$domain;
			return setcookie( $name, '', time() - ( 3600 * 25 ),$path,$domain,$secure);
		}
    }
    /* Check login remember me
	---------------------------------------------------------------------*/
	
	function getPaddingImg($img_path,$box_width,$box_height){
		//echo $img_path;
		//$img_path = 'public/upload/gallery/original/'.$tbl['gallery_path'];
		if (exif_imagetype($img_path) == IMAGETYPE_JPEG) {
			$img = imagecreatefromjpeg($img_path);
		}
		else if (exif_imagetype($img_path) == IMAGETYPE_PNG) {
			$img = imagecreatefrompng($img_path);
		}
		else if (exif_imagetype($img_path) == IMAGETYPE_GIF) {
			$img = imagecreatefromgif($img_path);
		}
		
		
		$width=imagesx($img);
		$height=imagesy($img);
		
		$boxW = ($box_width<$width) ? $box_width : $width;
		$boxH = ($box_height<$height) ? $box_height : $height;
		
		/*if($box_width<$width){
			$boxW=$box_width;
			//$imgW=$box_width.'px';
		}else{
			$boxW=$width;
			//$imgW='auto';
		}
		if($box_height<$height){
			$boxH=$box_height;
			//$imgH=$box_height.'px';
		}else{
			$boxH=$height;
			//$imgH='auto';
		}*/
		
		if($width>$height){
			$imgW =  $box_width;
			$imgH = ($box_width*$height)/$width;
			//$imgH = 'auto';
		}else{
			//$imgW = 'auto';
			$imgW = ($box_height*$width)/$height;
			$imgH = $box_height;
		}
				
		$pad_left = ($box_width-$imgW)/2;
		$pad_top = ($box_height-$imgH)/2;
		
		return array($imgW.'px',$imgH.'px',$boxW,$boxH,$pad_left,$pad_top);
	}
	
	
		
	//###################################################
	
	public function addLog($log_name,$log_desc='',$link=''){
		
		$admin= $this->session->userdata('admin');
		$listAllLang = $this->listAllLang();
		$log_id = $this->getLastID('log','log_id');
		$date = date('Y-m-d H:i:s');
		$data = array("log_id"=>$log_id,
							"admin_user"=>$admin->admin_user,
							"admin_group_id"=>$admin->admin_group,
							"log_name"=>$log_name,
							"log_date"=>$date
		);
		$this->db_lib->insert('log',$data);
		
		if($log_desc!=''){
			foreach($log_desc as $lang=>$desc){
				$desc = ($link=='') ? $desc : '<a href="'.$link.'" target="_blank">'.$desc.'</a>';
				$data = array(	"log_id"=>$log_id,
									"language_id"=>$lang,
									"log_desc"=>$desc
				);
				$this->db_lib->insert('log_lang',$data);
			}
		}
	}
	public function addLogById($log_name,$tbl_name,$field_name,$id,$link=''){
		
		$admin= $this->session->userdata('admin');
		$listAllLang = $this->listAllLang();
		
		$select = $this->db_lib->select(array($field_name,'language_id'))
										->from($tbl_name.'_lang')
										->where($tbl_name.'_id',$id);
		$query = $this->db_lib->get();
		$result = $query->result_array();
		
		if(!empty($result)){
			foreach($result as $list){
				$log_desc[$list['language_id']] = $list[$field_name];
			}
		}
					
		$log_id = $this->getLastID('log','log_id');
		$date = date('Y-m-d H:i:s');
		$data = array("log_id"=>$log_id,
							"admin_user"=>$admin->admin_user,
							"admin_group_id"=>$admin->admin_group,
							"log_name"=>$log_name,
							"log_date"=>$date
		);
		$this->db_lib->insert('log',$data);
		
		foreach($log_desc as $lang=>$desc){
			
			$desc = ($link=='') ? $desc : '<a href="'.$link.'" target="_blank">'.$desc.'</a>';
			
			$data = array(	"log_id"=>$log_id,
								"language_id"=>$lang,
								"log_desc"=>$desc
			);
			$this->db_lib->insert('log_lang',$data);
		}
		return ;
	}
	
	
	//###################################################
	
	public function gen_pcode($product_id){
		return str_pad($product_id,6,0,STR_PAD_LEFT);
	}
	
	public function showSelectDay($name,$val){
		$txt='
		<select name="'.$name.'" id="'.$name.'" class="select" style="width:100px;">
			<option value="">--- วัน ---</option>';
			for($d=1;$d<=31;$d++){
				$txt.='<option value="'.$d.'" '; if($val==$d){ $txt.='selected="selected"'; } $txt.='>'.$d.'</option>';
			}
		$txt.='</select>';

		return $txt;
	}
	public function showSelectYearNow($name,$val){
		$txt='
		<select name="'.$name.'" id="'.$name.'" class="select" style="width:100px;">
			<option value="">--- ปี ---</option>';
			for($y=date("Y")+543;$y>=((date("Y")+543)-2);$y--){
				$txt.='<option value="'.$y.'" '; if($val==$y){ $txt.='selected="selected"'; } $txt.='>'.$y.'</option>';
			}
		$txt.='</select>';

		return $txt;
	}
	public function showSelectYear($name,$val){
		$txt='
		<select name="'.$name.'" id="'.$name.'" class="select" style="width:100px;">
			<option value="">--- ปี ---</option>';
			for($y=2500;$y<=((date("Y")+543)-10);$y++){
				$txt.='<option value="'.$y.'" '; if($val==$y){ $txt.='selected="selected"'; } $txt.='>'.$y.'</option>';
			}
		$txt.='</select>';

		return $txt;
	}
	public function showSelectMonth($name,$val){
		$txtMonth=array("มกราคม","กุมภาพันธ์","มีนาคม","เมษายน","พฤษภาคม","มิถุนายน","กรกฎาคม","สิงหาคม","กันยายน","ตุลาคม","พฤศจิกายน","ธันวาคม");
		$txt='
		<select name="'.$name.'" id="'.$name.'" class="select" style="width:100px;">
			<option value="">--- เดือน ---</option>';
			for($m=1;$m<=12;$m++){
				$txt.='<option value="'.$m.'" '; if($val==$m){ $txt.='selected="selected"'; } $txt.='>'.$txtMonth[$m-1].'</option>';
			}
		$txt.='</select>';

		return $txt;
	}
	public function changeFMonth($m){
		if($m==1){ $month="มกราคม"; }
		else if($m==2){ $month="กุมภาพันธ์"; }
		else if($m==3){ $month="มีนาคม"; }
		else if($m==4){ $month="เมษายน"; }
		else if($m==5){ $month="พฤษภาคม"; }
		else if($m==6){ $month="มิถุนายน"; }
		else if($m==7){ $month="กรกฎาคม"; }
		else if($m==8){ $month="สิงหาคม"; }
		else if($m==9){ $month="กันยายน"; }
		else if($m==10){ $month="ตุลาคม"; }
		else if($m==11){ $month="พฤศจิกายน"; }
		else { $month="ธันวาคม"; }

		return $month;
	}
	public function changeSMonth($m){
		if($m==1){ $month="ม.ค."; }
		else if($m==2){ $month="ก.พ."; }
		else if($m==3){ $month="มี.ค."; }
		else if($m==4){ $month="เม.ย."; }
		else if($m==5){ $month="พ.ค."; }
		else if($m==6){ $month="มิ.ย."; }
		else if($m==7){ $month="ก.ค."; }
		else if($m==8){ $month="ส.ค."; }
		else if($m==9){ $month="ก.ย."; }
		else if($m==10){ $month="ต.ค."; }
		else if($m==11){ $month="พ.ย."; }
		else { $month="ธ.ค."; }

		return $month;
	}
	
	public function cutZeroDay($day){
		$arrDay=str_split($day,1);
		if($arrDay[0]==0){ $day=$arrDay[1]; }
		return $day;
	}
	public function addZeroDay($day){
		$arrDay=str_split($day,1);
		if(count($arrDay)==1){ $day='0'.$arrDay[0]; }
		return $day;
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
	public function cutNumberSeparate($num){
		$num = ($num=='') ? '0' : $num;
		$Array_num = explode(",",$num);
		$num = implode("",$Array_num);
		return $num;
	}
	
	
	
	/*  POINT
	-------------------------------------------------------------------------------------------------------*/
	public function updateMemberPoint($member_id,$point){
			$data = array(
					"member_point"=>$point,
			);
		
			$this->db_lib->where('member_id',$member_id);
			$this->db_lib->update('member',$data);
	}
	public function getMemberPoint($member_id){
		$select = $this->db_lib->select('member_point')
										->from('member')
										->where('member_id',$member_id);
		$query = $this->db_lib->get();
		$result = $query->row_array();
		return (empty($result)) ? 0 : $result['member_point'];
	}
	
	
	
	/*  EMAIL
	-------------------------------------------------------------------------------------------------------*/
	public function emailTemplate($topic,$name,$txt){
		$html='
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<div style=" background:#f0f0f0; width:100%; padding-top:40px; padding-bottom:40px; ">
			<div style="width:90%; height:140px; border-bottom:1px solid #999; margin:0 auto; margin-top:0px; background:#FFF;border:1px solid #dfdfdf; padding-left:30px; padding-right:30px;">
				<table cellpadding="0" cellspacing="0" border="0" style="width:850px; height:140px;" class="default">
					<tr>
						<td><img src="'.DIR_HOST.DIR_PUBLIC.'layout/default/images/logo.png" /></td>
						<td align="right" valign="bottom"><div style="color:#F60; font-weight:bold; font-size:24px;">'.$topic.'</div></td>
					</tr>
				</table>
			</div>
			<div style="clear:both; width:90%; margin:0 auto; background:#FFF;padding-left:30px; padding-right:30px; padding-bottom:40px; border:1px solid #dfdfdf;">
				<table cellpadding="0" cellspacing="0" border="0" style="width:850px;" class="default">
					<tr>
						<td height="50" valign="top"><div style="font-weight:bold; font-size:24px;">สวัสดี คุณ '.$name.'</div></td>
					</tr>
					<tr>
						<td><div class="data" style="clear:both; float:left; margin-bottom:20px;">'.$txt.'</div>
						</td>
					</tr>
					<tr>
						<td height="20"></td>
					</tr>
				</table>
				<div style="width:90%; margin:0 auto; border-top:1px solid #999; margin-top:20px; padding-bottom:20px;background:#FFF;">
					<div style="text-align:left;margin-top:20px;">
						<a href="www.bkkmarket.com" target="_blank">BkkMarket.com</a> | 
						<a href="www.bkkmarket.com" target="_blank">ติดต่อเรา</a> | 
						<a href="www.bkkmarket.com" target="_blank">เงื่อนไขและข้อกำหนด</a> | 
						<a href="www.bkkmarket.com" target="_blank">Hot Seller</a>
					</div>
				</div>
			</div>
		</div>';
		return $html;
	}
}
?>